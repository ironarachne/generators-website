<?php


namespace App;


class LanguageStyle
{
    public array $descriptors;
    public int $word_length;
    public bool $uses_apostrophes;
    public array $initiators;
    public array $connectors;
    public array $finishers;
    public array $feminine_endings;
    public array $masculine_endings;

    public function __construct()
    {
        $this->descriptors = [];
        $this->initiators = [];
        $this->connectors = [];
        $this->finishers = [];
        $this->feminine_endings = [];
        $this->masculine_endings = [];
    }
}
