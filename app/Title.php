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

    public function __construct(string $malePrefix, string $femalePrefix, string $maleSuffix, string $femaleSuffix, string $type, int $precedence)
    {
        $this->male_prefix = $malePrefix;
        $this->female_prefix = $femalePrefix;
        $this->male_suffix = $maleSuffix;
        $this->female_suffix = $femaleSuffix;
        $this->type = $type;
        $this->precedence = $precedence;
    }

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
