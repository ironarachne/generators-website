<?php

namespace App;

use \GuzzleHttp\Client;

class HeraldryGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'http://' . env('WORLDAPI') . '/heraldry/' . $id);
        $heraldry = $response->getBody()->getContents();

        $heraldry = ['heraldry' => json_decode($heraldry), 'id' => $id];

        return $heraldry;
    }
}