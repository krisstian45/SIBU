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
        @if(count($ventas) == 0)
            <h1>No se han vendido productos entre el {{ $fechaInicio }} y {{ $fechaFin }}</h1>
        @else
            <h2>Listado de productos vendidos entre el {{ $fechaInicio }} y {{ $fechaFin }}</h2>
            <div id="divListado">
                <table id="listado" class="listado">
                    <tr class="categorias">
                        <th id="nombre">Nombre</th>
                        <th id="marca">Marca</th>
                        <th id="codigoBarra">Codigo de barra</th>
                        <th id="cantVentas">Cantidad de ventas</th>
                    </tr>
                    @foreach($ventas as $producto)
                        <tr>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->codigo_barra }}</td>
                            <td>{{ $producto->cantVentas }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div id="black" class="margen"></div>

            <br>

            <button class="enviar" onclick="javascript:demoFromHTML()">Exportar a PDF</button>

            <br>
            <br>

            <div id="container" style="height: 400px"></div>
        @endif
    </section>

@endsection

@section('javascript')

    <script src="{{ asset('js/highcharts.js') }}"></script>
    <script src="{{ asset('js/highcharts-3d.js') }}"></script>
    <script src="{{ asset('js/exporting.js') }}"></script>
    <script src="{{ asset('js/exportarAPdf.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

    <script type="text/javascript">
        $(function () {
            Highcharts.chart('container', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Productos vendidos entre el {{ $fechaInicio }} y {{ $fechaFin }}'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Cantidad de ventas',
                    data: [
                        @foreach($ventas as $producto)
                            ['{{ $producto->nombre_producto }}', {{ $producto->cantVentas }}],
                        @endforeach
                    ]
                }]
            });
        });
    </script>

    <!-- Configuracion de la paginacion -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#black').smartpaginator({ totalrecords: {{ count($ventas) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection