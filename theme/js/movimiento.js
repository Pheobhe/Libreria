
//alert("Hola Movimiento.js"); func OK

var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
//$("#tablaPrincipal").empty().append(loading);
var countrow=0;
$(".select2").select2();
cargarSelectProveedor();
cargarSelectUsuario();



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
  cargarSelectNombreArt();
});


$('#consultaNombre').on("select2:select", function(e) { 
   consultarArtNombre();
});



//Cargar Selects

function cargarSelectProveedor()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Movimiento/getProveedores', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},           
      })

    
    .done(function(data) {

      var $element = $('#selectProveedor').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        //console.log(data[i]);
        //var item=data[i].nombre;
        //var option = new Option(data[i].id_proveedor, data[i].id_proveedor, true, true);
        //console.log(option);
        //$element.append(option);

        var newOption = new Option(data[i].nombre, data[i].id_provedor, true, true);
        $("#selectProveedor").append(newOption).trigger('change');
      }      
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}


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
      
      //var $element = $('#selectUsuario').select2();
      //$element.empty();
      //$element.append(data.nombre, 0, true, true);
      //$('#selectUsuario').select2().enable(false);
      //var id=1;
      var newOption = new Option(data.nombre, data.id, true, true);
      $("#selectUsuario").append(newOption).trigger('change');
  
      
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
            url:'Producto/getNombresArt', 
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
        var option = new Option(data[i].producto, data[i].id_producto, true, true);
        //console.log(option);
        $element.append(option);
      }      
      var option2 = new Option("Seleccione...", "null", true, true);
      $("#consultaNombre").append(option2).trigger('change');  
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

function consultarArtNombre()
{
  var id = $("#consultaNombre").val(); 
  var postData = {
      'id_producto' : id  //aca era 'id' :id yo lo modifique lklk
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getproductosId', 
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
          drawRow(arrayElementos[i],"tablaConsulta");
          //drawRow(arrayElementos[i],"example1");
        }
      }
    })
    .fail(function() {
      alert("Error. Consulte con el administrador de sistemas.")
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
      console.log(valor+i);
      if(i!=4){      //8
        datos.push(valor);
      }

      if(i==0){
        id=valor;
      }
       if(i==1){
        producto=valor;
        producto = producto.replace(/"/g, '\\"');//escapa comillas dobles en el nombre
      }
      if(i==2){
        presentacion=valor;
      }
      
     i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad+descripcion);
    row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+producto+"\""+",\""+presentacion+"\""+")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>")); 

}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}


function agregarPrincipal(id,producto,presentacion,tamano){    //agrega los productos a movimiento y o remito
     countrow++;
     var row = $("<tr>");
     $("#tablaPrincipal").append(row); 
     
       row.append($("<td>" + id + "</td>"));
       row.append($("<td>" + producto + "</td>"));
       row.append($("<td>" + presentacion + "</td>"));
       row.append($("<td><input name='cantidad["+countrow+"]' class='cantidad' type='text'></input></td>"));
       row.append($("<td><input name='tamano["+countrow+"]' class='tamano' type='text' ></input></td>"));
      row.append($("<td><input name='inventario["+countrow+"]' class='inventario' type='text'></input></td>"));
       row.append($("<td><button class='eliminar btn btn-flat btn-danger' type='button'><span class='fa fa-close'></span></button></td>"));
       row.append($("<td></td></tr></tbody>"));
    $(".consultarart").modal('hide');
    setTimeout(function() {
      $(".consultarart").modal('show');
    }, 800);

    $('.eliminar').click(DeleteRow);
}

function DeleteRow(){
  $(this).parents('tr').first().remove();
}


$.validator.addMethod("maxDate", function(value, element) {
    var SpecialToDate = value; // DD/MM/YYYY

    var SpecialTo = moment(SpecialToDate, "DD/MM/YYYY");
    if (moment() < SpecialTo) {
        return true;
    } else {
        return false;
    }
}, "Invalid Date!"); 


//validation code

