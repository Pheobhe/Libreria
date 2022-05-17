$(".select2").select2();
cargarSelectStock();


$('#selectProducto').on("select2:select", function(e) { 
   cargarStock();
   //$("#tablaPrincipal").DataTable().destroy();
   /*setTimeout(function() {
    $('#tablaPrincipal').DataTable({
      "destroy":true,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "pageLength": 50
    });
}, 2000);*/
});


$("#guardarInv").click(function(){
	actualizarInv();
	//cargarStock();
});


//Cargar Selects
function cargarSelectStock()
{
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

      var $element = $('#selectProducto').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var option = new Option(data[i].producto, data[i].id_producto, true, true);
        $element.append(option);
      }   
      var newOption = new Option("Seleccione...", "null", true, true);
      $("#selectProducto").append(newOption).trigger('change');   
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
}


function cargarStock(){
 // console.log("Aaa");
  var id_producto = $("#selectProducto").val(); 
    var postData = {
      'id_producto' : id_producto
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getproductoById', 
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
            /*$("#numauto").val(value.id_autorizacion);
            $("#numRem").val(value.id_egreso);
            $("#datepicker").val(value.fec_mov);
            $("#selectDestino").val(value.destino);
            $("#selectUsuario").val(value.alias);
            $("#responsable").val(value.responsable);*/
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
        /*for (var i = 0 ;i<1;i++) {
          $('td:nth-child('+i+')').hide();
          $('td:nth-child('+i+'),th:nth-child('+i+')').hide();
        }*/
        
      }else{
      	alert('el stock del artiulo es 0 o no tuvo movimientos');
      }
    })
    .fail(function() {
      alert("Error en asignarSeguimiento.js. Consulte con el administrador de sistemas.")
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
    encabezado +="<th>Cambiar</th></thead></tr>";

    //contenido="<thead><tr><th>LEGAJO</th><th>APELLIDOS</th><th>NOMBRES</th><th>FECHA NACIMIENTO</th><th>DNI</th><th>FECHA POS</th><th>TITULO</th><th>DESTINO</th></tr></head>";
    $("#"+nombreTabla).empty().append(encabezado);
    //console.log(encabezado);
}


function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}


function drawRow(rowData,nombreTabla,indice) {
  var row = $("<tr id=fila"+indice+">");
  var valor;
  var i=0;
  $("#"+nombreTabla).append(row); 
  var indexlower;
  var td="<td>";

  var today=moment();
  var cant=0;
  var stkmin=0;
  


  $.each(rowData, function( index, value ) {
      
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      indexlower=index.toLowerCase();

        switch(i) {
        	case 0:
                id=valor;
                break;
            case 1:
                cant=parseInt(valor);
                if (valor==0){
                  td="<td style='background-color:red;'>";
                }else{
                td="<td>";
              }
                break;
          
            case 2:
                //var a = moment(valor);
                fec_venc=valor;
                //var days = a.diff(today, 'days');
                //  if(days<90){
                //    td="<td style='background-color:yellow;'>";
                // }else{
                //  td="<td>";
                // }
                break;
          
           
            default:
                td="<td>";
        }


      row.append($(td + valor  + "</td>"));


      i=i+1;
    });


  	row.append($("<td><button data-toggle='modal' data-target='.consultarRem' type='button'  onclick='asignarSeguimiento(\""+id+"\")'  class='btn seleccionar btn-default '><span class='fa fa-check-circle-o'></span></button></td></tr></tbody>")); 
    
    row.append($("</tr>")); 
}


function asignarSeguimiento(id){
  //$("#inventario").empty();
  //$("#feclotevenctaminv").val("");
  var id_producto = id; 
    var postData = {
      'id_producto' : id_producto,
      
    };
    var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>';
    $("#tablaConsulta").empty().append(loading);
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/setSeguimiento', 
      cache: false,
      data: postData,
      dataType: 'json',        
    })
    .done(function(data) {
      
      if (data==true){
        $("#resultado").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se asignó Correctamente </div>');
        window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                  });
                    
                  $('.alert .close').on("click", function(e){
                        $(this).parent().fadeTo(500, 0).slideUp(500);
                  });

                  $(".consultarRem").modal('hide');
                  }, 2000);
                }else{
                  $("#resultado").html('<div class="alert alert-danger"><button type="button" class="close">×</button>El Producto ya está en seguimiento. </div>');
                  window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                              $(this).remove(); 
                    });
                      
                    $('.alert .close').on("click", function(e){
                          $(this).parent().fadeTo(500, 0).slideUp(500);
                    });

                    $(".consultarRem").modal('hide');
                  }, 2000);
                }

    })
    .fail(function() {
      alert("error. Consulte con el administrador de sistemas.");
    }); 

}



