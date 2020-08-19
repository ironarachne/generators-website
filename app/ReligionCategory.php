<?php


namespace App;


class ReligionCategory
{
    public $name;
    public $commonality;
    public $founder_title;
    public $leader_title;
    public $pantheon_max_size;
    public $pantheon_min_size;
    public $gathering_places;
    public $has_pantheon;

    public static function all()
    {
        $monotheistic = new ReligionCategory();
        $monotheistic->name = 'monotheistic';
        $monotheistic->commonality = 5;
        $monotheistic->founder_title = 'prophet';
        $monotheistic->leader_title = 'priest';
        $monotheistic->pantheon_max_size = 1;
        $monotheistic->pantheon_min_size = 1;
        $monotheistic->gathering_places = ['temple', 'shrine', 'church'];
        $monotheistic->has_pantheon = true;

        $duotheistic = new ReligionCategory();
        $duotheistic->name = 'duotheistic';
        $duotheistic->commonality = 1;
        $duotheistic->founder_title = 'prophet';
        $duotheistic->leader_title = 'priest';
        $duotheistic->pantheon_max_size = 2;
        $duotheistic->pantheon_min_size = 2;
        $duotheistic->gathering_places = ['temple', 'shrine', 'church'];
        $duotheistic->has_pantheon = true;

        $polytheistic = new ReligionCategory();
        $polytheistic->name = 'polytheistic';
        $polytheistic->commonality = 17;
        $polytheistic->founder_title = 'prophet';
        $polytheistic->leader_title = 'priest';
        $polytheistic->pantheon_max_size = 30;
        $polytheistic->pantheon_min_size = 7;
        $polytheistic->gathering_places = ['temple', 'shrine', 'church'];
        $polytheistic->has_pantheon = true;

        $shamanistic = new ReligionCategory();
        $shamanistic->name = 'shamanistic';
        $shamanistic->commonality = 2;
        $shamanistic->founder_title = 'shaman';
        $shamanistic->leader_title = 'shaman';
        $shamanistic->pantheon_max_size = 0;
        $shamanistic->pantheon_min_size = 0;
        $shamanistic->gathering_places = ['medicine lodge', 'sweat lodge', 'spirit lodge'];
        $shamanistic->has_pantheon = false;

        $atheistic = new ReligionCategory();
        $atheistic->name = 'atheistic';
        $atheistic->commonality = 1;
        $atheistic->founder_title = 'philosopher';
        $atheistic->leader_title = 'sage';
        $atheistic->pantheon_max_size = 0;
        $atheistic->pantheon_min_size = 0;
        $atheistic->gathering_places = ['great hall', 'forum', 'public house', 'town square'];
        $atheistic->has_pantheon = false;

        return [$monotheistic, $duotheistic, $polytheistic, $shamanistic, $atheistic];
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
