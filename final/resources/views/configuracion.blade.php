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

		<br>

		<h2>Configuración</h2>
		<!-- Laravel genera el token para evitar CSRF automaticamente -->
		{!! Form::open(['route' => ['configuracion.update', $config->id], 'method' => 'POST', 'class' => 'formato']) !!}

			<label>Título:</label>
			<input title="Ingrese un mínimo de 2 carácteres, máximo 50" pattern=".{2,50}" type="text" name="titulo" value="{{ $config->titulo }}" class="borde" required>

			<label>Descripción:</label>
			<input title="Ingrese un mínimo de 2 carácteres, máximo 255" pattern=".{2,255}" type="text" name="descripcion" value="{{ $config->descripcion }}" class="borde" required>

			<label>Email de contacto:</label>
			<input title="Ejemplo user@mail.com" pattern=".{2,30}" type="text" name="email" value="{{ $config->email }}" class="borde" required>

			<label>Elementos por página:</label>
			<input type="number" name="elementos" min="0" max="9999999" value="{{ $config->elementos }}" class="borde" required>

			<label>Habilitado:</label>
			<div class="centrado">
				@if($config->habilitado)
					<input type="radio" name="habilitado" value="1" checked="checked" required><label>Si</label>
					<input type="radio" name="habilitado" value="0" required><label>No</label>
				@else
					<input type="radio" name="habilitado" value="1" required><label>Si</label>
					<input type="radio" name="habilitado" value="0" checked="checked" required><label>No</label>
				@endif
			</div>

			<label>Mensaje de sitio deshabilitado:</label>
			<input title="Ingrese un mínimo de 2 carácteres, máximo 255" pattern=".{2,255}" type="text" name="mensaje" value="{{ $config->mensaje }}" class="borde" required>

			<br>
			<br>

			<div>
				<input type="submit" name="guardar" value="Guardar" class="enviar">
			</div>

		{!! Form::close() !!}

		<br>

		<a class="cancelar" href="{{ route('backend') }}">Cancelar</a>
	</section>

@endsection