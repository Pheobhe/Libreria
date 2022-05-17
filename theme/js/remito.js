//alert("Hola Remito.js 3");

var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
//$("#tablaPrincipal").empty().append(loading);
var countrow=0;
$(".select2").select2();
cargarSelectUsuario();
cargarSelectDestino();

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
   //alert("Hola LOLA remito.js 41");
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
      var defecto= new Option("Seleccione Destino", "Seleccione Destino",true,true);
      $("#selectDestino").append(defecto).trigger('change');
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    });
  });
}

function cargarSelectNombreArt()  //carga el select en autorizar remito
{
  $('#consultaNombre').text("");
  var cargando = new Option("Cargando...", "null", true, true);
  $("#consultaNombre").append(cargando).trigger('change');
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getnombresArtConStock',
            //url:'Producto/getNombresArtConStock',
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
        //var option = new Option(data[i].producto, data.i, true, true);
        var option = new Option(data[i].producto, data[i].producto, true, true);
        //console.log(option);
        $element.append(option);
      }
      var option = new Option("Seleccione...", "null", true, true);
      $("#consultaNombre").append(option).trigger('change');

    })
    .fail(function() {
       
        alert("Error . Consulte con el administrador de sistemas.")
    });
  });
}



function consultarArtNombre()
{
  var nombre = $("#consultaNombre").val(); // me llena la tabla cuando selecciono el producto todo ok
  var postData = {
      'nombre' : nombre
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getProductosStock',
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
      alert("Error 185. Consulte con el administrador de sistemas.")
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
  var stockMenor=0;
  var bloqueado=0
  
  if(parseInt(rowData.total)<parseInt(rowData.stockMin)){
     stockMenor=1;    
  }else{
    stockMenor=0;
  }
  // console.log(rowData.bloqueado);
  if(rowData.bloqueado!=0 && rowData.bloqueado!=null){
      bloqueado=1;    
    }else{
      bloqueado=0;
    }  
  //  console.log("bloqueado es:"+bloqueado ); 
  var row = $("<tr id='articulo' title='Se recomienda seleccionar el vencimiento m&aacute;s pr&oacute;ximo.' class='primervenc"+indice+"'>");
 
  
  $(".primervenc0").tooltip("show");
  var valor;
  var i=0;
  $("#"+nombreTabla).append(row);
  var datos=[];
  //var j=0;
  
  $.each(rowData, function( index, value ) {

      //Transformar null en -
        if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}
  
      if (stockMenor==1 && (i==9 || i==6)){
        row.append($("<td style='background-color:orange'>" + valor + "</td>"));
      }else if(i==10){
          if (bloqueado==1){
            row.append($("<td style='background-color:red'>SI</td>"));
          }else{
            row.append($("<td>NO</td>"));
          }
        
      }else{
        row.append($("<td>" + valor + "</td>"));
      }

     

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
        case 4:
            tamano=valor;
            //row.append($("<input name='cantidad["+indice+"]' class='cantidad' placeholder='Cantidad' type='text'></input>"));
            break;
        case 5:
            inventario=valor;
            break;  
    }
      i=i+1;
     
    });
    
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad+presentacion+descripcion);
    if (indice==0){
        row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+producto+"\""+",\""+presentacion+"\",\""+total+"\",\""+tamano+"\",\""+indice+"\",\""+inventario+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>"));
    }else{
      row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+producto+"\""+",\""+categoria+"\",\""+total+"\",\""+tamano+"\",\""+indice+"\",\""+inventario+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>"));
    }
    stockMenor=0;
    bloqueado=0;

}



function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();
}

