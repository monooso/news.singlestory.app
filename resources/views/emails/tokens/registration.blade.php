@component('mail::token')
# Welcome to Single Story #
Click on the button below to finish setting up your account.

@component('mail::button', ['url' => $url])
Finish setting up your account
@endcomponent

This link will expire in 15 minutes.
@endcomponent
