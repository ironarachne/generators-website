<?php

namespace App;

use \GuzzleHttp\Client;

class RegionGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'http://' . env('WORLDAPI') . '/region/' . $id);
        $region = json_decode($response->getBody()->getContents());

        return $region;
    }
}