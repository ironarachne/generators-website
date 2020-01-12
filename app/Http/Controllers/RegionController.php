<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use App\RegionGenerator;
use App\Region;

class RegionController extends Controller
{
    public function index()
    {
        $regionData = Region::latest()->limit(5)->get();

        $regions = [];

        foreach ($regionData as $regionObject) {
            $data = json_decode($regionObject->data);
            $region['name'] = $data->name;
            $region['guid'] = $regionObject->guid;
            $region['description'] = $data->name . ', ruled by ' . $data->ruler->name;
            $regions[] = $region;
        }

        $page = [
            'title' => 'Regions',
            'subtitle' => 'Generate individual regions in a fantasy world',
            'description' => 'This tool procedurally generates regions for a fantasy world.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'region.index', [ 'page' => $page, 'regions' => $regions ] );
    }

    public function create()
    {
        $guid = Uuid::uuid4();

        $regionGenerator = new RegionGenerator();
        $region = $regionGenerator->generate( $guid );

        if (\Auth::check()) {
            $user = \Auth::user();

            $user->regions()->save($region);
        } else {
            $region->save();
        }

        Cache::forever('region-'.$region->guid, $region);

        return redirect()->route('region.show', ['guid' => $region->guid]);
    }

    public function show( $guid )
    {
        $regionObject = Cache::get('region-'.$guid);
        $region = json_decode($regionObject->data);

        $page = [
            'id' => $guid,
            'title' => $region->name,
            'subtitle' => 'A region ruled by ' . $region->ruler->name,
            'description' => 'The fantasy region of ' . $region->name . '.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'region.show', [ 'region' => $region, 'page' => $page ] );
    }
}
