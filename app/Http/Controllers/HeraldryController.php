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

    public function show( Request $request, $guid )
    {
        $fieldShape = $request->query('shape');

        $heraldry = Cache::rememberForever( "heraldry-$guid", function () use ($guid, $fieldShape) {
            $heraldryGenerator = new \App\HeraldryGenerator();
            return $heraldryGenerator->generate($guid, $fieldShape);
        } );

        $page = [
            'title' => $heraldry['heraldry']->Blazon,
            'description' => 'A coat of arms for the blazon "' . $heraldry['heraldry']->Blazon . '"',
            'type' => 'single',
        ];

        return view( 'heraldry.show', [ 'heraldry' => $heraldry, 'page' => $page ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'heraldry.show', [ 'guid' => $guid ] );
    }
}
