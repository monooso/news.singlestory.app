<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')" />

    <link rel="stylesheet" href="/assets/styles/app.css" />
</head>

<body>

@stack('statuses')

<div class="root">
    <div class="box">
        @include('includes.nav')

        <section class="main">
            @yield('content')
        </section>
    </div>
</div>

</body>
</html>
