@component('mail::token')
# Welcome to Single Story #
Click on the button below to log in to your account.

@component('mail::button', ['url' => $url])
Log in to your account
@endcomponent

This link will expire in 15 minutes.
@endcomponent
