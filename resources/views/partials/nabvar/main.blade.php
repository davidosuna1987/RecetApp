<nav class="navbar is-primary has-shadow is-fixed-top">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ url('/') }}" class="navbar-item">{{ config('app.name', 'RecetApp') }}</a>

            <div class="navbar-burger burger" data-target="navMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="navbar-menu" id="navMenu">
            <div class="navbar-start">
                @if(Auth::user())
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">{{ trans('navbar.recipes') }}</a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ route('recipes.create') }}">{{ trans('navbar.recipes_create') }}</a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="navbar-end">
                @if(Auth::guest())
                    <a class="navbar-item " href="{{ route('login') }}">{{ trans('navbar.login') }}</a>
                    <a class="navbar-item " href="{{ route('register') }}">{{ trans('navbar.register') }}</a>
                @else
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">{{ trans('navbar.hello') }} {{ Auth::user()->profile->first_name }}!</a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ trans('navbar.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>
