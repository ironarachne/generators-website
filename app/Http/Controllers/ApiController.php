<?php

namespace App\Http\Controllers;

use App\GeographicRegionGenerator;

class ApiController extends Controller
{
    public function randomRegion()
    {
        $gen = new GeographicRegionGenerator();
        $region = $gen->generate();

        $json = '{"region":' . json_encode($region) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomRegionSeed($seed)
    {
        seeder($seed);

        $gen = new GeographicRegionGenerator();
        $region = $gen->generate();

        $json = '{"region":' . json_encode($region) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }
}
