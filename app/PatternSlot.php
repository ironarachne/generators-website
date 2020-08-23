<?php


namespace App;


class PatternSlot
{
    public string $name;
    public string $required_tag;
    public string $description_template;
    public array $possible_quirks;
    public Resource $resource;

    public function __construct()
    {
        $this->possible_quirks = [];
    }
}
