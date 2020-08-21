<?php


namespace App;


class Title
{
    public string $male_prefix;
    public string $female_prefix;
    public string $male_suffix;
    public string $female_suffix;
    public string $type;
    public int $precedence;

    public function getPrefix($gender)
    {
        if ($gender == 'female') {
            return $this->female_prefix;
        }

        return $this->male_prefix;
    }

    public function getSuffix($gender)
    {
        if ($gender == 'female') {
            return $this->female_suffix;
        }

        return $this->male_suffix;
    }
}
