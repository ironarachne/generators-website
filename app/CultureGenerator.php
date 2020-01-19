<?php

namespace App;

use \GuzzleHttp\Client;

class CultureGenerator {
    public function generate($id) {
        $client = new Client();
        $response = $client->request('GET', 'http://' . env('WORLDAPI') . '/culture/' . $id);
        $body = $response->getBody()->getContents();

        $culture = new Culture();
        $culture->data = $body;
        $culture->guid = $id;

        $cultureData = json_decode($culture->data);
        $culture->name = $cultureData->name;
        $culture->description = 'The ' . $cultureData->adjective . ', a fictional ' . $cultureData->primary_race->adjective . ' culture from a ' . $cultureData->home_climate->adjective . ' climate.';
        $culture->html = view( 'culture.individual', [ 'culture' => $cultureData ] )->render();

        return $culture;
    }
}