function agregarPinpad(){
  $(function() {
$( "#PINform" ).draggable();
});

$( "#PINcode" ).html(
"<form action='' method='' name='PINform' id='PINform' autocomplete='off' draggable='true'>" +
"<input id='PINbox' type='password' value='' name='PINbox' disabled />" +
"<br/>" +
"<input type='button' class='PINbutton' name='1' value='1' id='1' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton' name='2' value='2' id='2' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton' name='3' value='3' id='3' onClick=addNumber(this); />" +
"<br>" +
"<input type='button' class='PINbutton' name='4' value='4' id='4' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton' name='5' value='5' id='5' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton' name='6' value='6' id='6' onClick=addNumber(this); />" +
"<br>" +
"<input type='button' class='PINbutton' name='7' value='7' id='7' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton' name='8' value='8' id='8' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton' name='9' value='9' id='9' onClick=addNumber(this); />" +
"<br>" +
"<input type='button' class='PINbutton clear' name='-' value='limpiar' id='-' onClick=clearForm(this); />" +
"<input type='button' class='PINbutton' name='0' value='0' id='0' onClick=addNumber(this); />" +
"<input type='button' class='PINbutton enter' name='+' value='ingresar' id='+' onClick=submitForm(PINbox); />" +
"</form>"
);
}


function addNumber(e)
{  
  var v = $( "#PINbox" ).val();
  $( "#PINbox" ).val( v + e.value );
}

function clearForm(e)
{
  //document.getElementById('PINbox').value = "";
  $( "#PINbox" ).val( "" );
}

// function submitForm(e)
// {
//   var bloq=$("#bloqueo").val();
//   var resultadopin=0;
//   if (e.value == "")
//   {
//     alert("Ingrese PIN");
//   }
//   else
//   {
//     //alert( "Your PIN has been sent! - " + e.value );
//     data = {
//       pin: e.value,
//       id_bloqueo:bloq
//     }
//     $.ajax({
//           async: true,
//           type: "POST",
//           url:'Remito/checkPin',
//           cache: false,
//           //data: 'json',
//           dataType: 'json',
//           data: data,
//     })
//     .done(function(data) {
//       //console.log(data);
//       //document.getElementById('PINbox').value = "";
//       $( "#PINbox" ).val( "" );
//       resultadopin=1;
//       if(data==1)
//       {
//         var row = $("<tr id="+countrow+">");
//         $("#tablaPrincipal").append(row);
//        row.append($("<td>" + id + "</td>"));
//     row.append($("<td>" + producto + "</td>"));
//     row.append($("<td>" + presentacion + "</td>"));
//     row.append($("<td>" + total + "</td>"));
//     row.append($("<td><input name='cantidad["+countrow+"]' class='cantidad' type='text'></input></div></td>"));
//     row.append($("<td class='"+tamano+"' name='tamano"+tamano+"'>" + tamano + "</td>"));
//     row.append($("<td class='"+inventario+"' name='inventario"+inventario+"'>" + inventario + "</td>"));
//         row.append($("<td><button class='no-print eliminar btn btn-flat btn-danger' type='button'><span class='fa fa-close'></span></button></td>"));
//         row.append($("<td></td></tr></tbody>"));
//         $('.pinpad').modal('hide');

//         //}else{
//         //  alert("no se puede agregar en 0");
//         //}

//         //elimina row
//         $('.eliminar').click(DeleteRow);

//       }
//       else
//       {
//         alert("PIN incorrecto");
//       }

//     })
//     .fail(function() {
//       alert("error. Consulte con el administrador de sistemas.")
//     });
  
// }


function agregarPrincipal(id,producto,presentacion,total,tamano,indice,inventario){  //agrega los productos a movimiento y o remito
var resultadopin=0;

	   countrow++;
     	var postData = {
	      //'id_producto' : id,
        'id' : id,
	      'producto' : producto,
	      'presentacion': presentacion,
	      'total':total,
        'tamano':tamano,
        'inventario':inventario,

	    };
   
        $.ajax({
            async: true,
            type: "POST",
            url:'Remito/checkBloqueo',
            cache: false,
            data: postData,
            dataType: 'json',
            //data: {id_articulo: "articulo"},
      })
      .done(function(data) {
          if(data>0)
          {
            $('#bloqueo').val(data);
            $('.pinpad').modal('show');
            agregarPinpad();



          }
          else
          {
	    var row = $("<tr id="+countrow+">");
     // var row =$("<tr>");
	    $("#tablaPrincipal").append(row);
    row.append($("<td>" + id + "</td>"));
		row.append($("<td>" + producto + "</td>"));
		row.append($("<td>" + presentacion + "</td>"));
		row.append($("<td>" + total + "</td>"));
    //row.append($("<td class='"+ total + "</td>"));
    row.append($("<td><input name='cantidad["+countrow+"]' class='cantidad' type='text'></input></div></td>"));
    row.append($("<td class='"+tamano+"' name='tamano"+tamano+"'>" + tamano + "</td>"));
    row.append($("<td class='"+inventario+"' name='inventario"+inventario+"'>" + inventario + "</td>"));
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

      })
      .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
      });

}


function DeleteRow(){
  $(this).parents('tr').first().remove();
}



function enviarAutorizacion(){

  var cab={
            //nro_remito:$("#numremito").val(),
            fec_ingreso:$("#datepicker").val(),
            destino:$("#selectDestino").val(),
            id_usuario:$("#selectUsuario").val(),
            destinatario:$("#destinatario").val(),
            oficio:$("#oficio").val(),
            responsable:$("#responsable").val().trim(),
            observaciones:$("#observaciones").val()}



  var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:  $(this.cells[0]).text(),          
            cantidad: $(this).find("td:eq(4) input[type='text']").val(),
            tamano: $(this.cells[5]).text(),
            inventario: $(this.cells[6]).text(),
        };
    }).get();

  //data.forEach(function(entry) {
    //console.log(entry.id_producto+entry.lote+entry.fec_venc);
//});

var valueArr = data.map(function(item){ return item.id_producto+item.tamano+item.inventario });
var isDuplicate = valueArr.some(function(item, idx){
    return valueArr.indexOf(item) != idx
});
//console.log(isDuplicate);

  if(isDuplicate==false){


    if(jQuery.isEmptyObject(data)==false){
      $.ajax({
            async: true,
            type: "POST",
            url:'Remito/checkStock',
            cache: false,
            data: 'json',
            dataType: 'json',
            data: {data: data,cab:cab},
      })


      .done(function(data) {
        if(data>0){

          //alert("EXITO"+data);

          $("#result").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se Agregó Correctamente </div>');
                window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                  });

                  $('.alert .close').on("click", function(e){
                        $(this).parent().fadeTo(500, 0).slideUp(500);
                  });

                  resetearForm();
                  imprimir(data);
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
                    id:  $(this.cells[0]).text(),                   
                    total: $(this.cells[3]).text(),
                    cantidad: $(this).find("td:eq(4) input[type='text']").val(),
                    tamano: $(this.cells[5]).text(),
                    inventario: $(this.cells[6]).text(),

                };
          }).get();
          //console.log(inventario);
         // console.log(data);
          actualizarTotal(totales);
          $('#ingresarRemito').prop('disabled', false);
        }
      })
      .fail(function() {
        alert("Error 422. Consulte con el administrador de sistemas.")
      });
    }else{
      alert("Error no hay Productos");
      $('#ingresarRemito').prop('disabled', false);
    }
  }else{
    alert("Error existen elementos duplicados");
    $('#ingresarRemito').prop('disabled', false);
  }

}


$('#actualizar').click(function(){
  var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:  $(this.cells[0]).text(),           
            total: $(this.cells[3]).text(),
            cantidad: $(this).find("td:eq(4) input[type='text']").val(),
           
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
                data: {id:value.id_producto},
      })
      .done(function(data) {
          //console.log(data);

          $.each(data, function( index, val ) {
          //console.log(value);
            $("."+value.id_producto).empty().append(val.total);
          });

      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
  });

}

function resetearForm(){
  var encab="";
  encab += "<thead><tr><th>Id<\/th><th>Producto<\/th><th>Presentación<\/th><th>Total<\/th><th>Cantidad<\/th><th>Tamaño<\/th><th>Inventario<\/th><\/tr><\/thead>";
  $("#tablaPrincipal").empty().append(encab);
  $("#responsable").val("");
  $("#destinatario").val("");
  $("#oficio").val("");
  $('#ingresarRemito').prop('disabled', false);
  $('#consultaNombre').text("");
  $('#errorStock').text("");
  $('#selectDestino').val('Seleccione Destino').trigger('change');

  /*$.ajax({
          async: true,
          type: "POST",
          url: 'Remito/mostrarDatos',
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/remito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}


$('input').on('blur keyup', function() {
    $('#mov').valid();
});


$('#ingresarRemito').click(function() {

  $('#ingresarRemito').prop('disabled', true);

  $("#mov").validate({
    //ignore: [],
        rules: {
            responsable: { required:true, minlength: 3, maxlength:50  },
            destinatario:{minlength:5, maxlength:100},
            oficio:{ minlength:5, maxlength:150 },
            datepicker: {required:true}
            //selectDestino:{required:true,notEqual:"1"}
        },
        messages: {
            responsable : {required:"Debe ingresar un responsable",minlength:"minimo 3 caracteres",maxlength:"maximo 50 caracteres"},
            destinatario: {minlength:"minimo 5 caracteres",maxlength:"maximo 100 caracteres"},
            oficio : {minlength:"minimo 5 caracteres",maxlength:"maximo 150 caracteres"},
            datepicker: "Debe ingresar Fecha"
            //selectDestino: {required:"aaaaa",notEqual:"Debe seleccionar un destino"}
        }
      });
  $("[name^=cantidad]").each(function () {
        $(this).rules("add", {
            required: true,
            number:true,
            min:1,
            specialRem:true,
            messages: {
                required: "Campo Requerido",
                number:"Debe ser numérico",
                min:"el valor debe ser mayor a 0",

            }
        });
    });


  //alert($("#mov").valid());
  if ($("#mov").valid()==true){

    if($("#selectDestino").val()!="Seleccione Destino"){
      enviarAutorizacion();
    }else{
      alert("Error debe seleccionar un destino");
      $('#ingresarRemito').prop('disabled', false);
    }
    //$('#ingresarRemito').prop('disabled', true);
  }else{
    $('#ingresarRemito').prop('disabled', false);
  }
});



function multiple(valor, multiple)
        {
            resto = valor % multiple;
            if(resto==0)
                return true;
            else
                return false;
        }


jQuery.validator.addMethod("specialRem", function (value, element) {
  //var tamano=$('#tablaPrincipal tr:gt(0)').find("td:eq(8)").text();
    var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            tamano: $(this.cells[5]).text(),
            cantidad: $(this).find("td:eq(4) input[type='text']").val()
        };
    }).get();

    var resultado=0;
    var retorno=0;
    $.each(data, function( index, val ) {
        //console.log(val.tamano);
        //console.log(index);
        //console.log(val.cantidad);
        resto = val.cantidad % val.tamano;
        //resto = val.cantidad ;
            if(resto==0){
                //console.log("true");
                //resultado=true;
                //return true;
                }
            else{
                //console.log("false");
                resultado=resultado+1;
                //return false;
                }

    });
    if (resultado>0){
      //console.log(resultado);
      return false;
    }else{
      return true;
    }
    //return resultado;
    //return resultado;
//return this.optional(element) || parseInt(value) % parseInt(val.tamano) == 0
}
//});
, 'Las cantidades deben ser multiplo del tamaño');



jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value != param;
}, "Please specify a different (non-default) value");


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
           var pie=' <div style="position:fixed;bottom:0px;width:100%;margin-left:15px;">\
                          <div><tr><td>Autoriza</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Notificado Libreria D.P.S.P</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <br>\
                          <div>Original: Archivar en D.P.S.P/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duplicado: Devolver Conformado/</div>\
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
            <div class="row">\
              <div class="col-md-3">\
              <div class="destinatario">\
                <span>DESTINATARIO:'+data[0].destinatario+'</span>\
              </div>\
              </div>\
              <div class="col-md-3">\
                <div class="oficio">\
                  <span>GEDEBA: '+data[0].oficio+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
               <div class="oficio">\
                 <span>OBSERVACIONES: '+data[0].observaciones+'</span>\
              </div>\
              </div>\
               <div style="margin-top:20px;">\
              </div>\
              </div>\
           </div>';

          var header='<img class="img-responsive" src="../theme/dist/img/salud_justicia_logo2021.png" alt="Inicio">';
          var marcaOriginal='<img  src="../theme/dist/img/original.png" style="position:absolute;opacity: 0.5;right:25px;">';
          var marcaDuplicado='<img  src="../theme/dist/img/duplicado.png" style="position:absolute;opacity: 0.5;right:25px;">';
          var td1="";
          var td2="";
          var td3="";
          var td4="";
          var td5="";


           var i=1;
          $.each(data, function( index, val ) {

                 switch (true){
                  case (i < 19):
                  td1 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>";
                  break;
                  case (i > 18 && i < 38):
                  td2 +="<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>";
                  break;
                  case (i > 37 && i < 57):
                  td3 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>";
                  break;
                  case (i > 56 && i < 76):
                  td4 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>";
                  break;
                  case (i > 75 && i < 95):
                  td5 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>";
                  break;
                 }
            i++;
          });

           var html2='<div style="bottom:200px;">\
           <table id="tablaPrincipal" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Id</th><th>Producto</th><th>Presentación</th><th>Cantidad</th><th>Tamaño</th></tr></thead>\
           <tbody>'+td1+'</tbody></table>\
          </div>';
          html2+=pie+"<div class='saltopagina'></div>";

          var html3='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <the<thead><tr><th>Id</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td2+'</tbody></table>\
          </div>';
         html3+=pie+"<div class='saltopagina'></div>";

         var html4='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Id</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td3+'</tbody></table>\
          </div>';
         html4+=pie+"<div class='saltopagina'></div>";
          var html5='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Id</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td4+'</tbody></table>\
          </div>';
         html5+=pie+"<div class='saltopagina'></div>";

          var html6='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Id</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td5+'</tbody></table>\
          </div>';
         html6+=pie+"<div class='saltopagina'></div>";


      var codigoHtmlOriginal=header+marcaOriginal+html;
           var codigoHtmlDuplicado=header+marcaDuplicado+html;
           if (td1!==""){
              codigoHtmlOriginal+=html2;
              codigoHtmlDuplicado+=html2;
                if (td2!==""){
                  codigoHtmlOriginal+=marcaOriginal+html3;
                  codigoHtmlDuplicado+=marcaDuplicado+html3;
                    if (td3!==""){
                      codigoHtmlOriginal+=marcaOriginal+html4;
                      codigoHtmlDuplicado+=marcaDuplicado+html4;
                      if (td4!==""){
                            codigoHtmlOriginal+=marcaOriginal+html5;
                            codigoHtmlDuplicado+=marcaDuplicado+html5;
                            if (td5!==""){
                                  codigoHtmlOriginal+=marcaOriginal+html6;
                                  codigoHtmlDuplicado+=marcaDuplicado+html6;
                              }
                        }
                  }
                }
           }


         $("#impresion").print({
              globalStyles: true,
              mediaPrint: true,
              stylesheet : "../theme/dist/css/imprimir.css",
              iframe: true,
              noPrintSelector : ".avoid-this",
              append: "SISTEMAS DPSP - 2019",
              prepend: codigoHtmlOriginal+codigoHtmlDuplicado,
              title: 'Sistema Libreria',
              doctype: '<!DOCTYPE html>'
          });
        })
        .fail(function() {
          alert("Error Impresion. Consulte con el administrador de sistemas.")
        });


}

$('#imp').click(function(){
  imprimir("116");
});
