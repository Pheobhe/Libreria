//carga elementos del dashboard
var ingresos=0;
var autorizaciones=0;
var egresos=0;
var devoluciones=0;
cargarUltimosIngresos();
getCantidadDashboard();
//getNotificacionVencer();


$('#acerca').click(function(){
  $('#modalAcerca').modal('show');
});

$('#footerAcerca').click(function(){
  $('#modalAcerca').modal('show');
});

// $('#artPorVencer').click(function(){
//   $('#modalNotifiacion').modal('show');
//   getNotificacionVencer();
//   $("#tablaNotificacion").empty();
  
// });

// $('#artvencerwidget').click(function(){
//   $('#modalNotifiacion').modal('show');
//   getNotificacionVencer();
//   $("#tablaNotificacion").empty();
  
// });

$('#artStockMin').click(function(){
  $('#modalNotifiacion2').modal('show');
  getStockMin();
  $("#tablaNotificacion2").empty();
  //$("#tablaNotificacion2").DataTable().destroy();
});

$('#artstockminwidget').click(function(){
  $('#modalNotifiacion2').modal('show');
  getStockMin();
  $("#tablaNotificacion2").empty();
  //$("#tablaNotificacion2").DataTable().destroy();
});



$('#artSinStock').click(function(){
  $('#modalNotifiacion3').modal('show');
  getSinStock();
  $("#tablaNotificacion3").empty();
  //$("#tablaNotificacion2").DataTable().destroy();
});

$('#artsinstockwidget').click(function(){
  $('#modalNotifiacion3').modal('show');
  getSinStock();
  $("#tablaNotificacion3").empty();
  //$("#tablaNotificacion2").DataTable().destroy();
});



