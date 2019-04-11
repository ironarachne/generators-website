<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $page = [
            'title' => 'Iron Arachne',
            'subtitle' => 'Procedural Generation Tools for Tabletop Role-playing Games',
            'description' => 'Procedural Generation Tools for Tabletop Role-playing Games',
            'type' => 'home',
        ];

        return view( 'index' )->with( [ 'page' => $page ] );
    }
}
