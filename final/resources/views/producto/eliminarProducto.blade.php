@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">

@endsection

@section('nav')

    @include('parts/producto_nav')

@endsection

@section('content')

	<div>
		<h2>Eliminar producto</h2>
	</div>
    <section class="principal">
		@if(!$datos['existeProducto'])
			<h2>No se pudo eliminar el producto porque no existe</h2>
		@else
			@if($datos['existenVentas'])
				<h2>No se pudo eliminar el producto porque se encuntra en ventas realizadas</h2>
			@else
				{!! Form::open(['route' => ['productos.eliminar', $datos['producto']], 'method' => 'POST', 'class' => 'formato']) !!}
					<h2>Estas a punto de eliminar el producto {{ $datos['producto']->nombre_producto }}. ¿Estas seguro?</h2>
					<input name="eliminar" class="enviar" type="submit" value="Eliminar">
				{!! Form::close() !!}
			@endif
		@endif
	</section>

@endsection