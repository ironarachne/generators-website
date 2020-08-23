<?php


namespace App;


use Exception;

class CuisineGenerator
{
    public function generate($resources)
    {
        $includeMeat = true;

        $chanceVegetarian = mt_rand(0, 100);
        if ($chanceVegetarian > 90) {
            $includeMeat = false;
        }

        $cuisine = new Cuisine();
        $cuisine->is_vegetarian = !$includeMeat;
        $cuisine->cooking_methods = $this->randomCookingMethods();
        $cuisine->flavors = $this->randomFlavorProfiles();
        $cuisine->main_ingredients = $this->randomMainIngredients($resources, $includeMeat);
        $cuisine->spices = $this->randomSpices($resources);
        $cuisine->description = $cuisine->describe();

        return $cuisine;
    }

    private function randomCookingMethods()
    {
        $options = [
            'over rice',
            'over noodles',
            'in stews',
            'in soups',
            'baked',
            'roasted',
            'fried',
            'boiled',
            'steamed',
        ];

        $methods = [];

        for ($i = 0; $i < 3; $i++) {
            $method = random_item($options);
            if (!in_array($method, $methods)) {
                $methods [] = $method;
            }
        }

        return $methods;
    }

    private function randomFlavorProfiles()
    {
        $flavors = [
            'sour',
            'sweet',
            'salty',
            'savory',
            'bitter',
        ];

        $degrees = [
            'slightly ',
            'quite ',
            'strongly ',
            'very ',
            '',
            '',
            '',
        ];

        $first = random_item($flavors);
        $firstDegree = random_item($degrees);

        $profiles = ["$firstDegree$first"];

        $chanceSecond = mt_rand(0, 100);

        if ($chanceSecond > 30) {
            $second = random_item($flavors);
            $secondDegree = random_item($degrees);

            if ($first != $second) {
                $profiles [] = "$secondDegree$second";
            }
        }

        return $profiles;
    }

    private function randomMainIngredients($resources, $includeMeat)
    {
        $bases = [];

        if ($includeMeat) {
            $meat = Resource::byTag($resources, 'meat');
            $eggs = Resource::byTag($resources, 'eggs');
            $bases = array_merge($bases, $meat, $eggs);
        }

        $vegetables = Resource::byTag($resources, 'vegetable');

        $bases = array_merge($bases, $vegetables);

        if (sizeof($bases) == 0) {
            throw new Exception('no food bases to use');
        }

        $numberOfMainIngredients = mt_rand(2, 5);

        $ingredients = [];

        for ($i = 0; $i < $numberOfMainIngredients; $i++) {
            $ingredient = random_item($bases);
            if (!in_array($ingredient->name, $ingredients)) {
                $ingredients [] = $ingredient->name;
            }
        }

        return $ingredients;
    }

    private function randomSpices($resources)
    {
        $options = [];

        $spices = Resource::byTag($resources, 'spice');
        $herbs = Resource::byTag($resources, 'herb');

        $options = array_merge($options, $spices, $herbs);

        if (sizeof($options) == 0) {
            return [];
        }

        $numberOfSpices = mt_rand(1, 4);

        $result = [];

        for ($i = 0; $i < $numberOfSpices; $i++) {
            $s = random_item($options);
            if (!in_array($s->name, $result)) {
                $result [] = $s->name;
            }
        }

        return $result;
    }
}
