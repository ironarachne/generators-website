<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class CultureController extends Controller
{
    public function index()
    {
        $page = [
            'title' => 'Culture Generator',
            'subtitle' => 'Generate human cultures for a fantasy world',
            'description' => 'This tool procedurally generates fantasy human cultures',
            'type' => 'single',
        ];

        return view( 'culture.index', [ 'page' => $page ] );
    }

    public function show( $guid )
    {
        $culture = Cache::rememberForever( "culture-$guid", function () use ($guid) {
            $cultureGenerator = new \App\CultureGenerator();
            return $cultureGenerator->generate($guid);
        } );

        $page = [
            'id' => $guid,
            'title' => 'The ' . $culture->Adjective . ' Culture',
            'subtitle' => 'A fictional people from a ' . $culture->HomeClimate->Name . ' climate',
            'description' => 'The ' . $culture->Adjective . ', a fictional culture from a ' . $culture->HomeClimate->Name . ' climate.',
            'type' => 'single',
        ];

        return view( 'culture.show', [ 'culture' => $culture, 'page' => $page ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'culture.show', [ 'guid' => $guid ] );
    }
}
