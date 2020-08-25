<?php


namespace App;


class LeadershipType
{
    public string $name;
    public int $max_leaders;
    public int $min_leaders;
    public Title $title;

    public function __construct(string $name, int $min, int $max, Title $title)
    {
        $this->name = $name;
        $this->max_leaders = $max;
        $this->min_leaders = $min;
        $this->title = $title;
    }
}
