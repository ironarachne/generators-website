<?php


namespace App;


use Exception;

class GeographicRegionGenerator
{
    public function generate()
    {
        $region = new GeographicRegion();

        $region->distance_to_equator = mt_rand(0, 100) - 50;
        $region->altitude = mt_rand(0, 50) + 10;
        $region->nearest_ocean_distance = mt_rand(0, 100);
        $region->nearest_ocean_direction = random_direction();
        $region->nearest_mountains_distance = mt_rand(0, 100);
        $region->nearest_mountains_direction = random_direction();
        $region->temperature = $this->getTemperature($region->distance_to_equator, $region->altitude);
        $region->humidity = $this->getHumidity($region->altitude, $region->nearest_ocean_distance);

        $climateGenerator = new ClimateGenerator();
        $region->climate = $climateGenerator->generate($region);

        $biomeGenerator = new BiomeGenerator();
        $region->biome = $biomeGenerator->generate($region->climate, $region);
        $region->possible_landmarks = $region->biome->possible_landmarks;

        $seasonGenerator = new SeasonGenerator();
        $region->seasons = $seasonGenerator->generate($region->climate, $region);

        $region->animals = $this->getAnimals($region->humidity, $region->temperature, $region->biome->fauna_prevalence, $region->biome->tags);
        $region->plants = $this->getPlants($region->humidity, $region->temperature, $region->biome->flora_prevalence, $region->biome->tags);
        $region->minerals = $this->getMinerals($region->nearest_ocean_distance, $region->humidity, $region->temperature);

        $region->description = $this->describe($region);

        return $region;
    }

    public function describe($region)
    {
        $biomeName = $region->biome->name;
        $temperature = $this->describeTemperature($region->temperature);
        $humidity = $this->describeHumidity($region->humidity);

        return 'This area is ' . pronoun($biomeName) . " $biomeName. It's $temperature with $humidity humidity.";
    }

    public function describeHumidity($humidity)
    {
        if ($humidity < 10) {
            return "very dry";
        } else if ($humidity < 30) {
            return "dry";
        } else if ($humidity < 75) {
            return "moderate";
        } else if ($humidity < 90) {
            return "humid";
        }

        return "very humid";
    }

    public function describeTemperature($temperature)
    {
        if ($temperature < 10) {
            return "frigid";
        } else if ($temperature < 30) {
            return "cold";
        } else if ($temperature < 60) {
            return "temperate";
        } else if ($temperature < 75) {
            return "warm";
        } else if ($temperature < 90) {
            return "hot";
        }

        return "very hot";
    }

    public function getAnimals($humidity, $temperature, $prevalence, $tags)
    {
        $result = [];

        $animals = Species::load('animal');

        $filteredAnimals = [];

        foreach ($animals as $a) {
            if ($a->suits($humidity, $temperature, $tags)) {
                $filteredAnimals [] = $a;
            }
        }

        $fish = Species::load('fish');

        $filteredFish = [];

        foreach ($fish as $a) {
            if ($a->suits($humidity, $temperature, $tags)) {
                $filteredFish [] = $a;
            }
        }

        $insects = Species::load('insect');

        $filteredInsects = [];

        foreach ($insects as $a) {
            if ($a->suits($humidity, $temperature, $tags)) {
                $filteredInsects [] = $a;
            }
        }

        $numAnimals = (($prevalence / 100) * 20) + 4;
        $numFish = (($prevalence / 100) * 20) + 3;
        $numInsects = (($prevalence / 100) * 20) + 1;

        for ($i = 0; $i < $numAnimals; $i++) {
            $a = $filteredAnimals[mt_rand(0, sizeof($filteredAnimals) - 1)];
            if (!$a->in($result)) {
                $result [] = $a;
            }
        }

        if (sizeof($filteredFish) > 0) {
            for ($i = 0; $i < $numFish; $i++) {
                $a = $filteredFish[mt_rand(0, sizeof($filteredFish) - 1)];
                if (!$a->in($result)) {
                    $result [] = $a;
                }
            }
        }

        if (sizeof($filteredInsects) > 0) {
            for ($i = 0; $i < $numInsects; $i++) {
                $a = $filteredInsects[mt_rand(0, sizeof($filteredInsects) - 1)];
                if (!$a->in($result)) {
                    $result [] = $a;
                }
            }
        }

        return $result;
    }

    public function getMinerals($oceanDistance, $humidity, $temperature)
    {
        $result = [];

        $metals = Mineral::load('metal');

        for ($i = 0; $i < 5; $i++) {
            $weighted = Mineral::weightedRandom($metals);
            if (!$weighted->in($result)) {
                $result [] = $weighted;
            }
        }

        $gems = Mineral::load('gem');

        for ($i = 0; $i < 3; $i++) {
            $gem = $gems[mt_rand(0, sizeof($gems) - 1)];
            if (!$gem->in($result)) {
                $result [] = $gem;
            }
        }

        $stones = Mineral::load('stone');

        for ($i = 0; $i < 2; $i++) {
            $stone = $stones[mt_rand(0, sizeof($stones) - 1)];
            if (!$stone->in($result)) {
                $result [] = $stone;
            }
        }

        if ($oceanDistance < 10 || ($humidity < 15 && $temperature > 40)) {
            $sands = Mineral::load('sand');

            $result [] = $sands[mt_rand(0, sizeof($sands) - 1)];
        }

        if ($humidity > 50) {
            $clays = Mineral::load('clay');

            $result [] = $clays[mt_rand(0, sizeof($clays) - 1)];
        }

        if ($temperature > 30 && $humidity > 30) {
            $loams = Mineral::load('loam');

            $result [] = $loams[mt_rand(0, sizeof($loams) - 1)];
        }

        if ($temperature > 40 && $humidity < 40) {
            $silts = Mineral::load('silt');

            $result [] = $silts[mt_rand(0, sizeof($silts) - 1)];
        }

        return $result;
    }

    public function getPlants($humidity, $temperature, $prevalence, $tags)
    {
        $result = [];

        $plants = Species::load('plant');

        $filteredPlants = [];

        foreach ($plants as $a) {
            if ($a->suits($humidity, $temperature, $tags)) {
                $filteredPlants [] = $a;
            }
        }

        $trees = Species::load('tree');

        $filteredTrees = [];

        foreach ($trees as $a) {
            if ($a->suits($humidity, $temperature, $tags)) {
                $filteredTrees [] = $a;
            }
        }

        $numPlants = (($prevalence / 100) * 30) + 4;
        $numTrees = (($prevalence / 100) * 20) + 1;

        for ($i = 0; $i < $numPlants; $i++) {
            $p = $filteredPlants[mt_rand(0, sizeof($filteredPlants) - 1)];
            if (!$p->in($result)) {
                $result [] = $p;
            }
        }

        $hasGrains = false;

        foreach ($result as $p) {
            $grain = new Tag();
            $grain->name = 'grain';

            if ($grain->in($p->tags)) {
                $hasGrains = true;
            }
        }

        if (!$hasGrains) {
            $grains = Species::byTagName('grain', $plants);
            if (sizeof($grains) > 0) {
                $result [] = $grains[mt_rand(0, sizeof($grains) - 1)];
            } else {
                throw new Exception('failed to find an appropriate grain plant for this area');
            }
        }

        if (sizeof($filteredTrees) > 0) {
            for ($i = 0; $i < $numTrees; $i++) {
                $p = $filteredTrees[mt_rand(0, sizeof($filteredTrees) - 1)];
                if (!$p->in($result)) {
                    $result [] = $p;
                }
            }
        }

        return $result;
    }

    public function getHumidity($altitude, $nearestOceanDistance)
    {
        if ($nearestOceanDistance == 0) {
            return 100;
        }

        $humidity = 100 - ($altitude / 2) - ($nearestOceanDistance / 2);

        if ($humidity > 100) {
            $humidity = 100;
        }

        if ($humidity < 0) {
            $humidity = 0;
        }

        return $humidity;
    }

    public function getTemperature($distanceToEquator, $altitude)
    {
        $temperature = 100 - abs($distanceToEquator) - ($altitude / 2);
        if ($temperature < 0) {
            $temperature = 0;
        }
        if ($temperature > 100) {
            $temperature = 100;
        }

        return $temperature;
    }
}
