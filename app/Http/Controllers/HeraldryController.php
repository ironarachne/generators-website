<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\HeraldryGenerator;
use App\Heraldry;

class HeraldryController extends Controller
{
    public function index()
    {
        $devices = Heraldry::latest()->limit(5)->get();

        $page = [
            'title' => 'Heraldry',
            'subtitle' => 'Generate fictional coats-of-arms and their blazons',
            'description' => 'This tool procedurally generates fictional coats-of-arms and their blazons.',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'heraldry.index', [ 'page' => $page, 'devices' => $devices ] );
    }

    public function create( Request $request )
    {
        $guid = Uuid::uuid4();

        $fieldShape = $request->field_shape;

        if ($fieldShape == 'any') {
            $fieldShape = '';
        }

        $heraldryGenerator = new HeraldryGenerator();
        $heraldry = $heraldryGenerator->generate( $guid, $fieldShape );

        if (\Auth::check()) {
            $user = \Auth::user();

            $user->heraldries()->save($heraldry);
        } else {
            $heraldry->save();
        }

        Cache::forever('heraldry-'.$heraldry->guid, $heraldry);

        return redirect()->route('heraldry.show', ['guid' => $heraldry->guid]);
    }

    public function show( Request $request, $guid )
    {
        $heraldry = Cache::get('heraldry-'.$guid);

        $page = [
            'title' => $heraldry->blazon,
            'description' => 'A coat of arms for the blazon "' . $heraldry->blazon . '"',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'heraldry.show', [ 'heraldry' => $heraldry, 'page' => $page ] );
    }
}
