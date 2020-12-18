@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/altaUsuario.css') }}">

@endsection

@section('nav')

    <li><a href="{{ route('frontend') }}">Volver</a></li>

@endsection

@section('content')

    <section class="principal">
        <div id="envelope">
            @include('errors/errors')

            <!-- Laravel genera el token para evitar CSRF automaticamente -->
            {!! Form::open(['route' => 'register', 'method' => 'POST', 'class' => 'formato']) !!}
                <h2>Crea tu cuenta de SIBU</h2>

            @if(empty($request))

                <label for="usuario">Nombre de usuario</label>
                <input id="usuario" name="usuario" type="text" required="required" pattern="[A-Za-z0-9_]{5,20}$" maxlength="20" title="Ingrese un mínimo de 5 letras y/o números, máximo 20" autofocus>

                <label for="password">Contraseña</label>
                <input id="password" name="password" class="clave1" type="password" required="required" pattern="(?=.*\d)(?=.*[A-Z]).{6,20}" maxlength="20" title="Ingrese al menos 6 caracteres, incluyendo mínimamente un número y una mayúscula" onChange="checkPasswordMatch();">

                <label for="confirmacion_de_password">Repetir contraseña</label>
                <input id="confirmacion_de_password" name="confirmacion_de_password" type="password" required="required" pattern="(?=.*\d)(?=.*[A-Z]).{6,20}" maxlength="20" title="Ingrese al menos 6 caracteres, incluyendo mínimamente un número y una mayúscula" onChange="checkPasswordMatch();">
                <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>

                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" type="text" required="required" pattern="[A-Za-z\s]{2,30}" maxlength="30" title="Ingrese un mínimo de 2 letras, máximo 30">
                {{--{!! Form::input('text', 'nombre', '', ['class'=> 'form-control']) !!}--}}

                <label for="apellido">Apellido</label>
                <input id="apellido" name="apellido" type="text" required="required" pattern="[A-Za-z]{2,30}" maxlength="30" title="Ingrese un mínimo de 2 letras, máximo 30">

                <label for="email">Email:</label>
                <input id="email" name="email"  type="email" required="required" title="Ingrese email válido">

                <label for="tipoDocumento">Tipo de documento:</label>
                <select id="tipoDocumento" name="tipoDocumento">
                        <option value="DNI" selected="selected">DNI</option>
                        <option value="CI">Cedula de identidad</option>
                        <option value="LE">Libreta de enrolamiento</option>
                        <option value="LC">Libreta civica</option>
                </select>

                <label>Número de documento:</label>
                <input id="numeroDocumento" name="numeroDocumento" type="number" required="required" min="10000000" max="99999999" title="Ingrese un número de documento válido">

                <label for="telefono">Teléfono:</label>
                <input id="telefono" name="telefono" required="required" type="text" pattern=".{6,20}" title="Ingrese un mínimo de 6 carácteres, máximo 20">

                <label for="ubicacion">Oficina o departamento</label>
                <select name="ubicacion" id="ubicacion">
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre_ubicacion }}</option>
                    @endforeach
                </select>

            @else

                <label for="usuario">Nombre de usuario</label>
                <input id="usuario" name="usuario" type="text" value="{{ $request->usuario }}" required="required" pattern="[A-Za-z0-9_]{5,20}$" maxlength="20" title="Ingrese un mínimo de 5 letras y/o números, máximo 20" autofocus>

            @endif

                <input name="rol_id" value="3" hidden>
                <input name="habilitado" value="1" hidden>

                <br>
                <br>
                <br>

                <input class="enviar" type="submit" value="Enviar">
            {!! Form::close() !!}
            <a class="cancelar" href="{{ route('frontend') }}">Cancelar</a>
        </div>
    </section>

@endsection

@section('javascript')

    <script type="text/javascript">
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirmacion_de_password").val();
            if (password != confirmPassword)
                $("#divCheckPasswordMatch").html("Las contraseñas deben coincidir");
            else
                $("#divCheckPasswordMatch").html("Las contraseñas coinciden");
        }

        $(document).ready(function () {
            $("#txtConfirmPassword").keyup(checkPasswordMatch);
        });
    </script>

@endsection