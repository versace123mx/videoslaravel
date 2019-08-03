@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 offset-md-1">
                <h2>{{ $video->title }}</h2>
                @if( !empty(session('info')) || !empty(session('error')) )
                    @php
                        $info = session('info');
                        $error = session('error');
                    @endphp

                    @if(!empty($info))
                        @php
                            $mensaje = $info ;
                            $tipoClas = ' alert-success ';
                        @endphp
                        @else
                        @php
                            $mensaje = $error;
                            $tipoClas = ' alert-danger ';
                        @endphp
                        @endif
                    <div class="alert {{ $tipoClas }}">
                        {{ $mensaje }}
                    </div>
                    @endif
                <div class="col-md-8">

                    <!-- Video-->
                    @if(!empty($video->video_path))
                        <video width="640" height="480" controls id="{{$video->id}}">
                            <source src="{{ route('showvideo',$video->video_path) }}">
                            Tu navegador no soporta HTML5
                        </video>
                    @else
                        <p>Lo sentimos no existe video</p>
                @endif
                <!-- Descripccion-->
                    <div class="card video-data">
                        <div class="card-header">
                            <div class="card-title">
                                Subido por: <strong>{{$video->user->surname}}</strong> {{ $video->fecha_publicacion }}
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $video->description }}
                        </div>
                    </div>
                    <!-- Commentarios-->
                        @include('video.comments')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-body">
                <a class="btn btn-primary" href="{{ route('home') }}"> Regresar al listado</a>
            </div>
        </div>
    </div>

    @endsection