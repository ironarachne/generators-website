<?php


namespace App;


class NobleTitle extends Title
{
    public bool $is_landed;
    public string $lands_name;

    public function __construct($malePrefix, $femalePrefix, $precedence, $isLanded = false, $landsName = '')
    {
        $this->male_prefix = $malePrefix;
        $this->female_prefix = $femalePrefix;
        $this->precedence = $precedence;
        $this->is_landed = $isLanded;
        $this->lands_name = $landsName;
        $this->male_suffix = $malePrefix;
        $this->female_suffix = $femalePrefix;

        if ($this->lands_name != '') {
            $this->male_suffix .= " of $landsName";
            $this->female_suffix .= " of $landsName";
        }

        $this->type = 'noble';
    }

    public function getFullTitle(string $gender): string
    {
        $name = $this->male_prefix;

        if ($gender == 'female') {
            $name = $this->female_prefix;
        }

        if ($this->is_landed) {
            $name .= " of {$this->lands_name}";
        }

        return $name;
    }

    public function getTitle(string $gender): string
    {
        $name = $this->male_prefix;

        if ($gender == 'female') {
            $name = $this->female_prefix;
        }

        return $name;
    }

    public static function all(): array
    {
        return [
            new NobleTitle('Lord', 'Lady', 0),
            new NobleTitle('Lord', 'Lady', 1, true),
            new NobleTitle('Baron', 'Baroness', 2),
            new NobleTitle('Baron', 'Baroness', 3, true),
            new NobleTitle('Viscount', 'Viscountess', 4),
            new NobleTitle('Viscount', 'Viscountess', 5, true),
            new NobleTitle('Count', 'Countess', 6, true),
            new NobleTitle('Marquess', 'Marchioness', 7, true),
            new NobleTitle('Duke', 'Duchess', 8, true),
            new NobleTitle('Prince', 'Princess', 9, true),
            new NobleTitle('Crown Prince', 'Crown Princess', 10, true),
            new NobleTitle('King', 'Queen', 11, true),
            new NobleTitle('Emperor', 'Empress', 12, true),
        ];
    }

    public static function allLanded(): array
    {
        $landed = [];
        $all = NobleTitle::all();

        foreach ($all as $t) {
            if ($t->is_landed) {
                $landed [] = $t;
            }
        }

        return $landed;
    }

    public static function random(): NobleTitle
    {
        return random_item(NobleTitle::all());
    }

    public static function randomLanded(): NobleTitle
    {
        $landed = NobleTitle::allLanded();

        return random_item($landed);
    }
}
