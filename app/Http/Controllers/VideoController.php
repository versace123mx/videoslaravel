<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoRequest;
use App\Http\Requests\EditVideoRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

use App\Video;
use App\Comment;
use App\Helpers\FormatTime;

class VideoController extends Controller
{
    /**
     * Metodo que llama a la vista create Video para crear un nuevo video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createVideo()
    {
        return view('video.createVideo');
    }

    public function saveVideo(CreateVideoRequest $request)
    {
        //la validacion de los campos del formulario los hago mediante CreateVideoRequest

        $video = new Video();
        $user  = Auth::user(); //usuario logeado actualmente
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //subida de la miniatura
        $image = $request->file('image');
        if($image){
            $nombre_image = time().'_'.$image->getClientOriginalName();
            Storage::disk('images')->put($nombre_image, \File::get($image));

            $video->image = $nombre_image;
        }

        //subida del video
        $videofail = $request->file('video');
        if($videofail){
            $nombre_video = time().'_'.$videofail->getClientOriginalName();
            Storage::disk('videos')->put($nombre_video,\File::get($videofail));

            $video->video_path = $nombre_video;
        }
        $video->save();

     return redirect()->route('home')->with('info','El video se subio correctamente');
    }

    /**
     * Metodo para cargar la imagen en una etiqueta html apartir de un rout (cargamos la ruta de donde se encuentra la imagen)
     * @param $filename
     * @return Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function Image($filename)
    {
        $file = Storage::disk('images')->get($filename);
        return new Response($file,200);
    }

    /**
     * Metodo para mostrar el detalle del video en la vista videodetail mas no muestra el video para eso esta el metodo showVideo
     * @param $idVideo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function videoDetaill($idVideo)
    {
        $video = Video::find($idVideo);
        $video['fecha_publicacion'] = FormatTime::LongTimeFilter($video->created_at);
        return view('video.videodetaill',compact('video'));
    }

    /**
     * Metodo para mostrar el video en una etiqueta html apartir de un rout (larcamos el video de la ruta donde se encuentra)
     * @param $filename
     * @return Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function ShowVideo($filename)
    {
        $file = Storage::disk('videos')->get($filename);
        return new Response($file,200);
    }

    /**
     * Metodo para eliminar un video y los comentarios que pertenecen a ese video
     * @param $idVideo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteVideo($idVideo)
    {
        $info = 'error';
        $mensaje = 'El video no se ha podido borrar';

        //comprobamos que el usuario este atentificado
        //comprobamos que exista el video
        //comprobamos que ese video pertenesca a ese usuario
        $user = Auth::user();
        $video = Video::find($idVideo);

        if( $user && !empty($video) && $video->user_id == $user->id ){
            $info = 'info';
            $mensaje = 'El video sido borrado correctamente';
            Comment::where('video_id',$idVideo)->update(['eliminada'=>1]);
            $video->eliminada = 1;
            $video->updated_at = Carbon::now();
            $video->save();
        }

        return redirect()->route('home')->with($info,$mensaje);
    }

    /**
     * Metodo para mostrar los datos en el formulario de edicion de video
     * @param $idVideo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function videoEditForm($idVideo)
    {
        $video = Video::findOrFail($idVideo);

        return view('video.videoEdit',compact('video'));
    }

    public function saveEditionVideo(EditVideoRequest $request,$idVideo)
    {
        $tipo = 'error';
        $mensaje = 'No se pudo realizar la edicion.';

        $user = Auth::user(); //el usuario autenticado actualemnte
        $video = Video::findOrFail($idVideo);

        if( $user && !empty($video) && $video->user_id == $user->id ){

            $tipo = 'info';
            $mensaje = 'La edicion fue exitosa';

            $video->title = $request->input('title');
            $video->description = $request->input('description');

            $image = $request->file('image');

            if($image){

                Storage::disk('images')->delete($video->image);

                $nombre_image = time().'_'.$image->getClientOriginalName();
                Storage::disk('images')->put($nombre_image, \File::get($image));

                $video->image = $nombre_image;
            }

            //subida del video
            $videofail = $request->file('video');
            if($videofail){
                Storage::disk('videos')->delete($video->video_path);

                $nombre_video = time().'_'.$videofail->getClientOriginalName();
                Storage::disk('videos')->put($nombre_video,\File::get($videofail));

                $video->video_path = $nombre_video;
            }

            $video->save();
        }

        return redirect()->route('home')->with($tipo,$mensaje);
    }

    /**
     * Metodo para realizar la busqueda de videos
     * @param Request $request
     * @param null $edad
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchVideo(Request $request)
    {
        $videos = Video::where('title','LIKE','%'.$request->search.'%')->orderBy('id','desc')->paginate(5);

        return view('video.searchs',compact('videos'));
    }
}
