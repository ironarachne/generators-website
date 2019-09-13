<?php

namespace App;

use \GuzzleHttp\Client;

class HeraldryGenerator {
    public function generate($id, $fieldShape) {
        $client = new Client();
        $url = 'http://' . env('WORLDAPI') . '/heraldry/' . $id;
        if (!empty($fieldShape)) {
            $url .= "?shape=$fieldShape";
        }
        $response = $client->request('GET', $url);
        $heraldry = $response->getBody()->getContents();

        $heraldry = ['heraldry' => json_decode($heraldry), 'id' => $id];

        return $heraldry;
    }
}
