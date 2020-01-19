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

        $regionData = json_decode($region->data);
        $region->name = $regionData->name;
        $region->description = 'The fantasy region of ' . $regionData->name . ', ruled by ' . $regionData->ruler->name . '.';
        $region->html = view( 'region.individual', [ 'region' => $regionData ] )->render();

        return $region;
    }
}
