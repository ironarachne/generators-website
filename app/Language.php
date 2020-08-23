<?php

namespace App;

class Language
{
    public string $name;
    public string $adjective;
    public array $conjugation_rules;
    public array $female_first_names;
    public array $female_last_names;
    public array $male_first_names;
    public array $male_last_names;
    public array $place_names;
    public string $new_word_prefixes;
    public string $new_word_suffixes;
    public bool $is_tonal;
    public string $descriptors;
    public string $sample_phrase_translation;
    public string $sample_phrase;
    public string $description;
    public array $words;
    public array $writing_systems;

    public function __construct() {
        $this->conjugation_rules = [];
        $this->female_first_names = [];
        $this->male_first_names = [];
        $this->female_last_names = [];
        $this->male_last_names = [];
        $this->place_names = [];
        $this->words = [];
        $this->writing_systems = [];
    }

    public function translate($phrase)
    {
        // TODO: Handle plural words
        // TODO: Handle conjugation of verbs
        $translation = '';
        $isFirstWordOfSentence = true;

        $words = explode(' ', $phrase);

        foreach ($words as $word) {
            $filtered = str_replace(['!', ',', '.', '?'], '', strtolower($word));

            if ($filtered == 'is' || $filtered == 'are' || $filtered == 'am') {
                $filtered = 'be';
            }

            foreach ($this->words as $w) {
                if ($w->english_translation == $filtered) {
                    $dictionary = $w;
                    break;
                }
            }

            if (!empty($dictionary->word)) {
                if ($isFirstWordOfSentence) {
                    $translation .= ucfirst($dictionary->word);
                } else {
                    $translation .= $dictionary->word;
                }
            } else {
                if ($isFirstWordOfSentence) {
                    $translation .= ucfirst($filtered);
                } else {
                    $translation .= $filtered;
                }
            }

            if (strlen($filtered) < strlen($word)) {
                $punctuation = substr($word, -1);
                if (in_array($punctuation, ['!', '?', '.'])) {
                    $isFirstWordOfSentence = true;
                } else {
                    $isFirstWordOfSentence = false;
                }
                $translation .= substr($word, -1);
            } else {
                $isFirstWordOfSentence = false;
            }

            $translation .= ' ';
        }

        $translation = substr($translation, 0, -1);

        return $translation;
    }

    public static function fromJSON(string $json): Language {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Language {
        $language = new Language();

        foreach($data as $key => $value) {
            if ($key == 'writing_systems') {
                foreach($value as $v) {
                    $ws = new WritingSystem();
                    foreach ($v as $vk => $vv) {
                        $ws->{$vk} = $vv;
                    }
                    $language->writing_systems [] = $ws;
                }
            } elseif ($key == 'words') {
                foreach($value as $v) {
                    $w = new Word();
                    foreach ($v as $vk => $vv) {
                        $w->{$vk} = $vv;
                    }
                    $language->words [] = $w;
                }
            } else {
                $language->{$key} = $value;
            }
        }

        return $language;
    }
}
