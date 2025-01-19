<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        $manager = new ImageManager(new Driver());

        $imagenServidor = $manager->read($imagen->path());
        $imagenServidor->cover(1000, 1000);

        $imagePath = public_path('uploads') . '/' . $nombreImagen;
        // dd($imagePath);

        $imagenServidor->save($imagePath);

        return response()->json([
            'imagen' => $nombreImagen
        ]);
    }
}
