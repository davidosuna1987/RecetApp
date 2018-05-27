@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card m-t-60">
                <header class="card-header">
                    <p class="card-header-title">{{ trans('auth.password_reset') }}</p>
                </header>

                <div class="card-content">
                    @if (session('status'))
                        <div class="notification is-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="password-reset-form" method="POST" action="{{ route('password.request') }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">


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
                                        <input class="input" id="password-confirm" type="password" name="password_confirmation">
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="field">
                            <div class="field-body">
                                <div class="field is-grouped">
                                    <div class="control">
                                        <button type="submit" class="button is-primary">{{ trans('auth.password_reset') }}</button>
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
