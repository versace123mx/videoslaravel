@if(count($videos) >= 1)
    @foreach($videos as $video)
        <div class="video-item col-md-8 float-ce card">
            <div class="card-body">
                <div class="data">
                    <h5><a href="">{{ $video->title }}</a></h5>
                </div>
                <!-- Imagen del video-->
                {{--                        @if(Storage::disk('images')->has($video->image))  comprovamos si tiene imagen--}}
                <div class="video-image-thumb col-md-4 float-left">
                    <div class="col-md-6 offset-md-0">
                        <img class="video-image-mask" src="{{ !empty($video->image)?route('imageVideo',$video->image):asset('img/default.png') }}">
                    </div>
                </div>
                {{--                        @endif--}}
                <div>
                    <p>Propietario: <a href="{{route('channel',$video->user->id)}}">{{$video->user->name}}</a></p>
                    <p>Apodo: {{$video->user->surname}}</p>
                </div>

                <div>
                    <a href="{{ route('videoDetaill',$video->id) }}" class="btn btn-success">Ver</a>
                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                        <a href="{{ route('videoEditForm',$video->id )}}" class="btn btn-warning">Editar</a>
                        <a href="javascript:void(0)" role="button" class="btn btn-danger" data-toggle="modal" data-target="#victorModal{{ $video->id }}">Eliminar</a>
                        @include('video.modal.popup_deleteVideo')
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif
