<?php

namespace App\Http\Controllers;

use App\ClothingStyleGenerator;
use App\GeographicRegionGenerator;
use App\LanguageGenerator;
use App\Language;
use App\MusicGenerator;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ApiController extends Controller
{
    public function randomClothingStyle()
    {
        $gen = new ClothingStyleGenerator();
        $style = $gen->generate();

        $json = '{"clothing_style":' . json_encode($style) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomClothingStyleSeed($seed)
    {
        $style = Cache::rememberForever("clothing_style_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new ClothingStyleGenerator();

            return $gen->generate();
        });

        $json = '{"clothing_style":' . json_encode($style) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomGeographicRegion()
    {
        $gen = new GeographicRegionGenerator();
        $region = $gen->generate();

        $json = '{"geographic_region":' . json_encode($region) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomGeographicRegionSeed($seed)
    {
        $region = Cache::rememberForever("geographic_region_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new GeographicRegionGenerator();

            return $gen->generate();
        });

        $json = '{"geographic_region":' . json_encode($region) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomLanguage()
    {
        $guid = Uuid::uuid4()->toString();

        $language = Cache::rememberForever("language_$guid", function () use ($guid) {
            seeder($guid);

            $gen = new LanguageGenerator();
            $language = $gen->generate($guid);
            return Language::where('guid', '=', $guid)->with(['names', 'words', 'writingSystems'])->first();
        });

        $json = '{"language": ' . json_encode($language) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomLanguageFromSeed($seed)
    {
        $guid = $seed;

        $language = Cache::rememberForever("language_$guid", function () use ($guid) {
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

    public function randomMusic()
    {
        $guid = Uuid::uuid4()->toString();

        $music = Cache::rememberForever("music_$guid", function () use ($guid) {
            seeder($guid);

            $gen = new MusicGenerator();
            return $gen->generate($guid);
        });

        $json = '{"music": ' . json_encode($music) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomMusicFromSeed($seed)
    {
        $guid = $seed;

        $music = Cache::rememberForever("music_$guid", function () use ($guid) {
            seeder($guid);

            $gen = new MusicGenerator();
            return $gen->generate($guid);
        });

        $json = '{"music": ' . json_encode($music) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }
}
