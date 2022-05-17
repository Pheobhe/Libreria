var today = moment().format('DD/MM/YYYY');
$('#fechaIn').val(today);
$('#fechaFin').val(today);

//Datemask dd/mm/yyyy
$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

$("[data-mask]").inputmask();

//Date picker
    $('#fechaIn').datepicker({
      autoclose: true,
      format:'dd/mm/yyyy',
      language:'es'

    });
     $('#fechaFin').datepicker({
      autoclose: true,
      format:'dd/mm/yyyy',
      language:'es'

    });

$('#buscar').click(function(){
  enviarFormulario();
  $("#tablaPrincipal").DataTable().destroy();
  
});


function enviarFormulario(){
 // console.log("Aaa");
  var fechaIn = $("#fechaIn").val();
  var fechaFin= $("#fechaFin").val(); 
    var postData = {
      'fechaIn' : fechaIn,
      'fechaFin': fechaFin
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Movimiento/getMovimientoOByFecha',   
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

        dibujarEncabezado("tablaPrincipal",arrayEncabezado);
       
        for (i=0;i<arrayElementos.length;i++){
          drawRow(arrayElementos[i],"tablaPrincipal");
          //drawRow(arrayElementos[i],"example1");
        }
        //esconder las primeras 6 columnas de la tabla
        
      }else{
        alert("no hay datos entre las fechas seleccionadas");
      }
      $('#tablaPrincipal').DataTable({
      "destroy":true,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "pageLength": 10,
      dom: 'Bfrtip',
      buttons: [
            'excelHtml5',
            'pdfHtml5'
      ]
      });
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
    if(nombreTabla=="tablaPrincipal"){
      encabezado+="<th>Detalle</th>";
    }
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



      if (i==0){
        id=value;
      }
      if (i==2){
        valor=moment(value).format('DD/MM/YYYY');
      }

      row.append($("<td>" + valor + "</td>"));
      i=i+1;
    });
    //console.log(datos);
    
    row.append($("<td><button data-toggle='modal' data-target='.consultarRem' type='button'  onclick='verMovimiento("+id+")'  class='btn seleccionar btn-default '><span class='fa fa-list'></span></button></td></tr></tbody>")); 
    


}


function drawRowSinBoton(rowData,nombreTabla) {
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
    //console.log(id+marca+nombre+droga+unidad);
    //row.append($("<td><button data-toggle='modal' data-target='.consultarRem' type='button'  onclick='verRemito("+id+")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>")); 
    


}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}


function verMovimiento(id){
  var id_ingreso = id; 
    var postData = {
      'id_ingreso' : id_ingreso
    };
    var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>';
    $("#tablaConsulta").empty().append(loading);
    $.ajax({
      async: true,
      type: "POST",
      url:'Movimiento/getMovimientooById', 
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
          
          i=i+1;
        })

        dibujarEncabezado("tablaConsulta",arrayEncabezado);
       
        for (i=0;i<arrayElementos.length;i++){
          drawRowSinBoton(arrayElementos[i],"tablaConsulta");
          //drawRow(arrayElementos[i],"example1");
        }
        //esconder las primeras 6 columnas de la tabla
        for (var i = 0 ;i<7;i++) {
          $('#tablaConsulta td:nth-child('+i+')').hide();
          $('#tablaConsulta td:nth-child('+i+'),#tablaConsulta th:nth-child('+i+')').hide();
        }
        
      }
    })
    .fail(function() {
      alert("error. Consulte con el administrador de sistemas.")
    }); 

}