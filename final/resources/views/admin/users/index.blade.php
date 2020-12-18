@extends('admin/template/main')

@section('title', 'Listado de Usuarios')

@section('content')

	<a href="{{ route('admin.users.create') }}" class="btn btn-info">Registrar nuevo usuario</a>
	<hr>
	<table class="table table-striped">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
			<th>Tipo</th>
			<th>Accion</th>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>
						@if($user->type == "admin")
							<span class="label label-danger">{{ $user->type }}</span>
						@else
							<span class="label label-primary">{{ $user->type }}</span>
						@endif
					</td>
					<td>
						<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>

						<a href="{{ route('admin.users.destroy', $user->id) }}" class="btn btn-danger" onClick="return confirm('¿Seguro que deseas eliminarlo?')"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<!-- Esto es para habilitar la paginacion -->
	{!! $users->render() !!}

@endsection
