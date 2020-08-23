<?php


namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Domain
{
    public string $name;
    public array $appearance_traits;
    public array $personality_traits;
    public array $holy_items;
    public array $holy_symbols;

    public function __construct()
    {
        $this->appearance_traits = [];
        $this->personality_traits = [];
        $this->holy_items = [];
        $this->holy_symbols = [];
    }

    public function removeFrom($haystack): array
    {
        $result = [];

        foreach ($haystack as $d) {
            if ($this->name != $d->name) {
                $result [] = $d;
            }
        }

        return $result;
    }

    public static function fromJSON(string $json): Domain
    {
        $data = json_decode($json);

        return self::fromObject($data);
    }

    public static function fromObject(\stdClass $data): Domain
    {
        $domain = new Domain();
        $domain->name = $data->name;
        $domain->appearance_traits = $data->appearance_traits;
        $domain->personality_traits = $data->personality_traits;
        $domain->holy_items = $data->holy_items;
        $domain->holy_symbols = $data->holy_symbols;

        return $domain;
    }

    public static function loadAll(): array
    {
        return Cache::remember('domains_all', 600, function () {
            $domains = [];

            $url = env('DATA_CORE_URL');

            $client = new Client();
            $response = $client->request('GET', $url . '/domains');

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->domains as $d) {
                $domain = new Domain();
                $domain->name = $d->name;
                $domain->appearance_traits = explode(',', $d->appearance_traits);
                $domain->personality_traits = explode(',', $d->personality_traits);
                $domain->holy_items = explode(',', $d->holy_items);
                $domain->holy_symbols = explode(',', $d->holy_symbols);
                $domains[] = $domain;
            }

            return $domains;
        });
    }
}
