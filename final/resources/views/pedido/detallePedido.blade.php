@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/listadoProductos.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/paginador.css') }}">

@endsection

@section('nav')

    @if(Auth::user()->rol->nombre == 'Usuario Online')
        @include('parts/pedido_cliente_nav')
    @else
        @include('parts/pedido_administrativo_nav')
    @endif

@endsection

@section('content')

	<section class="principal">
        @if(count($pedido_detalle) == 0)
            <h3>Este pedido no tiene detalles para mostrar...</h3>
        @else
            <h3>Lista de productos del pedido realizado el día {{ date('d-m-Y', strtotime($pedido_detalle[0]->created_at)) }}</h3>
            <br />
            <table class="listado">
                <tr class="categorias">
                    <th class="title">Nombre</th>
                    <th class="title">Marca</th>
                    <th class="title">Codigo de barra</th>
                    <th class="title">Stock</th>
                    <th class="title">Stock minimo</th>
                    <th class="title">Proveedor</th>
                    <th class="title">Precio unitario</th>
                    <th class="title">Descripcion</th>
                    <th class="title">Cantidad</th>
                    <th class="title">Categoria</th>
                    <th class="title">Estado</th>
                    <th class="title">Observacion</th>
                </tr>
                @foreach($pedido_detalle as $producto)
                    <tr>
                        <td>{{ $producto->nombre_producto }}</td>
                        <td>{{ $producto->marca }}</td>
                        <td>{{ $producto->codigo_barra }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>{{ $producto->stock_minimo }}</td>
                        <td>{{ $producto->proveedor }}</td>
                        <td>{{ $producto->precio_venta_unitario }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>{{ $producto->nombre_categoria }}</td>
                        <td>{{ $producto->estado }}</td>
                        <td>{{ $producto->observacion }}</td>
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
            $('#black').smartpaginator({ totalrecords: {{ count($pedido_detalle) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection