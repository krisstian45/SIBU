@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">

@endsection

@section('nav')

    @include('parts/compra_nav')

@endsection

@section('content')

    <section class="principal">
		{!! Form::open(['route' => ['compras.eliminar', $compra->id], 'method' => 'POST', 'class' => 'formato']) !!}
			<h1>Estas a punto de eliminar la compra con fecha: {{ $compra->fecha }}. Se restablecerá el stock de los productos. ¿Estas seguro?</h1>

			<br>

			<input name="eliminar" class="enviar" type="submit" value="Eliminar" style="width: 300px;">
		{!! Form::close() !!}
		<a class="cancelar" href="{{ route('compras') }}" style="width: 300px;">Cancelar</a>
	</section>

@endsection