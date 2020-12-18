@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">

@endsection

@section('nav')

    @include('parts/producto_nav')

@endsection

@section('content')

    <section class="principal">
        @include('errors/errors')
        <div>
            <h2>Modificar producto: {{ $producto->nombre_producto }}</h2>
        </div>
        {!! Form::open(['route' => ['productos.modificar', $producto->id], 'method' => 'POST', 'class' => 'formato']) !!}

            <label  for="nombre">Nombre <span class="asterisco">*</span></label>
            <input value="{{ $producto->nombre_producto }}" class="borde" id="nombre" name="nombre" type="text" required="required" pattern="[A-Za-z0-9]{2,20}" maxlength="20" title="Ingrese un mínimo de 2 letras, máximo 20" autofocus>

            <label for="marca">Marca<span class="asterisco">*</span></label>
            <input value="{{ $producto->marca }}" class="borde" id="marca" name="marca" type="text" required="required" pattern="[A-Za-z0-9]{2,20}" maxlength="20" title="Ingrese un mínimo de 2 letras, máximo 20">

            <label for="codigo_barra">Código de barra<span class="asterisco">*</span></label>
            <input value="{{ $producto->codigo_barra }}" class="borde" id="codigo_barra" name="codigo_barra" type="text" required="required" pattern="[0-9]{10,20}" maxlength="20" title="Ingrese un mínimo de 10 caracteres, máximo 20. No soporta letras">

            <label for="stock">Cantidad de stock</label>
            <input value="{{ $producto->stock }}" class="borde" id="stock" name="stock" type="number" min="0" title="Ingrese un número de stock">

            <label for="stock_minimo">Cantidad mínima de stock<span class="asterisco">*</span></label>
            <input value="{{ $producto->stock_minimo }}" class="borde" id="stock_minimo" name="stock_minimo" type="number" required="required" min="0" title="Ingrese un número mínimo de stock">

            <label>Categoría<span class="asterisco">*</span></label>
            <select name="categoria_id" >
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach
            </select>

            <label for="proveedor">Proveedor<span class="asterisco">*</span></label>
            <input value="{{ $producto->proveedor }}" class="borde" id="proveedor" name="proveedor" type="text" required="required" maxlength="20" pattern="[A-Za-z0-9]{2,20}" title="Ingrese un mínimo de 2 letras, máximo 20">

            <label for="precio_venta_unitario">Precio por unidad<span class="asterisco">*</span></label>
            <input value="{{ $producto->precio_venta_unitario }}" class="borde" id="precio_venta_unitario" name="precio_venta_unitario" type="number" required="required" min="0" step="0.01" title="Ingrese un precio">

            <label >Descripción<span class="asterisco">*</span></label>
            <textarea class="borde" name="descripcion" cols="27" rows="7" required="required">{{ $producto->descripcion }}</textarea>

            <br>

			<input type="submit" class="enviar" value="Modificar">
            <input type="reset" class="enviar"  value="Restablecer">

        {!! Form::close() !!}

        <a class="cancelar" href="{{ route('productos') }}">Cancelar</a>
	</section>

@endsection