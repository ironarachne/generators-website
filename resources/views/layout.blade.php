<!DOCTYPE html>
<html>

<head>
    <title>@yield('title') | Iron Arachne</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('}img/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script async defer data-website-id="3f86eae1-109d-43b8-b56f-ab8168fae101"
            src="https://umami.benovermyer.com/umami.js"></script>
</head>

<body>
<header>
    <img class="logo" src="{{ asset('img/ia-logo-small.png') }}" alt="Iron Arachne logo">
    <div>
        <h1>@yield('title')</h1>
        <p class="subtitle">@yield('subtitle')</p>
    </div>
</header>
<nav role="navigation" aria-label="main navigation">
    <ul>
        <li><a href="{{ route('index') }}">Main</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('quick') }}">Quick</a></li>
        <li><a href="{{ route('culture.index') }}">Cultures</a></li>
        <li><a href="{{ route('region.index') }}">Regions</a></li>
        <li><a href="{{ route('heraldry.index') }}">Heraldry</a></li>
        @if (!Auth::check())
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @else
            <li><a href="{{ route('dashboard' ) }}">Dashboard</a></li>
            <li><a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout
                </a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ Form::token() }}
            </form>
        @endif
    </ul>
</nav>
<section id="app">
    @yield('content')
</section>
<footer>
    <p>
        <strong>Iron Arachne</strong> is the ongoing project of
        <a href="https://benovermyer.com">Ben Overmyer</a>. You can find source code for most of these tools on
        GitHub at <a href="https://github.com/ironarachne/">github.com/ironarachne</a>.
    </p>
    <p>
        You can contact the author at <a href="mailto:ben@ironarachne.com">ben@ironarachne.com</a>.
    </p>
    <p>
        The Iron Arachne privacy policy is visible <a href="{{ route('privacy') }}">here</a>.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
<script>
    @yield('javascript')
</script>
</body>

</html>
