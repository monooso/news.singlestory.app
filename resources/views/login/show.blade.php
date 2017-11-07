@extends('layouts.app')

@section('meta_title', 'Log in to Single Story')
@section('meta_description', 'Log in to your Single Story account')

@section('nav')
    <a href="{{ route('home') }}" title="Join Single Story">Join</a>
@endsection

@if ($errors->has('email'))
    @push('statuses')
        @component('components.status-error')
            {{ $errors->first('email') }}
        @endcomponent
    @endpush
@endif

@section('content')
    <section class="section">
        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}

            <div class="columns">
                <div class="column is-two-thirds">
                    <input class="input is-large" name="email" placeholder="Enter your email" required type="email" />
                </div>

                <div class="column">
                    <button class="button is-fullwidth is-large is-primary">Log in</button>
                </div>
            </div>
        </form>
    </section>
@endsection
