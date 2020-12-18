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
        @include('errors/errors')
        <p class="error">{{ $mensaje }}</p>

        <br>

        <h1>Balance de ventas de cada producto</h1>

        <br>

        <h3>Ingrese un rango de fechas</h3>

        <br>

        {!! Form::open(['route' => 'listado-balance-ventas', 'method' => 'POST']) !!}
            <p>
                <input name="fechaInicio" type="text" required="required" class="datepicker" placeholder="Fecha inicio" readonly="readonly" size="12">
            </p>
            <p>
                <input name="fechaFin" type="text" required="required" class="datepicker" placeholder="Fecha fin" readonly="readonly" size="12">
            </p>

            <br>

            <input class="enviar" type="submit" value="Calcular ventas">
        {!! Form::close() !!}
    </section>

@endsection