<?php


namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Resource
{
    public string $name;
    public string $description;
    public string $main_material;
    public string $origin;
    public int $commonality;
    public int $value;
    public array $tags;

    public function __construct() {
        $this->tags = [];
    }

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

    public static function fromJSON(string $json): Resource
    {
        $data = json_decode($json);
        return Resource::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Resource
    {
        $resource = new Resource();
        $resource->name = $data->name;
        $resource->description = $data->description;
        $resource->commonality = $data->commonality;
        $resource->main_material = $data->main_material;
        $resource->origin = $data->origin;
        $resource->value = $data->value;

        foreach ($data->tags as $t) {
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
                $resource = Resource::fromObject($d);
                $resources[] = $resource;
            }

            return $resources;
        });
    }

    public static function random(array $resources): Resource {
        return random_item($resources);
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
