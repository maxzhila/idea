@extends('layout.layout')
@section('content')

        <div class="row">
            <div class="col-3">
                @include('shared.left_side_bar')
            </div>
            <div class="col-6">
                @include('shared.succes_message')
                <div class="mt-3">
                @include('shared.idea_card')
            </div>
            </div>

            <div class="col-3">
                @include('shared.search_bar')
                @include('shared.follow_box ')
            </div>
        </div>
@endsection
