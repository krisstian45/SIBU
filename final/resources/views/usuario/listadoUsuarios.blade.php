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

    <input class="enviar" type="button" onclick="location.href='{{ route('usuarios.vista-crear') }}';" value="Crear nuevo usuario" />

    <section class="principal">
        <h2>Listado de usuarios</h2>
        <table id="listado" class="listado ">
            <thead>
                <tr class="categorias">
                    <th id="usuario">Usuario</th>
                    <th id="nombre">Nombre</th>
                    <th id="apellido">Apellido</th>
                    <th id="email">Email</th>
                    <th id="telefono">Teléfono</th>
                    <th id="rol">Rol</th>
                    <th id="ubicacion">Ubicacion</th>
                    <th id="ubicacion">Habilitado?</th>
                    <th id="operaciones">Operaciones</th>
                </tr>
            </thead>
            @foreach($usuarios as $usuario)
                <tbody>
                    <tr>
                        <td>{{ $usuario->usuario }}</td>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellido }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefono }}</td>
                        <td>
                            @if($usuario->rol_id == 1)
                                Administrador
                            @else
                                @if($usuario->rol_id == 2)
                                    Gestion
                                @else
                                    Cliente
                                @endif
                            @endif
                        </td>
                        <td>{{ $usuario->ubicacion->nombre_ubicacion }}</td>
                        <td>
                            @if($usuario->habilitado)
                                Si
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('usuarios.vista-modificar', $usuario->id) }}"><img title="Editar" src="{{ asset('images/editar.png') }}" class="imagenesListado" alt="Editar"></a>

                            <a href="{{ route('usuarios.vista-eliminar', $usuario->id) }}"><img title="Eliminar" src="{{ asset('images/eliminar.png') }}" class="imagenesListado" alt="Eliminar"></a>
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
        <div id="black" class="margen">
        </div>
    </section>

@endsection

@section('javascript')

    <!-- Configuracion de la paginacion -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#black').smartpaginator({ totalrecords: {{ count($usuarios) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection