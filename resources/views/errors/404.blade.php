@extends('layouts.app')

@section('content')
    <p>{{ $exception->getMessage() }}</p>
@endsection
