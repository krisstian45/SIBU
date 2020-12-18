$(document).ready(function() {
    //Pantalla grande
    if ($(document).width() > 450) {
        $('.menu li:has(ul)').hover(function() {
            /* Act on the event */
            if ($(this).hasClass('activado')) {
                $(this).removeClass('activado');
                $('.contenedor-menu .menu li ul').css({ 'position': 'absolute' });


                $(this).children('ul').slideDown(10);
                // $(this).preventDefault();
            } else {
                $('.menu li ul').slideUp(10);
                $('.contenedor-menu .menu').css({ 'position': 'relative' });

                $(this).addClass('activado');
                // $(this).preventDefault();

            }
        });
    }else{

    //Pantalla chica
    if ($(document).width() < 450) {
        $('.menu li').removeClass('activado');

        $('.btn-menu').click(function() {
            $('.contenedor-menu .menu').slideToggle();
        });

        $('.menu li:has(ul)').click(function() {

            if ($(this).hasClass('activado')) {
                 $('.menu li ul').slideUp();
                $(this).removeClass('activado');
            } else {
                $('.menu li ul').slideUp();
                $('.menu li ').removeClass('activado');
                $(this).addClass('activado');
                $(this).children('ul').slideDown();
            }
        });



        $(window).resize(function() {
            if ($(document).width() > 450) {
                $('.contenedor-menu .menu').css({ 'display': 'flex' });
                $('.contenedor-menu .menu li ul').css({ 'position': 'absolute' });

            }
            if ($(document).width() < 450) {
                $('.contenedor-menu .menu').css({ 'display': 'none' });
                $('.menu li ul').slideUp();
                $('.menu li').removeClass('activado');
            }
        });

    }
}

});