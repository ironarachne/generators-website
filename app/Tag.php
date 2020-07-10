<?php


namespace App;


class Tag
{
    public $name;

    public function in($haystack) {
        foreach ($haystack as $tag) {
            if ($tag->name == $this->name) {
                return true;
            }
        }

        return false;
    }
}
