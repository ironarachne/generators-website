<?php


namespace App;


class Organization
{
    public string $name;
    public string $size;
    public int $number_of_members;
    public string $description;
    public array $notable_members;
    public array $leaders;
    public string $primary_trait;
    public OrganizationType $type;

    public function describe(): string
    {
        $leaderNames = [];

        foreach ($this->leaders as $leader) {
            $leaderNames [] = $leader->primary_title . " {$leader->first_name} {$leader->last_name}";
        }

        $description = "The {$this->name} is " . pronoun($this->size) . " {$this->size} {$this->type->name} with ";
        $description .= "{$this->number_of_members} members. It's led by " . combine_phrases($leaderNames) . '. ';
        $description .= "This {$this->type->name} is known for being {$this->primary_trait}.";

        return $description;
    }

    public function getLeaderAgeCategories(): array
    {
        $leaderRankName = $this->type->leadership_type->title->male_prefix;

        foreach ($this->type->ranks as $rank) {
            if ($rank->title->male_prefix == $leaderRankName) {
                return $rank->possible_age_categories;
            }
        }

        return [];
    }

    public function getMembersOfRank(OrganizationRank $rank): array
    {
        $result = [];

        foreach ($this->notable_members as $member) {
            foreach ($member->titles as $title) {
                if ($title->male_prefix == $rank->title->male_prefix) {
                    $result [] = $member;
                }
            }
        }

        return $result;
    }

    public function getRandomMemberRank(): OrganizationRank
    {
        $possibleRanks = [];

        foreach ($this->type->ranks as $rank) {
            if ($rank->is_leader) {
                continue;
            }

            $membersOfRank = $this->getMembersOfRank($rank);

            if ($rank->maximum_holders == 0 || sizeof($membersOfRank) < $rank->maximum_holders) {
                $possibleRanks [] = $rank;
            }
        }

        $rank = random_item($possibleRanks);

        return $rank;
    }

    public function getSizeClass(): string
    {
        $min = $this->type->min_size;
        $max = $this->type->max_size;
        $number = $this->number_of_members;
        $range = $max - $min;

        if ($number < ($min + ($range / 3))) {
            return 'small';
        } else if ($number < ($min + ($range / 2))) {
            return 'medium';
        } else if ($number < ($min + (($range * 2) / 3))) {
            return 'large';
        }

        return 'huge';
    }

    public function randomProfession(): Profession
    {
        $professions = $this->type->member_professions;

        return random_item($professions);
    }
}
