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
        @if(count($ganancias) == 0)
            <h1>No se han registrado ganancias entre el {{ $fechaInicio }} y {{ $fechaFin }}</h1>
        @else
            <h2>Listado de Ganancias entre el {{ $fechaInicio }} y {{ $fechaFin }}</h2>
            <div id="divListado">
                <table id="listado" class="listado">
                    <tr class="categorias">
                        <th id="fecha">Fecha</th>
                        <th id="monto">Monto</th>
                    </tr>
                    @foreach($ganancias as $ganancia)
                        <tr>
                            <td>{{ $ganancia['fecha'] }}</td>
                            <td>$ {{ $ganancia['monto'] }}</td>
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
    <script src="{{ asset('js/exporting.js') }}"></script>
    <script src="{{ asset('js/exportarAPdf.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

    <script type="text/javascript">
        $(function () {
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Estadistica de las ganancias'
                },
                subtitle: {
                    text: 'Ganancias entre el {{ $fechaInicio }} y {{ $fechaFin }}'
                },
                xAxis: {
                    categories: [
                        @foreach($ganancias as $ganancia)
                            '{{ $ganancia['fecha'] }}',
                        @endforeach
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Pesos ($)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>${point.y:.2f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Ganancia',
                    data: [@foreach($ganancias as $ganancia) {{ $ganancia['monto'] }}, @endforeach]
                }]
            });
        });
    </script>

    <!-- Configuracion de la paginacion -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#black').smartpaginator({ totalrecords: {{ count($ganancias) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection