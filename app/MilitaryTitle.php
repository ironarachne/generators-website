<?php


namespace App;


class MilitaryTitle extends Title
{
    public bool $is_officer;
    public string $unit;

    public function __construct(string $prefix, int $precedence, string $unit, bool $isOfficer = false) {
        $this->male_prefix = $prefix;
        $this->female_prefix = $prefix;
        $this->male_suffix = "$prefix of the $unit";
        $this->female_suffix = "$prefix of the $unit";
        $this->is_officer = $isOfficer;
        $this->precedence = $precedence;
    }
}
