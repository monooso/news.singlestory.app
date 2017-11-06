@extends('layouts.app')

@section('meta_title', 'Internal server error')
@section('meta_description', 'Sorry, something went wrong on our side of things')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">Well that’s not good</h1>
        <p>Sorry, something went wrong on our side of things.</p>
        <p>It’s probably a temporary glitch, but if you continue to have problems, please <a href="mailto: hello@singlestory.news">let us know</a>.</p>
    </section>
@endsection
