@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaProducto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventaProductos.css') }}">

@endsection

@section('nav')

    @include('parts/pedido_administrativo_nav')

@endsection

@section('content')

    <section class="principal">
        @include('errors/errors')
        @if(empty($pedido))
            <h3>Pedido no tomado</h3>
        @else
            <h2>Aceptar pedido N° {{ $pedido->id }}</h2>
            <table class="listado">
                <tr>
                    <td>
                        {!! Form::open(['route' => ['pedidos-administrativo.aceptar-pedido', $pedido->id], 'method' => 'POST']) !!}
                            <input class="enviar" type="submit" value="Aceptar pedido" style="width: 300px;">
                        {!! Form::close() !!}
                    </td>
                </tr>
            </table>

            <br>
            <br>

            <h2>Rechazar pedido N° {{ $pedido->id }}</h2>
            <table class="listado">
                <tr>
                    <td>
                        {!! Form::open(['route' => ['pedidos-administrativo.rechazar-pedido', $pedido->id], 'method' => 'POST']) !!}
                            <label>Observación<span class="asterisco">*</span></label>
                            <textarea class="borde" name="observacion" required="required" maxlength="255" cols="27" rows="7"></textarea>

                            <br>
                            <br>

                            <input class="cancelar" type="submit" value="Rechazar pedido" style="width: 300px;">
                        {!! Form::close() !!}

                        <br>
                        <br>

                    </td>
                </tr>
            </table>
        @endif
    </section>

@endsection