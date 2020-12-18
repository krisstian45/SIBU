@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/listadoProductos.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/paginador.css') }}">

@endsection

@section('nav')

    @include('parts/inner_nav')

@endsection

@section('content')

	<section class="principal">
		<input type="hidden" class="fechaDeHoy" name="fecha" value="{{ $fecha }}">
		<h2>Listado de productos</h2>
	        @if(count($productos) == 0)
	            <p>No hay productos para ser listados</p>
	        @else
	            <table id="listado" class="listado">
		            <thead>
		                <tr class="categorias">
		                    <th id="id">id</th>
		                    <th id="nombreProducto">Nombre</th>
		                    <th id="stockProducto">Stock </th>
		                    <th id="stockMinProducto">Stock Minimo</th>
		                    <th id="proveedorProducto">Proveedor</th>
		                    <th id="precioUniProducto">Precio unitario</th>
		                    <th id="descripcionProducto">Descripcion</th>
		                    <th id="categoriaProducto">Categoría</th>
		                    <th id="operacionesProducto">Operaciones</th>
		                    <th>Producto en menu</th>
		                </tr>
		            </thead>
	                <tbody>
	                @foreach($productos as $producto)
		                <tr class="prod" >
		                    <td  class="id">{{ $producto->id }}</td>
		                    <td>{{ $producto->nombre_producto }}</td>
		                    <td>{{ $producto->stock }}</td>
		                    <td>{{ $producto->stock_minimo }}</td>
		                    <td>{{ $producto->proveedor }}</td>
		                    <td>{{ $producto->precio_venta_unitario }}</td>
		                    <td>{{ $producto->descripcion }}</td>
		                    <td>{{ $producto->categoria_id }}</td>
		                    <td class=" caja">
		                    	@if(!empty($producto->menu))
		                			<a><img title="add" id="{{ $producto->id }}" src="{{ asset('images/eliminar.png') }}" class="imagenesListado add" alt="Add"></a>
								@else
									<a><img title="add" id="{{ $producto->id }}" src="{{ asset('images/agregar.png') }}" class="imagenesListado add" alt="Add"></a>
		               			@endif
	                        <span></span>
		                    </td>
		                    @if(!empty($producto->menu))
		                    	<td class="inMenu inCart">{{ $producto->menu }}</td>
		               		@endif
		                </tr>
	                @endforeach
	                </tbody>
	            </table>
	            <div id="black" class="margen"></div>

	            <br><br><br>

	       	@endif
	</section>

@endsection

@section('javascript')

	<script src="{{ asset('js/newMenu.js') }}"></script>

@endsection