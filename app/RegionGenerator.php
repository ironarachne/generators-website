<?php

namespace App;

class RegionGenerator
{
    public function generate($id)
    {
        $cultureGen = new CultureGenerator();
        $culture = $cultureGen->generate($id);
        $cultureData = Culture::fromJSON($culture->data);

        $nameGenerator = new NameGenerator();
        $nameGenerator->female_first_names = $cultureData->language->female_first_names;
        $nameGenerator->female_last_names = $cultureData->language->female_last_names;
        $nameGenerator->male_first_names = $cultureData->language->male_first_names;
        $nameGenerator->male_last_names = $cultureData->language->male_last_names;
        $nameGenerator->place_names = $cultureData->language->place_names;

        $regionData = new Region();
        $regionData->area_description = $cultureData->geography->description;
        $regionData->biome = $cultureData->geography->biome->name;
        $regionData->geography = $cultureData->geography;
        $regionData->culture = $cultureData;

        $regionData->category = RegionCategory::random();

        $regionData->name = $nameGenerator->randomPlaceName();

        $townGen = new TownGenerator();
        $smallTowns = mt_rand($regionData->category->min_small_towns, $regionData->category->max_small_towns);
        $mediumTowns = mt_rand($regionData->category->min_medium_towns, $regionData->category->max_medium_towns);
        $largeTowns = mt_rand($regionData->category->min_large_towns, $regionData->category->max_large_towns);
        $towns = $townGen->generateSet($smallTowns, $mediumTowns, $largeTowns, $regionData->geography, $nameGenerator);

        $regionData->towns = array_slice($towns, 0, -1);
        $regionData->capital = $towns[sizeof($towns) - 1];

        $charGen = new CharacterGenerator();
        $species = Species::randomRace();
        $ruler = $charGen->generate($nameGenerator, $species);
        $ruler->profession = Profession::load('noble')[0];
        $ruler->titles = [$regionData->category->leadership_type->title];
        $ruler->primary_title = $regionData->category->leadership_type->title->getPrefix($ruler->gender);

        $heraldryGen = new HeraldryGenerator();
        $ruler->heraldry = $heraldryGen->random();
        $ruler->description = $ruler->describe();

        $regionData->ruler = $ruler;

        $regionData->organizations = [];
        $orgGen = new OrganizationGenerator();
        $numberOfOrganizations = mt_rand($regionData->category->min_organizations, $regionData->category->max_organizations);
        for ($i = 0; $i < $numberOfOrganizations; $i++) {
            $regionData->organizations [] = $orgGen->generate($nameGenerator);
        }

        $region = new SavedRegion();
        $region->data = json_encode($regionData);
        $region->guid = $id;

        $region->name = 'The ' . ucfirst($regionData->category->leadership_type->name) . ' of ' . $regionData->name;
        $region->description = 'The fantasy region of ' . $regionData->name . ', ruled by ' . $regionData->ruler->getFullName() . '.';
        $region->html = view('region.individual', ['region' => $regionData])->render();

        return $region;
    }
}
