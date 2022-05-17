$(".select2").select2();
cargarSelectNombreArt();

$('#selectProducto').on("select2:select", function(e) { 
   consultarArtNombre();
});


$('#deleteProducto').click(function(){
	deleteArt();
});


function deleteArt(){
	//var producto = $("#nombreProducto").val(); 
		    var data = $('#tablaPrincipal tr:gt(0)').map(function() {
		        return {
		            id_producto:  $(this.cells[0]).text()
		        };
		    }).get();
		    var postData = {
		      'id_producto' : data[0].id_producto,
		    };

		    $.post('Producto/deleteProducto', postData, function(data){
		        if (data) { 
		            alert("exito");
		            resetearForm();
		        }else{
		        	alert("error");
		            
		        }
		    });
}


function consultarArtNombre()
{
  var id = $("#selectProducto").val(); 
  var postData = {
      'id' : id
    };
    $.ajax({
      async: true,
      type: "POST",
      url:'Producto/getProductosId', 
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
        dibujarEncabezado("tablaPrincipal",arrayEncabezado);
        //dibujarEncabezado("example1",arrayEncabezado);
        for (i=0;i<arrayElementos.length;i++){
          drawRow(arrayElementos[i],"tablaPrincipal");
          //drawRow(arrayElementos[i],"example1");
        }
      }
    })
    .fail(function() {
      alert("Error. Consulte con el administrador de sistemas.")
    }); 
}



function cargarSelectNombreArt()
{
  $(function () {
     $.ajax({
            async: true,
            type: "POST",
            url:'Producto/getNombresArtEliminar', 
            cache: false,
            data: 'json',
            dataType: 'json',
            ///data: {id_producto: "producto"},                   
      })

    
    .done(function(data) {

      var $element = $('#selectProducto').select2();
      $element.empty();
      for (var i = 0; i < data.length; i++) {
        //console.log(data[i]);
        var item=data[i].marca;

        var option = new Option(data[i].id_producto+" - "+data[i].producto, data[i].id_producto, true, true);
        //console.log(option);
        $element.append(option);
      }      
      var option2 = new Option("Seleccione...", "null", true, true);
      $("#selectProducto").append(option2).trigger('change');  
      
    })
    .fail(function() {
        alert("Error. Consulte con el administrador de sistemas.")
    }); 
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


function resetearForm(){
  $.ajax({
          async: true,
          type: "POST",
          url: 'Producto/mostrarDatosEliminarArt', 
          cache: false,
          data: 'json',
          dataType: 'json',
      //data: {id_producto: "producto"},           
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/eliminarArt.js");
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });
}