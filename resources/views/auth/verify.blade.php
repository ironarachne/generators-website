@extends('layout')

@section('title')
    Verification Sent
@endsection

@section('content')
    <h1>Verification Sent</h1>
    {{ Form::open([ 'route' => 'verification.resend' ]) }}
    {{ Form::submit('Click to request another verification email', [ 'class' => 'button is-primary' ]) }}
    {{ Form::close() }}
@endsection
