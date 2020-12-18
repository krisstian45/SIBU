$(document).ready(function() {
    if(location.hostname === "localhost" || location.hostname === "127.0.0.1")
        $path = "http://localhost/grupo46/final";
    else
        $path = "https://grupo46.proyecto2016.linti.unlp.edu.ar/final";
    // cuando entro me tengo que crear la parte del producto

    // end
    var producto = 0; // controlador de productos

    $(".add").click(function(e) {
        //var id = $(this).children('td:first').attr('id');
        var id = $(this).attr('id');
        var fecha = $('.fechaDeHoy').val();
        //console.log(fecha,id);
        //var actual=$(' .prod').;
        var actual = $(this).closest(' .prod ');
        var caja = $(this);
        e.preventDefault();

        $.ajax({
                url: $path + '/menu/route',
                type: 'GET',
                data: { id: id , fecha: fecha },
            })
            .done(function(dato) {
                console.log(dato);
                if(!$(actual).hasClass('inCart') && !$(actual).children('td:last').hasClass('inCart')) {
                    $(actual).addClass('inCart');
                    producto = producto + 1;
                    if($(actual).children('td:last').hasClass('inMenu')) {

                    }
                    else{
                        $(actual).append('<td class="inMenu inCart">Agregado al menu </td>');
                        $(caja).attr('src', 'https://grupo46.proyecto2016.linti.unlp.edu.ar/entrega1/imagenes/eliminar.png');
                    }

                    // if ((!$('thead').hasClass('carrito'))) { // agrega la tabla de que hay elementos en el carrito
                    //     $('thead').addClass('carrito');

                    //     $('thead tr').append('<th class=" estado">estado</th>');
                    //     $('.estado').text("En menu.")
                    // }

                    // if ($(actual).hasClass('inCart')) { //agrega el estado del producto
                    //     $(actual).append('<td class="state">Agregado al menu </td>');
                    // }

                }
                else {
                    $(actual).removeClass('inCart');
                    $(actual).children('td:last').removeClass('inCart');

                    if(!$(actual).hasClass('inCart')) { // elimina el estado del producto
                        //$(actual).children('.inMenu').remove();
                        $(caja).attr('src', 'https://grupo46.proyecto2016.linti.unlp.edu.ar/entrega1/imagenes/agregar.png');
                        $(actual).children('td:last').remove();
                        //producto = producto - 1;
                    }
                    // if (($('thead').hasClass('carrito')) && (producto == 0)) { //si ya no queda elementos en el carrito elimnia la tabla
                    //     $('thead').removeClass('carrito');
                    //     $('thead tr .estado').remove()
                    // }
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
    });
});