@extends('layout')

@section('title')
    Login
@endsection

@section('content')
    <p>Log in to your user account.</p>

    {{ Form::open() }}

    @if ($errors->any())
        @foreach($errors->all() as $error)
            <h4 class="has-text-danger">{{ $error }}</h4>
        @endforeach
    @endif

    <div class="field">
        {{ Form::label('email', 'Email Address', ['class' => 'label']) }}
        <div class="control">
            {{ Form::email('email', '', ['class' => 'input']) }}
        </div>
    </div>
    <div class="field">
        {{ Form::label('password', 'Password', ['class' => 'label']) }}
        <div class="control">
            {{ Form::password('password', ['class' => 'input']) }}
        </div>
    </div>

    {{ Form::submit('Login', ['class' => 'button is-primary']) }}

    {{ Form::close() }}

    <a href="/password/reset">Forgot your password?</a>

@endsection
