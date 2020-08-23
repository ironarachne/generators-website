<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use App\RegionGenerator;
use App\SavedRegion;

class RegionController extends Controller
{
    public function index()
    {
        $regions = SavedRegion::latest()->limit(5)->get();

        $page = [
            'title' => 'Regions',
            'subtitle' => 'Generate individual regions in a fantasy world',
            'description' => 'This tool procedurally generates regions for a fantasy world.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view('region.index', ['page' => $page, 'regions' => $regions]);
    }

    public function create(Request $request)
    {
        $guid = Uuid::uuid4();

        $languageChoice = $request->input('language-choice');

        $useFamiliar = false;

        if ($languageChoice == 'Common') {
            $useFamiliar = true;
        }

        $regionGenerator = new RegionGenerator();
        $region = $regionGenerator->generate($guid, $useFamiliar);

        if (Auth::check()) {
            $user = Auth::user();

            $user->regions()->save($region);
        } else {
            $region->save();
        }

        Cache::forever('region-' . $region->guid, $region);

        return redirect()->route('region.show', ['guid' => $region->guid]);
    }

    public function show($guid)
    {
        $region = Cache::rememberForever('region-' . $guid, function () use ($guid) {
            $region = SavedRegion::where('guid', $guid)->first();
            if ($region == false) {
                $regionGenerator = new RegionGenerator();

                $region = $regionGenerator->generate($guid);

                if (Auth::check()) {
                    $user = Auth::user();

                    $user->regions()->save($region);
                } else {
                    $region->save();
                }
            }
            return $region;
        });

        $page = [
            'id' => $guid,
            'title' => $region->name,
            'subtitle' => $region->description,
            'description' => $region->description,
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view('region.show', ['region' => $region, 'page' => $page]);
    }
}
