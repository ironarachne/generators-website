<?php


namespace App;


abstract class OrganizationType
{
    public string $name;
    public int $min_size;
    public int $max_size;
    public array $possible_traits;
    public LeadershipType $leadership_type;
    public array $ranks;
    public array $member_professions;

    public abstract function generateName();
}
