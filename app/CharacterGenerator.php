<?php


namespace App;

class CharacterGenerator
{
    public function generate(NameGenerator $name_generator, Species $species): Character
    {
        $character = new Character();

        $character->gender = $this->randomGender();
        $character->orientation = $this->randomOrientation();

        $character->species = $species;

        $full_name = $name_generator->generate($character->gender);
        $full_name = explode(' ', $full_name);

        $character->first_name = $full_name[0];
        $character->last_name = $full_name[1];

        $character->age_category = $species->randomAgeCategory();
        $character->age = $character->age_category->randomAge();

        $character->height = $character->age_category->randomHeight($character->gender);
        $character->weight = $character->age_category->randomWeight($character->gender);

        if (in_array($character->age_category->name, ['teenager', 'young adult', 'adult', 'elderly'])) {
            $character->profession = Profession::random();

            if ($character->profession->name == 'noble') {
                $heraldryGenerator = new HeraldryGenerator();
                $character->heraldry = $heraldryGenerator->random();
                $title = NobleTitle::random();
                if ($title->is_landed) {
                    $title->lands_name = $name_generator->randomPlaceName();
                }
                $character->primary_title = $title->getTitle($character->gender);
                $character->titles = [$title];
            }
        };

        $character->hobby = $this->randomHobby($character->age_category);
        $character->motivation = $this->randomMotivation();

        $character->negative_traits = [];
        $character->positive_traits = [];
        $negativeTraits = $this->randomNegativeTraits();
        $positiveTraits = $this->randomPositiveTraits();
        $positiveTraits = PersonalityTrait::removeIncompatible($negativeTraits, $positiveTraits);
        foreach($negativeTraits as $t) {
            $character->negative_traits [] = $t->name;
        }
        foreach($positiveTraits as $t) {
            $character->positive_traits [] = $t->name;
        }

        $character->physical_traits = $character->species->randomPhysicalTraits();
        $character->description = $character->describe();

        return $character;
    }

    private function randomGender(): string
    {
        $options = [
            'male',
            'female',
        ];

        return random_item($options);
    }

    private function randomHobby(AgeCategory $age_category): string
    {
        if ($age_category->name == 'infant') {
            $options = [
                'drooling',
                'giggling',
                'staring',
            ];
        } elseif ($age_category->name == 'child') {
            $options = [
                'playing street games',
                'exploring',
                'playing hide and seek',
                'making "potions"',
            ];
        } elseif ($age_category->name == 'elderly') {
            $options = [
                'composing poetry',
                'playing chess',
                'playing cards',
                'telling stories',
                'feasting',
                'fishing',
                'painting',
                'watching tournaments',
            ];
        } else {
            $options = [
                'archery',
                'carving',
                'composing poetry',
                'dancing',
                'drinking',
                'feasting',
                'fishing',
                'gambling',
                'hawking',
                'hunting',
                'painting',
                'participating in tournaments',
                'playing darts',
                'playing chess',
                'watching tournaments',
                'whittling',
            ];
        }

        return random_item($options);
    }

    private function randomMotivation(): string
    {
        $options = [
            'a desire to better oneself',
            'achieving destiny',
            'ambition',
            'balance in all things',
            'conquest',
            'conspiracy',
            'control',
            'creativity',
            'debauchery',
            'desperation',
            'distinguishing oneself',
            'duty',
            'escaping destiny',
            'fairness',
            'faith',
            'fame',
            'family',
            'fear',
            'freedom',
            'friends',
            'gaining acceptance',
            'greatness',
            'greed',
            'happiness',
            'hate',
            'honor',
            'justice',
            'knowledge',
            'laziness',
            'love',
            'loyalty',
            'money',
            'pleasure',
            'power',
            'religious devotion',
            'revenge',
            'rivalry',
            'romance',
            'safety',
            'stability',
            'survival',
            'the pursuit of perfection',
            'truth',
        ];

        return random_item($options);
    }

    private function randomNegativeTraits(): array
    {
        $allTraits = PersonalityTrait::negative();
        $result = [];

        $numberOfNegativeTraits = mt_rand(1, 3);

        for ($i = 0; $i < $numberOfNegativeTraits; $i++) {
            $trait = random_item($allTraits);
            if (!$trait->in($result)) {
                $result [] = $trait;
            }
        }

        return $result;
    }

    private function randomOrientation(): string
    {
        $options = [
            'straight' => 100,
            'gay' => 10,
            'bi' => 15,
        ];

        return random_weighted_item($options);
    }

    private function randomPositiveTraits(): array
    {
        $allTraits = PersonalityTrait::positive();
        $result = [];

        $numberOfPositiveTraits = mt_rand(1, 3);

        for ($i = 0; $i < $numberOfPositiveTraits; $i++) {
            $trait = random_item($allTraits);
            if (!$trait->in($result)) {
                $result [] = $trait;
            }
        }

        return $result;
    }
}
