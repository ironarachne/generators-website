<?php


namespace App;


class ClothingStyleGenerator
{
    public function generate() {
        $style = new ClothingStyle();

        $style->male_outfit = $this->randomOutfit();
        $style->female_outfit = $this->randomOutfit();
        $style->male_adornment = $this->randomAdornment();
        $style->female_adornment = $this->randomAdornment();

        return $style;
    }

    private function randomAdornment() {
        $adornments = [
            'feathers in their hair',
            'metal rings',
            'necklaces of beads',
            'metal necklaces',
            'metal jewelry',
            'bone rings',
            'small crystals in their hair',
        ];

        return random_item($adornments);
    }

    private function randomOutfit() {
        $hatRoll = mt_rand(0, 100);

        $hat = $hatRoll > 90 ? $this->randomHeadwear() : '';

        $robeRoll = mt_rand(0, 100);

        if ($robeRoll > 80) {
            $main = $this->randomRobe();
        } else {
            $main = $this->randomTop() . ' and '. $this->randomBottom();
        }

        $footwear = $this->randomFootwear();

        $outfit = "$main, with $footwear";

        if ($hat != '') {
            $outfit .= ' and ' . pronoun($hat) . " $hat";
        }

        return $outfit;
    }

    private function randomFootwear() {
        $types = [
            'knee-length boots',
            'calf-length boots',
            'short boots',
            'shoes',
            'turnshoes',
            'slippers',
            'sandals',
        ];

        return random_item($types);
    }

    private function randomHeadwear() {
        $types = [
            'turban',
            'bonnet',
            'cap',
            'tall hat',
            'hat',
            'soft cap',
            'wide hat',
            'short hat',
            'wide turban',
            'tight turban',
            'poofy hat',
        ];

        return random_item($types);
    }

    private function randomRobe() {
        $sleeveRoll = mt_rand(0, 100);
        if ($sleeveRoll > 95) {
            $sleeves = 'no sleeves';
        } else {
            $sleeves = $this->randomSleeves();
        }

        $lengths = [
            'floor-length',
            'ankle-length',
            'calf-length',
            'knee-length',
        ];

        $neckline = $this->randomNeckline();
        $neckline = pronoun($neckline) . " $neckline";

        $length = random_item($lengths);
        $length = pronoun($length) . " $length";

        return "$length robe with $neckline neckline and $sleeves";
    }

    private function randomBottom() {
        $types = [
            'pants',
            'skirt',
            'kilt',
        ];

        $type = random_item($types);

        $cuts = [
            'straight',
            'loose',
            'tight',
        ];

        $cut = random_item($cuts);

        $lengths = [
            'knee-length',
            'ankle-length',
            'calf-length',
        ];

        $length = random_item($lengths);

        if ($type != 'pants') {
            $length = "a $length";
        }

        return "$length $cut $type";
    }

    private function randomTop() {
        $lengths = [
            'waist-length',
            'thigh-length',
            'knee-length',
            'ankle-length',
        ];

        $length = random_item($lengths);

        $neckline = $this->randomNeckline();
        $neckline = pronoun($neckline) . " $neckline";

        $sleeveRoll = mt_rand(0, 100);

        if ($neckline == 'halter' || $sleeveRoll > 90) {
            $sleeves = '';
        } else {
            $sleeves = ' and ' . $this->randomSleeves();
        }

        $fits = [
            'very tight',
            'tight',
            'loose',
            'very loose',
        ];

        $fit = random_item($fits);

        return pronoun($length) . " $length $fit-fit top with $neckline neckline$sleeves";
    }

    private function randomNeckline() {
        $necklines = [
            'crossover',
            'collared',
            'halter',
            'straight',
            'v-neck',
            'asymmetric',
            'high',
            'off-shoulder',
        ];

        return random_item($necklines);
    }

    private function randomSleeves() {
        $lengths = [
            'wrist-length',
            'short',
            'elbow-length',
        ];

        $length = random_item($lengths);

        $shapes = [
            ' narrow sleeves',
            ' loose sleeves',
            ' broad sleeves',
            ' slitted sleeves',
            ', gradually flared sleeves',
            ' sleeves, sharply flared at the wrist',
        ];

        $shape = random_item($shapes);

        return "$length$shape";
    }
}
