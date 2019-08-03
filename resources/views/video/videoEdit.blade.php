@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="col-12">Editar Video: {{ $video->title }}</h2>
            <hr>
            <form action="{{ route('saveEditionVideo',$video->id) }}" method="POST" enctype="multipart/form-data" class="col-lg-7">
                @csrf
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Titulo del video" value="{{ $video->title }}" required>
                    {!! $errors->first('title','<span class="error">:message</span>') !!}
                </div>
                <div class="form-group">
                    <label for="description">Descipcion</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Descripcion del video" required>{{ $video->description }}</textarea>
                    {!! $errors->first('description','<span class=error>:message</span>') !!}
                </div>
                <div class="form-group">
                    <label for="image">Miniatura</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    {!! $errors->first('image','<span class=error>:message</span>') !!}
                </div>
                <div class="form-group">
                    <div class="video-image-thumb col-md-4 float-left">
                        <img class="video-image-mask" src="{{ !empty($video->image)?route('imageVideo',$video->image):asset('img/default.png') }}">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="video">Archivo de video</label>
                    <input type="file" class="form-control @error('video') is-invalid @enderror" id="video" name="video">
                    {!! $errors->first('video','<span class=error>:message</span>') !!}
                </div>
                <div class="form-group">
                    <!-- Video-->
                    @if(!empty($video->video_path))
                        <video width="120" height="120" controls id="{{$video->id}}">
                            <source src="{{ route('showvideo',$video->video_path) }}">
                            Tu navegador no soporta HTML5
                        </video>
                    @else
                        <p>Lo sentimos no existe video</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Actualizar Video</button>
            </form>
        </div>
        <div class="row">
            <div class="card-body col-md-6">
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('home') }}"> Regresar al listado</a>
                </div>
            </div>
        </div>
    </div>

@endsection