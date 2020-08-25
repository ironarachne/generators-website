<?php


namespace App;

use Exception;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class BiomeGenerator
{
    public function generate($climate, $region)
    {
        $type = $this->getRandomBiomeType($region->altitude);

        return $this->match($type, $climate->precipitation_amount, $region->temperature, $region->altitude);
    }

    public function match($biomeType, $precipitation, $temperature, $altitude)
    {
        $appropriate = [];

        $biomes = $this->getBiomeData();

        foreach ($biomes as $biome) {
            $score = $this->score($biome, $biomeType, $precipitation, $temperature, $altitude);
            if ($score > 0) {
                $biome->match_score = $score;
                $appropriate [] = $biome;
            }
        }

        if (sizeof($appropriate) == 0) {
            throw new Exception('no appropriate biomes found');
        }

        return $this->findBestBiome($appropriate);
    }

    public function findBestBiome($biomes)
    {
        $bestScore = $biomes[0]->match_score;
        $best = $biomes[0];

        foreach ($biomes as $biome) {
            if ($biome->match_score > $bestScore) {
                $best = $biome;
                $bestScore = $biome->match_score;
            }
        }

        return $best;
    }

    public function getBiomeData()
    {
        return Cache::remember('biomes', 600, function () {
            $biomes = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/biomes');

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->biomes as $b) {
                $biome = new Biome();
                $biome->altitude_max = $b->altitude_max;
                $biome->altitude_min = $b->altitude_min;
                $biome->fauna_prevalence = $b->fauna_prevalence;
                $biome->flora_prevalence = $b->vegetation_prevalence;
                $biome->name = $b->name;
                $biome->precipitation_max = $b->precipitation_max;
                $biome->precipitation_min = $b->precipitation_min;
                $biome->temperature_max = $b->temperature_max;
                $biome->temperature_min = $b->temperature_min;

                $biome->possible_landmarks = explode(',', $b->possible_landmarks);

                $biome->type = $b->type;
                foreach ($b->tags as $tag) {
                    $n = new Tag;
                    $n->name = $tag->name;

                    $biome->tags [] = $n;
                }

                $biomes [] = $biome;
            }

            return $biomes;
        });
    }

    public function getRandomBiomeType($altitude)
    {
        if ($altitude < 0) {
            return 'marine';
        }

        $types = [
            'terrestrial',
            'freshwater',
        ];

        return $types[mt_rand(0, sizeof($types) - 1)];
    }

    public function score($biome, $biomeType, $precipitation, $temperature, $altitude)
    {
        $score = 0;

        if ($biomeType != $biome->type) {
            return 0;
        }

        if ($precipitation > $biome->precipitation_max || $precipitation < $biome->precipitation_min) {
            return 0;
        }

        if ($temperature > $biome->temperature_max || $temperature < $biome->temperature_min) {
            return 0;
        }

        if ($altitude > $biome->altitude_max || $altitude < $biome->altitude_min) {
            return 0;
        }

        $precipitationOffset = abs(($biome->precipitation_min + $biome->precipitation_max) / 2 - $precipitation);
        $score += 50 - $precipitationOffset;
        $temperatureOffset = abs(($biome->temperature_min + $biome->temperature_max) / 2 - $temperature);
        $score += 50 - $temperatureOffset;
        $altitudeOffset = abs(($biome->altitude_min + $biome->altitude_max) / 2 - $altitude);
        $score += 50 - $altitudeOffset;

        return $score;
    }
}
