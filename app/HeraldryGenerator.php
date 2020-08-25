<?php

namespace App;

use \GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class HeraldryGenerator
{
    public function generate($id, $fieldShape)
    {
        $client = new Client();
        $url = 'http://' . env('WORLDAPI') . '/heraldry/' . $id;
        if (!empty($fieldShape)) {
            $url .= "?shape=$fieldShape";
        }
        $response = $client->request('GET', $url);
        $heraldry = $response->getBody()->getContents();

        $body = json_decode($heraldry);

        $heraldry = new Heraldry();
        $heraldry->guid = $id;
        $heraldry->blazon = $body->blazon;
        $heraldry->url = $body->image_url;

        return $heraldry;
    }

    public function random()
    {
        $guid = Uuid::uuid4()->toString();

        return $this->generate($guid, '');
    }
}
