$(document).ready(function() {
  if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
      $path= "http://localhost/grupo46/entrega2";
  else
      $path= "https://grupo46.proyecto2016.linti.unlp.edu.ar/entrega2";

    $(".compra-item").submit(function(e){
      var form_data = $(this).serialize();
      $.ajax({ // Hacemos el request de ajax
        url: $path + "/index.php/?action=Compra&request=agregarACompra",
        type: "POST",
        data: form_data
      }).done(function(data){ // on Ajax success
        window.location = $path + "/index.php/?action=Compra&request=vistaCrear";
      })
      e.preventDefault();
    });

    $(".subtotal-item").submit(function(e){
      var form_data = $(this).serialize();
      $.ajax({
        url: $path + "/index.php/?action=Compra&request=quitarDeCompra",
        type: "POST",
        data: form_data
      }).done(function(data){
        window.location = $path + "/index.php/?action=Compra&request=vistaCrear";
      })
      e.preventDefault();
    });

});
