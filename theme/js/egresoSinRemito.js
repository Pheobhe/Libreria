var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
//$("#tablaPrincipal").empty().append(loading);
var countrow=0;
$(".select2").select2();
cargarSelectUsuario();
//cargarSelectDestino();

//Funciones DATEPICKER
var today = moment().format('DD/MM/YYYY');
$('#datepicker').val(today);

//Datemask dd/mm/yyyy
$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

$("[data-mask]").inputmask();

//Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      format:'dd/mm/yyyy'

    });

   

$('#fechaHoy').click(function(){
  var today = moment().format('DD/MM/YYYY');
  $('#datepicker').val(today);
});



//carga de select en consulta
$('#consultarArt').click(function(){
	$("#tablaConsulta").empty();
	cargarSelectNombreArt();
});


$('#consultaNombre').on("select2:select", function(e) { 
   consultarArtNombre();
});


function cargarSelectUsuario()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Login/getCurrentUser', 
            cache: false,
            data: 'json',
            dataType: 'json',
           //data: {id_producto: "producto"},                      
      })
    .done(function(data) {

      var newOption = new Option(data.nombre, data.id, true, true);
      $("#selectUsuario").append(newOption).trigger('change');      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

function cargarSelectDestino()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Unidad/getNombreUnidades', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},                      
      })

    
    .done(function(data) {

      var $element = $('#selectDestino').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var newOption = new Option(data[i].nombre, data[i].id_destino, true, true);
        $("#selectDestino").append(newOption).trigger('change');
      }      
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

function cargarSelectNombreArt()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getNombresArtConStock', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},                    
      })

    
    .done(function(data) {

      var $element = $('#consultaNombre').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        //console.log(data[i]);
        var item=data[i].marca;
        var option = new Option(data[i].Producto, data.i, true, true);
        //console.log(option);
        $element.append(option);
      }
      var option = new Option("Seleccione...", "null", true, true);
      $("#consultaNombre").append(option).trigger('change');      
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}



