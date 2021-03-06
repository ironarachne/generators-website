@extends('layout')

@section('title')
    About Iron Arachne
@endsection

@section('subtitle')
    A quick word about what Iron Arachne is meant to be
@endsection

@section('description')
    About the Iron Arachne website
@endsection

@section('content')
    <h2>About Iron Arachne</h2>
    <p>Iron Arachne&trade; is a project to generate an entire fantasy world completely from scratch in a way that is coherent
        and at least somewhat realistic. Eventually, this will include maps, artwork, calendars, phrasebooks, and
        everything else necessary for a gazetteer about a world.</p>

    <h2>Content Usage</h2>
    <p>Anything generated by this website is yours to use in any capacity you see fit. The heraldry artwork is public
        domain. All generated text and artwork can be used as is, modified, included
        in commercial works, and any other usage without attribution.</p>
    <p>The Iron Arachne&trade; logo is copyright &copy;{{ date('Y') }} Ben Overmyer. All artwork and icons that are not
    specifically called out as public domain is owned in whole or in part, or used under license, by Ben Overmyer.</p>
    <p>I would love to know if you decide to use anything here. Drop me a line at <a
            href="mailto:ben@ironarachne.com">ben@ironarachne.com</a>.</p>
@endsection
