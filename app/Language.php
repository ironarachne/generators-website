<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function conjugationRules()
    {
        return $this->hasMany('App\ConjugationRule');
    }

    public function names()
    {
        return $this->hasMany('App\Name');
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

            $dictionary = $this->words()->where('english_translation', '=', $filtered)->first();

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

    public function words()
    {
        return $this->hasMany('App\Word');
    }

    public function writingSystems()
    {
        return $this->belongsToMany('App\WritingSystem');
    }
}
