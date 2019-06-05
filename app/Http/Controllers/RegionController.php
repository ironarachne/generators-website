<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class RegionController extends Controller
{
    public function index()
    {
        $page = [
            'title' => 'Region Generator',
            'subtitle' => 'Generate individual regions in a fantasy world',
            'description' => 'This tool procedurally generates regions for a fantasy world.',
            'type' => 'single',
        ];
        
        return view( 'region.index', [ 'page' => $page ] );
    }

    public function device( $guid )
    {
        $region = Cache::rememberForever( "region-$guid", function () use ($guid) {
            $regionGenerator = new \App\RegionGenerator();
            return $regionGenerator->generate($guid);
        } );

        return response($region->ruler->device)->header('Content-Type', 'image/svg+xml');
    }

    public function show( $guid )
    {
        $region = Cache::rememberForever( "region-$guid", function () use ($guid) {
            $regionGenerator = new \App\RegionGenerator();
            return $regionGenerator->generate($guid);
        } );

        $page = [
            'id' => $guid,
            'title' => $region->name,
            'subtitle' => 'A region ruled by ' . $region->ruler->name,
            'description' => 'The fantasy region of ' . $region->name . '.',
            'type' => 'single',
        ];

        return view( 'region.show', [ 'region' => $region, 'page' => $page ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'region.show', [ 'guid' => $guid ] );
    }
}
