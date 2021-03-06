@extends('layout')

@section('content')
    {{ form_open([ 'route' => 'password.confirm' ]) }}
    @if ($errors->any)
        <h4 class="has-text-danger">{{ $errors->first }}</h4>
    @endif
    <div class="field">
        {{ form_label('password', 'Password', ['class' => 'label']) }}

        <div class="control">
            {{ form_password('password', '', ['class' => 'input', 'required' => true ]) }}
        </div>
    </div>

    {{ form_submit('Confirm Password', [ 'class' => 'button is-primary' ]) }}

    <a class="button is-warning" href="{{ route('password.request') }}">Forgot your password?</a>
    {{ form_close() }}
@endsection
