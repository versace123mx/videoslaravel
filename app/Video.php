<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    //relacion one to many  uno a muchos  un video puede tener muchos comentarios

    public function comments()
    {
        return $this->hasMany('App\Comment')->where('eliminada',0)->orderBy('id' ,'desc');
    }

    //relacion de Muchos a uno  el usuario que creo un video

    public function user()
    {
        return $this->belongsTo('App\User','user_id')->where('eliminada',0);
    }
}
