<?php


namespace App;


class ReligionGenerator
{
    public function generate(NameGenerator $nameGenerator)
    {
        $religion = new Religion();
        $religion->category = ReligionCategory::random(ReligionCategory::all());
        $religion->name = $this->randomName();
        $religion->common_name = $religion->name;
        $religion->virtues = $this->randomVirtues();
        $religion->gathering_place = random_item($religion->category->gathering_places);

        if ($religion->category->has_pantheon) {
            $pantheonGenerator = new PantheonGenerator();
            $religion->pantheon = $pantheonGenerator->generate($religion->category->pantheon_min_size, $religion->category->pantheon_max_size, $nameGenerator);
        }

        return $religion;
    }

    private function randomName()
    {
        $names = [
            'The Way',
            'The Path',
            'The Truth',
        ];

        return random_item($names);
    }

    private function randomVirtues()
    {
        $numberOfVirtues = mt_rand(3, 6);

        $virtues = [
            'acetism',
            'balance',
            'bravery',
            'carefulness',
            'civic duty',
            'cleanliness',
            'community',
            'compassion',
            'education',
            'faith',
            'generosity',
            'honesty',
            'honor',
            'hope',
            'justice',
            'love',
            'loyalty',
            'nobility',
            'order',
            'prudence',
            'respect',
            'self-reflection',
            'strength',
            'subtlety',
            'temperance',
            'wealth',
        ];

        $result = [];

        for ($i = 0; $i < $numberOfVirtues; $i++) {
            $virtue = random_item($virtues);
            if (!in_array($virtue, $result)) {
                $result [] = $virtue;
            }
        }

        return $result;
    }
}
