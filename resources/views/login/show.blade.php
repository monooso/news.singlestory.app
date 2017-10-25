@extends('layouts.app')

@section('content')
    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}

        <div>
            @if ($errors->has('email'))
                <strong>{{ $errors->first('email') }}</strong>
            @endif

            <label for="email">Email</label>
            <input id="email" name="email" required type="email" />
        </div>

        <div>
            <input type="submit" value="Login" />
        </div>
    </form>
@endsection
