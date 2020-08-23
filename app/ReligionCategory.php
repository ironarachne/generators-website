<?php


namespace App;


class ReligionCategory
{
    public string $name;
    public int $commonality;
    public string $founder_title;
    public string $leader_title;
    public int $pantheon_max_size;
    public int $pantheon_min_size;
    public array $gathering_places;
    public bool $has_pantheon;

    public function __construct(string $name, int $commonality, string $founderTitle, string $leaderTitle,
                                int $pantheonMax, int $pantheonMin, array $gatheringPlaces, bool $hasPantheon)
    {
        $this->name = $name;
        $this->commonality = $commonality;
        $this->founder_title = $founderTitle;
        $this->leader_title = $leaderTitle;
        $this->pantheon_max_size = $pantheonMax;
        $this->pantheon_min_size = $pantheonMin;
        $this->gathering_places = $gatheringPlaces;
        $this->has_pantheon = $hasPantheon;
    }

    public static function all()
    {
        $standard = ['temple', 'shrine', 'church', 'cathedral'];

        $monotheistic = new ReligionCategory('monotheistic', 5, 'prophet', 'priest', 1, 1, $standard, true);
        $duotheistic = new ReligionCategory('duotheistic', 1, 'prophet', 'priest', 2, 2, $standard, true);
        $polytheistic = new ReligionCategory('polytheistic', 17, 'prophet', 'priest', 30, 7, $standard, true);
        $shamanistic = new ReligionCategory('shamanistic', 2, 'shaman', 'shaman', 0, 0, ['medicine lodge', 'sweat lodge', 'spirit lodge'], false);
        $atheistic = new ReligionCategory('atheistic', 1, 'philosopher', 'sage', 0, 0, ['great hall', 'forum', 'public house', 'town square'], false);

        return [$monotheistic, $duotheistic, $polytheistic, $shamanistic, $atheistic];
    }

    public static function fromJSON(string $json): ReligionCategory
    {
        $data = json_decode($json);

        return new ReligionCategory($data->name, $data->commonality, $data->founder_title, $data->leader_title,
            $data->pantheon_max_size, $data->pantheon_min_size, $data->gathering_places, $data->has_pantheon);
    }

    public static function random($categories)
    {
        $categoryNames = [];

        foreach ($categories as $c) {
            $categoryNames[$c->name] = $c->commonality;
        }

        $categoryName = random_weighted_item($categoryNames);

        foreach ($categories as $c) {
            if ($c->name == $categoryName) {
                return $c;
            }
        }

        return null;
    }
}
