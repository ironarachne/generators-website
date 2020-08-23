<?php


namespace App;


class Biome
{
    public string $name;
    public int $fauna_prevalence;
    public int $altitude_min;
    public int $altitude_max;
    public int $match_score;
    public int $temperature_min;
    public int $temperature_max;
    public int $precipitation_min;
    public int $precipitation_max;
    public string $type;
    public int $flora_prevalence;
    public array $tags;

    public function __construct()
    {
        $this->tags = [];
    }

    public static function fromJSON(string $json): Biome
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Biome
    {
        $object = new Biome();

        foreach ($data as $key => $value) {
            if ($key == 'tags') {
                foreach ($data->tags as $t) {
                    $tag = new Tag();
                    $tag->name = $t->name;
                    $object->tags [] = $tag;
                }
            } else {
                $object->{$key} = $value;
            }
        }

        return $object;
    }
}
