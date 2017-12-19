@extends('layouts.app')

@section('meta_title', 'Manage your email preferences')
@section('meta_description', 'Manage your email preferences')

@if ($errors->has('schedule'))
    @push('statuses')
        @component('components.status-error')
            {{ $errors->first('schedule') }}
        @endcomponent
    @endpush
@endif

@if (session()->has('status'))
    @push('statuses')
        @component('components.status-success')
            {{ session('status') }}
        @endcomponent
    @endpush
@endif

@section('nav')
    <a href="{{ route('logout') }}" title="Log out of your account">Log out</a>
@endsection

@section('content')
    <form action="{{ route('account') }}" method="post">
        {{ csrf_field() }}

        <section class="section has-text-centered">
            <h1 class="title">Email frequency</h1>
            <label for="schedule">
                How frequently should we email you?
            </label>
        </section>

        <section class="section">
            @component('components.email-schedule', ['selected' => $user->schedule, 'value' => 'daily'])
                @slot('title')
                    Every day
                @endslot

                @slot('description')
                    Receive one article every day, at around 5am EST
                @endslot
            @endcomponent

            @component('components.email-schedule', ['selected' => $user->schedule, 'value' => 'weekly'])
                @slot('title')
                    Once a week
                @endslot

                @slot('description')
                    Receive one article every Saturday, at around 5am EST
                @endslot
            @endcomponent

            @component('components.email-schedule', ['selected' => $user->schedule, 'value' => 'never'])
                @slot('title')
                    Never
                @endslot

                @slot('description')
                    Don’t receive any articles (or you can <a href="{{ route('account.delete') }}">delete your account</a>)
                @endslot
            @endcomponent
        </section>

        <section class="section has-text-centered">
            <input class="button is-primary is-large" type="submit" value="Save preferences"/>
        </section>
    </form>
@endsection
