@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <h1 class="m-b-40">{{ trans('auth.password_reset') }}</h1>
            @if (session('status'))
                <div class="notification is-info">
                    {{ session('status') }}
                </div>
            @endif

            <form class="forgot-password-form" method="POST" action="{{ route('password.email') }}">

                {{ csrf_field() }}

                <div class="vd-input has-label-primary">
                    <input id="email" class="vd-input-field" type="text" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email') }}" autofocus />

                    <label class="vd-placeholder">{{ trans('auth.email') }}</label>
                </div>
                @if ($errors->has('email'))
                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                @endif

                <div class="field m-t-20">
                    <div class="field-body">
                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-primary">{{ trans('auth.password_reset_link') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
