$('#addUnidad').click(function(){
	$('#addUnidad').prop('disabled', true);
			$("#formNuevo").validate({
                rules: {
                    nombreUnidad: { required: true, minlength: 3, maxlength:45},
                    direccion:{required:true,minlength: 3, maxlength:45},
                    telefono:{required:true,minlength: 3, maxlength:45}
                },
                messages: {
                    nombreUnidad: { required: "debe ingresar un nombre de unidad", minlength: "minimo 3 caracteres", maxlength:"maximo 45 caracteres" },
                    direccion: { required: "debe ingresar una direccion", minlength: "minimo 3 caracteres", maxlength:"maximo 45 caracteres" },
                    telefono: { required: "debe ingresar un telefono", minlength: "minimo 3 caracteres", maxlength:"maximo 45 caracteres" }
                }
            });

            if ($("#formNuevo").valid()==true){
            	enviarDatos();
            }else{
              $('#addUnidad').prop('disabled', false);
            }

});


function enviarDatos(){
    var nombreUnidad = $("#nombreUnidad").val().trim(); 
    var direccion =  $("#direccion").val().trim();
    var telefono =  $("#telefono").val().trim();
    var cod_postal =  $("#codigoPostal").val().trim();
    var contacto =  $("#contacto").val().trim();
   
    var postData = {
      'nombre' : nombreUnidad,
      'direccion': direccion,
      'telefono':telefono,
      'contacto':contacto,
      'cod_postal':cod_postal
    };

    $.post('Unidad/addUnidad', postData, function(data){
        if (data) { 
            $("#result").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se Agregó Correctamente </div>');
            window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                  });
                    
                  $('.alert .close').on("click", function(e){
                        $(this).parent().fadeTo(500, 0).slideUp(500);
                  });

                  resetearForm();
                }, 3000);
        }else{
            alert("error");
            
        }
    });

}

function resetearForm(){

  $("#nombreUnidad").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#contacto").val("");
  $("#codigoPostal").val("");
  $('#addUnidad').prop('disabled', false);



 /* $.ajax({
          async: true,
          type: "POST",
          url: 'Unidad/mostrarDatosNuevoUnidad', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/nuevoUnidad.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}