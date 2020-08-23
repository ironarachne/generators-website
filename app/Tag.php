<?php


namespace App;


class Tag
{
    public string $name;

    public static function fromJSON(string $json): Tag {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Tag {
        $object = new Tag();

        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }

    public function in($haystack)
    {
        foreach ($haystack as $tag) {
            if ($tag->name == $this->name) {
                return true;
            }
        }

        return false;
    }
}
