var loading='<div style="margin-top:50px; margin-bottom:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>';
$(".select2").select2();
cargarSelectStock();
cargarSelectPre();
//cargarSelectCat();

$('#selectPresentacion').on("select2:select", function(e) { 
   cargarProdPorPres();
   cargarSelectArt();
   $("#tablaPrincipal").DataTable().destroy();
   
});


$('#selectProducto').on("select2:select", function(e) { 
   cargarStock();
   $("#tablaPrincipal").DataTable().destroy();
   
});

$('#resetfilter').click(function(){
  resetearForm();
});

//mostrar por lote/fecha de vencimiento el stock
$('#showall').click(function(){
  cargarTodoStock();
  var legend="";
  legend += "<div class=\"col-md-6\">";
  legend += "        <span>Por Vencer en 90 días <small class=\"leyenda yellow\">&nbsp;&nbsp;<\/small><\/span>";
  legend += "      <\/div>";
  

  $("#legend").empty().append(legend);

  $("#tablaPrincipal").DataTable().destroy();
  $("#tablaPrincipal").empty().append(loading);
  

});


//mostrar agrupado por id el stock
$('#showallid').click(function(){
  cargarTodoStockId();
  var legend="";
  legend += "      <div class=\"col-md-6\">";
  legend += "        <span>Por debajo del stock mínimo <small class=\"leyenda orange\">&nbsp;&nbsp;<\/small><\/span>";
  legend += "      <\/div>";

  $("#legend").empty().append(legend);
  $("#tablaPrincipal").DataTable().destroy();
  $("#tablaPrincipal").empty().append(loading);

});

$('#showallsin').click(function(){
  cargarSinStock();

  

});

//cargar todos los articulos con su stock

function cargarTodoStock(){
  $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getAllStock', 
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
                {
                extend: 'excelHtml5',
                orientation: 'portrait',
                pageSize: 'A4'
            },
                 {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4'
            }
       
      ]
      });
    })
    .fail(function() {
      alert("Error. Consulte con el administrador de sistemas.")
    }); 
}

function cargarSinStock(){
  $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getSinStock', 
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
    })
    .fail(function() {
      alert("error. Consulte con el administrador de sistemas.")
    }); 
}

function cargarTodoStockId(){
  $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getAllStockId', 
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
            {
                extend: 'excelHtml5',
                orientation: 'portrait',
                pageSize: 'A4'
            },
                 {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4'
            }
      ]
      });
    })
    .fail(function() {
      alert("error. Consulte con el administrador de sistemas.")
    }); 
}

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
            //data: {id_articulo: "articulo"},           
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

function cargarSelectPre()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getPresentacion', 
            cache: false,
            data: 'json',
            dataType: 'json',
      })

    
    .done(function(data) {

      var $element = $('#selectPresentacion').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var item=data[i].marca;
        var option = new Option(data[i].presentacion, data[i].presentacion, true, true);
        $element.append(option);
      }      
      var newOption = new Option("Seleccione...", "null", true, true);
      $("#selectPresentacion").append(newOption).trigger('change');  
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
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
      url:'Producto/getProductoById', 
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
        alert('El stock del Producto es 0 o no tuvo movimientos');
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


/*function drawRow(rowData,nombreTabla) {
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
    

}*/

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

  //var today=moment();
  var cant=0;
  var stkmin=0;



  $.each(rowData, function( index, value ) {
      
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

      indexlower=index.toLowerCase();

        switch(i) {
            case 3:
                cant=parseInt(valor);
                if (valor==0){
                  td="<td style='background-color:red;'>";
                }else{
                td="<td>";
              }
                break;
            // case 4:
            //     var a = moment(valor);
            //     var days = a.diff(today, 'days');
            //       if(days<90){
            //         td="<td style='background-color:yellow;'>";
            //      }else{
            //       td="<td>";
            //      }
            //     break;
            case 4:
              stkmin=parseInt(valor);
              if(cant<valor){
                td="<td style='background-color:orange;'>";
              }else{
                td="<td>";
              }
              break;
            default:
                td="<td>";
        }

      

      row.append($(td + valor  + "</td>"));


      i=i+1;
    });
    row.append($("</tr>")); 
}


function cargarProdPorPres(){
  var presentacion = $("#selectPresentacion").val(); 
    var postData = {
      'presentacion' : presentacion
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getProductoByPre', 
      cache: false,
      data: postData,
      dataType: 'json',        
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
      
        dibujarEncabezado("tablaPrincipal",arrayEncabezado);

        for (i=0;i<arrayElementos.length;i++){
          drawRow(arrayElementos[i],"tablaPrincipal",i);
        }
      }else{
        alert("No hay articulos en esa Presentacion");
        $("#tablaPrincipal").empty();
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


function cargarSelectArt()
{
  var presentacion = $("#selectProducto").val(); 
    var postData = {
      'presentacion' : presentacion
    };
  
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getProductosPre', 
            cache: false,
            data: postData,
            dataType: 'json',
      })

    
    .done(function(data) {

      var $element = $('#selectProducto').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var item=data[i].marca;
        var option = new Option(data[i].producto, data[i].id_producto, true, true);
        $element.append(option);
      }      
      var newOption = new Option("Seleccione...", "null", true, true);
      $("#selectProducto").append(newOption).trigger('change');  
      
    })
    .fail(function() {
        alert("Error. Consulte con el administrador de sistemas.")
    }); 
  
}


function resetearForm(){
  $.ajax({
          async: true,
          type: "POST",
          url: 'Producto/mostrarDatosConsulta', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_articulo: "articulo"},
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/consultaStock.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });
}