<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class HeraldryController extends Controller
{
    public function index()
    {
        return view( 'heraldry.index' );
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

        return view( 'heraldry.show', [ 'heraldry' => $heraldry ] );
    }

    public function generate()
    {
        $guid = rand(10, 100000);

        return redirect()->route( 'heraldry.show', [ 'guid' => $guid ] );
    }
}
