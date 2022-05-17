//$(".select2").select2();
cargarSelectRemitos();
var usuario="";
var responsable="";

getUser();

$('#selectAutorizacion').on("select2:select", function(e) { 
   cargarRemitos();
});


//Cargar Selects
function cargarSelectRemitos()
{
  $("#selectAutorizacion").select2({
    placeholder:"Seleccione Remito...",
    language:{
       noResults: function(){
           return "<a href='#' class='btn btn-danger'>Resultado no encontrado. Por favor ingrese número.</a>";
       }
    },
    ajax:{
      url: 'CerrarRemito/getRemitosSelect2Old',
      dataType:'json',
      delay:250,
      processResults: function (data) {
          return {
              results: $.map(data.results, function(results) {
                //alert(data.results.id_autorizacion);
                  return { id: results.id_egreso, text: results.id_egreso };
              })
          };
      },
      cache:true
    },
    escapeMarkup: function (markup) {
        return markup;
    }
  });
}


function cargarRemitos(){
  var id_egreso = $("#selectAutorizacion").val(); 
    var postData = {
      'id_egreso' : id_egreso
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'CerrarRemito/getRemitoByIdOld', 
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
            $("#numauto").val(value.id_autorizacion);
            $("#numRem").val(value.id_egreso);
            $("#datepicker").val(value.fec_mov);
            $("#selectDestino").val(value.destino);
            $("#selectUsuario").val(value.alias);
            $("#responsable").val(value.responsable);
            $("#observaciones").val(value.observaciones);
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
        for (var i = 0 ;i<7;i++) {
          $('td:nth-child('+i+')').hide();
          $('td:nth-child('+i+'),th:nth-child('+i+')').hide();
        }
        
      }
    })
    .fail(function() {
      alert("Error 98.js . Consulte con el administrador de sistemas.")
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
      i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad);
    //row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+marca+"\""+",\""+nombre+"\""+",\""+droga+"\",\""+unidad+"\",\""+descripcion+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>")); 
    


}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}


function getUser(){
    $.ajax({
            async: true,
            type: "POST",
            url:'Login/getCurrentUser', 
            cache: false,
            data: 'json',
            dataType: 'json',
                   
      })
    .done(function(data) {
      usuario=data.id;
      responsable=data.nombre;

    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
}

function resetearForm(){
  $.ajax({
          async: true,
          type: "POST",
          url: 'CerrarRemito/mostrarDatos', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/cerrarRemito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });
}