<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('blog_posts', 600, function () {
            $client = new Client(['base_uri' => 'https://blog.ironarachne.com/api/']);
            $response = $client->request('GET', 'collections/ben/posts');

            $body = $response->getBody();

            $json = json_decode($body);

            $post_data = $json->data->posts;

            $Parsedown = new \Parsedown();

            $i = 0;

            foreach ($post_data as $post) {
                if ( $i < 3 ) {
                    $posts[] = [
                        'title' => $post->title,
                        'created' => $post->created,
                        'body' => $Parsedown->text( $post->body ),
                    ];
                }

                $i++;
            }

            return $posts;
        });

        $page = [
            'title' => 'Iron Arachne',
            'subtitle' => 'Procedural Generation Tools for Tabletop Role-playing Games',
            'description' => 'Procedural Generation Tools for Tabletop Role-playing Games',
            'type' => 'home',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];
        return view( 'index' )->with( [ 'page' => $page, 'posts' => $posts ] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = \Auth::user();

        $cultures = [];

        $userCultures = $user->cultures()->latest()->get();

        foreach ($userCultures as $cultureObject) {
            $cultureData = json_decode($cultureObject->data);
            $culture['name'] = $cultureData->name;
            $culture['guid'] = $cultureObject->guid;
            $cultures[] = $culture;
        }

        $regions = [];

        $userRegions = $user->regions()->latest()->get();

        foreach ($userRegions as $regionObject) {
            $regionData = json_decode($regionObject->data);
            $region['name'] = $regionData->name;
            $region['guid'] = $regionObject->guid;
            $regions[] = $region;
        }

        $devices = $user->heraldries()->latest()->get();

        $page = [
            'title' => 'My Dashboard',
            'subtitle' => '',
            'description' => 'Personal dashboard',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];
        return view( 'dashboard' )->with( [ 'page' => $page, 'cultures' => $cultures, 'regions' => $regions, 'devices' => $devices ] );
    }

    public function quick()
    {
        $page = [
            'title' => 'Quick Generators',
            'subtitle' => 'Small generators for quick creations',
            'description' => 'Small generators for quick creations',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'quick' )->with( [ 'page' => $page ] );
    }

    public function privacy()
    {
        $page = [
            'title' => 'Privacy Policy',
            'subtitle' => 'This is the site privacy policy',
            'description' => 'Iron Arachne\'s privacy policy',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'privacy' )->with( [ 'page' => $page ] );
    }
}
