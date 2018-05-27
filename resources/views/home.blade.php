@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is- is-marginless is-centered">
            <div class="column is-7">
                <nav class="card">
                    <header class="card-header">
                        <p class="card-header-title">{{ trans('home.dashboard') }}</p>
                    </header>

                    <div class="card-content">
                        {{ trans('home.welcome_message') }}
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection
