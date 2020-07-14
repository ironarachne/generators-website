<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Profession
{
    public $name;
    public $description;
    public $tags;

    public function load($tag)
    {
        return Cache::remember("professions_$tag", 600, function () use ($tag) {
            $professions = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/professions?tag=' . $tag);

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->professions as $d) {
                $p = new Profession();

                $p->name = $d->name;
                $p->description = $d->description;

                foreach ($d->tags as $t) {
                    $tag = new Tag();
                    $tag->name = $t->name;
                    $p->tags [] = $tag;
                }

                $professions [] = $p;
            }

            return $professions;
        });
    }
}
