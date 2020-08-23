<?php


namespace App;


class Climate
{
    public string $cloud_cover;
    public int $wind_strength;
    public int $wind_direction;
    public int $precipitation_amount;
    public int $precipitation_frequency;
    public string $precipitation_type;

    public function describeClouds(): string
    {
        if ($this->cloud_cover < 10) {
            return 'no clouds';
        } else if ($this->cloud_cover < 30) {
            return 'few clouds';
        } else if ($this->cloud_cover < 50) {
            return 'some clouds';
        } else if ($this->cloud_cover < 70) {
            return 'many clouds';
        }

        return 'frequently overcast skies';
    }

    public static function fromJSON(string $json): Climate
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Climate
    {
        $object = new Climate();

        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }
}
