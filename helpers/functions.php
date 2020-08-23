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

if (!function_exists('inches_to_feet')) {
    function inches_to_feet(int $inches): string
    {
        $feet = floor($inches / 12);
        $remainder = $inches % 12;

        return "$feet'$remainder\"";
    }
}

if (!function_exists('rnd')) {
    function rnd($max): int
    {
        srand();

        return mt_rand(0, $max);
    }
}

if (!function_exists('seeder')) {
    function seeder($seed)
    {
        $hash = substr(md5($seed), 0, 6);
        $seedNumber = '';
        $byteArray = unpack('C*', $hash);
        foreach ($byteArray as $b) {
            $seedNumber .= $b;
        }
        $seedNumber = intval($seedNumber);
        srand($seedNumber);
    }
}

if (!function_exists('combine_phrases')) {
    function combine_phrases($phrases, $use_and = true): string
    {
        $result = '';
        $joiner = $use_and ? 'and' : 'or';

        if (sizeof($phrases) == 1) {
            return $phrases[0];
        } elseif (sizeof($phrases) == 2) {
            return "${phrases[0]} $joiner ${phrases[1]}";
        } else {
            foreach ($phrases as $index => $phrase) {
                if ($index == sizeof($phrases) - 1) {
                    $result .= "$joiner $phrase";
                } else {
                    $result .= "$phrase, ";
                }
            }
        }

        return $result;
    }
}

if (!function_exists('pronoun')) {
    function pronoun($word): string
    {
        $pronoun = 'a';

        $firstLetter = $word[0];

        if (in_array($firstLetter, ['a', 'e', 'i', 'o', 'u'])) {
            $pronoun = 'an';
        }

        return $pronoun;
    }
}

if (!function_exists('direction_word')) {
    function direction_word($direction): string
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
    function opposite_direction($direction): int
    {
        $opposite = 0;

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
    function random_direction(): int
    {
        return mt_rand(0, 7);
    }
}

if (!function_exists('random_item')) {
    function random_item($items)
    {
        if (sizeof($items) == 0) {
            return null;
        }

        if (sizeof($items) == 1) {
            return $items[0];
        }

        return $items[mt_rand(0, sizeof($items) - 1)];
    }
}

if (!function_exists('random_weighted_item')) {
    function random_weighted_item($items)
    {
        $ceiling = 0;

        foreach ($items as $item => $weight) {
            $ceiling += $weight;
        }

        $randomValue = mt_rand(0, $ceiling);

        foreach ($items as $item => $weight) {
            $randomValue -= $weight;
            if ($randomValue <= 0) {
                return $item;
            }
        }

        return '';
    }
}
