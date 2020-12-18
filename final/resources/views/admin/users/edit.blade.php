@extends('admin/template/main')

@section('title', 'Modificar Usuario ' . $user->name)

@section('content')

	<!-- El path del action del formulario debe ir separado por puntos, si lo agrego separado por barras no funciona -->

	<!-- En el modificar se manda el path y el id del objeto a modificar -->
	{!! Form::open(['route' => ['admin.users.update', $user], 'method' => 'PUT']) !!}
		<div class="form-group">
			{!! Form::label('name', 'Nombre') !!}
			{!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Nombre completo',
				'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('email', 'Correo Electronico') !!}
			{!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'example@gmail.com',
				'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('type', 'Tipo') !!}
			{!! Form::select('type', ['' => 'Seleccione un nivel...', 'member' => 'Miembro', 'admin' => 'Administrador'], $user->type, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Modificar', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}

@endsection
