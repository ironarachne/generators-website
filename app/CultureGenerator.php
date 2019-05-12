<?php

namespace App;

use \GuzzleHttp\Client;

class CultureGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'http://' . env('WORLDAPI') . '/culture/' . $id);
        $culture = json_decode($response->getBody()->getContents());

        return $culture;
    }
}