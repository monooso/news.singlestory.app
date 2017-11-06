@component('mail::story')
# {{ $article->title }} #
{{ $article->abstract }}

@component('mail::button', ['url' => $article->url])
Read the full story
@endcomponent

You can change your email preferences at any time, by [logging-in]({{ route('login') }} "Log in to your account") to your account.
@endcomponent
