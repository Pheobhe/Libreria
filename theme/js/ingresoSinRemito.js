var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
//$("#tablaPrincipal").empty().append(loading);
var countrow=0;
$(".select2").select2();
//cargarSelectProveedor();
cargarSelectUsuario();

var xhr;
var active=false;


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
            url:'Unidad/getNombreUnidades', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_articulo: "articulo"},           
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

        var newOption = new Option(data[i].nombre, data[i].id_destino, true, true);
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
            //data: {id_articulo: "articulo"},           
      })

    
    .done(function(data) {
      
      //var $element = $('#selectUsuario').select2();
      //$element.empty();
      //$element.append(data.nombre, 0, true, true);
      //$('#selectUsuario').select2().enable(false);
      //var id=1;
      var newOption = new Option(data.nombre, data.id, true, true);
      $("#selectUsuario").append(newOption).trigger('change');

      //console.log(data.nombre);
      /*for (var i = 0; i < data.length; i++) {
        //console.log(data[i]);

        var item=data[i].nombre;
        var option = new Option(data[i].nombre, data.i, true, true);
        //console.log(option);
        $element.append(option);
      }      */
      
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
            //data: {id_articulo: "articulo"},           
      })

    
    .done(function(data) {

      var $element = $('#consultaNombre').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        //console.log(data[i]);
        var item=data[i].marca;
        var option = new Option(data[i].id_producto+" - "+data[i].producto, data[i].id_producto, true, true);
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
      'id_producto' : id
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
      console.log(valor+i);
      if(i!=8){
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
      // if(i==4){
      //   descripcion=valor;
      // }

      i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad+presentacion+descripcion);
   //var todo=id+","+articulo+","+categoria+","+presentacion+","+descripcion;
    row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+producto+"\""+",\""+presentacion+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>"));
    


}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}




function agregarPrincipal(id,producto,presentacion,tamano,inventario){
     countrow++;
     var row = $("<tr>");
     $("#tablaPrincipal").append(row); 
     
       row.append($("<td>" + id + "</td>"));
       row.append($("<td>" + producto + "</td>"));
       row.append($("<td>" + presentacion + "</td>"));
       row.append($("<td><input name='cantidad["+countrow+"]' class='cantidad' type='text'></input></td>"));
       row.append($("<td><input name='tamano["+countrow+"]' class='tamano' type='text'></input></td>"));
       row.append($("<td><input name='inventario["+countrow+"]' class='inventario' type='text'></input></td>"));
       row.append($("<td><button class='eliminar btn btn-flat btn-danger' type='button'><span class='fa fa-close'></span></button></td>"));
       row.append($("<td></td></tr></tbody>"));
    $(".consultarart").modal('hide');
    setTimeout(function() {
      $(".consultarart").modal('show');
    }, 800);
    //$('.venc').val(today);
    //Datemask dd/mm/yyyy
    $(".venc").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    $("[data-mask]").inputmask();
    /*$('.venc').datepicker({
      autoclose: true,
      format:'dd/mm/yyyy'
    });*/
    //elimina row
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



$('#ingresar').click(function() {   ///*****

  $('#ingresar').prop('disabled', true);
  if(active) { console.log("killing active"); xhr.abort(); }

  ///probar esto
  ///if(xhr && xhr.readyState != 4){
  ///          xhr.abort();
  ///}
  
  $("#mov").validate({
        rules: {
            numremito: { required: true },
            responsable: { required:true, minlength: 3, maxlength:50  },
            datepicker: {required:true}
        },
        messages: {
            numremito: "Debe ingresar motivo.",
            responsable : {required:"Debe ingresar un responsable",minlength:"minimo 3 caracteres",maxlength:"maximo 50 caracteres"},
            datepicker: "Debe ingresar Fecha"
        }
      });
  // $("[name^=lote]").each(function () {
  //       $(this).rules("add", {
  //           required: true,
  //           messages: {
  //               required: "Campo Requerido"
  //           }            
  //       });
  //   });
  // $("[name^=venc]").each(function () {
  //       $(this).rules("add", {
  //           required: true,
  //           maxDate: true,
  //           messages: {
  //               required: "Campo Requerido",
  //               maxDate: "Fecha de Vencimiento debe ser mayor a la actual"
  //           }            
  //       });
  //   });
  $("[name^=cantidad]").each(function () {
        $(this).rules("add", {
            required: true,
            number:true,
            max: 10000000,
            min: 1,
            messages: {
                required: "Campo Requerido",
                number:"Debe ser numérico",
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
                number:"Debe ser numérico",
                max: "El valor debe ser inferior a 10.000.000",
                min: "El valor debe ser superior a 0"
            }            
        });
  });
  
  $("[name^=inventario]").each(function () {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Campo Requerido"
            }            
        });
  });
  
  
  //alert($("#mov").valid());
  if ($("#mov").valid()==true){
    enviarFormulario();
    //$('#ingresar').prop('disabled', true);
  }else{
    $('#ingresar').prop('disabled', false);
  }
});

    



        
function enviarFormulario(){
  active=true;
      var cab={
            nro_remito:$("#numremito").val(),
            fec_ingreso:$("#datepicker").val(),
            id_provedor:$("#selectProveedor").val(),
            id_usuario:$("#selectUsuario").val(),
            responsable:$("#responsable").val().trim()}
    
    var data = $('#tablaPrincipal tr:gt(0)').map(function() {
        return {
            id_producto:  $(this.cells[0]).text(),
           // fec_venc: $(this).find("td:eq(5) input[type='text']").val(),
           // lote: $(this).find("td:eq(6) input[type='text']").val(), 
            cantidad: $(this).find("td:eq(3) input[type='text']").val(),
            tamano: $(this).find("td:eq(4) input[type='text']").val(),
            inventario: $(this).find("td:eq(5) input[type='text']").val(),
        };
    }).get();

    //console.log(data);
    //console.log(cab);

    if(jQuery.isEmptyObject(data)==false){
    xhr = $.ajax({
            async: true,
            type: "POST",
            url:'IngresoX/addIngresoX', 
            cache: false,
            data: 'json',
            dataType: 'json',
            data: {data: data, cab:cab},           
      })

    
    .done(function(data) {
      if(data==true){
        
        $("#result").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se Agregó Correctamente </div>');
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
                active=false;
      }else{
        alert("error");
        $('#ingresar').prop('disabled', false);
      }      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.");
        $('#ingresar').prop('disabled', false);
    });
  }else{
    alert("Error no hay articulos");
    $('#ingresar').prop('disabled', false);
  }
}


function resetForm(){
  
  var encab="";
  encab += "<thead><tr><th>Id<\/th><th>Producto<\/th><th>Descripcion<\/th><th>Total<\/th><th>Cantidad<\/th><th>Tamano<\/th><th>Inventario<\/th><\/tr><\/thead>";
  $("#tablaPrincipal").empty().append(encab);
  $("#responsable").val("");
  $('#ingresar').prop('disabled', false);
  $('#consultaNombre').text("");
  
  /*$.ajax({
          async: true,
          type: "POST",
          url: 'IngresoX/mostrarDatos', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_articulo: "articulo"},
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/farmacia/theme/js/ingresoSinRemito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}