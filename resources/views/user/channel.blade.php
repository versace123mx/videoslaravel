@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <h1>Canal de: {{$user->name}}</h1>

                <div class="videos-list">
                    @include('video.video')
                </div>
            </div>
        </div>
    </div>
@endsection
