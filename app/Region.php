<?php


namespace App;


class Region
{
    public string $name;
    public string $area_description;
    public string $biome;
    public GeographicRegion $geography;
    public Culture $culture;
    public RegionCategory $category;
    public array $towns;
    public Town $capital;
    public Character $ruler;
    public array $organizations;

    public function __construct()
    {
        $this->towns = [];
        $this->organizations = [];
    }
}
