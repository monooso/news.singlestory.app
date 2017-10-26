@extends('layouts.app')

@section('content')
    @if (session()->has('status'))
        <div>
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <form action="{{ route('account') }}" method="post">
        {{ csrf_field() }}

        <div>
            @if ($errors->has('schedule'))
                <strong>{{ $errors->first('schedule') }}</strong>
            @endif

            <label for="schedule">How frequently would you like us to email you?</label>

            @foreach ($schedule_options as $value => $label)
                <label>
                    <input name="schedule"
                           type="radio"
                           id="schedule--{{ $value }}"
                           value="{{ $value }}"
                           @if ($value === $user->schedule)checked="checked"@endif
                    />
                    {{ $label }}
                </label>
            @endforeach
        </div>

        <div>
            <input type="submit" value="Save Preferences" />
        </div>
    </form>
@endsection