$('#ingresar').click(function() {

  $('#ingresar').prop('disabled', true);
  
  $("#mov").validate({
        rules: {
            numremito: { required: true, number:true},
            responsable: { required:true, minlength: 3, maxlength:50  },
            datepicker: {required:true}
        },
        messages: {
            numremito: "Debe ingresar numero.",
            responsable : {required:"Debe ingresar un responsable",minlength:"minimo 3 caracteres",maxlength:"maximo 50 caracteres"},
            datepicker: "Debe ingresar Fecha"
        }
      });
  
  $("[name^=cantidad]").each(function () {
        $(this).rules("add", {
            required: true,
            number:true,
            max: 10000000,
            min: 1,
            specialMov:true,
            messages: {
                required: "Campo Requerido",
                number:"Debe ser num??rico",
                max: "El valor debe ser inferior a 10.000.000",
                min: "El valor debe ser superior a 0"
            }            
        });
    });

  $("[name^=tamano]").each(function () {
        $(this).rules("add", {
            required: true,
            number:true,
            max: 10000000,
            min: 1,
            messages: {
                required: "Campo Requerido",
                number:"Debe ser num??rico",
                max: "El valor debe ser inferior a 10.000.000",
                min: "El valor debe ser superior a 0"
            }            
        });
    });
  
  //alert($("#mov").valid());
  if ($("#mov").valid()==true){
   // var rep=checkRepetido();
    checkRepetido();
    //enviarFormulario();
    //$('#ingresar').prop('disabled', true);
  }else{
    $('#ingresar').prop('disabled', false);
  }
});


jQuery.validator.addMethod("specialMov", function (value, element) {
    var tamano=$('#tablaPrincipal tr:gt(0)').find("td:eq(4)").text();
    var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            tamano: $(this).find("td:eq(4) input[type='text']").val(),
            cantidad: $(this).find("td:eq(3) input[type='text']").val()
        };
    }).get();

    var resultado=0;
    var retorno=0;
    $.each(data, function( index, val ) {    
        //console.log(val.tamano);
        //console.log(index);
        //console.log(val.cantidad);
        resto = val.cantidad % val.tamano;
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
    
}, 'Las cantidades deben ser multiplo del tama??o');



function checkRepetido(){
  
  var cab={
            nro_remito:$("#numremito").val(),
            id_provedor:$("#selectProveedor").val()}
            

  $.ajax({
            async: true,//importante
            type: "POST",
            url:'Movimiento/checkRepetido', 
            cache: false,
            data: 'json',
            dataType: 'json',
            data: {cab:cab},           
      })

    
    .done(function(data) {
      if (data==false){
      alert("el numero de remito para ese proveedor ya existe");
      $('#ingresar').prop('disabled', false);
    }else{ enviarFormulario(); }

    })
    .fail(function() {
        alert("error de conexion. Consulte con el administrador de sistemas.")
        $('#ingresar').prop('disabled', false);
    });


}


function enviarFormulario(){
      var cab={
            nro_remito:$("#numremito").val(),
            fec_ingreso:$("#datepicker").val(), //1
            id_provedor:$("#selectProveedor").val(), //2
            id_usuario:$("#selectUsuario").val(), //3
            responsable:$("#responsable").val().trim()}  //4
    
    var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:$(this.cells[0]).text(),
            //cantidad: $(this.cells[4]).text(),
            cantidad:$(this).find("td:eq(3) input[type='text']").val(),
            tamano:$(this).find("td:eq(4) input[type='text']").val(),
            inventario:$(this).find("td:eq(5) input[type='text']").val(),
        };
    }).get();

    //console.log(data);
    //console.log(cab);

    if(jQuery.isEmptyObject(data)==false){
    $.ajax({
            async: true,
            type: "POST",
            url:'Movimiento/addMovimiento', 
            cache: false,
            data: 'json',
            dataType: 'json',
            data: {data: data, cab:cab},           
      })

    
    .done(function(data) {
      if(data==true){
        $("#result").html('<div class="alert alert-success"><button type="button" class="close">??</button>Se Agreg?? Correctamente </div>');
                window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                  });
                    
                  $('.alert .close').on("click", function(e){
                        $(this).parent().fadeTo(500, 0).slideUp(500);
                  });

                  resetForm();
                  //imprimir(data);
                }, 3000);
      }else{
        alert("Error 488");
        $('#ingresar').prop('disabled', false);
      }      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    });
  }else{
    alert("Error no hay Productos");
    $('#ingresar').prop('disabled', false);
  }
}


function resetForm(){
  var encab="";
  encab += "<thead><tr><th>Codigo<\/th><th>Producto<\/th><th>Presentaci??n<\/th><th>Cantidad<\/th><th>Tama??o<\/th><\/tr><\/thead>";
  $("#tablaPrincipal").empty().append(encab);
  $("#responsable").val("");
  $("#numremito").val("");
  $('#ingresar').prop('disabled', false);
  $('#consultaNombre').text("");
  /*
  $.ajax({
          async: true,
          type: "POST",
          url: 'Movimiento/mostrarDatos', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/movimiento.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });
        */
}