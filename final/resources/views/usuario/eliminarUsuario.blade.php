@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">

@endsection

@section('nav')

    @include('parts/usuario_nav')

@endsection

@section('content')

    <section class="principal">
		{!! Form::open(['route' => ['usuarios.eliminar', $usuario->id], 'method' => 'POST', 'class' => 'formato']) !!}
			<h1>Estas a punto de eliminar el usuario {{ $usuario->usuario }}. ¿Estas seguro?</h1>

			<br>

			<input name="eliminar" class="enviar" type="submit" value="Eliminar" style="width: 300px;">
		{!! Form::close() !!}
		<a class="cancelar" href="{{ route('usuarios') }}" style="width: 300px;">Cancelar</a>
	</section>

@endsection