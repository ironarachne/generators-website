<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class CultureController extends Controller
{
    public function index()
    {
        return view( 'culture.index' );
    }

    public function show( $guid )
    {
        $culture = Cache::rememberForever( "culture-$guid", function () {
            $cultureGenerator = new App\CultureGenerator();
            return $cultureGenerator->generate();
        } );

        return view( 'culture.show', [ 'culture' => $culture ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'culture.show', [ 'guid' => $guid ] );
    }
}
