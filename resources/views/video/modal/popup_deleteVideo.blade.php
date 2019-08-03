        <!-- Modal / Ventana / Overlay en HTML -->
        <div id="victorModal{{ $video->id }}" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">¿Estás seguro?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Seguro que quieres borrar el video: <strong>{{$video->title}}</strong>?</p>
                        <p class="text-danger"><small>Si lo borras, nunca podrás recuperarlo.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a href="{{route('deleteVideo',$video->id)}}" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>