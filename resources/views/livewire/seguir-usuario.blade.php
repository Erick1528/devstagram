<div>

    <p class=" text-gray-800 text-sm mb-3 font-bold mt-5">
        {{ $followers }}
        <span class=" font-normal"> @choice('Seguidor|Seguidores', $followers)</span>
    </p>

    <p class=" text-gray-800 text-sm mb-3 font-bold">
        {{ $user->followings->count() }}
        <span class=" font-normal"> Siguiendo</span>
    </p>

    <p class=" text-gray-800 text-sm mb-3 font-bold">
        {{ $user->posts->count() }}
        <span class=" font-normal"> Publicaciónes</span>
    </p>

    @auth
        @if ($user->id !== Auth::user()->id)
            <button wire:click="follow"
                class=" {{ $isFollowing ? 'bg-red-600' : 'bg-blue-600' }} text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                {{ $isFollowing ? 'Dejar de Seguir' : 'Seguir' }}
            </button>
        @endif
    @endauth

</div>