function consultarArtNombre()
{
  var nombre = $("#consultaNombre").val(); 
  var postData = {
      'nombre' : nombre
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getproductosStock', 
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
            for (i=0;i<Object.keys(value).length;i++){
              arrayEncabezado[i] = Object.keys(value)[i];//lleno el encabezado de la tabla
            }
            i=1;
          }
          arrayElementos.push(value);
        })
        //var html=arrayElementos.length;
        //$('.bg-green').html(html);
        //console.log(data);
        dibujarEncabezado("tablaConsulta",arrayEncabezado);
        //dibujarEncabezado("example1",arrayEncabezado);
        for (i=0;i<arrayElementos.length;i++){
          drawRow(arrayElementos[i],"tablaConsulta",i);
          //drawRow(arrayElementos[i],"example1");
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
function drawRow(rowData,nombreTabla,indice) {
  var row = $("<tr>");
  var valor;
  var i=0;
  $("#"+nombreTabla).append(row); 
  var datos=[];
  //var j=0;
  $.each(rowData, function( index, value ) {
      
      //Transformar null en -
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      row.append($("<td>" + valor + "</td>"));
      


		switch(i) {
		    case 0:
		        id=valor;
		        break;
		    case 1:
		        producto=valor;
            producto = producto.replace(/"/g, '\\"');//escapa comillas dobles en el nombre
		        break;
		    case 2:
		        presentacion=valor;
		        break;
		   
		    case 3:
		        total=valor;
            //row.append($("<input name='cantidad["+indice+"]' class='cantidad' placeholder='Cantidad' type='text'></input>"));
		        break;
        

		}

      i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad);
    row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+Id+",\""+Producto+"\""+",\""+Presentacion+"\",\""+Total+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>")); 
    


}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}

function agregarPrincipal(id,producto,presentacion,total,indice){
    
	/*var cantidad;
    $("[name^='cantidad["+indice+"]']").each(function () {
        cantidad=$(this).val();
    });*/

    countrow++;

    //chequear que no descuente menos de 0
    //if (total>0){   
    	var postData = {
	      'id' : id,
	      'producto' : producto,
	      'presentacion': presentacion,
	      
	      'total':total,
        
	      //'cantidad':cantidad

	    };
    	//FALTA HACER LA INSERCION DEL TEMP

      /*
    	$.ajax({
            async: true,
            type: "POST",
            url:'Remito/addEgresoTemp', 
            cache: false,
            data: postData,
            dataType: 'json',
           //data: {id_producto: "producto"},                      
     	})
    	.done(function(data) {
	      	console.log(data);
	      	            
    	})
    	.fail(function() {
        	alert("error. Consulte con el administrador de sistemas.")
    	}); 
  		*/



	    var row = $("<tr id="+countrow+">");
	    $("#tablaPrincipal").append(row);      
		row.append($("<td>" + id + "</td>"));
		row.append($("<td>" + producto + "</td>"));
		row.append($("<td>" + presentacion + "</td>"));
		//row.append($("<td>" + lote + "</td>"));
		//row.append($("<td>" + fec_venc + "</td>"));
    //	row.append($("<td>" + med_lote_fec + "</td>"));
		//row.append($("<td class='"+med_lote_fec+"' name='"+med_lote_fec+"'>" + total + "</td>"));
    	row.append($("<td><input name='cantidad["+countrow+"]' class='cantidad' type='text'></input></div></td>"));
    	//row.append($("<td><input name='cantidad["+countrow+"]' class='cantidad"+med_lote_fec+"' type='text'></input></div></td>"));
      
     // row.append($("<td class='"+inventario+"' name='"+inventario+"'>" + inventario + "</td>"));
      row.append($("<td><button class='no-print eliminar btn btn-flat btn-danger' type='button'><span class='fa fa-close'></span></button></td>"));
    	row.append($("<td></td></tr></tbody>"));
    	$(".consultarart").modal('hide');

      setTimeout(function() {
        $(".consultarart").modal('show');
      }, 800);
	//}else{
	//	alert("no se puede agregar en 0");
	//}

	//elimina row
    $('.eliminar').click(DeleteRow);
}

function DeleteRow(){
  $(this).parents('tr').first().remove();
}


function enviarAutorizacion(){

  var cab={
            //nro_remito:$("#numremito").val(),
            fec_egresox:$("#datepicker").val(),
            motivo:$("#selectMotivo").val(),
            id_usuario:$("#selectUsuario").val(),
            responsable:$("#responsable").val()}

  var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:  $(this.cells[0]).text(),
            //fec_venc: $(this.cells[4]).text(),
           // lote: $(this.cells[3]).text(), 
            cantidad: $(this).find("td:eq(7) input[type='text']").val(),
           // tamano:$(this.cells[8]).text(),
           // inventario:$(this.cells[9]).text(),  
        };
    }).get();

  //data.forEach(function(entry) {
    //console.log(entry.id_producto+entry.lote+entry.fec_venc);
//});

var valueArr = data.map(function(item){ return item.id_producto });
var isDuplicate = valueArr.some(function(item, idx){ 
    return valueArr.indexOf(item) != idx 
});
//console.log(isDuplicate);
  
  if(isDuplicate==false){
    
    
    if(jQuery.isEmptyObject(data)==false){
      
      if($("#selectMotivo").val()=="CAMBIO INVENTARIO"){
        checkCambioInventario();
      }else{
        enviarCheckStock();
      }

      
    }else{
      alert("Error no hay Productos");
      $('#ingresarRemito').prop('disabled', false);
    }
  }else{
    alert("Error existen elementos duplicados");
    $('#ingresarRemito').prop('disabled', false);
  }

}