function getCantidadDashboard(){
   $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getCantidadDashboard', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_articulo: "articulo"},
      })
    .done(function(data) {
      //console.log(data);
      if(!$.isEmptyObject(data)){
        var html="<span class='pull-right-container'><small class='label pull-right bg-blue'>"+data.producto+"</small></span>";
        $('#productos').append(html);
        $('#cantProductos').empty().append(data.producto);
        $('#cantIngresos').empty().append(data.ingresos);
        $('#cantAuts').empty().append(data.autorizaciones);
        $('#cantEgresos').empty().append(data.remitos);
        $("#spanEgr").append(((data.remitos*100/(+data.ingresos+data.remitos+data.autorizaciones+data.devoluciones)).toFixed(2))+"%");
        $("#spanIng").append(((data.ingresos*100/(+data.ingresos+data.remitos+data.autorizaciones+data.devoluciones)).toFixed(2))+"%");
        $("#spanAut").append(((data.autorizaciones*100/(+data.ingresos+data.remitos+data.autorizaciones+data.devoluciones)).toFixed(2))+"%");
        $("#spanDev").append(((data.devoluciones*100/(+data.ingresos+data.remitos+data.autorizaciones+data.devoluciones)).toFixed(2))+"%");
        $("#artsinstockspan").append(data.sinstock);
        $("#artstockminspan").append(data.stockmin);
        //$("#artporvencerspan").append(data.artvencer);
        //graficar(data);
      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
}


// function graficar(data){
//     //-------------
//           //- PIE CHART -
//           //-------------
//           // Get context with jQuery - using jQuery's .get() method.
//           var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
//           var pieChart = new Chart(pieChartCanvas);
//           var PieData = [
//             {
//               value: data.ingresos,
//               color: "#f56954",
//               highlight: "#f56954",
//               label: "Movimientos"
//             },
//             {
//               value: data.autorizaciones,
//               color: "#00B7C6",
//               highlight: "#00B7C6",
//               label: "Autorizaciones"
//             },
//             {
//               value: data.remitos,
//               color: "#f39c12",
//               highlight: "#f39c12",
//               label: "Remitos"
//             },
//             {
//               value: data.devoluciones,
//               color: "#00c0ef",
//               highlight: "#00c0ef",
//               label: "Devoluciones"
//             }
//           ];
//           var pieOptions = {
//             //Boolean - Whether we should show a stroke on each segment
//             segmentShowStroke: true,
//             //String - The colour of each segment stroke
//             segmentStrokeColor: "#fff",
//             //Number - The width of each segment stroke
//             segmentStrokeWidth: 1,
//             //Number - The percentage of the chart that we cut out of the middle
//             percentageInnerCutout: 50, // This is 0 for Pie charts
//             //Number - Amount of animation steps
//             animationSteps: 100,
//             //String - Animation easing effect
//             animationEasing: "easeOutBounce",
//             //Boolean - Whether we animate the rotation of the Doughnut
//             animateRotate: true,
//             //Boolean - Whether we animate scaling the Doughnut from the centre
//             animateScale: false,
//             //Boolean - whether to make the chart responsive to window resizing
//             responsive: true,
//             // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
//             maintainAspectRatio: false,
//             //String - A legend template
//             legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
//             //String - A tooltip template
//             tooltipTemplate: "<%=value %> <%=label%> "
//           };
//           //Create pie or douhnut chart
//           // You can switch between pie and douhnut using the method below.
//           pieChart.Doughnut(PieData, pieOptions);
// }

function cargarUltimosIngresos(){
  $.ajax({
            async: true,
            type: "POST",
            url:'Movimiento/getUltimosIngresos', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_articulo: "articulo"},
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){

        for (i = 0; i < 4; i++) { 
          //$("#ultimoIngreso"+i).append("ID: "+data[i].id_producto+"&nbsp;"+data[i].producto);
          //$("#ultimoIngresoPre"+i).append(data[i].presentacion);
         // $("#ultimoIngresoCant"+i).append(data[i].cantidad);
        }
      }
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
}


// function cargarUltimosIngresos(){
//   $.ajax({
//             async: true,
//             type: "POST",
//             url:'Movimiento/getUltimosIngresos', 
//             cache: false,
//             data: 'json',
//             dataType: 'json',
//             //data: {id_producto: "producto"},
//       })
//     .done(function(data) {
//       if(!$.isEmptyObject(data)){

//         for (i = 0; i < 4; i++) { 
//           $("#ultimoIngreso"+i).append("ID: "+data[i].id_producto+"&nbsp;"+data[i].producto);
//           $("#ultimoIngresoCat"+i).append(data[i].presentacion);
//           $("#ultimoIngresoCant"+i).append(data[i].cantidad);
//         }
//       }
//     })
//     .fail(function() {
//         alert("error. Consulte con el administrador de sistemas.")
//     }); 
// }


// function getNotificacionVencer(){
//   $.ajax({
//             async: true,
//             type: "POST",
//             url:'Producto/getNotificacionVencer', 
//             cache: false,
//             data: 'json',
//             dataType: 'json',
//             //data: {id_articulo: "articulo"},
//       })
//     .done(function(data) {
//       if(!$.isEmptyObject(data)){
//         var i=0;
//         var arrayEncabezado = [];
//         var arrayElementos= [];
//         $.each(data,function(key,value){
//           if (i===0){
//             for (i=0;i<Object.keys(value).length;i++){
//               arrayEncabezado[i] = Object.keys(value)[i];//lleno el encabezado de la tabla
//             }
//             i=1;
//           }
//           arrayElementos.push(value);
//         })
//         dibujarEncabezado("tablaNotificacion",arrayEncabezado);
        
//         for (i=0;i<arrayElementos.length;i++){
//           drawRowVencer(arrayElementos[i],"tablaNotificacion");
//         }
//       }
//       $("#tablaNotificacion").DataTable().destroy();
//       $('#tablaNotificacion').DataTable({
//       "destroy":true,
//       "paging": true,
//       "lengthChange": false,
//       "searching": true,
//       "ordering": true,
//       "info": true,
//       "autoWidth": true,
//       "pageLength": 50,
//       dom: 'Bfrtip',
//       buttons: [
//             'excelHtml5',
//             'pdfHtml5'
//       ]
//       });

//     })
//     .fail(function() {
//         alert("error. Consulte con el administrador de sistemas.")
//     }); 
// }

function getStockMin(){
  $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getStockMin', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_articulo: "articulo"},
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
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
        dibujarEncabezado("tablaNotificacion2",arrayEncabezado);
        
        for (i=0;i<arrayElementos.length;i++){
          drawRowStock(arrayElementos[i],"tablaNotificacion2");
        }
      }
       $("#tablaNotificacion2").DataTable().destroy();
      $('#tablaNotificacion2').DataTable({
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


function getSinStock(){
  $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getSinStock', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_articulo: "articulo"},
      })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
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
        dibujarEncabezado("tablaNotificacion3",arrayEncabezado);
        
        for (i=0;i<arrayElementos.length;i++){
          drawRowStock(arrayElementos[i],"tablaNotificacion3");
        }
      }
      $("#tablaNotificacion3").DataTable().destroy();
      $('#tablaNotificacion3').DataTable({
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


function cargarImagenes(){
  var id=$(".id_usuario").val();
  console.log("id_usuario: "+id);
  $.ajax({
      url: "Usuario/obtenerImagenPerfil",
      type: "POST",
      dataType: "json",
      data: id_usuario=id,
      cache: false 
    }).success(function(data){
     $('.imagenPerfil').attr('src',data); 
    });
}
$( document ).ready(function() {
   // cargarImagenes();
});


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



function drawRowVencer(rowData,nombreTabla) {
  var row = $("<tr>");
  var valor;
  $("#"+nombreTabla).append(row); 
  var indexlower;
  var i=0;

  $.each(rowData, function( index, value ) {
      //console.log( value );
      
      //Transformar null en -
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      indexlower=index.toLowerCase();
     // if(indexlower.indexOf("fecha")>=0){valor=transformarDate(value)}

      if (i==4){
        row.append($("<td style='background-color:yellow;'>" + valor  + "</td>"));
      }else{
        row.append($("<td>" + valor  + "</td>"));
      }



      
      i++;
    });
    row.append($("</tr>")); 
}


function drawRowStock(rowData,nombreTabla) {
  var row = $("<tr>");
  var valor;
  $("#"+nombreTabla).append(row); 
  var indexlower;
  var i=0;

  $.each(rowData, function( index, value ) {
      //console.log( value );
      
      //Transformar null en -
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      indexlower=index.toLowerCase();
     // if(indexlower.indexOf("fecha")>=0){valor=transformarDate(value)}

      
        row.append($("<td>" + valor  + "</td>"));
      i++;
    });
    row.append($("</tr>")); 
}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();
  
}