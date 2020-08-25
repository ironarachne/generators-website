<?php


namespace App;


class Town
{
    public string $name;
    public string $description;
    public TownCategory $category;
    public int $population;
    public string $surrounding_environment;
    public array $common_exports;
    public string $character;

    public function describe(): string
    {
        $population = number_format($this->population);
        $description = "{$this->name} is " . pronoun($this->character) . " {$this->character} {$this->category->name}";
        $description .= " of $population people. Its notable exports are ";
        $description .= combine_phrases($this->common_exports) . ". The area has {$this->surrounding_environment}.";

        return $description;
    }
}
