@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/listadoProductos.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/paginador.css') }}">

@endsection

@section('nav')

    @include('parts/inner_nav')

@endsection

@section('content')

    <section class="principal">
        <input class="enviar" type="button" onclick="location.href='{{ route('menu.vista-crear', 'hoy') }}';" value="Elegír el menú del día">
        <input class="enviar" type="button" onclick="location.href='{{ route('menu.vista-crear', 'mañana') }}';" value="Elegír el menú de mañana">
    </section>

@endsection