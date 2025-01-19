<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    
    public function __invoke()
    {

        // dd( Auth::user()->followings->pluck('id')->toArray() );
        $ids = Arr::pluck( Auth::user()->followings, 'id' );
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        return view('index', [
            'posts' => $posts,
        ]);
    }

}
