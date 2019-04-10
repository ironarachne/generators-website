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

    public function show( $guid )
    {
        $heraldry = Cache::rememberForever( "heraldry-$guid", function () {
            $heraldryGenerator = new App\HeraldryGenerator();
            return $heraldryGenerator->generate();
        } );

        return view( 'heraldry.show', [ 'heraldry' => $heraldry ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'heraldry.show', [ 'guid' => $guid ] );
    }
}
