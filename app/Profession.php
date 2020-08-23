<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Profession
{
    public string $name;
    public string $description;
    public array $tags;

    public function __construct() {
        $this->tags = [];
    }

    public static function fromJSON(string $json): Profession
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Profession
    {
        $p = new Profession();

        $p->name = $data->name;
        $p->description = $data->description;
        $p->tags = [];

        foreach ($data->tags as $t) {
            $tag = new Tag();
            $tag->name = $t->name;
            $p->tags [] = $tag;
        }

        return $p;
    }

    public static function load($tag)
    {
        return Cache::remember("professions_$tag", 600, function () use ($tag) {
            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/professions?tag=' . $tag);

            $professions = [];

            $data = json_decode($response->getBody()->getContents());

            foreach($data->professions as $p) {
                $professions [] = self::fromObject($p);
            }

            return $professions;
        });
    }

    public static function loadAll()
    {
        return Cache::remember('professions_all', 600, function () {
            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/professions');

            $professions = [];

            $data = json_decode($response->getBody()->getContents());

            foreach($data->professions as $p) {
                $professions [] = self::fromObject($p);
            }

            return $professions;
        });
    }

    public static function random(): Profession
    {
        $professions = Profession::loadAll();

        return random_item($professions);
    }
}
