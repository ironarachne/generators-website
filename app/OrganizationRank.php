<?php


namespace App;


class OrganizationRank
{
    public string $name;
    public bool $is_leader;
    public Title $title;
    public array $possible_age_categories;
    public int $maximum_holders;

    public function __construct(string $name, Title $title, int $maximumHolders, array $possibleAgeCategories = ['young adult', 'adult'], $is_leader = false)
    {
        $this->name = $name;
        $this->title = $title;
        $this->is_leader = $is_leader;
        $this->maximum_holders = $maximumHolders;
        $this->possible_age_categories = $possibleAgeCategories;
    }

    public function canHaveMore(int $current) {
        if ($this->maximum_holders == 0 || $this->maximum_holders > $current) {
            return true;
        }

        return false;
    }
}
