$(".select2").select2();
cargarSelectAutorizaciones();
var usuario="";
var responsable="RESPONSABLE";

getUser();

$('#selectAutorizacion').on("select2:select", function(e) { 
   cargarAutorizaciones();
});

$('#cerrar').click(function(){

  $('#cerrar').prop('disabled', true);

  $("#close").validate({
        rules: {            
            responsableRem: { required:true, minlength: 3, maxlength:50  }
        },
        messages: {
            responsableRem : {required:"Debe ingresar un responsable",minlength:"minimo 3 caracteres",maxlength:"maximo 50 caracteres"}
        }
      });
  if ($("#close").valid()==true){
    if ($("#numauto").val()>0){
      cerrar($("#numauto").val(),usuario,$('#responsableRem').val().trim());
    }else{
      alert("debe seleccionar Autorizacion a cerrar");
      $('#cerrar').prop('disabled', false);
    }
  }else{
    $('#cerrar').prop('disabled', false);
  }
});

//Cargar Selects
function cargarSelectAutorizaciones()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'CerrarRemito/getAutorizaciones', 
            cache: false,
            data: 'json',
            dataType: 'json',
      })
    .done(function(data) {
      var $element = $('#selectAutorizacion').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        var newOption = new Option(data[i].id_autorizacion, data[i].id_autorizacion, true, true);
        $("#selectAutorizacion").append(newOption).trigger('change');
      }      
      var option = new Option("Seleccione...", "null", true, true);
      $("#selectAutorizacion").append(option).trigger('change');

    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
  });
}

function cargarAutorizaciones(){

  var id_autorizacion = $("#selectAutorizacion").val(); 
    var postData = {
      'id_autorizacion' : id_autorizacion
    };
    $.ajax({
      async: true,              
      type: "POST",
      url:'Remito/getAutorizacionById', 
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
            $("#datepicker").val(value.fec_autorizado);
            $("#selectDestino").val(value.destino);
            $("#selectUsuario").val(value.alias);
            $("#responsable").val(value.responsable);
            $("#observaciones").val(value.observaciones);
            $("#oficio").val(value.oficio);
            
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
        for (var i = 0 ;i<9;i++) {
          $('td:nth-child('+i+')').hide();
          $('td:nth-child('+i+'),th:nth-child('+i+')').hide();
        }
        
      }
    })
    .fail(function() {
      alert("Error 120. Consulte con el administrador de sistemas.")
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

}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();  
}

