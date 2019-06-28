<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
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

    public function pdf( $guid )
    {
        $culture = Cache::rememberForever( "culture-$guid", function () use ($guid) {
            $cultureGenerator = new \App\CultureGenerator();
            return $cultureGenerator->generate($guid);
        } );

        $page = [
            'id' => $guid,
            'title' => 'The ' . $culture->adjective . ' Culture',
            'subtitle' => 'A fictional people from a ' . $culture->home_climate->adjective . ' climate',
            'description' => 'The ' . $culture->adjective . ', a fictional ' . $culture->primary_race->adjective . ' culture from a ' . $culture->home_climate->adjective . ' climate.',
            'type' => 'single',
        ];

        $html = view( 'culture.pdf', [ 'culture' => $culture, 'page' => $page ] );

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    public function show( $guid )
    {
        $culture = Cache::rememberForever( "culture-$guid", function () use ($guid) {
            $cultureGenerator = new \App\CultureGenerator();
            return $cultureGenerator->generate($guid);
        } );

        $page = [
            'id' => $guid,
            'title' => 'The ' . $culture->adjective . ' Culture',
            'subtitle' => 'A fictional people from a ' . $culture->home_climate->adjective . ' climate',
            'description' => 'The ' . $culture->adjective . ', a fictional ' . $culture->primary_race->adjective . ' culture from a ' . $culture->home_climate->adjective . ' climate.',
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
