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
        @stack('styles')
    </head>
    <body>
        <div id="app">
            @include('partials.nabvar.main')
            @yield('content')
        </div>

        @include('partials.footer.main')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @include('partials.assets.scripts')
        @stack('scripts')
    </body>
</html>
