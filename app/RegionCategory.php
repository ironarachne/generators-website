<?php


namespace App;


class RegionCategory
{
    public string $name;
    public int $max_small_towns;
    public int $min_small_towns;
    public int $max_medium_towns;
    public int $min_medium_towns;
    public int $max_large_towns;
    public int $min_large_towns;
    public int $commonality;
    public LeadershipType $leadership_type;
    public int $max_organizations;
    public int $min_organizations;

    public function __construct(string $name, int $maxSmallTowns, int $minSmallTowns, int $maxMediumTowns,
                                int $minMediumTowns, int $maxLargeTowns, int $minLargeTowns, int $commonality,
                                LeadershipType $leadershipType, int $maxOrganizations, int $minOrganizations)
    {
        $this->name = $name;
        $this->max_small_towns = $maxSmallTowns;
        $this->min_small_towns = $minSmallTowns;
        $this->max_medium_towns = $maxMediumTowns;
        $this->min_medium_towns = $minMediumTowns;
        $this->max_large_towns = $maxLargeTowns;
        $this->min_large_towns = $minLargeTowns;
        $this->commonality = $commonality;
        $this->leadership_type = $leadershipType;
        $this->max_organizations = $maxOrganizations;
        $this->min_organizations = $minOrganizations;
    }

    public static function all(): array
    {
        $barony = new LeadershipType('barony', 1, 1, new NobleTitle('Baron', 'Baroness', 3, true));
        $viscounty = new LeadershipType('viscounty', 1, 1, new NobleTitle('Viscount', 'Viscountess', 5, true));
        $county = new LeadershipType('county', 1, 1, new NobleTitle('Count', 'Countess', 6, true));
        $march = new LeadershipType('march', 1, 1, new NobleTitle('Marquess', 'Marchioness', 7, true));
        $duchy = new LeadershipType('duchy', 1, 1, new NobleTitle('Duke', 'Duchess', 8, true));
        $kingdom = new LeadershipType('kingdom', 1, 1, new NobleTitle('King', 'Queen', 11, true));

        return [
            new RegionCategory('barony', 3, 1, 2, 1, 1, 0, 4, $barony, 2, 0),
            new RegionCategory('viscounty', 4, 2, 3, 1, 1, 1, 3, $viscounty, 2, 1),
            new RegionCategory('county', 4, 3, 3, 2, 1, 1, 5, $county, 3, 1),
            new RegionCategory('march', 5, 3, 3, 3, 2, 1, 3, $march, 3, 2),
            new RegionCategory('duchy', 6, 4, 5, 3, 3, 1, 7, $duchy, 4, 2),
            new RegionCategory('kingdom', 8, 4, 6, 4, 3, 2, 6, $kingdom, 5, 3),
        ];
    }

    public static function random(): RegionCategory {
        $options = [];
        $all = RegionCategory::all();

        foreach ($all as $r) {
            $options[$r->name] = $r->commonality;
        }

        $option = random_weighted_item($options);

        foreach($all as $r) {
            if ($r->name == $option) {
                return $r;
            }
        }

        return $all[0];
    }
}
