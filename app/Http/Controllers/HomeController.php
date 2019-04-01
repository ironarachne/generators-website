<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $page = [];

        $page['title'] = 'Iron Arachne';
        $page['subtitle'] = 'Procedural Generation Tools for Tabletop Role-playing Games';
        $page['type'] = 'home';

        return view( 'index' )->with( [ 'page' => $page ] );
    }
}
