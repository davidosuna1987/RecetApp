@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is- is-marginless is-centered">
            <div class="column is-10">
                <h1 class="m-t-60 m-b-40">{!! trans('recipes.index_title') !!}</h1>
                <recipe-list></recipe-list>
            </div>
        </div>
    </div>
@endsection
