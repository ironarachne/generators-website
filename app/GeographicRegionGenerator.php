<?php


namespace App;


class GeographicRegionGenerator
{
    public function generate($seed)
    {
        seeder($seed);

        $region = new GeographicRegion();

        $region->distance_to_equator = mt_rand(100) - 50;
        $region->altitude = mt_rand(50) + 10;
        $region->nearest_ocean_distance = mt_rand(100);
        $region->nearest_ocean_direction = random_direction();
        $region->nearest_mountains_distance = mt_rand(100);
        $region->nearest_mountains_direction = random_direction();
        $region->temperature = $this->getTemperature($region->distance_to_equator, $region->altitude);
        $region->humidity = $this->getHumidity($region->altitude, $region->nearest_ocean_distance);
        $region->description = $this->describe($region);

        return $region;
    }

    public function describe($region)
    {
        $description = $this->describeTemperature($region->temperature);
        $description .= ' with ' . $this->describeHumidity($region->humidity) . ' humidity';

        return $description;
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
