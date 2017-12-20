@extends('layouts.app')

@section('meta_title', 'Not Authorised')
@section('meta_description', 'You are not authorised to perform the requested action')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">Not authorised</h1>
        <p>You’re not allowed to perform the requested action.</p>
    </section>
@endsection
