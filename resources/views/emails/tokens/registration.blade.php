@component('mail::message')
# Welcome to Nofomo #

Click on the button below to get started.

@component('mail::button', ['url' => $url])
Get Started
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
