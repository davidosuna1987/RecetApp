@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is- is-marginless is-centered">
            <div class="column is-10">
                <h1 class="title m-t-60 m-b-40">Let's create a new recipe!</h1>
                <recipe-form></recipe-form>
            </div>
        </div>
    </div>
@endsection