function enviarCheckStock(){

  var cab={
            //nro_remito:$("#numremito").val(),
            fec_egresox:$("#datepicker").val(),
            motivo:$("#selectMotivo").val(),
            id_usuario:$("#selectUsuario").val(),
            responsable:$("#responsable").val()}

  var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:  $(this.cells[0]).text(),
            //fec_venc: $(this.cells[4]).text(),
            //lote: $(this.cells[3]).text(), 
            cantidad: $(this).find("td:eq(7) input[type='text']").val(),
            //tamano:$(this.cells[8]).text(),
           // inventario:$(this.cells[9]).text(),  
        };
    }).get();
  $.ajax({
            async: true,
            type: "POST",
            url:'EgresoX/checkStock', 
            cache: false,
            data: 'json',
            dataType: 'json',
            data: {data: data,cab:cab},           
      })

    
      .done(function(data) {
        if(data>0){
          //imprimir(data);
          $("#result").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se Agregó Correctamente </div>');
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
          var error="";
          $.each(data, function( index, value ) {
            error+="Error de stock en Producto: "+value.id+"<br>";
            $(".cantidad"+value.id).css({"color":"red","border":"1px solid red"});
          });
            $("#errorStock").empty().append(error+"Los Totales Fueron Actualizados.");

          var totales = $('#tablaPrincipal tr:gt(0)').map(function() {
                return {
                    id_producto:  $(this.cells[0]).text(),
                    //fec_venc: $(this.cells[4]).text(),
                    //lote: $(this.cells[3]).text(), 
                    total: $(this.cells[6]).text(),
                    cantidad: $(this).find("td:eq(7) input[type='text']").val(),
                    
                };
          }).get();

         // console.log(data);
          actualizarTotal(totales);
          $('#ingresarRemito').prop('disabled', false);
        } 
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
}





/*
function actualizarCant(data){
  
  var id=[];
  //console.log(data);
  $.each(data, function( index, value ) {
    id.push(value.id+value.lote+value.fec_venc);
    $.ajax({
              async: true,
              type: "POST",
              url:'Remito/actualizarCant', 
              cache: false,
              data: 'json',
              dataType: 'json',
              data: {id:value.id,lote:value.lote,fec_venc:value.fec_venc},           
        })
    .done(function(data) {
        //console.log(id);
        //console.log(id[index]);
        console.log(data);
        $("."+id[index]).empty().append(data[0].total);
        /*var i=0;
        $.each(data, function( index, value ) {
          //console.log(value);
          
          $("."+id[i]).empty().append(value.total);
          i++;

        });

    })
    .fail(function() {
      alert("error. Consulte con el administrador de sistemas.")
    });
});


}*/
$('#actualizar').click(function(){
  var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:  $(this.cells[0]).text(),
            fec_venc: $(this.cells[4]).text(),
            lote: $(this.cells[3]).text(), 
            total: $(this.cells[6]).text(),
            cantidad: $(this).find("td:eq(7) input[type='text']").val(),
        };
  }).get();

  actualizarTotal(data);

});

