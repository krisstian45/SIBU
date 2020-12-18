@extends('admin/template/main')

@section('title', 'Crear Usuario')

@section('content')

	<!-- El path del action del formulario debe ir separado por puntos, si lo agrego separado por barras no funciona -->

	{!! Form::open(['route' => 'admin.users.store', 'method' => 'POST']) !!}
		<div class="form-group">
			{!! Form::label('name', 'Nombre') !!}
			{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre completo',
				'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('email', 'Correo Electronico') !!}
			{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'example@gmail.com',
				'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('password', 'Contraseña') !!}
			{!! Form::password('password', ['class' => 'form-control', 'placeholder' => '*********',
				'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('type', 'Tipo') !!}
			{!! Form::select('type', ['' => 'Seleccione un nivel...', 'member' => 'Miembro', 'admin' => 'Administrador'], null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}

@endsection
