$('#buscarArtDes').click(function(){
  enviarFormularioArtDes();
  //$("#tablaPrincipal").DataTable().destroy();
});

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



function enviarFormularioArtDes(){
	var fechaIn = $("#fechaIn").val();
  	var fechaFin= $("#fechaFin").val(); 
    var postData = {
      'fechaIn' : fechaIn,
      'fechaFin': fechaFin
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/dobleEntrada', 
      cache: false,
      data:postData,
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
              {
                extend: 'excelHtml5',
                orientation: 'portrait',
                pageSize: 'A4'
            }
        ]
        });
        
      }else{
        alert("no hay datos entre las fechas seleccionadas");
      }
    })
    .fail(function() {
      alert("Error 94. Consulte con el administrador de sistemas.")
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
     
}