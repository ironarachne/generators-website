<?php


namespace App;


class ClimateGenerator
{
    public function generate($region)
    {
        $climate = new Climate;

        $climate->wind_direction = opposite_direction($region->nearest_mountains_direction);
        $climate->wind_strength = $this->getWindStrength($region->nearest_mountains_distance, $region->nearest_ocean_distance);
        $climate->cloud_cover = $this->getCloudCover($region->temperature, $climate->wind_strength, $region->nearest_mountains_distance);
        $climate->precipitation_amount = $this->getPrecipitationAmount($region->temperature, $region->humidity);
        $climate->precipitation_frequency = $this->getPrecipitationFrequency($climate->cloud_cover, $climate->precipitation_amount);
        $climate->precipitation_type = $this->getPrecipitationType($region->temperature);

        return $climate;
    }

    public function getCloudCover($temperature, $windStrength, $mountainDistance)
    {
        $cover = ($temperature / 3) + ($windStrength / 3) + ($mountainDistance / 2);

        if ($cover > 99) {
            $cover = 99;
        }

        return $cover;
    }

    public function getPrecipitationAmount($temperature, $humidity)
    {
        $amount = ($temperature / 2) + ($humidity * 0.7);

        if ($amount > 99) {
            $amount = 99;
        }

        return $amount;
    }

    public function getPrecipitationFrequency($cover, $amount)
    {
        $frequency = ($cover / 3) + ($amount / 3);

        return $frequency;
    }

    public function getPrecipitationType($temperature)
    {
        if ($temperature < 30) {
            return "snow";
        }

        return "rain";
    }

    public function getWindStrength($mountainsDistance, $oceanDistance)
    {
        $strength = ($mountainsDistance / 2) + ($oceanDistance / 4);
        if ($strength > 99) {
            $strength = 99;
        }

        return $strength;
    }
}
