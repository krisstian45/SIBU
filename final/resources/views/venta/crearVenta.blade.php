@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventaProductos.css') }}">

@endsection

@section('nav')

    @include('parts/venta_nav')

@endsection

@section('content')

    <section class="principal">
        @include('errors/errors')
        @if(!empty($error))
            <p align="center">{{ $error }}</p>
        @endif
        @if(count($datos['productos']) == 0)
            <p>No hay productos para vender</p>
        @else
            <h3>Listado de productos para vender</h3>

            <br>

            <table class="listado">
                <tr class="categorias">
                    <th class="hidden"></th>
                    <th class="title">Nombre</th>
                    <th class="title">Marca</th>
                    <th class="title">Codigo de barra</th>
                    <th class="title">Stock</th>
                    <th class="title">Stock minimo</th>
                    <th class="title">Precio unitario</th>
                    <th class="title">Descripcion</th>
                    <th class="title">Cantidad</th>
                    <th class="title"></th>
                </tr>
                @foreach($datos['productos'] as $producto)
                    <tr>
                        {!! Form::open(['route' => 'ventas.agregar-producto', 'method' => 'POST', 'class' => 'compra.item']) !!}
                            <td class="hidden"><input name="id" value="{{ $producto->id }}" type="hidden"></td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->codigo_barra }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->stock_minimo }}</td>
                            <td>{{ $producto->precio_venta_unitario }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                <input name="cantidad" type="number" value="0" min="0" max="50" title="Ingrese cantidad del producto a vender">
                            </td>
                            @if($producto->stock > 0)
                                @if(isset($datos['productosVenta']))
                                    @if(array_key_exists($producto->id, $datos['productosVenta']))
                                        <td>Producto agregado a la venta</td>
                                    @else
                                        <td><input class="enviar" type="submit" value="Agregar a la venta"></td>
                                    @endif
                                @else
                                    <td><input class="enviar" type="submit" value="Agregar a la venta"></td>
                                @endif
                            @else
                                <td>NO HAY STOCK</td>
                            @endif
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>

            <br>
            <br>

            @if(isset($datos['productosVenta']) && count($datos['productosVenta']) > 0)
                <h2>Total de productos a vender:</h2>
                <table class="listado">
                    <tr class="categorias">
                        <th class="title">id</th>
                        <th class="title">Nombre</th>
                        <th class="title">Codigo barra</th>
                        <th class="title">Precio unitario</th>
                        <th class="title">Cantidad</th>
                        <th class="title">Subtotal</th>
                        <th class="title"></th>
                        <th class="hidden"></th>
                    </tr>
                    @foreach($datos['productosVenta'] as $productoVenta)
                        <tr>
                           <tr>
                            <td>{{ $productoVenta->nombre_producto }}</td>
                            <td>{{ $productoVenta->marca }}</td>
                            <td>{{ $productoVenta->codigo_barra }}</td>
                            <td>{{ $productoVenta->precio_venta_unitario }}</td>
                            <td>{{ $productoVenta->cantidad }}</td>
                            <td>{{ $productoVenta->subtotal }}</td>
                            <td>
                                <a href="{{ route('ventas.quitar-producto', $productoVenta->id) }}">
                                    <input class="cancelar" type="submit" value="Quitar">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="title" style="border: 0px"></td>
                        <td class="title" style="border: 0px"></td>
                        <td class="title" style="border: 0px"></td>
                        <td class="title" style="border: 0px"></td>
                        <td class="title" style="font-weight: bold; border: 2px solid black">Total</td>
                        <td class="title" style="font-weight: bold; border: 2px solid black">{{ $datos['total'] }}</td>
                        <td class="title"></td>
                        <td class="hidden"></td>
                    </tr>
                </table>

                <br>
                <br>

                {!! Form::open(['route' => 'ventas.crear', 'method' => 'POST']) !!}
                    <input class="enviar" type="submit" value="Generar venta" style=" width: 300px;">
                {!! Form::close() !!}

                <br>
                <br>

                <a class="cancelar" href="{{ route('ventas.cancelar') }}" style="width: 300px;">Cancelar</a>
            @endif
        @endif
    </section>

@endsection

@section('javascript')

    <script src="{{ asset('js/venta.js') }}"></script>

@endsection