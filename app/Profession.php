<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Profession
{
    public string $name;
    public string $description;
    public array $tags;

    public static function fromJSON($json)
    {
        $professions = [];

        $data = json_decode($json);

        foreach ($data->professions as $d) {
            $p = new Profession();

            $p->name = $d->name;
            $p->description = $d->description;
            $p->tags = [];

            foreach ($d->tags as $t) {
                $tag = new Tag();
                $tag->name = $t->name;
                $p->tags [] = $tag;
            }

            $professions [] = $p;
        }

        return $professions;
    }

    public static function load($tag)
    {
        return Cache::remember("professions_$tag", 600, function () use ($tag) {
            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/professions?tag=' . $tag);

            return Profession::fromJSON($response->getBody()->getContents());
        });
    }

    public static function loadAll()
    {
        return Cache::remember('professions_all', 600, function () {
            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/professions');

            return Profession::fromJSON($response->getBody()->getContents());
        });
    }

    public static function random(): Profession
    {
        $professions = Profession::loadAll();

        return random_item($professions);
    }
}
