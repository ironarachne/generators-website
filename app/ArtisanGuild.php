<?php


namespace App;


class ArtisanGuild extends OrganizationType
{
    public Profession $profession;

    public function __construct(Profession $profession)
    {
        $this->name = 'artisan guild';
        $this->max_size = 150;
        $this->min_size = 10;
        $this->possible_traits = [
            'ambitious',
            'avaricious',
            'charitable',
            'fair',
            'frugal',
            'lazy',
            'manipulative',
            'observant',
            'productive',
        ];
        $this->profession = $profession;
        $this->member_professions = [$profession];

        $leaderTitle = new Title('Guild Leader', 'Guild Leader', '', '', 'artisan guild', 2);
        $artisanTitle = new Title('Artisan', 'Artisan', '', '', 'artisan guild', 1);
        $apprenticeTitle = new Title('Apprentice', 'Apprentice', '', '', 'artisan guild', 0);

        $this->leadership_type = new LeadershipType('council', 2, 4, $leaderTitle);
        $this->ranks = [
            new OrganizationRank('Guild Leader', $leaderTitle, 4, ['adult', 'elderly'], true),
            new OrganizationRank('Artisan', $artisanTitle, 0),
            new OrganizationRank('Apprentice Artisan', $apprenticeTitle, 0, ['teenager', 'young adult']),
        ];
    }

    public function generateName(): string
    {
        $qualifiers = [
            'August',
            'East Wind',
            'Global',
            'Imperial',
            'Incorporated',
            'North Wind',
            'Royal',
            'South Wind',
            'West Wind',
        ];

        $qualifier = random_item($qualifiers);

        $professionName = ucfirst($this->profession->name);

        $patterns = [
            "$qualifier Guild of {$professionName}s",
            "$qualifier $professionName's Guild",
        ];

        return random_item($patterns);
    }
}
