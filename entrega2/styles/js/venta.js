$(document).ready(function() {
  if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
      $path= "http://localhost/grupo46/entrega2";
  else
      $path= "https://grupo46.proyecto2016.linti.unlp.edu.ar/entrega2";

    $(".venta-item").submit(function(e){
      var form_data = $(this).serialize();
      $.ajax({ // Hacemos el request de ajax
        url: $path + "/index.php/?action=Venta&request=agregarAVenta",
        type: "POST",
        data: form_data
      }).done(function(data){ // on Ajax success
        window.location = $path + "/index.php/?action=Venta&request=vistaCrear";
      })
      e.preventDefault();
    });

    $(".subtotal-item").submit(function(e){
      var form_data = $(this).serialize();
      $.ajax({ // make ajax request to cart_process.php
        url: $path + "/index.php/?action=Venta&request=quitarDeVenta",
        type: "POST",
        data: form_data
      }).done(function(data){ // on Ajax success
        window.location = $path + "/index.php/?action=Venta&request=vistaCrear";
      })
      e.preventDefault();
    });

});