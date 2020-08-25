<?php


namespace App;


class MercenaryCompany extends OrganizationType
{
    public function __construct()
    {
        $this->name = 'mercenary company';
        $this->max_size = 500;
        $this->min_size = 20;
        $this->possible_traits = [
            'aggressive',
            'avaricious',
            'charismatic',
            'forceful',
            'heroic',
            'honorable',
            'dishonorable',
            'dangerous',
            'trustworthy',
        ];
        $this->member_professions = Profession::load('fighter');

        $captainTitle = new Title('Captain', 'Captain', '', '', 'mercenary company', 1);
        $mercenaryTitle = new Title('Mercenary', 'Mercenary', '', '', 'mercenary company', 0);

        $this->leadership_type = new LeadershipType('captaincy', 1, 1, $captainTitle);
        $this->ranks = [
            new OrganizationRank('Captain', $captainTitle, 1, ['adult'], true),
            new OrganizationRank('Mercenary', $mercenaryTitle, 0),
        ];
    }

    public function generateName(): string
    {
        $prefixes = [
            'Black',
            'Blood',
            'Burning',
            'Crimson',
            'Free',
            'Gilded',
            'Golden',
            'Iron',
            'Red',
            'Silver',
            'White',
        ];

        $suffixes = [
            'Axes',
            'Army',
            'Blades',
            'Coins',
            'Company',
            'Dragons',
            'Giants',
            'Lords',
            'Pikes',
            'Sentinels',
            'Swords',
            'Wolves',
            'Wyverns',
        ];

        return random_item($prefixes) . ' ' . random_item($suffixes);
    }
}
