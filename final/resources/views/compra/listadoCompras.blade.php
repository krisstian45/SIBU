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

        <br>

        <input class="enviar" type="button" onclick="location.href='{{ route('compras.vista-crear') }}';" value="Crear nueva compra" />
        @if(count($compras) == 0)
            <h1>Aún no se han registrado compras</h1>
        @else
            <h2>Listado de compras realizadas</h2>
            <table id="listado" class="listado">
                <tr class="categorias">
                    <th id="proveedor">Proveedor</th>
                    <th id="cuitProveedor">CUIT Proveedor</th>
                    <th id="fecha">Fecha</th>
                    <th></th>
                </tr>
                @foreach($compras as $compra)
                    <tr>
                        <td>{{ $compra->proveedor }}</td>
                        <td>{{ $compra->proveedor_cuit }}</td>
                        <td>{{ $compra->fecha }}</td>
                        <td>
                            <a href="{{ route('compras.vista-detalle', $compra->id) }}"><img title="Ver" src="{{ asset('images/ver.png') }}" class="imagenesListado" alt="Ver"></a>

                            <a href="{{ route('compras.vista-modificar', $compra->id) }}"><img title="Editar" src="{{ asset('images/editar.png') }}" class="imagenesListado" alt="Editar"></a>

                            <a href="{{ route('compras.vista-eliminar', $compra->id) }}"><img title="Eliminar" src="{{ asset('images/eliminar.png') }}" class="imagenesListado" alt="Eliminar"></a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div id="black" class="margen">
            </div>
        @endif
    </section>

@endsection

@section('javascript')

    <!-- Configuracion de la paginacion -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#black').smartpaginator({ totalrecords: {{ count($compras) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection