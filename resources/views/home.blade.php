@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
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
            <div class="videos-list">
                @include('video.video')
            </div>
        </div>
        {{ $videos->links() }}

    </div>
</div>
@endsection
