@extends('layout')

@section('content')
{{ form_open([ 'route' => 'password.update' ]) }}
    @if ($errors->any)
    <h4 class="has-text-danger">{{ $errors->first }}</h4>
    @endif

    {{ form_hidden('token', token ) }}

    <div class="field">
        {{ form_label('email', 'Email', [ 'class' => 'label' ]) }}

        <div class="control">
            {{ form_email('email', old('email'), [ 'class' => 'input', 'required' => true ]) }}
        </div>
    </div>

    <div class="field">
        {{ form_label('password', 'Password', [ 'class' => 'label' ]) }}

        <div class="control">
            {{ form_password('password', [ 'class' => 'input', 'required' => true ]) }}
        </div>
    </div>

    <div class="field">
        {{ form_label('password_confirmation', 'Confirm Password', [ 'class' => 'label' ]) }}

        <div class="control">
            {{ form_password('password_confirmation', [ 'class' => 'input', 'required' => true ]) }}
        </div>
    </div>

    {{ form_submit('Reset Password', [ 'class' => 'button is-primary' ]) }}
{{ form_close() }}
@endsection
