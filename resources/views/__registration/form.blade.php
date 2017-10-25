<form action="{{ route('register') }}" method="post">
    {{ csrf_field() }}

    <strong>{{ $errors->first('email') }}</strong>
    <input type="email" name="email" />

    <input type="submit" value="Register" />
</form>

