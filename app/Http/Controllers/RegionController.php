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

        return view('region.index', ['regions' => $regions]);
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

        return view('region.show', ['region' => $region]);
    }
}
