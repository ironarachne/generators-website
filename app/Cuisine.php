<?php


namespace App;


class Cuisine
{
    public string $description;
    public array $flavors;
    public array $main_ingredients;
    public array $cooking_methods;
    public array $spices;
    public bool $is_vegetarian;

    public function describe()
    {
        $description = 'This cuisine has ' . combine_phrases($this->flavors) . ' flavor profiles';

        $description .= ', favoring ' . combine_phrases($this->spices) . ' for spices. ';
        $description .= 'Main ingredients commonly include ' . combine_phrases($this->main_ingredients) . '. ';
        $description .= 'Dishes are usually ' . combine_phrases($this->cooking_methods, false) . '.';

        return $description;
    }

    public static function fromJSON(string $json): Cuisine {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Cuisine {
        $cuisine = new Cuisine();

        foreach ($data as $key => $value) {
            $cuisine->{$key} = $value;
        }

        return $cuisine;
    }
}
