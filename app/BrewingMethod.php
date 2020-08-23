<?php


namespace App;


class BrewingMethod
{
    public string $name;
    public string $base_tag;

    public function __construct(string $name, string $baseTag) {
        $this->name = $name;
        $this->base_tag = $baseTag;
    }

    public static function fromJSON(string $json): BrewingMethod {
        $data = json_decode($json);

        return new BrewingMethod($data->name, $data->base_tag);
    }

    public static function fromObject(\stdClass $data): BrewingMethod {
        return new BrewingMethod($data->name, $data->base_tag);
    }
}
