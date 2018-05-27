@extends('layouts.app')

@section('content')
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card m-t-60">
                <header class="card-header">
                    <p class="card-header-title">Register</p>
                </header>

                <div class="card-content">
                    <form class="register-form" method="POST" action="{{ route('register') }}">

                        {{ csrf_field() }}

                        <div class="field">
                            <label class="label">First name</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="first_name" type="first_name" name="first_name" value="{{ old('first_name') }}"
                                               required autofocus>
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
                            <label class="label">Last name</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="last_name" type="last_name" name="last_name" value="{{ old('last_name') }}"
                                               required autofocus>
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
                            <label class="label">E-mail Address</label>

                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="email" type="email" name="email"
                                               value="{{ old('email') }}" required autofocus>
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
                            <label class="label">Password</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="password" type="password" name="password" required>
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
                            <label class="label">Confirm Password</label>
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <input class="input" id="password-confirm" type="password"
                                               name="password_confirmation" required>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="field-body">
                                <div class="field is-grouped">
                                    <div class="control">
                                        <button type="submit" class="button is-primary">Register</button>
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
