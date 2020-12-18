$(document).ready(function() {
  if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
      $path= "localhost:8000";
  else
      $path= "https://grupo46.proyecto2016.linti.unlp.edu.ar/entrega3";

    $(".venta-item").submit(function(e){
      var form_data = $(this).serialize();
      $.ajax({ // Hacemos el request de ajax
        url: $path + "/ventas/agregar-producto",
        type: "POST",
        data: form_data
      }).done(function(data){ // on Ajax success
        window.location = $path + "/ventas/vista-crear";
      })
      e.preventDefault();
    });

    $(".subtotal-item").submit(function(e){
      var form_data = $(this).serialize();
      $.ajax({ // make ajax request to cart_process.php
        url: $path + "/ventas/quitar-producto",
        type: "POST",
        data: form_data
      }).done(function(data){ // on Ajax success
        window.location = $path + "/ventas/vista-crear";
      })
      e.preventDefault();
    });

});
