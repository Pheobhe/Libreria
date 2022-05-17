var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
$("#tablaPrincipal").empty().append(loading);




//Initialize Select2 Elements


$(".select2").select2();
cargarTodo();
//actualizarCantidadArt();
actualizarCantidadPro();
/*
$("#Productos").click(function() {

  cargarTodo();
  actualizarCantidadArt();
  cargarSelect();  
});
*/


//Carga de select en nuevo
$('#newArt').click(function(){
  cargarSelect();
});

//carga de select en consulta
$('#consultarArt').click(function(){
  cargarSelectNombreArt();
});


function cargarTodo(){
  $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getProductos', 
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
        



function consultarArtNombre()
{
  var nombre = $("#consultaNombre").val(); 
  var postData = {
      'producto' : nombre
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getProductosNombre', 
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
$('#enviarConsulta').click(function()
{
  consultarArtNombre();
});

$('#consultaNombre').on("select2:select", function(e) { 
   consultarArtNombre();
});





function actualizarCantidadPro()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getCantidadProductos', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},           
      })

    
    .done(function(data) {
      if(!$.isEmptyObject(data)){
        var html="<span class='pull-right-container'><small class='label pull-right bg-blue'>"+data.cantidad+"</small></span>";
        $('#producto').append(html);
        $('.bg-green').empty().append(data.cantidad);
      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

// function cargarSelect()
// {
//   $(function () {
//      $.ajax({
//             async: true,
//             type: "POST",
//             url:'Producto/getMarcas', 
//             cache: false,
//             data: 'json',
//             dataType: 'json',
//             //data: {id_producto: "producto"},               
//       })

    
//     .done(function(data) {

//       var $element = $('#marca').select2();
//       $element.empty();
//       for (var i = 0; i < data.length; i++) {
//         //console.log(data[i]);
//         var item=data[i].marca;
//         var option = new Option(data[i].marca, data.i, true, true);
//         //console.log(option);
//         $element.append(option);
//       }      
      
//     })
//     .fail(function() {
//         alert("error. Consulte con el administrador de sistemas.")
//     }); 
//   });
// }


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
        var option = new Option(data[i].producto, data.i, true, true);
        //console.log(option);
        $element.append(option);
      }      
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}