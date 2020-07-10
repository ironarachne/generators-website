<?php

if (!function_exists('distribute_array')) {
    function distribute_array($array1, $array2)
    {
        $availableElements = $array2;

        $iterations[] = $availableElements;

        foreach ($array1 as $element) {
            $index = rnd(count($availableElements) - 1);
            $myElement = $availableElements[$index];
            unset($availableElements[$index]);
            $availableElements = array_values($availableElements);

            $randomizedElements[$element] = $myElement;
        }

        return $randomizedElements;
    }
}

if (!function_exists('rnd')) {
    function rnd($max)
    {
        srand();

        return mt_rand(0, $max);
    }
}

if (!function_exists('seeder')) {
    function seeder($seed)
    {
        $seedNumber = '';
        $byteArray = unpack('C*', $seed);
        foreach ($byteArray as $b) {
            $seedNumber .= $b;
        }
        $seedNumber = intval($seedNumber);
        srand($seedNumber);
    }
}

if (!function_exists('pronoun')) {
    function pronoun($word) {
        $pronoun = 'a';

        $firstLetter = $word[0];

        if (in_array($firstLetter, ['a', 'e', 'i', 'o', 'u'])) {
            $pronoun = 'an';
        }

        return $pronoun;
    }
}

if (!function_exists('direction_word')) {
    function direction_word($direction)
    {
        $directions = [
            'north',
            'northeast',
            'east',
            'southeast',
            'south',
            'southwest',
            'west',
            'northwest',
        ];

        return $directions[$direction];
    }
}

if (!function_exists('opposite_direction')) {
    function opposite_direction($direction)
    {
        if ($direction == 0) {
            $opposite = 4;
        } else if ($direction == 1) {
            $opposite = 5;
        } else if ($direction == 2) {
            $opposite = 6;
        } else if ($direction == 3) {
            $opposite = 7;
        } else if ($direction == 4) {
            $opposite = 0;
        } else if ($direction == 5) {
            $opposite = 1;
        } else if ($direction == 6) {
            $opposite = 2;
        } else if ($direction == 7) {
            $opposite = 3;
        }

        return $opposite;
    }
}

if (!function_exists('random_direction')) {
    function random_direction()
    {
        return mt_rand(0, 7);
    }
}
