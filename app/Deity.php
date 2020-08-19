<?php


namespace App;


class Deity
{
    public $name;
    public $gender;
    public $description;
    public $domains;
    public $appearance;
    public $personality_traits;
    public $holy_item;
    public $holy_symbol;
    public $relationships;

    public function describe()
    {
        $type = 'god';

        $subject = 'he';
        $possessive = 'his';
        $object = 'him';

        if ($this->gender == 'female') {
            $type = 'goddess';
            $subject = 'she';
            $possessive = 'her';
            $object = 'her';
        }

        $domains = [];
        foreach ($this->domains as $d) {
            $domains [] = $d->name;
        }

        $description = "{$this->name} is the $type of " . combine_phrases($domains) . '. ';
        $description .= ucfirst($subject) . ' is ' . combine_phrases($this->personality_traits) . ', ';
        $description .= "and is depicted as {$this->appearance}. ";
        $description .= ucfirst($possessive) . " holy item is " . pronoun($this->holy_item) . " {$this->holy_item} ";
        $description .= "and $possessive holy symbol is " . pronoun($this->holy_symbol) . " {$this->holy_symbol}. ";

        if (sizeof($this->relationships) > 0) {
            $description .= "{$this->name} " . combine_phrases($this->relationships) . '.';
        }

        return $description;
    }

    public function removeFrom($haystack)
    {
        $result = [];

        foreach ($haystack as $d) {
            if ($this->name != $d->name) {
                $result [] = $d;
            }
        }

        return $result;
    }
}
