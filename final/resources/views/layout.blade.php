<!DOCTYPE html>
<html lang="es">

<head>

    @include('head')
    @yield('head')

</head>

<body>

    <header class="container">
        <h1 class="banner">Sistema de Buffet</h1>
    </header>

    <nav class=" wrapper">
        <div class="contenedor-menu">
            <a href="#" class="btn-menu">Menu</a>
            <ul class="menu">
                @yield('nav')
            </ul>
        </div>
    </nav>

    <div class="main container">
        <div class="contenedor">
            <div>
                @include('flash::message')
            </div>
            @yield('content')
        </div>
    </div>

    <footer class="container">
        @include('footer')
    </footer>

    @yield('javascript')

    <script type="text/javascript">
        location.reload();
        return (0);
    </script>

    <script>
        function openInNewTab(url) {
            var win = window.open(url, '_blank');
            win.focus();
        }
    </script>

</body>

</html>