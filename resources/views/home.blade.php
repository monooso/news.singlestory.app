@extends('layouts.app')

@section('meta_title', 'Single Story')
@section('meta_description', 'Get the one news story that matters most, delivered straight to your inbox')

@section('nav')
    <a href="{{ route('login') }}" title="Log in to your account">Log in</a>
@endsection

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">Get the one news story that matters most, delivered straight to your inbox</h1>
    </section>

    <section class="section">
        <form action="{{ route('join') }}" method="post">
            {{ csrf_field() }}

            <div class="columns">
                <div class="column is-two-thirds">
                    <input class="input is-large" name="email" placeholder="Enter your email" required type="email" />
                </div>

                <div class="column">
                    <button class="button is-fullwidth is-large is-primary">Get started</button>
                </div>
            </div>

            <p class="has-text-centered">Free forever, leave at any time.</p>
        </form>
    </section>
@endsection
