<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <title>{{ config('app.name', 'RecetApp') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @include('partials.assets.styles')
        @stack('styles')
    </head>
    <body>
        <div id="app">
            <section class="wrapper">
                @include('partials.nabvar.main')
                @yield('content')
            </section>
        </div>

        @include('partials.footer.main')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @include('partials.assets.scripts')
        @stack('scripts')
    </body>
</html>
