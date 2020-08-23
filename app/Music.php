<?php


namespace App;


class Music
{
    public string $guid;
    public string $rhythm;
    public string $beat;
    public string $dynamic;
    public string $harmony;
    public string $melody;
    public string $pitch;
    public string $key;
    public string $timbre;
    public string $description;

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

    public static function fromJSON(string $json): Music
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Music
    {
        $object = new Music();

        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
    }
}
