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

        <div class=" md:w-1/2 sm:w-full">
            <div class=" shadow bg-white p-5 mb-5 rounded-lg">
                @auth
                    <p class=" text-xl font-bold text-center mb-4">Agrega un Nuevo Comentario</p>

                    @if (session('mensaje'))
                        <div class=" bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                                Añade un Comentario
                            </label>
                            <textarea type="text" id="comentario" name="comentario" placeholder="Agrega un comentario"
                                class="resize-none border p-3 w-full rounded-lg focus:outline-none @error('comentario') border-red-500 @enderror "></textarea>

                            @error('comentario')
                                <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <input type="submit" value="Comentar"
                            class=" bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">

                    </form>
                @endauth

                <div class=" bg-white shadow rounded-lg mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class=" p-5 border-gray-300 border-b">
                                <a href="{{ route('posts.index', $comentario->user) }}"class=" font-bold">
                                    {{ $comentario->user->username }}
                                </a>
                                <p>{{ $comentario->comentario }}</p>
                                <p class=" text-gray-500 text-sm">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class=" p-10 text-center">Aun no hay comentarios</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
