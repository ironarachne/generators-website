<?php


namespace App;


class MusicGenerator
{
    public function generate($guid)
    {
        $rhythms = [
            'a single rhythm' => 100,
            'a cross-rhythm' => 10,
            'complex polyrhythm' => 1,
        ];

        $beats = [
            'very fast' => 5,
            'fast' => 5,
            'moderate' => 10,
            'slow' => 5,
            'very slow' => 5,
        ];

        $dynamics = [
            'very quiet' => 5,
            'quiet' => 15,
            'loud' => 15,
            'very loud' => 5,
        ];

        $harmonies = [
            'simple harmony' => 10,
            'two harmonies' => 1,
            'no harmony' => 5,
        ];

        $melodies = [
            'simple' => 10,
            'complex' => 2,
            'wandering' => 2,
            'chaotic' => 1,
        ];

        $pitches = [
            'low' => 5,
            'medium' => 5,
            'high' => 5,
        ];

        $keys = [
            'major' => 10,
            'minor' => 2,
        ];

        $timbres = [
            'booming',
            'bright',
            'brilliant',
            'dark',
            'emotional',
            'full',
            'mellow',
            'metallic',
            'nasal',
            'reedy',
            'resonant',
            'rough',
            'smooth',
        ];

        $music = new Music();
        $music->guid = $guid;
        $music->rhythm = random_weighted_item($rhythms);
        $music->beat = random_weighted_item($beats);
        $music->dynamic = random_weighted_item($dynamics);
        $music->harmony = random_weighted_item($harmonies);
        $music->melody = random_weighted_item($melodies);
        $music->pitch = random_weighted_item($pitches);
        $music->key = random_weighted_item($keys);
        $music->timbre = random_item($timbres);

        $music->description = $music->describe();

        return $music;
    }
}
