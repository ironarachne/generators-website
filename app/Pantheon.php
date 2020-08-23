<?php


namespace App;


class Pantheon
{
    public array $deities;

    public function __construct() {
        $this->deities = [];
    }

    public static function fromJSON(string $json): Pantheon {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Pantheon {
        $object = new Pantheon();

        foreach($data->deities as $deity) {
            $object->deities [] = Deity::fromJSON(json_encode($deity));
        }

        return $object;
    }
}
