<?php


namespace App;


class DeityGenerator
{
    public array $possible_domains;

    public function __construct() {
        $this->possible_domains = [];
    }

    public function generate(NameGenerator $nameGenerator)
    {
        $deity = new Deity();

        $genders = ['male', 'female'];
        $deity->gender = random_item($genders);

        $deity->name = $nameGenerator->generate($deity->gender, false);
        $deity->domains = [];

        $numberOfDomains = mt_rand(1, 3);

        for ($i = 0; $i < $numberOfDomains; $i++) {
            if (sizeof($this->possible_domains) > 0) {
                $domain = random_item($this->possible_domains);
                $this->possible_domains = $domain->removeFrom($this->possible_domains);
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

    private function randomAppearance($domains): string
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

    private function randomHolyItem($domains): string
    {
        $possible = [];

        foreach ($domains as $domain) {
            $possible = array_merge($possible, $domain->holy_items);
        }

        return random_item($possible);
    }

    private function randomHolySymbol($domains): string
    {
        $possible = [];

        foreach ($domains as $domain) {
            $possible = array_merge($possible, $domain->holy_symbols);
        }

        return random_item($possible);
    }

    private function randomPersonalityTraits($domains): array
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
