
//$('#modal').modal('show');
$("#enviarImagenes").click(function(e){
  e.preventDefault();
  var formData = new FormData(document.getElementById("formImagenes"));
   var self = this;
  $.ajax({
    url: "Usuario/insertarImagen",
    type: "POST",
    dataType: "HTML",
    data: formData,
    cache: false,
    contentType: false,
    processData: false
  }).success(function(data){
    $("#mensaje").html("Se actualizó la imagen de perfil exitosamente");
    var imagen = "<img src="+data+" class='img-circle menuconsultas' id='cambiarFoto' alt='User Image'>";
    obtenerImagenPerfil();
  });
});

function obtenerImagenPerfil(){
  var id=$(".id_usuario").val();
  console.log("id_usuario: "+id);
  $.ajax({
      url: "Usuario/obtenerImagenPerfil",
      type: "POST",
      dataType: "json",
      data: id_usuario=id,
      cache: false 
    }).success(function(data){
      console.log(data);
     $('.imagenPerfil').attr('src',data);
     //$("#cambiarFoto").append(data);
     espera = setTimeout(function () {
            $('#modal').modal('hide');//ocultar el modal
            $("#mensaje").html("");// vaciar el mensaje del modal
        }, 800);
      
    });
}

