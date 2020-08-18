<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Resource
{
    public $name;
    public $description;
    public $main_material;
    public $origin;
    public $commonality;
    public $value;
    public $tags;

    public static function byTag($resources, $tagName)
    {
        $result = [];
        $tag = new Tag();
        $tag->name = $tagName;

        foreach ($resources as $r) {
            if ($tag->in($r->tags)) {
                if (!$r->in($result)) {
                    $result[] = $r;
                    continue;
                }
            }
        }

        return $result;
    }

    public static function fromJSON($json)
    {
        $resource = new Resource();
        $resource->name = $json->name;
        $resource->description = $json->description;
        $resource->commonality = $json->commonality;
        $resource->main_material = $json->main_material;
        $resource->origin = $json->origin;
        $resource->value = $json->value;

        foreach ($json->tags as $t) {
            $tag = new Tag();
            $tag->name = $t->name;
            $resource->tags [] = $tag;
        }

        return $resource;
    }

    public static function loadAll()
    {
        return Cache::remember('resources_all', 600, function () {
            $resources = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/resources');

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->resources as $d) {
                $resource = Resource::fromJSON($d);
                $resources[] = $resource;
            }

            return $resources;
        });
    }

    public function in($haystack)
    {
        foreach ($haystack as $r) {
            if ($this->name == $r->name) {
                return true;
            }
        }

        return false;
    }
}
