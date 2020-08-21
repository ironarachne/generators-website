<?php

namespace App\Http\Controllers;

use App\AlcoholicDrinkGenerator;
use App\CharacterGenerator;
use App\ClothingStyleGenerator;
use App\CuisineGenerator;
use App\GeographicRegionGenerator;
use App\LanguageGenerator;
use App\MusicGenerator;
use App\NameGenerator;
use App\ReligionGenerator;
use App\Resource;
use App\Species;
use App\TownGenerator;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ApiController extends Controller
{
    public function randomAlcoholicDrink()
    {
        $gen = new AlcoholicDrinkGenerator();
        $name = $gen->randomName();
        $resources = Resource::loadAll();
        $drink = $gen->generate($resources, $name);

        $json = '{"alcoholic_drink":' . json_encode($drink) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomAlcoholicDrinkSeed($seed)
    {
        $drink = Cache::rememberForever("alcoholic_drink_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new AlcoholicDrinkGenerator();
            $name = $gen->randomName();
            $resources = Resource::loadAll();
            return $gen->generate($resources, $name);
        });

        $json = '{"alcoholic_drink":' . json_encode($drink) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomCharacter()
    {
        $gen = new CharacterGenerator();
        $nameGen = NameGenerator::defaultFantasy();
        $species = Species::randomRace();
        $character = $gen->generate($nameGen, $species);

        $json = '{"character":' . json_encode($character) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomCharacterSeed($seed)
    {
        $character = Cache::rememberForever("character_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new CharacterGenerator();
            $nameGen = NameGenerator::defaultFantasy();
            $species = Species::randomRace();
            return $gen->generate($nameGen, $species);
        });

        $json = '{"character":' . json_encode($character) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

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

    public function randomCuisine()
    {
        $gen = new CuisineGenerator();

        $resources = Resource::loadAll();
        $cuisine = $gen->generate($resources);

        $json = '{"cuisine":' . json_encode($cuisine) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomCuisineSeed($seed)
    {
        $cuisine = Cache::rememberForever("cuisine_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new CuisineGenerator();

            $resources = Resource::loadAll();
            return $gen->generate($resources);
        });

        $json = '{"cuisine":' . json_encode($cuisine) . '}';

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
            return $gen->generate();
        });

        $json = '{"language": ' . json_encode($language) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomLanguageFromSeed($seed)
    {
        $guid = $seed;

        $language = Cache::rememberForever("language_$guid", function () use ($guid) {
            seeder($guid);

            $gen = new LanguageGenerator();
            return $gen->generate();
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

    public function randomReligion()
    {
        $gen = new ReligionGenerator();

        $nameGenerator = NameGenerator::defaultFantasy();
        $religion = $gen->generate($nameGenerator);

        $json = '{"religion":' . json_encode($religion) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomReligionSeed($seed)
    {
        $religion = Cache::rememberForever("religion_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new ReligionGenerator();

            $nameGenerator = NameGenerator::defaultFantasy();
            return $gen->generate($nameGenerator);
        });

        $json = '{"religion":' . json_encode($religion) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomTown()
    {
        $gen = new TownGenerator();

        $nameGenerator = NameGenerator::defaultFantasy();
        $geoGenerator = new GeographicRegionGenerator();
        $geographicRegion = $geoGenerator->generate();
        $town = $gen->generate($geographicRegion, $nameGenerator);

        $json = '{"town":' . json_encode($town) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }

    public function randomTownSeed($seed)
    {
        $town = Cache::rememberForever("town_$seed", function () use ($seed) {
            seeder($seed);

            $gen = new TownGenerator();

            $nameGenerator = NameGenerator::defaultFantasy();
            $geoGenerator = new GeographicRegionGenerator();
            $geographicRegion = $geoGenerator->generate();
            return $gen->generate($geographicRegion, $nameGenerator);
        });

        $json = '{"town":' . json_encode($town) . '}';

        return response($json)->header('Content-Type', 'application/json');
    }
}
