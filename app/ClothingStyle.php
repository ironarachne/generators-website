<?php


namespace App;


class ClothingStyle
{
    public string $male_adornment;
    public string $female_adornment;
    public string $male_outfit;
    public string $female_outfit;

    public static function fromJSON(string $json): ClothingStyle
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): ClothingStyle
    {
        $clothing = new ClothingStyle();

        foreach ($data as $key => $value) {
            $clothing->{$key} = $value;
        }

        return $clothing;
    }
}
