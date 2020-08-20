<?php


namespace App;


use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Mineral
{
    public $name;
    public $plural_name;
    public $hardness;
    public $malleability;
    public $commonality;
    public $resources;
    public $tags;

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

    public static function weightedRandom($haystack)
    {
        $ceiling = 0;

        foreach ($haystack as $m) {
            $weights[$m->name] = $m->commonality;
            $ceiling += $m->commonality;
        }

        $randomValue = mt_rand(0, $ceiling);

        foreach ($weights as $k => $w) {
            $randomValue -= $w;
            if ($randomValue <= 0) {
                foreach ($haystack as $m) {
                    if ($m->name == $k) {
                        return $m;
                    }
                }
            }
        }

        throw new Exception('failed to find weighted mineral result');
    }

    public static function load($tag)
    {
        return Cache::remember("mineral_$tag", 600, function () use ($tag) {
            $minerals = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/minerals?tag=' . $tag);

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->minerals as $m) {
                $mineral = new Mineral();
                $mineral->name = $m->name;
                $mineral->plural_name = $m->plural_name;
                $mineral->hardness = $m->hardness;
                $mineral->malleability = $m->malleability;
                $mineral->commonality = $m->commonality;

                foreach ($m->resources as $r) {
                    $resource = Resource::fromJSON($r);
                    $m->resources [] = $resource;
                }

                foreach ($m->tags as $t) {
                    $tag = new Tag();
                    $tag->name = $t->name;
                    $mineral->tags [] = $tag;
                }

                $minerals [] = $mineral;
            }

            return $minerals;
        });
    }
}
