@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card m-t-60">
                <header class="card-header">
                    <p class="card-header-title">{{ trans('auth.login') }}</p>
                </header>

                <div class="card-content">
                    <form class="login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="field">
                            <label class="label">{{ trans('auth.email') }}</label>

                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="email" type="email" name="email"
                                               value="{{ old('email') }}" autofocus>
                                    </p>

                                    @if ($errors->has('email'))
                                        <p class="help is-danger">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field">
                                <label class="label">{{ trans('auth.password') }}</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="password" type="password" name="password">
                                    </p>

                                    @if ($errors->has('password'))
                                        <p class="help is-danger">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
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
                                    </p>
                                </div>
                            </div>
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
        </div>
    </div>
@endsection
