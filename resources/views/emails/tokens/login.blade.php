@component('mail::message')
# One-Time Password #

Click on the button below to log in to your account.

@component('mail::button', ['url' => $url])
Log In
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
