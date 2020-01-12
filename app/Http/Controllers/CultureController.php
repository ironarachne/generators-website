<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use App\CultureGenerator;
use App\Culture;

class CultureController extends Controller
{
    public function index()
    {
        $cultureData = Culture::latest()->limit(5)->get();

        foreach ($cultureData as $cultureObject) {
            $data = json_decode($cultureObject->data);
            $culture['name'] = $data->name;
            $culture['guid'] = $cultureObject->guid;
            $culture['description'] = 'The ' . $data->adjective . ' are a ' . $data->primary_race->adjective . ' society. They are from a ' . $data->home_climate->name . ' region.';
            $cultures[] = $culture;
        }

        $page = [
            'title' => 'Cultures',
            'subtitle' => 'Generate human cultures for a fantasy world',
            'description' => 'This tool procedurally generates fantasy human cultures',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'culture.index', [ 'page' => $page, 'cultures' => $cultures ] );
    }

    public function create()
    {
        $guid = Uuid::uuid4();

        $cultureGenerator = new CultureGenerator();
        $culture = $cultureGenerator->generate( $guid );

        if (\Auth::check()) {
            $user = \Auth::user();

            $user->cultures()->save($culture);
        } else {
            $culture->save();
        }

        Cache::forever('culture-'.$culture->guid, $culture);

        return redirect()->route('culture.show', ['guid' => $culture->guid]);
    }

    public function pdf( $guid )
    {
        $cultureObject = Cache::get('culture-'.$guid);
        $culture = json_decode($cultureObject->data);

        $page = [
            'id' => $guid,
            'title' => 'The ' . $culture->adjective . ' Culture',
            'subtitle' => 'A fictional people from a ' . $culture->home_climate->adjective . ' climate',
            'description' => 'The ' . $culture->adjective . ', a fictional ' . $culture->primary_race->adjective . ' culture from a ' . $culture->home_climate->adjective . ' climate.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
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
        $cultureObject = Cache::get('culture-'.$guid);
        $culture = json_decode($cultureObject->data);

        $page = [
            'id' => $guid,
            'title' => 'The ' . $culture->adjective . ' Culture',
            'subtitle' => 'A fictional people from a ' . $culture->home_climate->adjective . ' climate',
            'description' => 'The ' . $culture->adjective . ', a fictional ' . $culture->primary_race->adjective . ' culture from a ' . $culture->home_climate->adjective . ' climate.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'culture.show', [ 'culture' => $culture, 'page' => $page ] );
    }
}