function imprimir(data){
  $.ajax({
          async: true,
          type: "POST",
          url: 'CerrarRemito/imprimir', 
          cache: false,
          data: {id:data},
          dataType: 'json',
      //data: {id_articulo: "articulo"},
        })
        .done(function(data) {
            var pie=' <div style="position:fixed;bottom:0px;width:100%;margin-left:15px;">\
                          <div><tr><td>Entrega Libreria</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Chofer</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Recibe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <br>\
                          <div>Original: Archivar en Libreria/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duplicado: Devolver Conformado/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Triplicado: Archivar/</div>\
                      </div>';

          var html='\
          <div class="container">\
            <div class="row">\
              <div class="col-md-12">\
                <div class="idaut">\
                  <h3>REMITO N°: '+data[0].id_egreso+'</h3>\
                </div>\
              </div>\
            </div>\
            <div class="row">\
              <div class="col-md-3">\
                <div style="background-color:red;" class="fechaIng">\
                  <span>AUTORIZACION N°: '+data[0].id_autorizacion+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div style="background-color:red;" class="fechaIng">\
                  <span>FECHA: '+data[0].fec_mov+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="destino">\
                  <span>DESTINO: '+data[0].destino+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="responsable">\
                  <span>RESPONSABLE: '+data[0].responsable+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="oficio">\
                  <span>GEDEBA: '+data[0].oficio+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="usuario">\
                  <span>USUARIO: '+data[0].alias+'</span>\
                </div>\
              </div>\
               <div class="col-md-3">\
               <div class="observaciones">\
                  <span>OBSERVACIONES:'+data[0].observaciones+'</span>\
             </div>\
              </div>\
               <div style="margin-top:20px;">\
              </div>\
            </div>\
           </div>';

         var header='<img class="img-responsive" src="../theme/dist/img/salud_justicia_logo2021.png" alt="Inicio">';
          var marcaOriginal='<img  src="../theme/dist/img/original.png" style="position:absolute;opacity: 0.5;right:25px;">';
          var marcaDuplicado='<img  src="../theme/dist/img/duplicado.png" style="position:absolute;opacity: 0.5;right:25px;">';
          var marcaTriplicado='<img  src="../theme/dist/img/triplicado.png" style="position:absolute;opacity: 0.5;right:25px;">';

          var td1="";
          var td2="";
          var td3="";
          var td4="";
          var td5="";


           var i=1;
          $.each(data, function( index, val ) {
            
                 switch (true){
                  case (i < 19):
                  td1 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>"; 
                  break;
                  case (i > 18 && i < 38):
                  td2 +="<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>"; 
                  break;
                  case (i > 37 && i < 57):
                  td3 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>"; 
                  break;
                  case (i > 56 && i < 76):
                  td4 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>"; 
                  break;
                  case (i > 75 && i < 95):
                  td5 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"</td>"+"<td>"+val.cant+"</td>"+"<td>"+val.tamano+"</td>"+"</tr>"; 
                  break;
                 }
            i++;         
          });

           
          var html2='<div style="bottom:200px;">\
           <table id="tablaPrincipal" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Código</th><th>Producto</th><th>Presentación</th><th>Cantidad</th><th>Tamaño</th></tr></thead>\
           <tbody>'+td1+'</tbody></table>\
          </div>';
          html2+=pie+"<div class='saltopagina'></div>";

          var html3='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
              <thead><tr><th>Código</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td2+'</tbody></table>\
          </div>';
         html3+=pie+"<div class='saltopagina'></div>";

         var html4='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Código</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td3+'</tbody></table>\
          </div>';
         html4+=pie+"<div class='saltopagina'></div>";
          var html5='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
            <thead><tr><th>Código</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td4+'</tbody></table>\
          </div>';
         html5+=pie+"<div class='saltopagina'></div>";

          var html6='<div style="margin-top:150px;">\
           <table id="tabla2" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Código</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
           <tbody>'+td5+'</tbody></table>\
          </div>';
         html6+=pie+"<div class='saltopagina'></div>";


        var codigoHtmlOriginal=header+marcaOriginal+html;
        var codigoHtmlDuplicado=header+marcaDuplicado+html;
        var codigoHtmlTriplicado=header+marcaTriplicado+html;
           if (td1!==""){
              codigoHtmlOriginal+=html2;
              codigoHtmlDuplicado+=html2;
              codigoHtmlTriplicado+=html2;
                if (td2!==""){
                  codigoHtmlOriginal+=marcaOriginal+html3;
                  codigoHtmlDuplicado+=marcaDuplicado+html3;
                  codigoHtmlTriplicado+=marcaTriplicado+html3;
                    if (td3!==""){
                      codigoHtmlOriginal+=marcaOriginal+html4;
                      codigoHtmlDuplicado+=marcaDuplicado+html4;
                      codigoHtmlTriplicado+=marcaTriplicado+html4;
                      if (td4!==""){
                            codigoHtmlOriginal+=marcaOriginal+html5;
                            codigoHtmlDuplicado+=marcaDuplicado+html5;
                            codigoHtmlTriplicado+=marcaTriplicado+html5;
                            if (td5!==""){
                                  codigoHtmlOriginal+=marcaOriginal+html6;
                                  codigoHtmlDuplicado+=marcaDuplicado+html6;
                                  codigoHtmlTriplicado+=marcaTriplicado+html6;
                              }
                        } 
                  }  
                }
           }


         $("#impresion").print({
              globalStyles: true,
              mediaPrint: true,
              stylesheet : "../theme/dist/css/imprimir.css",
              iframe: true,
              noPrintSelector : ".avoid-this",
              append: "SISTEMAS DPSP - 2019",
              prepend: codigoHtmlOriginal+codigoHtmlDuplicado+codigoHtmlTriplicado,
              title: 'Sistema Libreria',
              doctype: '<!DOCTYPE html>'
          });
          
        })
        .fail(function() {
          alert("Error. Consulte con el administrador de sistemas.")
        });
}


function cerrar(id_autorizacion,usuario,responsable){
  $.ajax({
          async: true,
          type: "POST",
          url: 'CerrarRemito/cerrar', 
          cache: false,
          data: {id_autorizacion:id_autorizacion,usuario:usuario,responsable:responsable},
          dataType: 'json',
      //data: {id_articulo: "articulo"},
        })
        .done(function(data) {
          if (data>0){
            $("#result").html('<div class="alert alert-success"><button type="button" class="close">×</button>Se Cerró Correctamente </div>');
        window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                  });
                    
                  $('.alert .close').on("click", function(e){
                        $(this).parent().fadeTo(500, 0).slideUp(500);
                  });

                  resetearForm();
                  imprimir(data);
                }, 3000);
          }else{
            alert('error en cerrar');
            $('#cerrar').prop('disabled', false);
          }
        })
        .fail(function() {
          alert("Error. Consulte con el administrador de sistemas.")
        });
}


function getUser(){
    $.ajax({
            async: true,
            type: "POST",
            url:'Login/getCurrentUser', 
            cache: false,
            data: 'json',
            dataType: 'json',
            //data: {id_articulo: "articulo"},           
      })
    .done(function(data) {
      usuario=data.id;
      //responsable=data.nombre;

    })
    .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
    }); 
}

function resetearForm(){
  var encab="";
  encab += "<thead><tr><th>Código<\/th><th>Producto<\/th><th>Presentación<\/th><th>Cantidad<\/th><th>Tamaño<\/th><\/tr><\/thead>";
  $('#cerrar').prop('disabled', false);
  cargarSelectAutorizaciones();
  $('#responsable').val("");
  $('#selectUsuario').val("");
  $('#selectDestino').val("");
  $('#datepicker').val("");
  $('#numauto').val("");
  $('#responsableRem').val("");
  $('#tablaPrincipal').empty().append(encab);
  $("#oficio").val("");
 /* $.ajax({
          async: true,
          type: "POST",
          url: 'CerrarRemito/mostrarDatos', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_articulo: "articulo"},
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/farmacia/theme/js/cerrarRemito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });*/
}