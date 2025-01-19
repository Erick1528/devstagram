<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Bool_;

class LikePost extends Component
{

    public $post;
    public $isLiked;
    public $likes;

    public function mount($post)
    {
        $this->post = $post;
        $this->isLiked = $this->post->checkLike(Auth::user());
        $this->likes = $this->post->likes->count();
    }

    public function like()
    {
        if ($this->post->checkLike(Auth::user())) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->likes -= 1;
        } else {
            $this->post->likes()->create([
                'user_id' => Auth::user()->id,
            ]);
            $this->likes += 1;
        }
        $this->isLiked = !$this->isLiked;
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
