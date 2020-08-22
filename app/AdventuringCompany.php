<?php


namespace App;


class AdventuringCompany extends OrganizationType
{
    public function __construct()
    {
        $this->name = 'adventuring company';
        $this->max_size = 50;
        $this->min_size = 2;
        $this->possible_traits = [
            'aggressive',
            'avaricious',
            'charismatic',
            'curious',
            'forceful',
            'heroic',
            'honorable',
            'reckless',
            'reserved',
            'selfless',
        ];

        $professions = Profession::load('divine');
        $professions = array_merge($professions, Profession::load('fighter'));
        $professions = array_merge($professions, Profession::load('mage'));

        $this->member_professions = $professions;

        $captainTitle = new Title('Captain', 'Captain', '', '', 'adventuring company', 1);
        $adventurerTitle = new Title('Adventurer', 'Adventurer', '', '', 'adventuring company', 0);

        $this->leadership_type = new LeadershipType('captaincy', 1, 1, $captainTitle);
        $this->ranks = [
            new OrganizationRank('Captain', $captainTitle, 1, ['adult'], true),
            new OrganizationRank('Adventurer', $adventurerTitle, 0, ['young adult', 'adult'], false),
        ];
    }

    public function generateName(): string
    {
        $prefixes = [
            'Black',
            'Burning',
            'Crimson',
            'Free',
            'Golden',
            'Iron',
            'Righteous',
            'Silver',
            'Wandering',
            'White',
        ];

        $suffixes = [
            'Axes',
            'Blades',
            'Coins',
            'Company',
            'Dragons',
            'Giants',
            'Lords',
            'Pikes',
            'Swords',
            'Wolves',
            'Wyverns',
        ];

        return random_item($prefixes) . ' ' . random_item($suffixes);
    }
}
