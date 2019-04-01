<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class RegionController extends Controller
{
    public function index()
    {
        return view( 'region.index' );
    }

    public function show( $guid )
    {
        $region = Cache::rememberForever( "region-$guid", function () {
            $regionGenerator = new regionGenerator();
            return $regionGenerator->generate();
        } );

        return view( 'region.show', [ 'region' => $region ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'region.show', [ 'guid' => $guid ] );
    }
}
