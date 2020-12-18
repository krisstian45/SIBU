@extends('layout')

@section('nav')

    @include('parts/backend_nav')

@endsection

@section('content')

    <section class="principal">
        @if($menu)
            <article>
                <h3>Menú del dia {{ date('d-m-Y', strtotime($menu[0]->fecha)) }}: </h3>

                <br>

                @foreach($menu as $producto)
                    <p class="menuDia">{{ $producto->nombre_producto }}</p>
                @endforeach
            </article>
        @else
            <article>
                <h3>Aún no hay menú del día.</h3>
            </article>
        @endif
    </section>
    <aside>

        <br/>
        <br/>

        <h2>Subscribite a nuestro canal de telegram!</h2>
        <p>Enterate del menú del día de hoy y mañana: </p>
        <a style="color:blue" href="#" onclick=openInNewTab("https://web.telegram.org/#/im?p=@BuffetGrupo46_bot")>@BuffetGrupo46</a>
    </aside>

@endsection