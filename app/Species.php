<?php


namespace App;

use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;


class Species
{
    public $name;
    public $plural_name;
    public $adjective;
    public $commonality;
    public $possible_traits;
    public $common_traits;
    public $age_categories;
    public $humidity_max;
    public $humidity_min;
    public $temperature_max;
    public $temperature_min;
    public $resources;
    public $tags;

    public static function byTagName($tagName, $haystack) {
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

    public function suits($humidity, $temperature, $tags) {
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

                foreach ($d->tags as $t) {
                    $tag = new Tag();
                    $tag->name = $t->name;
                    $s->tags [] = $tag;
                }

                foreach ($d->trait_templates as $t) {
                    $trait = new TraitTemplate();
                    $trait->name = $t->name;
                    $trait->possible_descriptors = $t->possible_descriptors;
                    $trait->possible_values = $t->possible_values;
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
                    $resource = new Resource();

                    $resource->name = $r->name;
                    $resource->description = $r->description;
                    $resource->commonality = $r->commonality;
                    $resource->main_material = $r->main_material;
                    $resource->origin = $r->origin;
                    $resource->value = $r->value;

                    foreach ($r->tags as $t) {
                        $tag = new Tag();
                        $tag->name = $t->name;
                        $resource->tags [] = $tag;
                    }

                    $s->resources [] = $resource;
                }

                $species [] = $s;
            }

            return $species;
        });
    }
}
