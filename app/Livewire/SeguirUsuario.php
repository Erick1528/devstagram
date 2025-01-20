<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SeguirUsuario extends Component
{

    public $user;
    public $isFollowing;
    public $followers;

    public function mount()
    {
        $this->followers = $this->user->followers->count();
        $this->isFollowing = Auth::check() ? $this->user->siguiendo(Auth::user()) : false;
    }

    public function follow()
    {
        if (!$this->user->siguiendo(Auth::user())) {
            $this->user->followers()->attach(Auth::user()->id);
            $this->isFollowing = true;
            $this->followers++;
        } else {
            $this->user->followers()->detach(Auth::user()->id);
            $this->isFollowing = false;
            $this->followers--;
        }
    }

    public function render()
    {
        return view('livewire.seguir-usuario');
    }
}
