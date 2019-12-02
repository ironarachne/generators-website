<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class HeraldryController extends Controller
{
    public function index()
    {
        $page = [
            'title' => 'Heraldry Generator',
            'subtitle' => 'Generate fictional coats-of-arms and their blazons',
            'description' => 'This tool procedurally generates fictional coats-of-arms and their blazons.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'heraldry.index', [ 'page' => $page ] );
    }

    public function show( Request $request, $guid )
    {
        $fieldShape = $request->query('shape');

        $heraldry = Cache::rememberForever( "heraldry-$guid-$fieldShape", function () use ($guid, $fieldShape) {
            $heraldryGenerator = new \App\HeraldryGenerator();
            return $heraldryGenerator->generate($guid, $fieldShape);
        } );

        $page = [
            'title' => $heraldry['heraldry']->Blazon,
            'description' => 'A coat of arms for the blazon "' . $heraldry['heraldry']->Blazon . '"',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'heraldry.show', [ 'heraldry' => $heraldry, 'page' => $page ] );
    }

    public function generate()
    {
        $guid = Uuid::uuid4();

        return redirect()->route( 'heraldry.show', [ 'guid' => $guid ] );
    }
}
