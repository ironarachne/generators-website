<?php


namespace App;


class Resource
{
    public $name;
    public $description;
    public $main_material;
    public $origin;
    public $commonality;
    public $value;
    public $tags;

    public static function byTag($resources, $tagName)
    {
        $result = [];
        $tag = new Tag();
        $tag->name = $tagName;

        foreach ($resources as $r) {
            if ($tag->in($r->tags)) {
                if (!$r->in($result)) {
                    $result[] = $r;
                    continue;
                }
            }
        }

        return $result;
    }

    public function in($haystack)
    {
        foreach ($haystack as $r) {
            if ($this->name == $r->name) {
                return true;
            }
        }

        return false;
    }
}
