<?php

namespace App;

use \GuzzleHttp\Client;

class RegionGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'http://' . env('WORLDAPI') . '/region/' . $id);
        $body = $response->getBody()->getContents();

        $region = new Region();
        $region->data = $body;
        $region->guid = $id;

        return $region;
    }
}
