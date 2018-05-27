@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card m-t-60">
                <header class="card-header">
                    <p class="card-header-title">{{ trans('auth.register') }}</p>
                </header>

                <div class="card-content">
                    <form class="register-form" method="POST" action="{{ route('register') }}">

                        {{ csrf_field() }}

                        <div class="field">
                            <label class="label">{{ trans('auth.first_name') }}</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="first_name" type="first_name" name="first_name" value="{{ old('first_name') }}"
                                               autofocus>
                                    </p>

                                    @if ($errors->has('first_name'))
                                        <p class="help is-danger">
                                            {{ $errors->first('first_name') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">{{ trans('auth.last_name') }}</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="last_name" type="last_name" name="last_name" value="{{ old('last_name') }}"
                                               autofocus>
                                    </p>

                                    @if ($errors->has('last_name'))
                                        <p class="help is-danger">
                                            {{ $errors->first('last_name') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

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
                            <label class="label">{{ trans('auth.password_confirmation') }}</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="password-confirm" type="password"
                                               name="password_confirmation">
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="field-body">
                                <div class="field is-grouped">
                                    <div class="control">
                                        <button type="submit" class="button is-primary">{{ trans('auth.register') }}</button>
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
