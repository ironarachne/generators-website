<?php

namespace App;

use \GuzzleHttp\Client;

class HeraldryGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'http://' . env('HERALDRYAPI') . '/device/' . $id);
        $device = $response->getBody()->getContents();

        $response = $client->request('GET', 'http://' . env('HERALDRYAPI') . '/blazon/' . $id);
        $blazon = $response->getBody()->getContents();

        $heraldry = ['blazon' => $blazon, 'device' => $device, 'id' => $id];

        return $heraldry;
    }
}