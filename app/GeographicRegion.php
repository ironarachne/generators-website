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

    public function __construct()
    {
        $this->seasons = [];
        $this->animals = [];
        $this->plants = [];
        $this->minerals = [];
    }

    public function resources()
    {
        $resources = [];

        foreach ($this->animals as $a) {
            if (!empty($a->resources)) {
                $resources = array_merge($resources, $a->resources);
            }
        }

        foreach ($this->plants as $p) {
            if (!empty($p->resources)) {
                $resources = array_merge($resources, $p->resources);
            }
        }

        foreach ($this->minerals as $m) {
            if (!empty($m->resources)) {
                $resources = array_merge($resources, $m->resources);
            }
        }

        return $resources;
    }

    public static function fromJSON(string $json): GeographicRegion
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): GeographicRegion
    {
        $object = new GeographicRegion();

        foreach ($data as $key => $value) {
            if ($key == 'climate') {
                $object->climate = Climate::fromObject($value);
            } elseif ($key == 'biome') {
                $object->biome = Biome::fromObject($value);
            } elseif ($key == 'seasons') {
                foreach ($value as $s) {
                    $object->seasons[] = Season::fromObject($s);
                }
            } elseif ($key == 'animals' || $key == 'plants') {
                foreach ($value as $s) {
                    $object->$key [] = Species::fromObject($s);
                }
            } elseif ($key == 'minerals') {
                foreach ($value as $m) {
                    $object->minerals [] = Mineral::fromObject($m);
                }
            } else {
                $object->{$key} = $value;
            }
        }

        return $object;
    }
}
