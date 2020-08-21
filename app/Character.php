<?php


namespace App;


class Character
{
    public string $first_name;
    public string $last_name;
    public string $primary_title;
    public array $titles;
    public Heraldry $heraldry;
    public string $gender;
    public int $age;
    public AgeCategory $age_category;
    public string $orientation;
    public int $height;
    public int $weight;
    public Profession $profession;
    public string $hobby;
    public array $negative_traits;
    public array $positive_traits;
    public string $motivation;
    public array $physical_traits;
    public Species $species;
    public string $description;

    public function describe(): string
    {
        $description = '';

        if (!empty($this->primary_title)) {
            $description .= "{$this->primary_title} ";
        }

        $possessive = $this->gender == 'male' ? 'his' : 'her';
        $subject = $this->gender == 'male' ? 'he' : 'she';
        $object = $this->gender == 'male' ? 'him' : 'her';

        $height = inches_to_feet($this->height);

        $description .= "{$this->first_name} is " . pronoun($this->species->name) . " {$this->species->name} ";
        $description .= $this->genderNoun() . " of {$this->age} years. ";
        $description .= ucfirst($subject) . " is $height and weighs {$this->weight} pounds, with ";
        $description .= combine_phrases($this->physical_traits) . ". ";
        $description .= "Motivated by {$this->motivation}, {$this->first_name} is ";
        $description .= combine_phrases($this->positive_traits) . ', though also ' . combine_phrases($this->negative_traits) . '. ';

        if (!empty($this->profession)) {
            $description .= ucfirst($subject) . ' is ' . pronoun($this->profession->name) . ' ' . $this->profession->name;

            if ($this->profession->name == 'noble') {
                $description .= " and $possessive coat of arms is \"" . $this->heraldry->blazon . '."';
            } else {
                $description .= '.';
            }
        }

        return $description;
    }

    public function genderNoun(): string {
        if ($this->age_category->name == 'infant') {
            return 'infant';
        }

        if ($this->age_category->name == 'child' || $this->age_category == 'teenager') {
            if ($this->gender == 'male') {
                return 'boy';
            }

            return 'girl';
        }

        if ($this->gender == 'female') {
            return 'woman';
        }

        return 'man';
    }
}
