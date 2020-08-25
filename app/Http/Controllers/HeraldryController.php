<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        return view('heraldry.index', ['devices' => $devices]);
    }

    public function create(Request $request)
    {
        $guid = Uuid::uuid4();

        $fieldShape = $request->field_shape;

        if ($fieldShape == 'any') {
            $fieldShape = '';
        }

        $heraldryGenerator = new HeraldryGenerator();
        $heraldry = $heraldryGenerator->generate($guid, $fieldShape);

        if (Auth::check()) {
            $user = Auth::user();

            $user->heraldries()->save($heraldry);
        } else {
            $heraldry->save();
        }

        Cache::forever('heraldry-' . $heraldry->guid, $heraldry);

        return redirect()->route('heraldry.show', ['guid' => $heraldry->guid]);
    }

    public function show(Request $request, $guid)
    {
        $fieldShape = $request->query('shape');
        $heraldry = Cache::rememberForever('heraldry-' . $guid, function () use ($fieldShape, $guid) {
            $h = Heraldry::where('guid', $guid)->first();

            if ($h == false) {
                $heraldryGenerator = new HeraldryGenerator();
                $heraldry = $heraldryGenerator->generate($guid, $fieldShape);

                if (Auth::check()) {
                    $user = Auth::user();

                    $user->heraldries()->save($heraldry);
                } else {
                    $heraldry->save();
                }
            } else {
                $heraldry = $h;
            }

            return $heraldry;
        });

        return view('heraldry.show', ['heraldry' => $heraldry]);
    }
}
