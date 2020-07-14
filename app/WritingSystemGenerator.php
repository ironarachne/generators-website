<?php


namespace App;


class WritingSystemGenerator
{
    public function generate() {
        $system = new WritingSystem();

        $system->classification = $this->getRandomClassification();
        $system->stroke_style = $this->getRandomStrokeStyle();
        $system->character_order = $this->getRandomCharacterOrder();
        $system->name = $this->getRandomName($system->classification);
        $system->description = $this->describe($system);

        return $system;
    }

    public function describe($system)
    {
        $description = "{$system->name} is a writing system with {$system->stroke_style} for characters. ";
        $description .= "It's written {$system->character_order}.";

        if (strpos($system->name, $system->classification) === false) {
            $pronoun = pronoun($system->classification);
            $description .= " {$system->name} is $pronoun {$system->classification}.";
        }

        return $description;
    }

    public function getRandomName($classification)
    {
        // TODO: When there's a generic name generator, fill this out
        $firstPart = '';

        $secondPart = $this->getRandomNameQualifier($classification);

        return "$firstPart $secondPart";
    }

    public function getRandomNameQualifier($classification)
    {
        $qualifiers = [
            'classification',
            'script',
            'glyphs',
        ];

        $qualifier = random_item($qualifiers);

        if ($qualifier == 'classification') {
            $qualifier = $classification;
        }

        return $qualifier;
    }

    public function getRandomCharacterOrder() {
        $orders = [
            'left to right',
            'right to left',
            'downward vertically',
            'upward vertically',
        ];

        return random_item($orders);
    }

    public function getRandomClassification() {
        $classifications = [
            'abjad',
            'abugida',
            'alphabet',
            'ideograph',
            'pictograph',
            'syllabary',
        ];

        return random_item($classifications);
    }

    public function getRandomStrokeStyle() {
        $styles = [
            'angular lines',
            'arcs',
            'boxes',
            'circles',
            'dots',
            'flowing lines',
            'half-circles',
            'half-loops',
            'loops',
            'sharp angles',
            'slashes',
            'swirls',
            'triangles',
        ];

        return random_item($styles);
    }
}
