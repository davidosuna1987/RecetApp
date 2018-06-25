@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-marginless is-centered">
            <div class="column is-12">
                <h1 class="m-b-40">{!! trans('recipes.index_title') !!}</h1>
                <recipe-list></recipe-list>
            </div>
        </div>
    </div>
@endsection
