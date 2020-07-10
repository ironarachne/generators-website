<?php


namespace App;


class Climate
{
    public $cloud_cover;
    public $wind_strength;
    public $wind_direction;
    public $precipitation_amount;
    public $precipitation_frequency;
    public $precipitation_type;

    public function describeClouds() {
        if ($this->cloud_cover < 10) {
            return 'no clouds';
        } else if ($this->cloud_cover < 30 ) {
            return 'few clouds';
        } else if ($this->cloud_cover < 50) {
            return 'some clouds';
        } else if ($this->cloud_cover < 70) {
            return 'many clouds';
        }

        return 'frequently overcast skies';
    }
}
