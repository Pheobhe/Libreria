$(".select2").select2();
cargarSelectDestino();


$('#selectDestino').on("select2:select", function(e) { 
   obtenerProductoDestino();
});



//Cargar Selects
function cargarSelectDestino()
{
  $.ajax({
            async: true,
            type: "POST",
            url:'Unidad/getNombreUnidades', 
            cache: false,
            data: 'json',
            dataType: 'json',
                      
      })

    
    .done(function(data) {

      var $element = $('#selectDestino').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var option = new Option(data[i].nombre, data[i].nombre, true, true);
        $element.append(option);
      }   
      var newOption = new Option("Seleccione...", "null", true, true);
      $("#selectDestino").append(newOption).trigger('change');   
      
    })
    .fail(function() {
        alert("Error38. Consulte con el administrador de sistemas.")
    }); 
}


function obtenerProductoDestino(){
 // console.log("Aaa");
  var id_destino = $("#selectDestino").val(); 
    var postData = {
      'id_destino' : id_destino
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/obtenerProductosByDestino', 
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
        alert('El stock del artiulo es 0 o no tuvo movimientos');
      }
    })
    .fail(function() {
      alert("Error 125cdjs. Consulte con el administrador de sistemas.")
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
                  td="<td style='background-color:red;'>";
                }else{
                td="<td>";
              }
                break;
            case 4:
                var a = moment(valor);
                var days = a.diff(today, 'days');
                  if(days<90){
                    td="<td style='background-color:yellow;'>";
                 }else{
                  td="<td>";
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


    row.append($("<td><button data-toggle='modal' data-target='.consultarRem' type='button'  onclick='cambiarInv(\""+inven+"\")'  class='btn seleccionar btn-default '><span class='fa fa-list'></span></button></td></tr></tbody>")); 
    
    row.append($("</tr>")); 
}


//Funciones DATEPICKER
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
  //$("#tablaPrincipal").DataTable().destroy();
  
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
      url:'Producto/getProductosByFecha', 
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


      }
      else{
        alert("no hay datos entre las fechas seleccionadas");
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
    //if(nombreTabla=="tablaPrincipal"){
      //encabezado+="<th>Detalle</th>";
    //}
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
     

      row.append($("<td>" + valor + "</td>"));
      i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad+descripcion);
    //row.append($("<td><button data-toggle='modal' data-target='.consultarRem' type='button'  onclick='verRemito("+id+")'  class='btn seleccionar btn-default '><span class='fa fa-list'></span></button></td></tr></tbody>")); 
    


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
    //console.log(id+marca+nombre+droga+unidad+descripcion);
    //row.append($("<td><button data-toggle='modal' data-target='.consultarRem' type='button'  onclick='verRemito("+id+")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>")); 
    


}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}


