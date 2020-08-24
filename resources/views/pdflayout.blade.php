<!DOCTYPE html>
<html>

<head>
    <title>{{ $page->title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $page->description }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}" type="text/css">
</head>

<body>
@yield('content')
</body>

</html>
