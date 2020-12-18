@extends('admin/template/main')

@section('title', 'Modificar Categoria ' . $category->name)

@section('content')

	<!-- El path del action del formulario debe ir separado por puntos, si lo agrego separado por barras no funciona -->

	<!-- En el modificar se manda el path y el id del objeto a modificar -->
	{!! Form::open(['route' => ['admin.categories.update', $category->id], 'method' => 'PUT']) !!}
		<div class="form-group">
			{!! Form::label('name', 'Nombre') !!}
			{!! Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => 'Nombre de la categoria', 'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Modificar', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}

@endsection
