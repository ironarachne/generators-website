<?php

namespace App;

use \GuzzleHttp\Client;

class CultureGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'https://' . env('WORLDAPI') . '/culture/' . $id);
        $body = $response->getBody()->getContents();

        $culture = new Culture();
        $culture->data = $body;
        $culture->guid = $id;

        return $culture;
    }
}
