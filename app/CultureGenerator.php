<?php

namespace App;

class CultureGenerator
{
    public function generate($id, $useFamiliarLanguage = false): SavedCulture
    {
        $geoGen = new GeographicRegionGenerator();
        $geography = $geoGen->generate();
        $resources = $geography->resources();

        $langGen = new LanguageGenerator();
        if ($useFamiliarLanguage) {
            $language = $langGen->getCommon();
        } else {
            $language = $langGen->generate();
        }
        $nameGenerator = new NameGenerator();
        $nameGenerator->female_first_names = $language->female_first_names;
        $nameGenerator->female_last_names = $language->female_last_names;
        $nameGenerator->male_first_names = $language->male_first_names;
        $nameGenerator->male_last_names = $language->male_last_names;
        $nameGenerator->place_names = $language->place_names;

        if ($useFamiliarLanguage) {
            $name = $nameGenerator->randomPlaceName();
            $adjective = $name;
        } else {
            $name = $language->name;
            $adjective = $language->adjective;
        }

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

        $cultureData = new Culture($name, $adjective, $language, $geography, $music, $clothing, $cuisine, $drink, $religion);

        $culture = new SavedCulture();
        $culture->data = json_encode($cultureData);
        $culture->guid = $id;

        $culture->name = $cultureData->name;
        $culture->description = 'The ' . $cultureData->adjective . ', a fictional culture from a ' . $cultureData->geography->biome->name . ' climate.';
        $culture->html = view('culture.individual', ['culture' => $cultureData])->render();

        return $culture;
    }
}
