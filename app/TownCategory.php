<?php


namespace App;


class TownCategory
{
    public string $name;
    public int $min_size;
    public int $max_size;
    public bool $has_districts;
    public array $districts;
    public int $commonality;
    public array $export_types;
    public array $possible_character;

    public function __construct(string $name, int $min, int $max, int $commonality, array $possibleCharacter, array $exportTypes = [], bool $hasDistricts = false, array $districts = [])
    {
        $this->name = $name;
        $this->min_size = $min;
        $this->max_size = $max;
        $this->commonality = $commonality;
        $this->export_types = $exportTypes;
        $this->has_districts = $hasDistricts;
        $this->districts = $districts;
        $this->possible_character = $possibleCharacter;
    }

    public function randomCharacter(): string
    {
        return random_item($this->possible_character);
    }

    public function randomExports(): array
    {
        $exports = [];
        $numberOfExports = 3;

        if ($this->max_size < 100) {
            $numberOfExports = 2;
        }

        if ($this->max_size > 10000) {
            $numberOfExports = 4;
        }

        for ($i = 0; $i < $numberOfExports; $i++) {
            $export = random_item($this->export_types);
            if (!in_array($export, $exports)) {
                $exports [] = $export;
            }
        }

        return $exports;
    }

    public function randomSize(): int
    {
        return mt_rand($this->min_size, $this->max_size);
    }

    public static function all(): array
    {
        $simpleExports = [
            'ore',
            'stone',
            'vegetables',
            'fruit',
            'meat',
            'grain',
            'hides',
            'herbs',
            'spices',
        ];

        $refinedExports = [
            'metal goods',
            'building materials',
            'leather goods',
            'textiles',
            'clothing',
            'armor',
            'weapons',
            'alcoholic beverages',
            'furniture',
            'paper',
        ];

        $advancedExports = [
            'books',
            'magical artifacts',
            'spell scrolls',
            'potions',
        ];

        $smallExports = $simpleExports;
        $mediumExports = array_merge($simpleExports, $refinedExports);
        $largeExports = array_merge($mediumExports, $advancedExports);

        $smallCharacter = [
            'simple',
            'filthy',
            'quaint',
            'rustic',
            'run down',
            'cheerful',
        ];

        $mediumCharacter = [
            'lively',
            'dangerous',
            'busy',
            'active',
            'boisterous',
            'foul-smelling',
            'clean',
            'organized',
        ];

        $largeCharacter = [
            'imperious',
            'glorious',
            'marvelous',
            'corrupt',
            'segregated',
            'filthy',
            'ornate',
            'towering',
            'expansive',
            'ominous',
            'hazy',
        ];

        return [
            new TownCategory('hamlet', 10, 49, 10, $smallCharacter, $smallExports),
            new TownCategory('village', 50, 499, 20, $smallCharacter, $smallExports),
            new TownCategory('town', 500, 9999, 15, $mediumCharacter, $mediumExports),
            new TownCategory('borough', 10000, 19999, 5, $mediumCharacter, $mediumExports),
            new TownCategory('city', 20000, 49999, 5, $largeCharacter, $largeExports),
            new TownCategory('metropolis', 50000, 3000000, 1, $largeCharacter, $largeExports),
        ];
    }

    public static function randomSmall(): TownCategory
    {
        $all = TownCategory::all();
        $options = [];

        foreach ($all as $c) {
            if ($c->max_size < 10000) {
                $options[$c->name] = $c->commonality;
            }
        }

        $result = random_weighted_item($options);

        foreach ($all as $c) {
            if ($c->name == $result) {
                return $c;
            }
        }
    }

    public static function randomMedium(): TownCategory
    {
        $all = TownCategory::all();
        $options = [];

        foreach ($all as $c) {
            if ($c->max_size > 10000 && $c->min_size <= 20000) {
                $options[$c->name] = $c->commonality;
            }
        }

        $result = random_weighted_item($options);

        foreach ($all as $c) {
            if ($c->name == $result) {
                return $c;
            }
        }
    }

    public static function randomLarge(): TownCategory
    {
        $all = TownCategory::all();
        $options = [];

        foreach ($all as $c) {
            if ($c->max_size > 40000) {
                $options[$c->name] = $c->commonality;
            }
        }

        $result = random_weighted_item($options);

        foreach ($all as $c) {
            if ($c->name == $result) {
                return $c;
            }
        }
    }

    public static function random(): TownCategory
    {
        $all = TownCategory::all();
        $options = [];

        foreach ($all as $c) {
            $options[$c->name] = $c->commonality;
        }

        $result = random_weighted_item($options);

        foreach ($all as $c) {
            if ($c->name == $result) {
                return $c;
            }
        }
    }
}
