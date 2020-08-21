<?php


namespace App;


class GeographicRegion
{
    public string $description;
    public Climate $climate;
    public Biome $biome;
    public array $seasons;
    public array $animals;
    public array $plants;
    public array $minerals;
    public int $altitude;
    public int $humidity;
    public int $temperature;
    public int $nearest_ocean_distance;
    public int $nearest_ocean_direction;
    public int $nearest_mountains_distance;
    public int $nearest_mountains_direction;
    public int $distance_to_equator;

    public function resources()
    {
        $resources = [];

        foreach($this->animals as $a) {
            if (!empty($a->resources)) {
                $resources = array_merge($resources, $a->resources);
            }
        }

        foreach($this->plants as $p) {
            if (!empty($p->resources)) {
                $resources = array_merge($resources, $p->resources);
            }
        }

        foreach($this->minerals as $m) {
            if (!empty($m->resources)) {
                $resources = array_merge($resources, $m->resources);
            }
        }

        return $resources;
    }
}
