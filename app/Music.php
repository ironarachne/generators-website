<?php


namespace App;


class Music
{
    public $guid;
    public $rhythm;
    public $beat;
    public $dynamic;
    public $harmony;
    public $melody;
    public $pitch;
    public $key;
    public $timbre;
    public $description;

    public function describe()
    {
        $description = 'This style of music has ';
        $description .= $this->rhythm . ' with ';
        $description .= pronoun($this->beat) . ' ' . $this->beat . ' beat. It is ';
        $description .= $this->dynamic . ', with ';
        $description .= $this->harmony . '. It has ';

        if ($this->rhythm == 'a single rhythm') {
            $description .= pronoun($this->melody) . ' ';
        }

        $description .= $this->melody . ' ';

        if ($this->rhythm == 'a single rhythm') {
            $description .= 'melody';
        } else {
            $description .= 'melodies';
        }

        $description .= ' with ';

        $description .= pronoun($this->pitch) . ' ' . $this->pitch . ' pitch in a ';

        $description .= $this->key . ' key. Usually, it has ';

        $description .= pronoun($this->timbre) . ' ' . $this->timbre . ' timbre.';

        return $description;
    }
}
