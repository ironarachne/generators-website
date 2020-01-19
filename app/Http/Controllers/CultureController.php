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
        $cultures = Culture::latest()->limit(5)->get();

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
        $culture = Cache::rememberForever('culture-'.$guid, function() use ($guid) {
            $culture = Culture::where('guid', '=', $guid)->first();
            return $culture;
        });

        $page = [
            'title' => 'The ' . $culture->name . ' Culture',
            'description' => $culture->description,
        ];

        $html = view( 'culture.pdf', [ 'culture' => $culture, 'page' => $page ] )->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    public function show( $guid )
    {
        $culture = Cache::rememberForever('culture-'.$guid, function() use ($guid) {
            $culture = Culture::where('guid', '=', $guid)->first();
            return $culture;
        });

        $page = [
            'id' => $guid,
            'title' => 'The ' . $culture->name . ' Culture',
            'subtitle' => $culture->description,
            'description' => $culture->description,
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'culture.show', [ 'culture' => $culture, 'page' => $page ] );
    }
}
