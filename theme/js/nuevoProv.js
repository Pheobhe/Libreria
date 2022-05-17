$('#addProveedor').click(function(){
  $('#addProveedor').prop('disabled', true);
      $("#formNuevo").validate({
                rules: {
                    nombreProveedor: { required: true, minlength: 3, maxlength:45},
                    cuit:{required:true,minlength: 7, maxlength:30},
                    direccion:{required:true,minlength: 3, maxlength:45},
                    telefono:{required:true,minlength: 3, maxlength:45}
                },
                messages: {
                    nombreProveedor: { required: "debe ingresar un nombre de Producto", minlength: "minimo 3 caracteres", maxlength:"maximo 45 caracteres" },
                    cuit:{required: "Campo Requerido",minlength:"minimo 7 caracteres",maxlength:"maximo 30 caracteres"},
                    direccion: { required: "debe ingresar una direccion", minlength: "minimo 3 caracteres", maxlength:"maximo 45 caracteres" },
                    telefono: { required: "debe ingresar un telefono", minlength: "minimo 3 caracteres", maxlength:"maximo 45 caracteres" }
                }
            });

            if ($("#formNuevo").valid()==true){
              enviarDatos();
            }else{
              $('#addProveedor').prop('disabled', false);
            }

});


function enviarDatos(){
    var nombreProveedor = $("#nombreProveedor").val().trim(); 
    var cuit =  $("#cuit").val().trim();
    var direccion =  $("#direccion").val().trim();
    var telefono =  $("#telefono").val().trim();
    var email =  $("#email").val().trim();
    var contacto =  $("#contacto").val().trim();
   
    var postData = {
      'nombre' : nombreProveedor,
      'cuit' : cuit,
      'direccion': direccion,
      'telefono':telefono,
      'email':email,
      'contacto':contacto
    };

    $.post('Proveedor/addProveedor', postData, function(data){
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

  $("#nombreProveedor").val("");
  $("#cuit").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#contacto").val("");
  $('#addProveedor').prop('disabled', false);
  
  /*$.ajax({
          async: true,
          type: "POST",
          url: 'Proveedor/mostrarDatosNuevoProv', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/nuevoProv.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}