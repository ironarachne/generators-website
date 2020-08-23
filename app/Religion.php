<?php


namespace App;


class Religion
{
    public string $name;
    public string $common_name;
    public ReligionCategory $category;
    public Pantheon $pantheon;
    public string $gathering_place;
    public array $virtues;

    public static function fromJSON(string $json): Religion
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Religion
    {
        $object = new Religion();

        foreach ($data as $key => $value) {
            if ($key == 'category') {
                $object->category = ReligionCategory::fromJSON(json_encode($value));
            } elseif ($key == 'pantheon') {
                $object->pantheon = Pantheon::fromJSON(json_encode($value));
            } else {
                $object->{$key} = $value;
            }
        }

        return $object;
    }
}
