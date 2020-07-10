<?php


namespace App;


class Dice
{
    public $number;
    public $sides;

    public function __construct($expression) {
        $data = explode('d', $expression);

        $this->number = $data[0];
        $this->sides = $data[1];
    }

    public function average() {
        return (($this->sides + 1) / 2) * $this->number;
    }

    public function roll() {
        $total = 0;

        for($i=0;$i<$this->number;$i++) {
            $total += rand(1, $this->sides);
        }

        return $total;
    }
}
