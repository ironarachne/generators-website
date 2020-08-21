<?php


namespace App;


class TownGenerator
{
    public function generate(GeographicRegion $geographicRegion, NameGenerator $nameGenerator): Town
    {
        $category = TownCategory::random();

        return $this->random($category, $geographicRegion, $nameGenerator);
    }

    public function generateSet(int $numberOfSmall, int $numberOfMedium, int $numberOfLarge, GeographicRegion $geographicRegion, NameGenerator $nameGenerator): array
    {
        $towns = [];

        for($i=0;$i<$numberOfSmall;$i++) {
            $category = TownCategory::randomSmall();

            $towns [] = $this->random($category, $geographicRegion, $nameGenerator);
        }

        for($i=0;$i<$numberOfMedium;$i++) {
            $category = TownCategory::randomMedium();

            $towns [] = $this->random($category, $geographicRegion, $nameGenerator);
        }

        for($i=0;$i<$numberOfLarge;$i++) {
            $category = TownCategory::randomLarge();

            $towns [] = $this->random($category, $geographicRegion, $nameGenerator);
        }

        return $towns;
    }

    public function random(TownCategory $category, GeographicRegion $geographicRegion, NameGenerator $nameGenerator): Town
    {
        $town = new Town();
        $town->name = $nameGenerator->randomPlaceName();
        $town->category = $category;

        $town->population = $category->randomSize();
        $town->common_exports = $category->randomExports();
        $town->character = $category->randomCharacter();

        $town->surrounding_environment = $geographicRegion->description;
        $town->description = $town->describe();

        return $town;
    }
}
