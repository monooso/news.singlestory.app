@extends('layouts.app')

@section('meta_title', 'Check your email')
@section('meta_description', 'We’ve sent you a link to finish setting up your account')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">Check your email</h1>
        <p>We’ve sent you a link to finish setting up your account.</p>
    </section>

    <img class="next-email" src="/assets/images/next-email.png" />
@endsection
