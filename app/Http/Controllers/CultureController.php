<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use App\CultureGenerator;
use App\SavedCulture;

class CultureController extends Controller
{
    public function index()
    {
        $cultures = SavedCulture::latest()->limit(5)->get();
        return view('culture.index', ['cultures' => $cultures]);
    }

    public function create()
    {
        $guid = Uuid::uuid4();

        $cultureGenerator = new CultureGenerator();
        $culture = $cultureGenerator->generate($guid);

        if (Auth::check()) {
            $user = Auth::user();

            $user->cultures()->save($culture);
        } else {
            $culture->save();
        }

        Cache::forever('culture-' . $culture->guid, $culture);

        return redirect()->route('culture.show', ['guid' => $culture->guid]);
    }

    public function pdf($guid)
    {
        $culture = Cache::rememberForever('culture-' . $guid, function () use ($guid) {
            $culture = SavedCulture::where('guid', '=', $guid)->first();
            return $culture;
        });

        $html = view('culture.pdf', ['culture' => $culture])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    public function show($guid)
    {
        $culture = Cache::rememberForever('culture-' . $guid, function () use ($guid) {
            $culture = SavedCulture::where('guid', $guid)->first();
            if ($culture == false) {
                $cultureGenerator = new CultureGenerator();
                $culture = $cultureGenerator->generate($guid);

                if (Auth::check()) {
                    $user = Auth::user();

                    $user->cultures()->save($culture);
                } else {
                    $culture->save();
                }
            }
            return $culture;
        });

        return view('culture.show', ['culture' => $culture]);
    }
}
