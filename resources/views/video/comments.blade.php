<hr>
@if(Auth::check()) <!-- Si estas logueado te muestro los comentarios -->
    <h4>Ingresa comentario:</h4>
    <form class="col-md-4" action="{{route('comment')}}" method="POST">
        @csrf
        <input type="hidden" name="video_id" value="{{$video->id}}" required>
        <p>
            <textarea class="form-control" name="comentario" required></textarea>
            {!! $errors->first('comentario','<span class=error>:message</span>') !!}
        </p>
        <input type="submit" value="Comentar" class="btn btn-success">
    </form>
@endif()
<div class="clearfix"></div>
<hr>
@if(isset($video->comments))
    <div class="comments-list">
        @foreach($video->comments as $comment)
            <div class="comment-item col-md-12 float-left">
                <div class="card comments-data">
                    <div class="card-header">
                        <div class="card-title">
                            Creado por: <strong>{{$comment->user->surname}}</strong> {{ \App\Helpers\FormatTime::LongTimeFilter($comment->created_at) }}
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $comment->body }}
                        <!-- con Auth::user()->id es el usaurio loggeado actualemnte-->
                            <!-- con $comments->user_id es el id del usuario en la tabla commentarios-->
                            <!-- primero verificamos si el usuario logueado es igual al id del usuario del comentario podra borrar el comentario-->
                            <!-- verificamos si el id del usuario loggueado es el dueño del video puede borrar el comentario -->
                        @if( Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user->id) )
                            <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <div class="float-right">
                                    <a href="javascript:void(0)" role="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#victorModal{{$comment->id}}">Eliminar</a>
                                    @include('video.modal.popup_deleteMessage')
                                </div>
                            @endif()
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif