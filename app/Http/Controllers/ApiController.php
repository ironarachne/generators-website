<?php

namespace App\Http\Controllers;

use App\GeographicRegionGenerator;
use App\LanguageGenerator;
use App\Language;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ApiController extends Controller
{
    public function randomGeographicRegion()
    {
        $gen = new GeographicRegionGenerator();
        $region = $gen->generate();

        $json = '{"geographic_region":' . json_encode($region) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomGeographicRegionSeed($seed)
    {
        $region = Cache::rememberForever("geographic_region_$seed", function() use ($seed) {
            seeder($seed);

            $gen = new GeographicRegionGenerator();

            return $gen->generate();
        });

        $json = '{"geographic_region":' . json_encode($region) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomLanguage()
    {
        $guid = Uuid::uuid4();

        $language = Cache::rememberForever("language_$guid", function() use ($guid) {
            seeder($guid);

            $gen = new LanguageGenerator();
            $language = $gen->generate($guid);
            return $language->with(['names', 'words', 'writingSystems'])->get();
        });

        $json = '{"language": ' . json_encode($language) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomLanguageFromSeed($seed)
    {
        $guid = $seed;

        $language = Cache::rememberForever("language_$guid", function() use ($guid) {
            $language = Language::where('guid', '=', $guid)->with(['names', 'words', 'writingSystems'])->first();

            if (empty($language)) {
                seeder($guid);

                $gen = new LanguageGenerator();
                $language = $gen->generate($guid);
                return $language->with(['names', 'words', 'writingSystems'])->get();
            } else {
                return $language;
            }
        });

        $json = '{"language": ' . json_encode($language) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }
}
