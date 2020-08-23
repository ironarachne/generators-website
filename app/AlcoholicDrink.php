<?php


namespace App;

class AlcoholicDrink
{
    public string $name;
    public string $description;
    public string $appearance;
    public BrewingMethod $type;
    public string $strength;
    public Resource $base;
    public array $ingredients;

    public static function fromJSON(string $json): AlcoholicDrink
    {
        $data = json_decode($json);

        $object = new AlcoholicDrink();

        foreach ($data as $key => $value) {
            if ($key == 'base') {
                $object->base = Resource::fromJSON(json_encode($value));
            } elseif ($key == 'type') {
                $object->type = BrewingMethod::fromJSON(json_encode($value));
            }
            else {
                $object->{$key} = $value;
            }
        }

        return $object;
    }

    public static function fromObject(\stdClass $data): AlcoholicDrink
    {
        $object = new AlcoholicDrink();

        foreach ($data as $key => $value) {
            if ($key == 'base') {
                $object->base = Resource::fromObject($value);
            } elseif ($key == 'type') {
                $object->type = BrewingMethod::fromObject($value);
            }
            else {
                $object->{$key} = $value;
            }
        }

        return $object;
    }
}
