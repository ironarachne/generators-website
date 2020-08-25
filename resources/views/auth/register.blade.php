@extends('layout')

@section('title')
    Register a New Account
@endsection

@section('content')
    <p>Register a new user account.</p>

    {{ Form::open() }}

    @if ($errors->any())
        @foreach($errors->all() as $error)
            <h4 class="has-text-danger">{{ $error }}</h4>
        @endforeach
    @endif

    <div class="field">
        {{ Form::label('name', 'Display Name', ['class' => 'label']) }}
        <div class="control">
            {{ Form::text('name', '', ['class' => 'input']) }}
        </div>
    </div>

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
    <div class="field">
        {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'label']) }}
        <div class="control">
            {{ Form::password('password_confirmation', ['class' => 'input']) }}
        </div>
    </div>

    {{ Form::submit('Register', ['class' => 'button is-primary']) }}

    {{ Form::close() }}

@endsection
