<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;

class Comentarios extends Component
{

    public $post;
    public $user;
    public $comentario;

    protected $rules = [
        'comentario' => 'required|max:255',
    ];

    public function mount($post, $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function agregarComentario()
    {

        $this->validate();

        Comentario::create([
            'comentario' => $this->comentario,
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
        ]);

        $this->comentario = '';

        session()->flash('mensaje', 'Comentario Realizado Correctamente');
    }

    public function render()
    {
        return view('livewire.comentarios');
    }
}
