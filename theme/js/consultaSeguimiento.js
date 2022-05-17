$(".select2").select2();
cargarSelectProductosSeguimiento();


$('#selectProducto').on("select2:select", function(e) { 
   obtenerProductoSeguimiento();
});


//Cargar Selects
function cargarSelectProductosSeguimiento()
{
  $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getNombresArtSeguimiento', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_producto: "producto"},           
      })

    
    .done(function(data) {



      var $element = $('#selectProducto').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        //var option = new Option(data[i].Producto+" | "+data[i].lote+" | "+data[i].fec_venc+" | "+data[i].inventario, data[i].id_producto+","+data[i].lote+","+data[i].fec_venc+","+data[i].inventario, true, true);
        var option = new Option(data[i].Producto , data[i].id_producto , true, true);
        $element.append(option);

      }   
      var newOption = new Option("Seleccione...", "null", true, true);
      $("#selectProducto").append(newOption).trigger('change');   
      
    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
}


function obtenerProductoSeguimiento(){
 // console.log("Aaa");


  var id_producto = $("#selectProducto").val(); 
  var partsOfStr = id_producto.split(',');
  //console.log(partsOfStr);
    var postData = {
      'id_producto' : partsOfStr[0],
      
    };
    //console.log(postData);
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/obtenerProductosByIdSeguimiento', 
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
                pageSize: 'A4',
                exportOptions: {
                  columns: [1,2,3,4,5,6,7,8,9,10,11]
                }
            }
        ]
        });
      }else{
        alert('el stock del artiulo es 0 o no tuvo movimientos');
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
                //id=valor;
                break;
            case 6:
                cant=parseInt(valor);
                if (valor==0){
                  //td="<td style='background-color:red;'>";
                }else{
                td="<td>";
              }
                break;
            case 4:
                var a = moment(valor);
                var days = a.diff(today, 'days');
                  if(days<90){
                    //td="<td style='background-color:yellow;'>";
                 }else{
                  //td="<td>";
                 }
                break;
            case 5:
                inven=valor;
                break;
            default:
                td="<td>";
        }

      

      row.append($(td + valor  + "</td>"));


      i=i+1;
    });


   
    
    row.append($("</tr>")); 
}