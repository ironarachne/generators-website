<?php


namespace App;


use Exception;

class AlcoholicDrinkGenerator
{
    public function generate($resources, $name) {
        $methods = [];

        $spices = Resource::byTag($resources, 'spice');
        $grains = Resource::byTag($resources, 'grain');
        $herbs = Resource::byTag($resources, 'herb');
        $fruit = Resource::byTag($resources, 'fruit');
        $milk = Resource::byTag($resources, 'milk');

        if (sizeof($grains) > 0) {
            $methods []= [
                'name' => 'fermented',
                'base_tag' => 'grain',
            ];

            $methods []= [
                'name' => 'distilled',
                'base_tag' => 'grain',
            ];
        }

        if (sizeof($fruit) > 0) {
            $methods []= [
                'name' => 'fermented',
                'base_tag' => 'fruit',
            ];
        }

        if (sizeof($milk) > 0) {
            $methods []= [
                'name' => 'fermented',
                'base_tag' => 'milk',
            ];
        }

        if (sizeof($methods) == 0) {
            throw new Exception('no applicable resources');
        }

        $method = random_item($methods);

        $strength = $this->randomStrength();

        $baseOptions = Resource::byTag($resources, $method['base_tag']);
        $baseResource = random_item($baseOptions);
        $base = $baseResource->name;

        $description = "a beverage called $name, which is " . $method['name'] . " from $base";

        $chanceExtras = mt_rand(0, 100);
        if ($chanceExtras > 80) {
            $extras = [];
            $extras []= random_item($spices);
            $extras []= random_item($herbs);
            $extra = random_item($extras);
            $description .= ' with ' . $extra->name;
        }

        $drink = new AlcoholicDrink();
        $drink->name = $name;
        $drink->description = $description;
        $drink->base = $baseResource;
        $drink->strength = $strength;
        $drink->type = $method;

        return $drink;
    }

    public function randomName() {
        $prefixes = [
            'fire',
            'gods',
            'blessed ',
            'heart',
            'dragons',
        ];

        $suffixes = [
            'water',
            'milk',
            'fruit',
        ];

        return random_item($prefixes) . random_item($suffixes);
    }

    public function randomStrength() {
        $strengths = [
            'very weak',
            'weak',
            '',
            'strong',
            'very strong',
        ];

        return random_item($strengths);
    }
}