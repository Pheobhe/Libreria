
cargarSelectAutorizaciones();

$('#selectAutorizacion').on("select2:select", function(e) {
   cargarAutorizaciones();
});

$('#imp').click(function(){
  imprimir($("#numauto").val());
});

//Cargar Selects
function cargarSelectAutorizaciones()
{
  $("#selectAutorizacion").select2({
    placeholder:"Seleccione Autorizacion...",
    language:{
       noResults: function(){
           return "<a href='#' class='btn btn-danger'>Resultado no encontrado. Por favor ingrese número.</a>";
       }
    },
    ajax:{
      url: 'Remito/getAutorizacionesSelect2',
      dataType:'json',
      delay:250,
      processResults: function (data) {
          return {
              results: $.map(data.results, function(results) {
                //alert(data.results.id_autorizacion);
                  return { id: results.id_autorizacion, text: results.id_autorizacion };
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
            $("#destinatario").val(value.destinatario);
            $("#oficio").val(value.oficio);
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
        for (var i = 0 ;i<8;i++) {
          $('td:nth-child('+i+')').hide();
          $('td:nth-child('+i+'),th:nth-child('+i+')').hide();
        }

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
function drawRow(rowData,nombreTabla) {
  var row = $("<tr>");
  var valor;
  var i=0;
  $("#"+nombreTabla).append(row);
  var datos=[];

  $.each(rowData, function( index, value ) {

      //Transformar null en -
      if(value==null||value=="SIN ASIGNAR"||value=="NO ESPECIFICA"){ valor="-" }else{valor=value}

        if (value=="en"){valor="entregado"}
        if (value=="ca"){valor="cancelado"}
        if (value=="au"){valor="autorizado"}

      row.append($("<td>" + valor + "</td>"));
      i=i+1;
    });
    //console.log(datos);
    //console.log(id+marca+nombre+droga+unidad+descripcion);
    //row.append($("<td><button type='button' value='' onclick='agregarPrincipal("+id+",\""+nombre+"\""+",\""+unidad+"\",\""+descripcion+"\")'  class='btn seleccionar btn-default '><span class='glyphicon glyphicon-ok'></span></button></td></tr></tbody>"));



}

function limpiarTabla(nombreTabla){
  //$("#"+nombre).find("tr:gt(0)").remove();//limpiar tabla
  $("#"+nombreTabla+" thead").remove();
}

function imprimir(data){
  $.ajax({
          async: true,
          type: "POST",
          url: 'Remito/imprimir',
          cache: false,
          data: {id:data},
          dataType: 'json',
      //data: {id_producto: "producto"},
        })
        .done(function(data) {

            var pie=' <div style="position:fixed;bottom:0px;width:100%;margin-left:15px;">\
                          <div><tr><td>Autoriza</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Notificado Libreria</td><td>................................................................</td></tr></div>\
                          <div><tr><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Firma/Legajo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>................................................................</td></tr></div>\
                          <br>\
                          <div>Original: Archivar en Destino/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duplicado: Devolver Conformado/</div>\
                      </div>';

          var html='\
          <div class="container">\
            <div class="row">\
              <div class="col-md-12">\
                <div class="idaut">\
                  <h3>AUTORIZACION N°: '+data[0].id_autorizacion+'</h3>\
                </div>\
              </div>\
            </div>\
            <div class="row">\
              <div class="col-md-3">\
                <div style="background-color:red;" class="fechaIng">\
                  <span>Fecha: '+data[0].fec_autorizado+'</span>\
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
                <div class="responsable">\
                  <span>USUARIO: '+data[0].alias+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="destinatario">\
                  <span>DESTINATARIO: '+data[0].destinatario+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
                <div class="oficio">\
                  <span>GEDEBA: '+data[0].oficio+'</span>\
                </div>\
              </div>\
              <div class="col-md-3">\
               <div class="oficio">\
                 <span>OBSERVACIONES: '+data[0].observaciones+'</span>\
              </div>\
              </div>\
               <div style="margin-top:20px;">\
              </div>\
              </div>\
           </div>';

          var header='<img class="img-responsive" src="../theme/dist/img/salud_justicia_logo2021.png" alt="Inicio">';
          var marcaOriginal='<img  src="../theme/dist/img/original.png" style="position:absolute;opacity: 0.5;right:25px;">';
          var marcaDuplicado='<img  src="../theme/dist/img/duplicado.png" style="position:absolute;opacity: 0.5;right:25px;">';
          var td1="";
          var td2="";
          var td3="";
          var td4="";
          var td5="";
          //var total;
          //console.log("cantidad: "+data.length);
          //var resultado=Math.trunc(data.length/13);
          //console.log("division: "+data.length/13);
          //total=resultado+1;
          //console.log("total: "+total);
          var i=1;
          $.each(data, function( index, val ) {

                 switch (true){
                  case (i < 19):
                  td1 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"<td>"+val.cant+"</td>"+"</tr>";
                  break;
                  case (i > 18 && i < 38):
                  td2 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"<td>"+val.cant+"</td>"+"</tr>"; 
                  break;
                  case (i > 37 && i < 57):
                  td3 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"<td>"+val.cant+"</td>"+"</tr>";  
                  break;
                  case (i > 56 && i < 76):
                  td4 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"<td>"+val.cant+"</td>"+"</tr>";    
                  break;
                  case (i > 75 && i < 95):
                  td5 += "<tr><td>"+val.id_producto+"</td><td>"+val.producto+"</td>"+"<td>"+val.presentacion+"</td>"+"<td>"+val.cant+"</td>"+"</tr>"; 
                  break;
                  }
            i++;
          });
           //console.log("td1:"+td1);
           //console.log("td2:"+td2);
           //console.log("td3:"+td3);
           //console.log("td4:"+td4);
           //console.log("td5:"+td5);

          var html2='<div style="bottom:200px;">\
           <table id="tablaPrincipal" class="tablaPrincipal table table-bordered table-striped table-hover" >\
             <thead><tr><th>Código</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>\
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


          //$("#impresion").empty().append(html);
           var codigoHtmlOriginal=header+marcaOriginal+html;
           var codigoHtmlDuplicado=header+marcaDuplicado+html;
           if (td1!==""){
              codigoHtmlOriginal+=html2;
              codigoHtmlDuplicado+=html2;
                if (td2!==""){
                  codigoHtmlOriginal+=marcaOriginal+html3;
                  codigoHtmlDuplicado+=marcaDuplicado+html3;
                    if (td3!==""){
                      codigoHtmlOriginal+=marcaOriginal+html4;
                      codigoHtmlDuplicado+=marcaDuplicado+html4;
                      if (td4!==""){
                            codigoHtmlOriginal+=marcaOriginal+html5;
                            codigoHtmlDuplicado+=marcaDuplicado+html5;
                            if (td5!==""){
                                  codigoHtmlOriginal+=marcaOriginal+html6;
                                  codigoHtmlDuplicado+=marcaDuplicado+html6;
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
              prepend: codigoHtmlOriginal+codigoHtmlDuplicado,
              title: 'Sistema Libreria',
              doctype: '<!DOCTYPE html>'
          });
          //$.getScript("/libreria/theme/js/remito.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });
}
