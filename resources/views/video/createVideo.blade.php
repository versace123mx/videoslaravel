@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h2 class="col-12">Crear un nuevo video</h2>
            <hr>
            <form action="{{ route('saveVideo') }}" method="POST" enctype="multipart/form-data" class="col-lg-7">
                @csrf
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Titulo del video" value="{{old('title')}}">
                    {!! $errors->first('title','<span class="error">:message</span>') !!}
                </div>
                <div class="form-group">
                    <label for="description">Descipcion</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Descripcion del video">{{old('description')}}</textarea>
                    {!! $errors->first('description','<span class=error>:message</span>') !!}
                </div>
                <div class="form-group">
                    <label for="image">Miniatura</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    {!! $errors->first('image','<span class=error>:message</span>') !!}
                </div>
                <div class="form-group">
                    <label for="video">Archivo de video</label>
                    <input type="file" class="form-control @error('video') is-invalid @enderror" id="video" name="video">
                    {!! $errors->first('video','<span class=error>:message</span>') !!}
                </div>
                <button type="submit" class="btn btn-success">Crear Video</button>
            </form>
        </div>
    </div>
@endsection