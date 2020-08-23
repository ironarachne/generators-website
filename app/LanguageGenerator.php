<?php


namespace App;


class LanguageGenerator
{
    public function generate()
    {
        // TODO: Add generation of conjugation rules
        $style = $this->getRandomStyle();

        $newWordPrefixes = $this->generateNewWordPrefixes($style);
        $newWordSuffixes = $this->generateNewWordSuffixes($style);

        $language = new Language();
        $language->new_word_prefixes = implode(',', $newWordPrefixes);
        $language->new_word_suffixes = implode(',', $newWordSuffixes);
        $descriptors = $style->descriptors;

        $isTonal = mt_rand(0, 100);
        if ($isTonal > 93) {
            $language->is_tonal = true;
            $descriptors [] = 'tonal';
        }

        $language->descriptors = implode(',', $descriptors);

        $genericNames = $this->generateNames(1, 'neutral', $style);
        $language->name = $genericNames[0];
        $language->adjective = $language->name . $this->getRandomSyllable($style->initiators, $style->connectors, $style->finishers, 'finisher');

        $wriGen = new WritingSystemGenerator();
        $writingSystem = $wriGen->generate();
        $writingSystem->name = $language->name . ' ' . $wriGen->getRandomNameQualifier($writingSystem->classification);
        $writingSystem->description = $wriGen->describe($writingSystem);
        $language->writing_systems = [$writingSystem];

        $words = $this->generateWords($style);
        $language->words = $words;

        $language->male_first_names = $this->generateNames(50, 'male', $style);
        $language->female_first_names = $this->generateNames(50, 'female', $style);
        $language->male_last_names = $this->generateNames(50, 'family', $style);
        $language->female_last_names = $language->male_last_names;
        $language->place_names = $this->generateNames(50, 'place', $style);

        $language->sample_phrase_translation = $this->getRandomSamplePhraseTranslation();
        $language->sample_phrase = $language->translate($language->sample_phrase_translation);
        $language->description = $this->describe($language);

        return $language;
    }

    public function describe($language)
    {
        $descriptors = explode(',', $language->descriptors);
        $writingSystem = $language->writing_systems[0];

        $description = $language->name . ' is ' . pronoun($descriptors[0]) . ' ' . combine_phrases($descriptors);
        $description .= ' language. It has ' . pronoun($writingSystem->classification) . ' ' . $writingSystem->classification;
        $description .= ' writing system comprised of ' . $writingSystem->stroke_style . ' written in order ' . $writingSystem->character_order;
        $description .= '. The phrase "' . $language->sample_phrase . '" means "' . $language->sample_phrase_translation . '"';

        return $description;
    }

    public function generateNames($number, $type, $style)
    {
        $endings = [];
        $names = [];
        $maxSyllables = 3;
        $minSyllables = 1;

        if ($type == 'male') {
            $endings = $style->masculine_endings;
            $maxSyllables = 2;
        } else if ($type == 'female') {
            $endings = $style->feminine_endings;
            $maxSyllables = 2;
        } else if ($type == 'place') {
            $maxSyllables = 4;
        }

        for ($i = 0; $i < $number; $i++) {
            $name = $this->getRandomWord($style, $minSyllables, $maxSyllables);
            if (sizeof($endings) > 0) {
                $ending = random_item($endings);
                $name .= $ending;
            }

            if (!in_array($name, $names)) {
                $names [] = ucfirst($name);
            } else {
                $i--;
            }
        }

        return $names;
    }

    public function generateNewWordPrefixes($style)
    {
        $prefixes = [];

        for ($i = 0; $i < 50; $i++) {
            $prefix = $this->getRandomSyllable($style->initiators, $style->connectors, $style->finishers, 'connector');
            if (!in_array($prefix, $prefixes)) {
                $prefixes [] = $prefix;
            }
        }

        return $prefixes;
    }

    public function generateNewWordSuffixes($style)
    {
        $suffixes = [];

        for ($i = 0; $i < 50; $i++) {
            $suffix = $this->getRandomSyllable($style->initiators, $style->connectors, $style->finishers, 'finisher');
            if (!in_array($suffix, $suffixes)) {
                $suffixes [] = $suffix;
            }
        }

        return $suffixes;
    }

    public function generateWords($style)
    {
        $words = $this->getWordList();

        foreach ($words as $w) {
            $syllableCount = $this->getSyllableCountForWord($w);
            $w->word = $this->getRandomWord($style, $syllableCount, $syllableCount);
        }

        return $words;
    }

    public function getLanguageStyles()
    {
        $consonant = $this->getSoundsOfType('consonant');
        $breath = $this->getSoundsOfType('breath');
        $fricative = $this->getSoundsOfType('fricative');
        $glide = $this->getSoundsOfType('glide');
        $glottal = $this->getSoundsOfType('glottal');
        $growl = $this->getSoundsOfType('growl');
        $liquid = $this->getSoundsOfType('liquid');
        $nasal = $this->getSoundsOfType('nasal');
        $sibilant = $this->getSoundsOfType('sibilant');
        $stop = $this->getSoundsOfType('stop');
        $velar = $this->getSoundsOfType('velar');

        $musical = new LanguageStyle();
        $musical->descriptors = ['musical'];
        $musical->word_length = 2;
        $musical->uses_apostrophes = false;
        $musical->initiators = $fricative;
        $musical->connectors = $liquid;
        $musical->finishers = $sibilant;
        $musical->masculine_endings = ['ion', 'on', 'en', 'o'];
        $musical->feminine_endings = ['i', 'a', 'ia', 'ila'];

        $guttural = new LanguageStyle();
        $guttural->descriptors = ["guttural"];
        $guttural->word_length = 1;
        $guttural->uses_apostrophes = false;
        $guttural->initiators = array_merge($glottal, $growl);
        $guttural->connectors = $velar;
        $guttural->finishers = $velar;
        $guttural->masculine_endings = ["ur", "ar", "ach", "ag"];
        $guttural->feminine_endings = ["a", "agi"];

        $abrupt = new LanguageStyle();
        $abrupt->descriptors = ["abrupt"];
        $abrupt->word_length = 2;
        $abrupt->uses_apostrophes = true;
        $abrupt->initiators = $stop;
        $abrupt->connectors = $fricative;
        $abrupt->finishers = $liquid;
        $abrupt->masculine_endings = ["on", "en", "an"];
        $abrupt->feminine_endings = ["a", "e", "et"];

        $nasally = new LanguageStyle();
        $nasally->descriptors = ["nasal"];
        $nasally->word_length = 2;
        $nasally->uses_apostrophes = false;
        $nasally->initiators = $glottal;
        $nasally->connectors = $stop;
        $nasally->finishers = $nasal;
        $nasally->masculine_endings = ["een", "oon", "in", "en"];
        $nasally->feminine_endings = ["ini", "nia", "mia", "mi"];

        $rhythmic = new LanguageStyle();
        $rhythmic->descriptors = ["rhythmic"];
        $rhythmic->word_length = 2;
        $rhythmic->uses_apostrophes = false;
        $rhythmic->initiators = array_merge($glottal, $fricative);
        $rhythmic->connectors = array_merge($liquid, $fricative);
        $rhythmic->finishers = $liquid;
        $rhythmic->masculine_endings = ["ior", "iun", "ayan", "ar"];
        $rhythmic->feminine_endings = ["oa", "ua", "lia", "li"];

        $graceful = new LanguageStyle();
        $graceful->descriptors = ["graceful"];
        $graceful->word_length = 2;
        $graceful->uses_apostrophes = false;
        $graceful->initiators = $consonant;
        $graceful->connectors = array_merge($liquid, $fricative);
        $graceful->finishers = array_merge($stop, $glottal);
        $graceful->masculine_endings = ["em", "amn", "astor", "est", "and"];
        $graceful->feminine_endings = ["eela", "aela", "ali", "eli", "oli", "oa", "ea"];

        $breathy = new LanguageStyle();
        $breathy->descriptors = ["breathy"];
        $breathy->word_length = 1;
        $breathy->uses_apostrophes = false;
        $breathy->initiators = array_merge($breath, $fricative);
        $breathy->connectors = array_merge($breath, $glide);
        $breathy->finishers = array_merge($stop, $glottal);
        $breathy->masculine_endings = ["esh", "ashem", "eh", "ih", "ah"];
        $breathy->feminine_endings = ["eshi", "eha", "ala", "asha", "iha"];

        return [
            $musical,
            $guttural,
            $abrupt,
            $nasally,
            $rhythmic,
            $graceful,
            $breathy,
        ];
    }

    public function getRandomSamplePhraseTranslation(): string
    {
        $phrases = [
            'Hello friend! It is good to see you.',
            'Friend, it is good to see you again.',
            'Peace and long life to you.',
        ];

        return random_item($phrases);
    }

    public function getRandomStyle()
    {
        return random_item($this->getLanguageStyles());
    }

    public function getRandomSyllable($initiators, $connectors, $finishers, $role)
    {
        $syllable = random_item($initiators);
        $vowel = $this->getRandomWeightedVowel();
        $syllable .= $vowel;

        $expand = mt_rand(0, 10) + 1;
        if ($expand > 2) {
            if ($role == 'connector') {
                $connector = random_item($connectors);
                $syllable .= $connector;
            } else {
                $finisher = random_item($finishers);
                $syllable .= $finisher;
            }
        }

        return $syllable;
    }

    public function getRandomWeightedVowel()
    {
        $vowels = [
            'a' => 18,
            'e' => 20,
            'i' => 13,
            'o' => 6,
            'u' => 2,
        ];

        return random_weighted_item($vowels);
    }

    public function getRandomWord($style, $minSyllables, $maxSyllables)
    {
        $numSyllables = 1;
        $role = 'connector';
        $syllables = [];
        $word = '';

        if ($maxSyllables > 1) {
            $numSyllables = mt_rand($minSyllables, $maxSyllables);
        }

        for ($i = 0; $i < $numSyllables; $i++) {
            if ($numSyllables - $i == 1) {
                $role = 'finisher';
            }

            $syllable = $this->getRandomSyllable($style->initiators, $style->connectors, $style->finishers, $role);

            if ($style->uses_apostrophes) {
                $shouldIUseAnApostrophe = mt_rand(0, 100);
                if ($shouldIUseAnApostrophe > 87) {
                    $syllable .= '\'';
                }
            }

            $syllables [] = $syllable;
        }

        foreach ($syllables as $syllable) {
            $word .= $syllable;
        }

        return $word;
    }

    public function getSoundsOfType($soundType)
    {
        switch ($soundType) {
            case 'consonant':
                return ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];
            case 'breath':
                return ['h', 'th', 'f', 'ch', 'sh'];
            case 'fricative':
                return ['f', 'v', 'th', 'ð', 's', 'z', 'ch', 'zh'];
            case 'glide':
                return ['j', 'w'];
            case 'glottal':
                return ['g', 'k', 'ch'];
            case 'growl':
                return ['br', 'tr', 'gr', 'dr', 'kr'];
            case 'liquid':
                return ['l', 'r'];
            case 'nasal':
                return ['m', 'n', 'ng'];
            case 'sibilant':
                return ['s', 'f'];
            case 'stop':
                return ['p', 'b', 't', 'd', 'k', 'g'];
            case 'velar':
                return ['k', 'g', 'ng', 'w'];
        }

