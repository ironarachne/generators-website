<?php

namespace App;

use \GuzzleHttp\Client;

class CultureGenerator
{
    public function generate($id)
    {
        $geoGen = new GeographicRegionGenerator();
        $geography = $geoGen->generate();
        $resources = $geography->resources();

        $langGen = new LanguageGenerator();
        $language = $langGen->generate();
        $nameGenerator = new NameGenerator();
        $nameGenerator->female_first_names = $language->female_first_names;
        $nameGenerator->female_last_names = $language->female_last_names;
        $nameGenerator->male_first_names = $language->male_first_names;
        $nameGenerator->male_last_names = $language->male_last_names;
        $nameGenerator->place_names = $language->place_names;

        $name = $language->name;
        $adjective = $language->adjective;

        $musicGen = new MusicGenerator();
        $music = $musicGen->generate($id);

        $clothingGen = new ClothingStyleGenerator();
        $clothing = $clothingGen->generate();

        $drinkGen = new AlcoholicDrinkGenerator();
        $drink = $drinkGen->generate($resources, strtolower($language->translate('drink')));

        $cuisineGen = new CuisineGenerator();
        $cuisine = $cuisineGen->generate($resources);

        $religionGen = new ReligionGenerator();
        $religion = $religionGen->generate($nameGenerator);

        $cultureData = new \stdClass();
        $cultureData->name = $name;
        $cultureData->adjective = $adjective;
        $cultureData->language = $language;
        $cultureData->geography = $geography;
        $cultureData->music = $music;
        $cultureData->clothing = $clothing;
        $cultureData->cuisine = $cuisine;
        $cultureData->drink = $drink;
        $cultureData->religion = $religion;

        $culture = new Culture();
        $culture->data = json_encode($cultureData);
        $culture->guid = $id;

        $culture->name = $cultureData->name;
        $culture->description = 'The ' . $cultureData->adjective . ', a fictional culture from a ' . $cultureData->geography->biome->name . ' climate.';
        $culture->html = view('culture.individual', ['culture' => $cultureData])->render();

        return $culture;
    }
}
