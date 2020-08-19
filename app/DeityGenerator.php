<?php


namespace App;


class DeityGenerator
{
    public $possibleDomains;

    public function generate(NameGenerator $nameGenerator)
    {
        $deity = new Deity();

        $genders = ['male', 'female'];
        $deity->gender = random_item($genders);

        $deity->name = $nameGenerator->generate($deity->gender, false);
        $deity->domains = [];

        $numberOfDomains = mt_rand(1, 3);

        for ($i = 0; $i < $numberOfDomains; $i++) {
            if (sizeof($this->possibleDomains) > 0) {
                $domain = random_item($this->possibleDomains);
                $this->possibleDomains = $domain->removeFrom($this->possibleDomains);
                $deity->domains [] = $domain;
            }
        }

        $deity->appearance = $this->randomAppearance($deity->domains);
        $deity->personality_traits = $this->randomPersonalityTraits($deity->domains);
        $deity->holy_item = $this->randomHolyItem($deity->domains);
        $deity->holy_symbol = $this->randomHolySymbol($deity->domains);
        $deity->relationships = [];

        return $deity;
    }

    private function randomAppearance($domains)
    {
        $possibleAppearances = [];
        $appearances = [];

        foreach ($domains as $domain) {
            $possibleAppearances = array_merge($possibleAppearances, $domain->appearance_traits);
        }

        $numberOfAppearanceTraits = mt_rand(1, 3);

        for ($i = 0; $i < $numberOfAppearanceTraits; $i++) {
            $appearance = random_item($possibleAppearances);
            if (!in_array($appearance, $appearances)) {
                $appearances [] = $appearance;
            }
        }

        return combine_phrases($appearances);
    }

    private function randomHolyItem($domains)
    {
        $possible = [];

        foreach ($domains as $domain) {
            $possible = array_merge($possible, $domain->holy_items);
        }

        return random_item($possible);
    }

    private function randomHolySymbol($domains)
    {
        $possible = [];

        foreach ($domains as $domain) {
            $possible = array_merge($possible, $domain->holy_symbols);
        }

        return random_item($possible);
    }

    private function randomPersonalityTraits($domains)
    {
        $possiblePersonalityTraits = [];
        $traits = [];

        foreach ($domains as $domain) {
            $possiblePersonalityTraits = array_merge($possiblePersonalityTraits, $domain->personality_traits);
        }

        $numberOfPersonalityTraits = mt_rand(1, 3);

        for ($i = 0; $i < $numberOfPersonalityTraits; $i++) {
            $trait = random_item($possiblePersonalityTraits);
            if (!in_array($trait, $traits)) {
                $traits [] = $trait;
            }
        }

        return $traits;
    }
}
