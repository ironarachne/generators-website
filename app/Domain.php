<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Domain
{
    public $name;
    public $appearance_traits;
    public $personality_traits;
    public $holy_items;
    public $holy_symbols;

    public function removeFrom($haystack) {
        $result = [];

        foreach ($haystack as $d) {
            if ($this->name != $d->name) {
                $result [] = $d;
            }
        }

        return $result;
    }

    public static function fromJSON($json)
    {
        $domain = new Domain();
        $domain->name = $json->name;
        $domain->appearance_traits = explode(',', $json->appearance_traits);
        $domain->personality_traits = explode(',', $json->personality_traits);
        $domain->holy_items = explode(',', $json->holy_items);
        $domain->holy_symbols = explode(',', $json->holy_symbols);

        return $domain;
    }

    public static function loadAll()
    {
        return Cache::remember('domains_all', 600, function () {
            $domains = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/domains');

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->domains as $d) {
                $domain = Domain::fromJSON($d);
                $domains[] = $domain;
            }

            return $domains;
        });
    }
}
