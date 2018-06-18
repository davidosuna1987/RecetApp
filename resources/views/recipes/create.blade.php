@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-marginless is-centered">
            <div class="column is-12">
                <h1 class="m-b-40">{!! trans('recipes.create_title') !!}</h1>
                <recipe-form></recipe-form>
            </div>
        </div>
    </div>
@endsection
