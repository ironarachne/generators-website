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
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'index' )->with( [ 'page' => $page ] );
    }

    public function dashboard()
    {
        $page = [
            'title' => 'Iron Arachne',
            'subtitle' => 'Your Dashboard',
            'description' => 'User Dashboard',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'dashboard' )->with( [ 'page' => $page ] );
    }
}
