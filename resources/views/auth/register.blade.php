@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <h1 class="m-b-40">{{ trans('auth.register') }}</h1>
            <form class="register-form" method="POST" action="{{ route('register') }}">

                {{ csrf_field() }}

                <div class="vd-input has-label-primary">
                    <input id="first_name" class="vd-input-field" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="{{ trans('auth.first_name') }}" autofocus />

                    <label class="vd-placeholder">{{ trans('auth.first_name') }}</label>
                </div>
                @if ($errors->has('first_name'))
                    <p class="help is-danger">{{ $errors->first('first_name') }}</p>
                @endif

                <div class="vd-input has-label-primary">
                    <input id="last_name" class="vd-input-field" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="{{ trans('auth.last_name') }}" autofocus />

                    <label class="vd-placeholder">{{ trans('auth.last_name') }}</label>
                </div>
                @if ($errors->has('last_name'))
                    <p class="help is-danger">{{ $errors->first('last_name') }}</p>
                @endif

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

                <div class="vd-input has-label-primary">
                    <input id="password_confirmation" class="vd-input-field" type="password" name="password_confirmation" value="" placeholder="{{ trans('auth.password_confirmation') }}" />

                    <label class="vd-placeholder">{{ trans('auth.password_confirmation') }}</label>
                </div>

                <div class="field m-t-20">
                    <div class="field-body">
                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-primary">{{ trans('auth.register') }}</button>
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
