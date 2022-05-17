$(".select2").select2();
cargarSelectPresentacion();




$('#addProducto').click(function(){
	 $('#addProducto').prop('disabled', true);
			$("#formNuevo").validate({
                rules: {
                    nombreProducto: { required: true, minlength: 3, maxlength:100},
                    stock_minimo:{required:true,number:true,max: 10000000, min: 1 }
                },
                messages: {
                    nombreProducto: { required: "Debe ingresar un nombre de Producto", minlength: "minimo 3 caracteres", maxlength:"maximo 100 caracteres" },
                    stock_minimo:{required: "Campo Requerido",
                    number:"Debe ser numérico",
                    max: "El valor debe ser inferior a 10.000.000",
                    min: "El valor debe ser superior a 0"}
                }
            });

            if ($("#formNuevo").valid()==true){
            	enviarDatos();
            }else{
              $('#addProducto').prop('disabled', false);
            }

});


function enviarDatos(){


	var producto = $("#nombreProducto").val().trim(); 
        producto = producto.replace(/\s{2,}/g, ' ');//remplaza los espacios en blanco duplicados en medio
		    //var producto =  $("#producto").val();
		    var stock_minimo =  $("#stock_minimo").val().trim();
		    var presentacion =  $("#presentacion").val();
		   
		    var postData = {
		      'producto' : producto,
		      'stock_minimo' : stock_minimo,
		      'presentacion': presentacion
		      
		    };

		    $.post('Producto/addProducto', postData, function(data){
		        if (data) { 
		            //alert("exito");
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

function cargarSelectPresentacion()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getPresentacion', 
            cache: false,
            data: 'json',
            dataType: 'json',
           //data: {id_producto: "producto"},            
      })

    
    .done(function(data) {

      var $element = $('#presentacion').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        //console.log(data[i]);
        var item=data[i].marca;
        var option = new Option(data[i].presentacion, data[i].presentacion, true, true);
       // var option = new Option(data[i].presentacion,  data[i].presentacion, true, true);
        //console.log(option);
        $element.append(option);
      }      
      
    })
    .fail(function() {
        alert("Error nuevoArt.js103. Consulte con el administrador de sistemas.")
    }); 
  });
}



function resetearForm(){

  
  $("#nombreProducto").val("");
  $("#stock_minimo").val("");
  $('#addProducto').prop('disabled', false);
  


  /*$.ajax({
          async: true,
          type: "POST",
          url: 'Producto/mostrarDatosNuevoArt', 
          cache: false,
          data: 'json',
          dataType: 'json',
     //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/nuevoArt.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}


