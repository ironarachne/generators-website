<?php


namespace App;


class Season
{
    public string $name;
    public string $description;
    public int $temperature_change;
    public int $humidity_change;
    public int $daylight_hours;
    public string $precipitation_type;
    public int $precipitation_frequency_change;
    public int $precipitation_amount_change;
    public int $month_begin;
    public int $month_end;

    public static function fromJSON(string $json): Season
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Season
    {
        $object = new Season();

        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }
}
