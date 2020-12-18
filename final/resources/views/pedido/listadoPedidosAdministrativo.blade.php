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
        <h3>Lista de pedidos</h3>

        <br>

        Ingrese una fecha en formato dd-mm-AAAA para filtrar

        <br>
        <br>

        {!! Form::open(['route' => 'pedidos-administrativo', 'method' => 'GET']) !!}
            @if($fechaFiltro == NULL)
                <input type="text" name="fechaFiltro" placeholder="dd-mm-AAAA" pattern="(0[1-9]|1[0-9]|2[0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}">
            @else
                <input type="text" name="fechaFiltro" placeholder="dd-mm-AAAA" pattern="(0[1-9]|1[0-9]|2[0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}" value="{{ $fechaFiltro }}">
            @endif
            <input type="submit" class="enviar" value="Filtrar">
        {!! Form::close() !!}

        @if(count($pedidos) == 0)
            <h3>No hay pedidos</h3>
        @else
            <h3>---------------------------</h3>

            <br>

            <table id="listado" class="listado">
                <tr class="categorias">
                    <th id="nombreProducto">Fecha</th>
                    <th id="total">Total a pagar</th>
                    <th id="Estado">Estado</th>
                    <th id="detalle">Detalle</th>
                </tr>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->created_at }}</td>
                        <td>{{ $pedido->total }}</td>
                        <td>{{ $pedido->estado }}
                            @if($pedido->estado == "Pendiente")
                                <a href="{{ route('pedidos-administrativo.vista-modificar', $pedido->id) }}"><img title="Editar" src="{{ asset('images/editar.png') }}" class="imagenesListado" alt="Editar"></a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pedidos-administrativo.vista-detalle', $pedido->id) }}"><img title="Ver" src="{{ asset('images/ver.png') }}" class="imagenesListado" alt="Ver"></a>
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
            $('#black').smartpaginator({ totalrecords: {{ count($pedidos) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection