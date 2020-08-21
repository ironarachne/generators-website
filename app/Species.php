<?php


namespace App;

use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;


class Species
{
    public string $name;
    public string $plural_name;
    public string $adjective;
    public int $commonality;
    public array $possible_traits;
    public array $common_traits;
    public array $age_categories;
    public int $humidity_max;
    public int $humidity_min;
    public int $temperature_max;
    public int $temperature_min;
    public array $resources;
    public array $tags;

    public static function byTagName($tagName, $haystack)
    {
        $result = [];

        $tag = new Tag();
        $tag->name = $tagName;

        foreach ($haystack as $s) {
            if ($tag->in($s->tags)) {
                $result [] = $s;
            }
        }

        return $result;
    }

    public function in($haystack)
    {
        foreach ($haystack as $s) {
            if ($this->name == $s->name) {
                return true;
            }
        }

        return false;
    }

    public function suits($humidity, $temperature, $tags): bool
    {
        if ($humidity < $this->humidity_min || $humidity > $this->humidity_max) {
            return false;
        }

        if ($temperature < $this->temperature_min || $temperature > $this->temperature_max) {
            return false;
        }

        foreach ($tags as $tag) {
            if ($tag->in($this->tags)) {
                return true;
            }
        }

        return false;
    }

    public static function load($tag)
    {
        return Cache::remember("species_$tag", 600, function () use ($tag) {
            $species = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/species?tag=' . $tag);

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->species as $d) {
                $s = new Species();

                $s->name = $d->name;
                $s->plural_name = $d->plural_name;
                $s->adjective = $d->adjective;
                $s->commonality = $d->commonality;
                $s->humidity_max = $d->humidity_max;
                $s->humidity_min = $d->humidity_min;
                $s->temperature_max = $d->temperature_max;
                $s->temperature_min = $d->temperature_min;
                $s->tags = [];
                $s->possible_traits = [];
                $s->common_traits = [];
                $s->age_categories = [];
                $s->resources = [];

                foreach ($d->tags as $t) {
                    $tag = new Tag();
                    $tag->name = $t->name;
                    $s->tags [] = $tag;
                }

                foreach ($d->trait_templates as $t) {
                    $trait = new TraitTemplate();
                    $trait->name = $t->name;
                    $trait->possible_descriptors = explode(',', $t->possible_descriptors);
                    $trait->possible_values = explode(',', $t->possible_values);
                    $trait->trait_type = $t->trait_type;

                    if ($trait->trait_type == 'possible') {
                        $s->possible_traits [] = $trait;
                    } else {
                        $s->common_traits [] = $trait;
                    }
                }

                foreach ($d->age_categories as $a) {
                    $ac = new AgeCategory();

                    $ac->name = $a->name;
                    $ac->age_max = $a->age_max;
                    $ac->age_min = $a->age_min;
                    $ac->size_category = $a->size_category;
                    $ac->height_base_female = $a->height_base_female;
                    $ac->height_base_male = $a->height_base_male;
                    $ac->height_range_dice = $a->height_range_dice;
                    $ac->weight_base_female = $a->weight_base_female;
                    $ac->weight_base_male = $a->weight_base_male;
                    $ac->weight_range_dice = $a->weight_range_dice;
                    $ac->commonality = $a->commonality;

                    $s->age_categories [] = $ac;
                }

                foreach ($d->resources as $r) {
                    $resource = Resource::fromJSON($r);
                    $s->resources [] = $resource;
                }

                $species [] = $s;
            }

            return $species;
        });
    }

    public function randomAgeCategory(): AgeCategory
    {
        $weighted = [];

        foreach ($this->age_categories as $ac) {
            $weighted[$ac->name] = $ac->commonality;
        }

        $result = random_weighted_item($weighted);

        foreach ($this->age_categories as $ac) {
            if ($ac->name == $result) {
                return $ac;
            }
        }
    }

    public function randomPhysicalTraits(): array
    {
        $result = [];
        $templates = $this->common_traits;
        $templates [] = random_item($this->possible_traits);

        foreach ($templates as $t) {
            $value = random_item($t->possible_values);
            $descriptor = random_item($t->possible_descriptors);
            $result [] = str_replace('{{.Value}}', $value, $descriptor);
        }

        return $result;
    }

    public static function randomRace(): Species
    {
        $options = Species::load('race');

        return random_item($options);
    }
}
