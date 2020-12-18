@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">

@endsection

@section('nav')

    @include('parts/compra_nav')

@endsection

@section('content')

    <section class="principal">
        @include('errors/errors')
        <h2>Usted va a modificar la compra del proveedor: {{ $compra->proveedor }}</h2>
        {!! Form::open(['route' => ['compras.modificar', $compra->id], 'method' => 'POST', 'class' => 'formato']) !!}

        	<label  for="proveedor">Proveedor </label>
            <input class="borde" id="proveedor" name="proveedor" type="text" value="{{ $compra->proveedor }}" required="required" pattern="[A-Za-z ]{2,20}" maxlength="20" title="Ingrese un mínimo de 2 letras, máximo 20">

            <label for="cuit">CUIT Proveedor</label>
            <input class="borde" id="cuit" name="cuit" type="text" value="{{ $compra->proveedor_cuit }}" required="required" pattern="[1-9]{11}" maxlength="11" title="Ingrese los 11 digitos del numero de CUIT">

            <br>
            <br>

            <input class="enviar" type="submit" value="Modificar compra" style="width: 300px;">
        {!! Form::close() !!}
        <a class="cancelar" href="{{ route('compras') }}" style="width: 300px;">Cancelar</a>
    </section>

@endsection