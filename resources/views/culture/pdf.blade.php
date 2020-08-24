@extends('pdflayout')

@section('content')
    <h2>The {{ $culture->name }} Culture</h2>

    {{ $culture->html }}
@endsection