        return [];
    }

    public function getSyllableCountForWord($word)
    {
        if (in_array($word->speech_part, ['pronoun', 'preposition', 'article', 'question word', 'number'])) {
            return 1;
        } else if (in_array($word->speech_part, ['interjection', 'verb', 'adjective'])) {
            return 2;
        }

        return 3;
    }

    public function getWordList()
    {
        $adjectives = [
            'aromatic',
            'basted',
            'big',
            'bitter',
            'black',
            'blue',
            'brown',
            'chilled',
            'cold',
            'curried',
            'dark',
            'deep',
            'divine',
            'drunk',
            'empty',
            'evil',
            'familiar',
            'fat',
            'flat',
            'frail',
            'fried',
            'full',
            'good',
            'green',
            'grey',
            'honest',
            'hot',
            'light',
            'long',
            'loud',
            'mortal',
            'mysterious',
            'narrow',
            'old',
            'orange',
            'pungent',
            'purple',
            'quiet',
            'raw',
            'rectangular',
            'red',
            'roasted',
            'round',
            'salty',
            'savory',
            'shallow',
            'short',
            'smoked',
            'sober',
            'sour',
            'spicy',
            'spiral',
            'square',
            'steamed',
            'strange',
            'strong',
            'sturdy',
            'sweet',
            'tall',
            'thick',
            'thin',
            'warm',
            'weak',
            'white',
            'wide',
            'yellow',
            'young',
        ];

        foreach ($adjectives as $a) {
            $word = new Word();
            $word->speech_part = 'adjective';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $adverbs = [
            'again',
            'now',
            'soon',
            'often',
            'sometimes',
            'always',
            'never',
            'seldom',
        ];

        foreach ($adverbs as $a) {
            $word = new Word();
            $word->speech_part = 'adverb';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $articles = [
            'a',
            'an',
            'the',
        ];

        foreach ($articles as $a) {
            $word = new Word();
            $word->speech_part = 'article';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $interjections = [
            'hello',
            'goodbye',
            'hey',
            'bye',
            'ouch',
            'wow',
            'uh',
            'er',
            'um',
        ];

        foreach ($interjections as $a) {
            $word = new Word();
            $word->speech_part = 'interjection';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $prepositions = [
            'and',
            'as',
            'from',
            'in',
            'of',
            'or',
            'to',
            'will',
            'with',
        ];

        foreach ($prepositions as $a) {
            $word = new Word();
            $word->speech_part = 'preposition';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $questionWords = [
            'what',
            'who',
            'how',
            'why',
            'when',
        ];

        foreach ($questionWords as $a) {
            $word = new Word();
            $word->speech_part = 'question word';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $verbs = [
            'bake',
            'be',
            'belong',
            'bite',
            'break',
            'burn',
            'come',
            'die',
            'drink',
            'eat',
            'fall',
            'fight',
            'find',
            'fish',
            'fly',
            'frown',
            'go',
            'growl',
            'hate',
            'have',
            'hear',
            'hide',
            'hold',
            'hunt',
            'jump',
            'kill',
            'know',
            'laugh',
            'lie',
            'live',
            'lose',
            'love',
            'need',
            'own',
            'roast',
            'run',
            'see',
            'sit',
            'sleep',
            'smell',
            'smile',
            'stand',
            'strike',
            'swallow',
            'swim',
            'taste',
            'throw',
            'walk',
            'want',
        ];

        foreach ($verbs as $a) {
            $word = new Word();
            $word->speech_part = 'verb';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $nouns = [
            'afternoon',
            'ale',
            'all',
            'alligator',
            'arm',
            'ash',
            'axe',
            'bark',
            'bay',
            'beer',
            'beet',
            'bird',
            'blood',
            'boar',
            'bone',
            'breakfast',
            'breast',
            'castle',
            'cat',
            'cat',
            'chest',
            'chicken',
            'claw',
            'cloud',
            'coconut',
            'crime',
            'day',
            'dinner',
            'dog',
            'drink',
            'dungeon',
            'ear',
            'earth',
            'egg',
            'enemy',
            'evening',
            'eye',
            'feather',
            'fight',
            'finger',
            'fire',
            'fish',
            'flesh',
            'foot',
            'forest',
            'fox',
            'friend',
            'goose',
            'grease',
            'gulf',
            'hair',
            'hand',
            'hat',
            'hate',
            'head',
            'horn',
            'horse',
            'house',
            'inn',
            'island',
            'jaw',
            'lake',
            'leaf',
            'leg',
            'liver',
            'louse',
            'love',
            'lunch',
            'man',
            'many',
            'meal',
            'metal',
            'mine',
            'monster',
            'moon',
            'morning',
            'mountain',
            'mouth',
            'name',
            'neck',
            'night',
            'noodle',
            'nose',
            'ocean',
            'path',
            'peace',
            'pepper',
            'person',
            'pie',
            'pig',
            'rabbit',
            'rain',
            'rat',
            'river',
            'robe',
            'rock',
            'root',
            'salt',
            'sand',
            'seed',
            'skin',
            'sky',
            'smoke',
            'snake',
            'soup',
            'star',
            'stew',
            'stomach',
            'stone',
            'stream',
            'sun',
            'sword',
            'tail',
            'tavern',
            'thumb',
            'tongue',
            'tooth',
            'tree',
            'truth',
            'valley',
            'war',
            'water',
            'way',
            'wine',
            'woman',
            'word',
        ];

        foreach ($nouns as $a) {
            $word = new Word();
            $word->speech_part = 'noun';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $numbers = [
            'zero',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
        ];

        foreach ($numbers as $a) {
            $word = new Word();
            $word->speech_part = 'number';
            $word->english_translation = $a;
            $words [] = $word;
        }

        $pronouns = [
            'he',
            'her',
            'hers',
            'his',
            'I',
            'it',
            'me',
            'mine',
            'my',
            'our',
            'she',
            'them',
            'their',
            'theirs',
            'they',
            'you',
            'your',
            'yours',
        ];

        foreach ($pronouns as $a) {
            $word = new Word();
            $word->speech_part = 'pronoun';
            $word->english_translation = $a;
            $words [] = $word;
        }

        return $words;
    }
}
