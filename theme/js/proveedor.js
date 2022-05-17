

//Inicializar
var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
$("#tablaPrincipal").empty().append(loading);
$(".select2").select2();
cargarProveedores();




//onClick boton del menu proveedor
$("#proveedor").click(function() {
  cargarProveedores();
});


//Funciones Consultar

        
//carga de select en consulta
$('#consultar').click(function(){
  cargarSelectNombreProveedores();
});


$('#consultaNombre').on("select2:select", function(e) { 
   consultarProveedoresNombre();
});


function cargarSelectNombreProveedores(){
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Proveedor/getNombreProveedores', 
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
        var option = new Option(data[i].nombre, data.i, true, true);
        //console.log(option);
        $element.append(option);
      }      
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

function consultarProveedoresNombre(){
  var nombre = $("#consultaNombre").val(); 
  var postData = {
      'nombre' : nombre
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Proveedor/getProveedoresNombre', 
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


//Funciones Tablas
function cargarProveedores(){
  $.ajax({
      async: true,
      type: "POST",
      url:'Proveedor/getProveedores', 
      cache: false,
      data: 'json',
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
        dibujarEncabezado("tablaPrincipal",arrayEncabezado);
        //dibujarEncabezado("example1",arrayEncabezado);
        for (i=0;i<arrayElementos.length;i++){
          drawRow(arrayElementos[i],"tablaPrincipal");
          //drawRow(arrayElementos[i],"example1");
        }
      }
      $('#tablaPrincipal').DataTable({
      "destroy":true,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "pageLength": 15,
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
    encabezado +="</thead></tr>";

    //contenido="<thead><tr><th>LEGAJO</th><th>APELLIDOS</th><th>NOMBRES</th><th>FECHA NACIMIENTO</th><th>DNI</th><th>FECHA POS</th><th>TITULO</th><th>DESTINO</th></tr></head>";
    $("#"+nombreTabla).empty().append(encabezado);
    //console.log(encabezado);
}

function drawRow(rowData,nombreTabla) {
  var row = $("<tr>");
  var valor;
  $("#"+nombreTabla).append(row); 
  var indexlower;

  $.each(rowData, function( index, value ) {
      //console.log( value );
      
      //Transformar null en -
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      indexlower=index.toLowerCase();
     // if(indexlower.indexOf("fecha")>=0){valor=transformarDate(value)}


      row.append($("<td>" + valor  + "</td>"));
    });
    row.append($("</tr>")); 
}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();
}