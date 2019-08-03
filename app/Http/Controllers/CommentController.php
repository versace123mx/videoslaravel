<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addCommentVideo(Request $request)
    {
        $validate = $request->validate([
            'comentario' => 'required',
        ]);

        $comment  = new Comment(); //creamos una nueva instancia del modelo comments
        $use = Auth::user(); //traemos al usuario actual que esta logueado
        $comment->user_id = $use->id;
        $comment->video_id = $request->input('video_id');
        $comment->body = $request->input('comentario');
        $comment->save();

        return redirect()->route('videoDetaill',$comment->video_id)->with('info','El comentario se agrego correctamente');
    }

    /**
     * Metodo para eliminar un comentario y nos regresa al video donde se borra al comentario en caso de falla nos devuvle a ese comentario
     * @param $videoid
     * @param $comentarioid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCommentVideo($videoid, $comentarioid)
    {
        $mensaje = 'El comentario no se ha podido eliminar';
        $tipo = 'error';
        $ruta = 'home';

        $user = Auth::user(); //usuarios logueado actualmente
        $comentario = Comment::find($comentarioid); //compruebo que el comentario exista
        $video = Video::find($videoid); //compruebo que el video exista

        if($user){
            if(!empty($video)){
                $ruta = 'videoDetaill';
                if(!empty($comentario)){
                    if($comentario->user_id == $user->id || $comentario->video->user_id == $user->id){
                        $mensaje = 'El comentario ha sido elimindado';
                        $tipo = 'info';
                        $comentario->eliminada = 1;
                        $comentario->updated_at = Carbon::now();
                        $comentario->save();
                    } else {
                        $ruta;
                    }
                } else {
                    $ruta;
                }
            } else {
                $videoid='';
            }
        } else {
            $videoid='';
        }

        return redirect()->route($ruta,$videoid)->with($tipo,$mensaje);
    }
}
