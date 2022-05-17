$(".select2").select2();
cargarSelectMovimientos();

$('#selectMovimiento').on("select2:select", function(e) { 
   cargarMovimientos();
});



$('#anularMov').click(function() {

  $('#anularMov').prop('disabled', true);
  if($('#selectMovimiento').val()!="null"){
    enviarAnular();
  }else{
    alert("debe seleccionar movimiento");
    $('#anularMov').prop('disabled', false);
  }

});



function enviarAnular(){

  var id_ingreso=$('#selectMovimiento').val();
  var postData = {
      'id_ingreso' : id_ingreso
    };
  $.ajax({
            async: true,
            type: "POST",
            url:'Movimiento/anularMovimiento', 
            cache: false,
            data: postData,
            dataType: 'json',
      })
    .done(function(data) {
      if (data==true){
        $("#result").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se Anuló Correctamente </div>');
                window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                  });
                    
                  $('.alert .close').on("click", function(e){
                        $(this).parent().fadeTo(500, 0).slideUp(500);
                  });

                  resetearForm();
                  //imprimir(data);
                }, 3000);
      }else{
        alert("error en la transaccion");
        $('#anularMov').prop('disabled', false);
      }

    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
        $('#anularMov').prop('disabled', false);
    }); 

}


function resetearForm(){
  var encab="";
  encab += "<thead><tr><th>id<\/th><th>Nombre<\/th><th>Unidad<\/th><th>Cantidad<\/th><\/tr><\/thead>";
  $('#anularMov').prop('disabled', false);
  $('#tablaPrincipal').empty().append(encab);
  $('#numremito').val("");
  $('#datepicker').val("");
  $('#selectProveedor').val("");
  $('#selectUsuario').val("");
  $('#responsable').val("");
  cargarSelectMovimientos();
}





//Cargar Selects
function cargarSelectMovimientos()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Movimiento/getMovimientos', 
            cache: false,
            data: 'json',
            dataType: 'json',
      })
    .done(function(data) {
      var $element = $('#selectMovimiento').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var newOption = new Option(data[i].id_ingreso, data[i].id_ingreso, true, true);
        $("#selectMovimiento").append(newOption).trigger('change');
      }      
      var option = new Option("Seleccione...", "null", true, true);
      $("#selectMovimiento").append(option).trigger('change');

    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

function cargarMovimientos(){

	var id_ingreso = $("#selectMovimiento").val(); 
  	var postData = {
      'id_ingreso' : id_ingreso
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Movimiento/getMovimientoById', 
      cache: false,
      data: postData,
      dataType: 'json',        
    })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
        // $(".content-wrapper").html(data);
        var i=0;
        var arrayEncabezado = [];
        var arrayElementos= [];
        $.each(data,function(key,value){
          if (i===0){
          	$("#numremito").val(value.nro_remito);
          	$("#datepicker").val(value.fec_ingreso);
          	$("#selectProveedor").val(value.nombreProv);
          	$("#selectUsuario").val(value.alias);
          	$("#responsable").val(value.responsable);
            for (i=0;i<Object.keys(value).length;i++){
              arrayEncabezado[i] = Object.keys(value)[i];//lleno el encabezado de la tabla
            }
            i=1;
          }
         
          	arrayElementos.push(value);
          
          i=i+1;
        })

        dibujarEncabezado("tablaPrincipal",arrayEncabezado);
       
        for (i=0;i<arrayElementos.length;i++){
          drawRow(arrayElementos[i],"tablaPrincipal");
          //drawRow(arrayElementos[i],"example1");
        }
        //esconder las primeras 6 columnas de la tabla
        for (var i = 0 ;i<7;i++) {
        	$('td:nth-child('+i+')').hide();
        	$('td:nth-child('+i+'),th:nth-child('+i+')').hide();
        }
        
      }
    })
    .fail(function() {
      alert("error. Consulte con el administrador de sistemas.")
    }); 
}


function drawTable(data) {
    for (var i = 0; i < data.length; i++) {
        drawRow(data[i]);
    }
}

function dibujarEncabezado(nombreTabla,clave){
  var encabezado="<thead><tr>";
    $.each(clave, function( index, value ) {
      //console.log( index + ": " + value );
      encabezado +="<th>"+value+"</th>";
    });
    encabezado +="</thead></tr>";

    //contenido="<thead><tr><th>LEGAJO</th><th>APELLIDOS</th><th>NOMBRES</th><th>FECHA NACIMIENTO</th><th>DNI</th><th>FECHA POS</th><th>TITULO</th><th>DESTINO</th></tr></head>";
    $("#"+nombreTabla).empty().append(encabezado);
    //console.log(encabezado);
}
function drawRow(rowData,nombreTabla) {
  var row = $("<tr>");
  var valor;
  var i=0;
  $("#"+nombreTabla).append(row); 
  var datos=[];

  $.each(rowData, function( index, value ) {
      
      //Transformar null en -
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      row.append($("<td>" + valor + "</td>"));
      i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad+descripcion);
    //row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+marca+"\""+",\""+nombre+"\""+",\""+droga+"\",\""+unidad+"\",\""+descripcion+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>")); 
    


}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}
