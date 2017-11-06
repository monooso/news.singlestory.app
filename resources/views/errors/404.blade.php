@extends('layouts.app')

@section('meta_title', 'Page not found')
@section('meta_description', 'Sorry, we were unable to find the page you requested')

@section('nav')
    @auth
        <a href="{{ route('logout') }}" title="Log out of your account">Log out</a>
    @endauth

    @guest
        <a href="{{ route('join') }}" title="Join Single Story">Join</a>
        <a href="{{ route('login') }}" title="Log in to your account">Log in</a>
    @endguest
@endsection

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">Page not found</h1>
        <p>Sorry, we were unable to find the page your requested.</p>
    </section>
@endsection
