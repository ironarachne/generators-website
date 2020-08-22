<?php


namespace App;


class SeasonGenerator
{
    public function generate($climate, $region)
    {
        $result = [];

        $seasons = $this->getFourSeasons();

        if ($region->distance_to_equator < 20 && $region->distance_to_equator > -20) {
            $seasons = $this->getTwoSeasons();
        }

        foreach ($seasons as $season) {
            $season->precipitation_type = $this->getPrecipitationTypeForTemperature($region->temperature + $season->temperature_change);
            $season->daylight_hours = $this->getDaylightHours($region->distance_to_equator, $this->getMidMonth($season->month_begin, $season->month_end));
            $season->description = $this->describe($season, $climate, $region);
            $result [] = $season;
        }

        return $result;
    }

    public function getFourSeasons()
    {
        $spring = new Season();
        $spring->name = 'spring';
        $spring->temperature_change = 0;
        $spring->humidity_change = 0;
        $spring->precipitation_frequency_change = 10;
        $spring->precipitation_amount_change = 10;
        $spring->month_begin = 3;
        $spring->month_end = 5;

        $summer = new Season();
        $summer->name = 'summer';
        $summer->temperature_change = 10;
        $summer->humidity_change = 0;
        $summer->precipitation_frequency_change = 0;
        $summer->precipitation_amount_change = 0;
        $summer->month_begin = 6;
        $summer->month_end = 8;

        $autumn = new Season();
        $autumn->name = 'autumn';
        $autumn->temperature_change = 0;
        $autumn->humidity_change = 0;
        $autumn->precipitation_frequency_change = 0;
        $autumn->precipitation_amount_change = 0;
        $autumn->month_begin = 9;
        $autumn->month_end = 11;

        $winter = new Season();
        $winter->name = 'winter';
        $winter->temperature_change = -10;
        $winter->humidity_change = -10;
        $winter->precipitation_frequency_change = -10;
        $winter->precipitation_amount_change = -10;
        $winter->month_begin = 12;
        $winter->month_end = 2;

        return [$spring, $summer, $autumn, $winter];
    }

    public function getTwoSeasons()
    {
        $wet = new Season();
        $wet->name = 'wet';
        $wet->temperature_change = 0;
        $wet->humidity_change = 10;
        $wet->precipitation_frequency_change = 10;
        $wet->precipitation_amount_change = 10;
        $wet->month_begin = 5;
        $wet->month_end = 10;

        $dry = new Season();
        $dry->name = 'dry';
        $dry->temperature_change = 0;
        $dry->humidity_change = 0;
        $dry->precipitation_frequency_change = 0;
        $dry->precipitation_amount_change = 0;
        $dry->month_begin = 11;
        $dry->month_end = 4;

        return [$wet, $dry];
    }

    public function describe($season, $climate, $region)
    {
        if ($season->name == 'dry' || $season->name == 'wet') {
            $name = "The {$season->name} season";
        } else {
            $name = ucfirst($season->name);
        }

        $temp = $this->getWordForTemperature($region->temperature + $season->temperature_change);
        $clouds = $climate->describeClouds();
        $amount = $season->precipitation_amount_change + $climate->precipitation_amount;
        $freq = $season->precipitation_frequency_change + $climate->precipitation_frequency;

        if ($freq < 10) {
            $precipitation = 'usually dry';
        } else if ($freq < 50) {
            $precipitation = "sometimes {$season->precipitation_type}y";
        } else if ($freq < 70) {
            if ($amount < 30) {
                $storms = 'light';
            } else if ($amount < 50) {
                $storms = 'moderate';
            } else {
                $storms = 'heavy';
            }

            $precipitation = "frequently {$season->precipitation_type}y, with $storms storms";
        } else {
            if ($amount < 30) {
                $storms = 'moderate';
            } else if ($amount < 50) {
                $storms = 'heavy';
            } else {
                $storms = 'severe';
            }

            $precipitation = "persistently {$season->precipitation_type}y, with $storms storms";
        }

        $hours = floor($this->getDaylightHours($region->distance_to_equator, $this->getMidMonth($season->month_begin, $season->month_end)));

        return "$name is $temp, with $clouds. The weather is $precipitation. There are $hours hours of daylight each day.";
    }

    public function getDaylightHours($distance, $month)
    {
        $modifiers = [0.75, 1, 0.75, 0.5, 0, 0.5, -0.75, -1, -0.75, 0.5, 0, 0.5];

        $variance = ($distance / 99) * 12;
        $monthModifier = $modifiers[$month - 1];

        return ($variance * $monthModifier) + 12;
    }

    public function getMidMonth($begin, $end)
    {
        if ($begin <= $end) {
            $mid = ($begin + $end) / 2;
        } else {
            $mid = ($begin + $end + 12) / 2;
            if ($mid > 12) {
                $mid -= 12;
            }
        }

        return $mid;
    }

    public function getPrecipitationTypeForTemperature($temperature)
    {
        if ($temperature < 30) {
            return 'snow';
        }

        return 'rain';
    }

    public function getWordForTemperature($temperature)
    {
        if ($temperature < 10) {
            return 'frigid';
        } else if ($temperature < 30) {
            return 'cold';
        } else if ($temperature < 50) {
            return 'mild';
        } else if ($temperature < 70) {
            return 'warm';
        } else if ($temperature < 90) {
            return 'hot';
        }

        return 'very hot';
    }
}
