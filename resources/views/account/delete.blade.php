@extends('layouts.app')

@section('meta_title', 'Are you sure?')
@section('meta_description', 'Please confirm that you wish to delete your account.')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">Are you sure?</h1>
        <p>Please click the button below, to confirm that you wish to delete your account.</p>
    </section>

    <section class="section has-text-centered">
        <form action="{{ route('account.destroy') }}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}

            <button class="button is-medium is-primary">Delete my account</button>
        </form>
    </section>
@endsection
