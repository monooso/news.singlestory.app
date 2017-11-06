@extends('layouts.app')

@section('meta_title', $title)
@section('meta_description', $message)

@section('content')
    <section class="section has-text-centered">
        <h1 class="title">{{ $title }}</h1>
        <p>{{ $message }}</p>
    </section>
@endsection
