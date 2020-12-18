@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventaProductos.css') }}">

@endsection

@section('nav')

    @include('parts/compra_nav')

@endsection

@section('content')

    <section class="principal">
        @include('errors/errors')
        @if(!empty($error))
            <p align="center">{{ $error }}</p>
        @endif
        @if(count($datos['productos']) == 0)
            <h3>No hay productos para renovar stock</h3>
        @else
            <h3>Listado de productos para renovar stock</h3>

            <br>

            <table class="listado">
                <tr class="categorias">
                    <th class="hidden"></th>
                    <th class="title">Nombre</th>
                    <th class="title">Marca</th>
                    <th class="title">Codigo barra</th>
                    <th class="title">Stock</th>
                    <th class="title">Stock minimo</th>
                    <th class="title">Precio unitario</th>
                    <th class="title">Descripcion</th>
                    <th class="title">Cantidad</th>
                    <th class="title"></th>
                </tr>
                @foreach($datos['productos'] as $producto)
                    <tr>
                        {!! Form::open(['route' => 'compras.agregar-producto', 'method' => 'POST', 'class' => 'compra.item']) !!}
                            <td class="hidden"><input name="id" value="{{ $producto->id }}" type="hidden"></td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->codigo_barra }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->stock_minimo }}</td>
                            <td>{{ $producto->precio_venta_unitario }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                <input name="cantidad" type="number" value="0" min="0" max="50" title="Ingrese cantidad del producto a comprar">
                            </td>
                            @if(isset($datos['productosCompra']))
                                @if(array_key_exists($producto->id, $datos['productosCompra']))
                                    <td>Producto agregado a la compra</td>
                                @else
                                    <td><input class="enviar" type="submit" value="Agregar a la compra"></td>
                                @endif
                            @else
                                <td><input class="enviar" type="submit" value="Agregar a la compra"></td>
                            @endif
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>

            <br>
            <br>

            @if(isset($datos['productosCompra']) && count($datos['productosCompra']) > 0)
                <h2>Total de productos a comprar:</h2>
                <table class="listado">
                    <tr class="categorias">
                        <th class="title">Nombre</th>
                        <th class="title">Marca</th>
                        <th class="title">Codigo barra</th>
                        <th class="title">Precio unitario</th>
                        <th class="title">Cantidad</th>
                        <th class="title">Subtotal</th>
                        <th class="title"></th>
                        <th class="hidden"></th>
                    </tr>
                    @foreach($datos['productosCompra'] as $productoCompra)
                        <tr>
                            <td>{{ $productoCompra->nombre_producto }}</td>
                            <td>{{ $productoCompra->marca }}</td>
                            <td>{{ $productoCompra->codigo_barra }}</td>
                            <td>{{ $productoCompra->precio_venta_unitario }}</td>
                            <td>{{ $productoCompra->cantidad }}</td>
                            <td>{{ $productoCompra->subtotal }}</td>
                            <td>
                                <a href="{{ route('compras.quitar-producto', $productoCompra->id) }}">
                                    <input class="cancelar" type="submit" value="Quitar">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="title bord0"></td>
                        <td class="title bord0"></td>
                        <td class="title bord0"></td>
                        <td class="title bord0"></td>
                        <td class="title bord2">Total</td>
                        <td class="title bord2">{{ $datos['total'] }}</td>
                        <td class="title"></td>
                        <td class="hidden"></td>
                    </tr>
                </table>

                <br>
                <br>

                {!! Form::open(['route' => 'compras.crear', 'method' => 'POST', 'class' => 'formato', 'enctype' => 'multipart/form-data']) !!}

                    @if(empty($request))
                        <label  for="proveedor">Proveedor </label>
                        <input class="borde" id="proveedor" name="proveedor" type="text" required="required" pattern="[A-Za-z ]{2,20}" maxlength="20" title="Ingrese un mínimo de 2 letras, máximo 20">

                        <label for="cuit">CUIT Proveedor</label>
                        <input class="borde" id="cuit" name="cuit" type="text" required="required" pattern="[1-9]{11}" maxlength="11" title="Ingrese los 11 digitos del numero de CUIT">
                    @else
                        <label  for="proveedor">Proveedor </label>
                        <input class="borde" id="proveedor" name="proveedor" type="text" value="{{ $request->proveedor }}" required="required" pattern="[A-Za-z ]{2,20}" maxlength="20" title="Ingrese un mínimo de 2 letras, máximo 20">

                        <label for="cuit">CUIT Proveedor</label>
                        <input class="borde" id="cuit" name="cuit" type="text" value="{{ $request->cuit }}" required="required" pattern="[1-9]{11}" maxlength="11" title="Ingrese los 11 digitos del numero de CUIT">
                    @endif

                    <br>

                    <label>Ingrese la factura escaneada</label>

                    <br>

                    <input type="file" name="factura" accept="image/*">

                    <br>
                    <br>

                    <input class="enviar" type="submit" value="Generar compra" style="width: 300px;">

                {!! Form::close() !!}

                <br>
                <br>

                <a class="cancelar" href="{{ route('compras.cancelar') }}" style="width: 300px;">Cancelar</a>
            @endif
        @endif
    </section>

@endsection

@section('javascript')

    <script src="{{ asset('js/compra.js') }}"></script>

@endsection