<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        $request->validate([
            'comentario' => 'required|max:255',
        ]);

        Comentario::create([
            'comentario' => $request->comentario,
            'user_id' => Auth::user()->id,
            'post_id' => $post->id,
        ]);

        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }
}
