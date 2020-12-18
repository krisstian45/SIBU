@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">

@endsection

@section('nav')

    @include('parts/venta_nav')

@endsection

@section('content')

    <section class="principal">
		{!! Form::open(['route' => ['ventas.eliminar', $venta->id], 'method' => 'POST', 'class' => 'formato']) !!}
			<h1>Estas a punto de eliminar la venta con fecha: {{ $venta->fecha }}. Se restablecerá el stock de los productos. ¿Estas seguro?</h1>

			<br>

			<input name="eliminar" class="enviar" type="submit" value="Eliminar" style="width: 300px;">
		{!! Form::close() !!}
		<a class="cancelar" href="{{ route('ventas') }}" style="width: 300px;">Cancelar</a>
	</section>

@endsection