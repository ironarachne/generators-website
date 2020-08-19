<?php


namespace App;


class GeographicRegion
{
    public $description;
    public $climate;
    public $biome;
    public $seasons;
    public $animals;
    public $plants;
    public $minerals;
    public $altitude;
    public $humidity;
    public $temperature;
    public $nearest_ocean_distance;
    public $nearest_ocean_direction;
    public $nearest_mountains_distance;
    public $nearest_mountains_direction;
    public $distance_to_equator;

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
