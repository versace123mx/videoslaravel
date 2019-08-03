<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function channel($user_id)
    {
        $user = User::find($user_id);
        $videos = Video::where('user_id',$user_id)->paginate(5);

        if($user){
            return view('user.channel',compact('videos','user'));
        }

        return redirect()->route('home');
    }
}
