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

    public function describe(): string {
        $description = "{$this->name} is " . pronoun($this->character) . " {$this->character} {$this->category->name}";
        $description .= " of {$this->population} people. Its notable exports are ";
        $description .= combine_phrases($this->common_exports) . ". {$this->surrounding_environment}";

        return $description;
    }
}
