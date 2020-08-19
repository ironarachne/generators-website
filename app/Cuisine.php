<?php


namespace App;


class Cuisine
{
    public $description;
    public $flavors;
    public $main_ingredients;
    public $cooking_methods;
    public $spices;
    public $is_vegetarian;

    public function describe() {
        $description = 'This cuisine has ' . combine_phrases($this->flavors) . ' flavor profiles';

        $description .= ', favoring ' . combine_phrases($this->spices) . ' for spices. ';
        $description .= 'Main ingredients commonly include ' . combine_phrases($this->main_ingredients) . '. ';
        $description .= 'Dishes are usually ' . combine_phrases($this->cooking_methods, false) . '.';

        return $description;
    }
}
