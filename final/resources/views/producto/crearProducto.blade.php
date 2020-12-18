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
            <h2>Ingrese los datos del nuevo producto</h2>
            <div>En este formulario hay campos obligatorios <span class="asterisco">*</span></div>
        </div>
        {!! Form::open(['route' => 'productos.crear', 'method' => 'POST', 'class' => 'formato']) !!}

            <label  for="nombre">Nombre <span class="asterisco">*</span></label>
            <input class="borde" id="nombre" name="nombre" type="text" required="required" pattern="[A-Za-z\s1-9]{2,20}" maxlength="20" title="Ingrese un nombre de mínimo 2 letras, máximo 20" autofocus>

            <label for="marca">Marca<span class="asterisco">*</span></label>
            <input class="borde" id="marca" name="marca" type="text" required="required" pattern="[A-Za-z\s1-9]{2,20}" maxlength="20" title="Ingrese una marca mínimo de 2 letras, máximo 20">

            <label for="codigo_barra">Código de barra<span class="asterisco">*</span></label>
            <input class="borde" id="codigo_barra" name="codigo_barra" type="text" required="required" pattern="[0-9]{10}" maxlength="20" title="Ingrese solo 10 caracteres">

            <label for="stock">Cantidad de stock</label>
            <input class="borde" id="stock" name="stock" type="number" min="0" title="Ingrese un número de stock">

            <label for="stock_minimo">Cantidad mínima de stock<span class="asterisco">*</span></label>
            <input class="borde" id="stock_minimo" name="stock_minimo" type="number" required="required" min="0" title="Ingrese un número mínimo de stock">

            <label>Categoría<span class="asterisco">*</span></label>
            <select name="categoria_id" >
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach
            </select>

            <label for="proveedor">Proveedor<span class="asterisco">*</span></label>
            <input class="borde" id="proveedor" name="proveedor" type="text" required="required" maxlength="20" pattern="[A-Za-z\s1-9]{2,20}" title="Ingrese un mínimo de 2 caracteres, máximo 20">

            <label for="precio_venta_unitario">Precio por unidad<span class="asterisco">*</span></label>
            <input class="borde" id="precio_venta_unitario" name="precio_venta_unitario" type="number" required="required" min="0" step="0.01" title="Ingrese un precio">

            <label >Descripción<span class="asterisco">*</span></label>
            <textarea class="borde" name="descripcion" required="required" maxlength="255" cols="27" rows="7"></textarea>

            <br>

            <input class="enviar" type="submit" value="Agregar Producto">
            <input type="reset" class="enviar"  value="Restablecer">

        {!! Form::close() !!}

        <a class="cancelar" href="{{ route('productos') }}">Cancelar</a>
    </section>

@endsection