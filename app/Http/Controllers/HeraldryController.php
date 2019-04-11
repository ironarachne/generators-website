<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class HeraldryController extends Controller
{
    public function index()
    {
        $page = [
            'title' => 'Heraldry Generator',
            'subtitle' => 'Generate fictional coats-of-arms and their blazons',
            'description' => 'This tool procedurally generates fictional coats-of-arms and their blazons.',
            'type' => 'single',
        ];
        
        return view( 'heraldry.index', [ 'page' => $page ] );
    }

    public function device( $guid )
    {
        $heraldry = Cache::rememberForever( "heraldry-$guid", function () use ($guid) {
            $heraldryGenerator = new \App\HeraldryGenerator();
            return $heraldryGenerator->generate($guid);
        } );

        return response($heraldry['device'])->header('Content-Type', 'image/svg+xml');
    }

    public function show( $guid )
    {
        $heraldry = Cache::rememberForever( "heraldry-$guid", function () use ($guid) {
            $heraldryGenerator = new \App\HeraldryGenerator();
            return $heraldryGenerator->generate($guid);
        } );

        $page = [
            'title' => $heraldry['blazon'],
            'description' => 'A coat of arms for the blazon "' . $heraldry['blazon'] . '"',
            'type' => 'single',
        ];

        return view( 'heraldry.show', [ 'heraldry' => $heraldry, 'page' => $page ] );
    }

    public function generate()
    {
        $guid = rand(10, 100000);

        return redirect()->route( 'heraldry.show', [ 'guid' => $guid ] );
    }
}
