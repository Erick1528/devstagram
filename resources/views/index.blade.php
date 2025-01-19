@extends('layouts.app')

@section('titulo', 'Página de Inicio')

@section('contenido')

    <x-listar-post :posts="$posts" />

@endsection
