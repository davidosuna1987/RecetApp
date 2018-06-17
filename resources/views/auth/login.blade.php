@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <h1 class="m-t-60 m-b-40">{{ trans('auth.login') }}</h1>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="vd-input has-label-primary">
                    <input id="email" class="vd-input-field" type="text" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email') }}" autofocus />

                    <label class="vd-placeholder">{{ trans('auth.email') }}</label>
                </div>
                @if ($errors->has('email'))
                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                @endif

                <div class="vd-input has-label-primary">
                    <input id="password" class="vd-input-field" type="password" name="password" value="" placeholder="{{ trans('auth.password') }}" />

                    <label class="vd-placeholder">{{ trans('auth.password') }}</label>
                </div>
                @if ($errors->has('password'))
                    <p class="help is-danger">{{ $errors->first('password') }}</p>
                @endif

                <div class="vd-checkbox__group">
                    <label for="remember" class="vd-checkbox is-primary">
                        <input
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                            name="remember"
                            type="checkbox" />

                        <span class="vd-checkbox__info">
                            <span class="vd-checkbox__check"></span>
                            <span class="vd-checkbox__label">{{ trans('auth.remember') }}</span>
                        </span>
                    </label>
                </div>

                <div class="field">
                    <div class="field-body">
                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-primary">{{ trans('auth.login') }}</button>
                            </div>

                            <div class="control">
                                <a href="{{ route('password.request') }}" class="button is-text">
                                    {{ trans('auth.forgot') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
