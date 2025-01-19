<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        $request->request->add(['username' =>  Str::slug($request->username)]);

        $request->validate([
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore(Auth::user()),
                'min:3',
                'max:20',
                'not_in:editar-perfil',
            ],
        ]);

        if ($request->imagen) {
            $imagen = $request->file('imagen');
            
            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            $manager = new ImageManager(new Driver());

            $imagenServidor = $manager->read($imagen->path());
            $imagenServidor->cover(1000, 1000);

            $imagePath = public_path('perfiles') . '/' . $nombreImagen;
            // dd($imagePath);

            $imagenServidor->save($imagePath);
        }

        // Actualizar usuario
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
