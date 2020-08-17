<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Pattern
{
    public $name;
    public $description;
    public $tags;
    public $commonality;
    public $professions;
    public $slots;
    public $name_template;
    public $main_material;
    public $main_material_override;
    public $origin_override;
    public $value;

    public static function load($tag)
    {
        return Cache::remember("patterns_$tag", 600, function () use ($tag) {
            $patterns = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/patterns?tag=' . $tag);

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->patterns as $d) {
                $p = new Pattern();

                $p->name = $d->name;
                $p->description = $d->description;
                $p->commonality = $d->commonality;
                $p->name_template = $d->name_template;
                $p->main_material = $d->main_material;
                $p->main_material_override = $d->main_material_override;
                $p->origin_override = $d->origin_override;
                $p->value = $d->value;

                foreach ($d->tags as $t) {
                    $tag = new Tag();
                    $tag->name = $t->name;
                    $p->tags [] = $tag;
                }

                foreach ($d->slots as $s) {
                    $slot = new PatternSlot();
                    $slot->name = $s->name;
                    $slot->description_template = $s->description_template;
                    $slot->possible_quirks = $s->possible_quirks;
                    $slot->required_tag = $s->require_tag;
                    $p->slots [] = $slot;
                }

                foreach ($d->professions as $r) {
                    $profession = new Profession();
                    $profession->name = $r->name;
                    $profession->description = $r->description;

                    foreach ($r->tags as $t) {
                        $tag = new Tag();
                        $tag->name = $t->name;
                        $profession->tags [] = $tag;
                    }

                    $p->professions [] = $profession;
                }

                $patterns [] = $p;
            }

            return $patterns;
        });
    }

    public function makeResource($resources)
    {
        $filledSlots = [];

        foreach ($this->slots as $slot) {
            $options = Resource::byTag($resources, $slot->required_tag);
            $ingredient = random_item($options);
            $slot->resource = $ingredient;

            $filledSlots[] = $slot;
        }

        $this->slots = $filledSlots;

        $resource = new Resource();
        $resource->name = $this->renderName();
        $resource->description = $this->renderDescription();
        $resource->main_material = $this->slots[0]->resource->main_material;

        if ($this->main_material_override != '') {
            $resource->main_material = $this->main_material_override;
        }

        $resource->origin = $this->slots[0]->resource->origin;

        if ($this->origin_override != '') {
            $resource->origin = $this->origin_override;
        }

        $resource->tags = $this->tags;
        $resource->tags [] = $resource->name;
        $resource->commonality = $this->commonality;

        $value = 0;

        foreach ($this->slots as $s) {
            $value += $s->resource->value;
        }

        $value += $this->value;
        $resource->value = $value;

        return $resource;
    }

    public function renderDescription()
    {
        $description = '';

        foreach ($this->slots as $slot) {
            $description .= str_replace('{{.Resource.MainMaterial}}', $slot->resource->main_material, $slot->description_template);
        }

        return $description;
    }

    public function renderName()
    {
        $mainMaterial = $this->main_material_override != '' ? $this->main_material_override : $this->slots[0]->resource->main_material;
        return str_replace('{{.MainMaterial}}', $mainMaterial, $this->name_template);
    }
}
