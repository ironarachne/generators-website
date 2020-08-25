<?php


namespace App;


class TraitTemplate
{
    public string $name;
    public array $possible_values;
    public array $possible_descriptors;
    public string $trait_type;
    public array $tags;

    public function __construct()
    {
        $this->possible_values = [];
        $this->possible_descriptors = [];
        $this->tags = [];
    }

    public static function fromJSON(string $json): TraitTemplate
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): TraitTemplate
    {
        $object = new TraitTemplate();

        $object->name = $data->name;
        $object->possible_descriptors = explode(',', $data->possible_descriptors);
        $object->possible_values = explode(',', $data->possible_values);
        $object->trait_type = $data->trait_type;

        foreach($data->tags as $tag) {
            $object->tags [] = Tag::fromObject($tag);
        }

        return $object;
    }
}
