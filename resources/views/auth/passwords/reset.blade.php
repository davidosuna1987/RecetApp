@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <h1 class="m-t-60 m-b-40">{{ trans('auth.password_reset') }}</h1>
            @if (session('status'))
                <div class="notification is-info">
                    {{ session('status') }}
                </div>
            @endif

            <form class="password-reset-form" method="POST" action="{{ route('password.request') }}">

                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

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
                                <button type="submit" class="button is-primary">{{ trans('auth.password_reset') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
