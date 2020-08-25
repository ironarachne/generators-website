@extends('layout')

@section('title')
    Login
@endsection

@section('content')
    <p>Log in to your user account.</p>

    {{ Form::open() }}

    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    <div class="input-group">
        {{ Form::label('email', 'Email Address', ['class' => 'label']) }}
        {{ Form::email('email', '', ['class' => 'input']) }}
    </div>
    <div class="input-group">
        {{ Form::label('password', 'Password', ['class' => 'label']) }}
        {{ Form::password('password', ['class' => 'input']) }}
    </div>

    {{ Form::submit('Login', ['class' => 'button is-primary']) }}

    {{ Form::close() }}

    <p><a href="/password/reset">Forgot your password?</a></p>

@endsection
