<?php


namespace App;


class HolyOrder extends OrganizationType
{
    public function __construct()
    {
        $this->name = 'holy order';
        $this->max_size = 1000;
        $this->min_size = 10;
        $this->possible_traits = [
            'penitent',
            'helpful',
            'selfless',
            'controlling',
            'merciful',
            'merciless',
            'penniless',
            'proselytizing',
        ];
        $this->member_professions = Profession::load('divine');

        $highPriestTitle = new Title('High Priest', 'High Priestess', '', '', 'holy order', 2);
        $priestTitle = new Title('Priest', 'Priestess', '', '', 'holy order', 1);
        $acolyteTitle = new Title('Acolyte', 'Acolyte', '', '', 'holy order', 0);

        $this->leadership_type = new LeadershipType('priesthood', 1, 4, $highPriestTitle);

        $this->ranks = [
            new OrganizationRank('High Priest', $highPriestTitle, 4, ['adult', 'elderly'], true),
            new OrganizationRank('Priest', $priestTitle, 0),
            new OrganizationRank('Acolyte', $acolyteTitle, 0),
        ];

    }

    public function generateName(): string
    {
        $prefixes = [
            'Holy',
            'Glorious',
            'Exalted',
            'Humble',
            'Penitent',
            'Righteous',
        ];

        $suffixes = [
            'Divine Hand',
            'Dove',
            'Eye',
            'Flame',
            'Forest',
            'Four Truths',
            'Iron Path',
            'Light',
            'Meek',
            'Noble Path',
            'Noble Truth',
            'Path',
            'Winding River',
            'Sword',
            'Three Truths',
            'Truth',
            'Unbroken Sword',
        ];

        $prefix = random_item($prefixes);
        $suffix = random_item($suffixes);

        return "$prefix Church of the $suffix";
    }
}
