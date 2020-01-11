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
        $page = [
            'title' => 'My Dashboard',
            'subtitle' => '',
            'description' => 'Personal dashboard',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];
        return view( 'dashboard' )->with( [ 'page' => $page ] );
    }

    public function quick()
    {
        $page = [
            'title' => 'Iron Arachne',
            'subtitle' => 'Quick Generators',
            'description' => 'Quick generators',
            'type' => 'single',
            'fathom_domain' => config('services.fathom.domain'),
            'fathom_site_id' => config('services.fathom.site_id'),
        ];

        return view( 'quick' )->with( [ 'page' => $page ] );
    }
}
