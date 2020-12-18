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

    	<input class="enviar" type="button" onclick="location.href='{{ route('ventas.vista-crear') }}';" value="Crear nueva venta" />
        @if(count($ventas) == 0)
        	<h2>Aún no se han registrado ventas</h2>
        @else
        	<h2>Listado de ventas realizadas</h2>
	        <table id="listado" class="listado">
	            <tr class="categorias">
	                <th id="fecha">Fecha</th>
	                <th id="cantVendida">Cantidad vendida</th>
	                <th id="totalFacturado">Total facturado</th>
	                <th></th>
	            </tr>
	            @foreach($ventas as $venta)
		            <tr>
		                <td>{{ $venta->fecha }}</td>
		                <td>{{ $venta->cantidad }}</td>
		                <td>{{ $venta->total }}</td>
		                <td>
                            <a href="{{ route('ventas.vista-detalle', $venta->id) }}"><img title="Ver" src="{{ asset('images/ver.png') }}" class="imagenesListado" alt="Ver"></a>

                            <a href="{{ route('ventas.vista-eliminar', $venta->id) }}"><img title="Eliminar" src="{{ asset('images/eliminar.png') }}" class="imagenesListado" alt="Eliminar"></a>
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
            $('#black').smartpaginator({ totalrecords: {{ count($ventas) }}, recordsperpage: {{ $config->elementos }}, datacontainer: 'listado', dataelement: 'tr', length: 1, initval: 0, next: 'Siguiente', prev: 'Anterior', first: 'Primero', last: 'Último', theme: 'black', controlsalways: true });
        });
    </script>

@endsection