@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventaProductos.css') }}">

@endsection

@section('nav')

    @include('parts/pedido_cliente_nav')

@endsection

@section('content')

    <section class="principal">
        @include('errors/errors')
        @if(empty($datos['menu']))
            <h3>Aún no hay un menú disponible para el día de hoy</h3>
        @else
            <h3>Menú del día</h3>

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
                @foreach(datos['menu'] as $producto)
                    <tr>
                        {!! Form::open(['route' => 'pedidos-cliente.agregar-producto', 'method' => 'POST', 'class' => 'pedido.item']) !!}
                            <td class="hidden"><input type="hidden" name="id" value="{{ $producto->id }}"></td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->codigo_barra }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->stock_minimo }}</td>
                            <td>{{ $producto->precio_venta_unitario }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                <input name="cantidad" type="number" value="0" min="0" max="50" title="Ingrese cantidad del producto a pedir">
                            </td>
                            @if(isset($datos['pedidos']))
                                @if(array_key_exists($producto->id, $datos['pedidos']))
                                    <td>Producto agregado al pedido</td>
                                @else
                                    <td><input class="enviar" type="submit" value="Agregar al pedido"></td>
                                @endif
                            @else
                                <td><input class="enviar" type="submit" value="Agregar al pedido"></td>
                            @endif
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>
        @endif

        <br>
        <br>

        @if(empty($datos['productos']))
            <h3>No hay productos para realizar pedidos</h3>
        @else
            <h3>Lista de productos a ordenar</h3>

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
                        {!! Form::open(['route' => 'pedidos-cliente.agregar-producto', 'method' => 'POST', 'class' => 'pedido.item']) !!}
                            <td class="hidden"><input type="hidden" name="id" value="{{ $producto->id }}"></td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->codigo_barra }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->stock_minimo }}</td>
                            <td>{{ $producto->precio_venta_unitario }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                <input name="cantidad" type="number" value="0" min="0" max="50" title="Ingrese cantidad del producto a pedir">
                            </td>
                            @if(isset($datos['productosPedido']))
                                @if(array_key_exists($producto->id, $datos['productosPedido']))
                                    <td>Producto agregado al pedido</td>
                                @else
                                    <td><input class="enviar" type="submit" value="Agregar al pedido"></td>
                                @endif
                            @else
                                <td><input class="enviar" type="submit" value="Agregar al pedido"></td>
                            @endif
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>
        @endif

        <br>
        <br>

        @if(isset($datos['productosPedido']) && count($datos['productosPedido']) > 0)
            <h2>Total de productos del pedido:</h2>
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
                    @foreach($datos['productosPedido'] as $pedido)
                        <tr>
                            <td>{{ $pedido->nombre_producto }}</td>
                            <td>{{ $pedido->marca }}</td>
                            <td>{{ $pedido->codigo_barra }}</td>
                            <td>{{ $pedido->precio_venta_unitario }}</td>
                            <td>{{ $pedido->cantidad }}</td>
                            <td>{{ $pedido->subtotal }}</td>
                            <td>
                                <a href="{{ route('pedidos-cliente.quitar-producto', $pedido->id) }}">
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

            {!! Form::open(['route' => 'pedidos-cliente.crear', 'method' => 'POST', 'class' => 'formato']) !!}
                <input class="enviar" type="submit" value="Generar Pedido" style=" width: 300px;">
            {!! Form::close() !!}

            <br>
            <br>

            <a class="cancelar" href="{{ route('pedidos-cliente.cancelar') }}" style="width: 300px;">Cancelar</a>
        @endif
    </section>

@endsection

@section('javascript')

    <script src="{{ asset('js/pedido.js') }}"></script>

@endsection