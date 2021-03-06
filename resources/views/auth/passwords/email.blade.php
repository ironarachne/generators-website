@extends('layout')

@section('content')
{{ form_open([ 'route' => 'password.email' ]) }}
    {% if errors.any %}
    <h4 class="has-text-danger">{{ $errors->first }}</h4>
    {% endif %}

    <div class="field">
        {{ form_label('email', 'Email', [ 'class' => 'label' ]) }}

        <div class="control">
            {{ form_email('email', old('email'), [ 'class' => 'input', 'required' => true ]) }}
        </div>
    </div>

    {{ form_submit('Send password reset link', [ 'class' => 'button is-primary' ]) }}
{{ form_close() }}
@endsection
