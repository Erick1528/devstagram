@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex gap-6 md:flex-row md:items-start sm:items-center">

        <div class=" md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="imagen del post {{ $post->titulo }}">

            @auth()
                <livewire:like-post :post="$post" />
            @endauth

            <div class="">
                <p class=" font-bold">{{ $post->user->username }}</p>
                <p class=" text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                <p class=" mt-5">{{ $post->descripcion }}</p>
            </div>

            @auth
                @if ($post->user_id === Auth::user()->id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar Publicación"
                            class=" bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif
            @endauth

        </div>

        <livewire:comentarios :post="$post" :user="$user" />
    </div>
@endsection