function actualizarTotal(data){

  //console.log(data);
  $.each(data, function( index, value ) {
    //console.log(value);
      $.ajax({
                async: true,
                type: "POST",
                url:'Remito/getTotal', 
                cache: false,
                data: 'json',
                dataType: 'json',
                data: {id:value.id_producto,lote:value.lote,fec_venc:value.fec_venc},           
      })
      .done(function(data) {
          //console.log(data);

          $.each(data, function( index, val ) {
          //console.log(value);
            $("."+value.id_producto+value.lote+value.fec_venc).empty().append(val.total);
          });

      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
  });



}

function resetearForm(){

  var encab="";
  encab += "<thead><tr><th>Id<\/th><th>Producto<\/th><th>Presentación<\/th><th>Total<\/th><th>Cantidad<\/th><\/tr><\/thead>";
  $("#tablaPrincipal").empty().append(encab);
  $("#responsable").val("");
  $('#ingresarRemito').prop('disabled', false);
  $('#consultaNombre').text("");
 /* $.ajax({
          async: true,
          type: "POST",
          url: 'EgresoX/mostrarDatos', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/egresoSinRemito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}




$('#ingresarRemito').click(function() {
  
  $('#ingresarRemito').prop('disabled', true);


  $("#mov").validate({
        rules: {            
            responsable: { required:true, minlength: 3, maxlength:50  },
            datepicker: {required:true}
        },
        messages: {
            responsable : {required:"Debe ingresar un responsable",minlength:"minimo 3 caracteres",maxlength:"maximo 50 caracteres"},
            datepicker: "Debe ingresar Fecha"
        }
      });
  $("[name^=cantidad]").each(function () {
        $(this).rules("add", {
            required: true,
            number:true,
            min:1,
            messages: {
                required: "Campo Requerido",
                number:"Debe ser numérico",
                min:"el valor debe ser mayor a 0"
            }            
        });
    });
  $("[name^=venc]").each(function () {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Campo Requerido"
            }            
        });
    });
  
  
  
  //alert($("#mov").valid());
  if ($("#mov").valid()==true){
    enviarAutorizacion();
    //$('#ingresarRemito').prop('disabled', true);
  }else{
    $('#ingresarRemito').prop('disabled', false);
  }
});

function imprimir(data){



  $.ajax({
          async: true,
          type: "POST",
          url: 'Remito/imprimir', 
          cache: false,
          data: {id:data},
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
            var pie=' <div id="pie" style="position:fixed;bottom:0px;width:100%;margin-left:15px;">\
                          <div><tr><td>Entrega Libreria</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Retira Libreria</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Entrega Unidad&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Recibe Unidad&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <br>\
                          <div>Original: Archivar en Destino/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duplicado: Devolver Conformado/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>\
                      </div>';

          var html='\
          <div class="container">\
            <div class="row">\
              <div class="col-md-12">\
                <div class="idaut">\
                  <h3>AUTORIZACION N°: '+data[0].id_autorizacion+'</h3>\
                </div>\
              </div>\
            </div>\
            <div class="row">\
              <div class="col-md-3">\
                <div style="background-color:red;" class="fechaIng">\
                  <span>Fecha: '+data[0].fec_autorizado+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="destino">\
                  <span>DESTINO: '+data[0].destino+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="responsable">\
                  <span>RESPONSABLE: '+data[0].responsable+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="responsable">\
                  <span>USUARIO: '+data[0].alias+'</span>\
                </div>\
              </div>\
            </div>\
           </div>';

          var header='<img class="img-responsive" src="../theme/dist/img/membrete.png" alt="Inicio">';
          var marcaOriginal='<img  src="../theme/dist/img/original.png" style="position:absolute;opacity: 0.5;">';
          var marcaDuplicado='<img  src="../theme/dist/img/duplicado.png" style="position:absolute;opacity: 0.5;">';

          var td=[];
          $.each(data, function( index, val ) {    
          //console.log();          
              td.push("<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"<td>"+val.lote+"</td>"+"<td>"+val.fec_venc+"</td>"+"<td>"+val.cant+"</td>"+"</tr>");
          });
           
          var html2='<div class="box-body table-responsive no-padding">\
           <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">\
             <thead><tr><th>Id</th><th>Nombre</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td+'</tbody></table>\
          </div>';
          //$("#impresion").empty().append(html);


            var salto="";
            salto += "<style>";
            salto += "           @media all {";
            salto += "                 div.saltopagina{";
            salto += "                    display: none;";
            salto += "                 }";
            salto += "              }";
            salto += "                 ";
            salto += "              @media print{";
            salto += "                 div.saltopagina{ ";
            salto += "                    display:block; ";
            salto += "                    page-break-before:always;";
            salto += "                 }";
            salto += "              }";
            salto += "          <\/style>";

          $("#impresion").print({
              globalStyles: true,
              mediaPrint: false,
              stylesheet: null,
              iframe: true,
              append: "SISTEMAS DPSP - 2016",
              prepend: header+marcaOriginal+html+html2+pie+"<div class='saltopagina'>"+header+marcaDuplicado+html+html2+pie+"</div>"+salto,
              title: 'Sistema Libreria',
              doctype: '<!DOCTYPE html>'
          });
          //$.getScript("/libreria/theme/js/remito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });

  
}

$('#imp').click(function(){
  imprimir("116");
});
