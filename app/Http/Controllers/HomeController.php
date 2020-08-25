<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Parsedown;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('blog_posts', 600, function () {
            $posts = [];

            $client = new Client(['base_uri' => 'https://blog.ironarachne.com/api/']);
            $response = $client->request('GET', 'collections/ben/posts');

            $body = (string)$response->getBody();

            $json = json_decode($body);

            $post_data = $json->data->posts;

            $Parsedown = new Parsedown();

            $i = 0;

            foreach ($post_data as $post) {
                if ($i < 3) {
                    $body = $Parsedown->text($post->body);
                    $body = str_replace('h2', 'h3', $body);

                    $posts[] = [
                        'title' => $post->title,
                        'created' => $post->created,
                        'body' => $body,
                    ];
                } else {
                    break;
                }

                $i++;
            }

            return $posts;
        });

        return view('index')->with(['posts' => $posts]);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function dashboard()
    {
        $user = Auth::user();

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

        return view('dashboard')->with(['cultures' => $cultures, 'regions' => $regions, 'devices' => $devices]);
    }

    public function about()
    {
        return view('about');
    }

    public function quick()
    {
        return view('quick');
    }

    public function privacy()
    {
        return view('privacy');
    }
}
