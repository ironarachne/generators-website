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
}
