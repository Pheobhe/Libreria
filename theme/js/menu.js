
var xhr;
var active=false;

//$('.menudin').click(true);
//MENU ADMIN --------------------------------
$(".menudin").click(function(event) {
  //event.preventDefault();
  if(active) { 
    console.log("killing active"); 
    xhr.abort(); 
  }

  var loading='<div style="margin-top:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
  
  //collapsa el sidebar en version movil
  if ($('.skin-blue').hasClass('sidebar-open')){
    $('.skin-blue').removeClass('sidebar-open');
  }
  

  $(".content-wrapper").empty().append(loading);
  var dato=$(this).attr('id');
  console.log(dato);
  if(dato!='Dashboard'){    

  //active=true;

     $.ajax({
      async: true,
      type: "POST",
      url: dato+'/mostrarDatos', 
      cache: false,
      data: 'json',
      dataType: 'json',
 //data: {id_producto: "producto"},           
    })
    .done(function(data) {
      if(!$.isEmptyObject(data)){          
        
        $(".content-wrapper").empty().append(data);

        switch(dato) {

          case 'producto':
            if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/producto.js", function( data, textStatus, jqxhr ) {
              active=false;
            });

            //$.getScript("/libreria/theme/js/producto.js");//NO TIRA CORS PROBAR CON MAS ELEMENTOS DEL MENU
            //$("#cargarjs").empty().append("<script src='/libreria/theme/js/producto.js'></script>"); //TIRA CORS VER 
            // $("#cargarjs").attr('src','/libreria/theme/js/producto.js');  //FUNCIONA OK     
                
            break;
          case 'unidad':
            if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/unidad.js", function( data, textStatus, jqxhr ) {
              active=false;
            });

            break;
          case 'proveedor':
            if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/proveedor.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
            break;
          case 'movimiento':
            if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/movimiento.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
            
            break;
          case 'nota':

            if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/nota.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
            


            break;
          case 'remito':
            if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/remito.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
            
           break;
          case 'cerrarRemito':

            if(active) { 
              //console.log("killing active"); 
              xhr.abort(); 
            }
            //active=true;
            //xhr =$.getScript("/farmacia/theme/js/cerrarRemito.js");
            //active=false;
            active=true;
            //xhr = $.getScript( "/farmacia/theme/js/cerrarRemito.js", function( data, textStatus, jqxhr ) { SI CAMBIO A LIBRERIA 2 NO FUNCIONA!!
             xhr = $.getScript( "/libreria/theme/js/cerrarRemito.js", function( data, textStatus, jqxhr ) {
              console.log( data ); // Data returned
              console.log( textStatus ); // Success
              console.log( jqxhr.status ); // 200
              console.log( "Load was performed." );
              active=false;

            });




            break;
          default:
              alert ('Menu 124');
            break;
        }

        // console.log(data);
      }
    })
    .fail(function() {
      //alert("error. Consulte con el administrador de sistemas.")
    });
  }
  else
  {
    location.reload();
  }
});


//botones de consultas

$(".menuconsultas").click(function(event) {
  var loading='<div style="margin-top:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
  var dato=$(this).attr('id');
  if (dato!="cambiarFoto"){
    $(".content-wrapper").empty().append(loading);  
  }
  
  //collapsa el sidebar en version movil
  if ($('.skin-blue').hasClass('sidebar-open')){
    $('.skin-blue').removeClass('sidebar-open');
  }
  var dato=$(this).attr('id');
  console.log(dato);
  switch(dato) {
    case 'verIngresos':
    case 'masinfoing':
    case 'consultaMovimiento':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Movimiento/mostrarDatosConsulta', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaMovimiento.js");
      })
      .fail(function() {
        alert("Error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'consultaMovimientoOld':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Movimiento/mostrarDatosConsultaO', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaMovimientoOld.js");
      })
      .fail(function() {
        alert("Error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'consultaNota':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Nota/mostrarDatosConsulta', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaNota.js");
      })
      .fail(function() {
        alert("Error 210. Consulte con el administrador de sistemas.")
      });
      break;

   // case 'masinfoegr':
    case 'consultaRemito':
      $.ajax({
        async: true,
        type: "POST",
        url: 'CerrarRemito/mostrarDatosConsulta', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaRemito.js");
      })
      .fail(function() {
        alert("Error 229. Consulte con el administrador de sistemas.")
      });
      break;
      case 'cambiarFoto':
        $.getScript("/libreria/theme/js/perfil.js");
      break;
    //case 'masinfoaut':

    case 'consultaRemitoOld':
        $.ajax({
          async: true,
          type: "POST",
          url: 'CerrarRemito/mostrarDatosConsultaO', 
          cache: false,
          data: 'json',
          dataType: 'json',
        })
        .done(function(data) {
          $(".content-wrapper").empty().append(data);
          $.getScript("/libreria/theme/js/consultaRemitoOld.js");
        })
        .fail(function() {
          alert("Error 251. Consulte con el administrador de sistemas.")
        });
        break;
  
   
    case 'consultaAutorizacion':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Remito/mostrarDatosConsulta', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaAutorizacion.js");
      })
      .fail(function() {
        alert("Error 272. Consulte con el administrador de sistemas.")
      });

      break;

      case 'consultaAutorizacionOld':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Remito/mostrarDatosConsultaO', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaAutorizacionOld.js");
      })
      .fail(function() {
        alert("Error 291. Consulte con el administrador de sistemas.")
      });
      break;

    case 'consultaStock':
      $.ajax({ 
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatosConsulta', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaStock.js");
      })
      .fail(function() {
        alert("EEError. Consulte con el administrador de sistemas.")
      });
      break;

    case 'consultaStockGestion':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatosConsultaGestion', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaStockGestion.js");
      })
      .fail(function() {
        alert("Error 325. Consulte con el administrador de sistemas.")
      });
      break; 

    case 'masinfoart':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatos', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/producto.js");
      })
      .fail(function() {
        alert("menu.js270. Consulte con el administrador de sistemas.")
      });
      break;

    case 'consultaProducto':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarVistaProductos', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaProducto.js");
      })
      .fail(function() {
        alert("Error. Consulte con el administrador de sistemas.")
      });
      break;                

      case 'consultaProductoFecha':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarVistaProductosFecha', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaproducto.js");
      })
      .fail(function() {
        alert("Error 379. Consulte con el administrador de sistemas por fecha.")
      });
      break; 

      // case 'consultaproductosSeguimiento':
      // $.ajax({
      //   async: true,
      //   type: "POST",
      //   url: 'Producto/mostrarVistaproductosSeguimiento', 
      //   cache: false,
      //   data: 'json',
      //   dataType: 'json',
      // })
      // .done(function(data) {
      //   $(".content-wrapper").empty().append(data);
      //   $.getScript("/libreria/theme/js/consultaSeguimiento.js");
      // })
      // .fail(function() {
      //   alert("error. Consulte con el administrador de sistemas.")
      // });
      break; 
      
      case 'consultaDestino':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarVistaConsultaDestino', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/consultaDestino.js");
      })
      .fail(function() {
        alert("Error 415. Consulte con el administrador de sistemas.")
      });
      break;    

      // case 'consultaproductoVencidos':
      //   $.ajax({
      //     async: true,
      //     type: "POST",
      //     url: 'producto/mostrarVistaConsultaVencidos', 
      //     cache: false,
      //     data: 'json',
      //     dataType: 'json',
      //   })
      //   .done(function(data) {
      //     $(".content-wrapper").empty().append(data);
      //     $.getScript("/libreria/theme/js/consultaproductoVencidos.js");
      //   })
      //   .fail(function() {
      //     alert("error. Consulte con el administrador de sistemas.")
      //   });
      // break;      
      
    //   case 'consultaProductosDestino':
    //     $.ajax({
    //       async: true,
    //       type: "POST",
    //       url: 'Producto/mostrarVistaProductosDestino', 
    //       cache: false,
    //       data: 'json',
    //       dataType: 'json',
    //     })
    //     .done(function(data) {
    //       $(".content-wrapper").empty().append(data);
    //       $.getScript("/libreria/theme/js/consultaProductosDestino.js");
    //     })
    //     .fail(function() {
    //       alert("Error. Consulte con el administrador de sistemas, Menujs388.")
    //     });
    //   break;      

    // default:
    //     alert ('Articulo-****nada MenuJS393');
    //   break;
  }
});


//botones de admin

$(".menuadmin").click(function(event) {
  var loading='<div style="margin-top:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
  //collapsa el sidebar en version movil
  if ($('.skin-blue').hasClass('sidebar-open')){
    $('.skin-blue').removeClass('sidebar-open');
  }
  $(".content-wrapper").empty().append(loading);  

  if(active) { 
    console.log("killing active"); 
    xhr.abort(); 
  }
  
  
  var dato=$(this).attr('id');
  console.log(dato);
  switch(dato) {
    case 'ingresoSinRemito':
      $.ajax({
        async: true,
        type: "POST",
        url: 'IngresoX/mostrarDatos', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
       
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/ingresoSinRemito.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
        })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;
    case 'egresoSinRemito':
      $.ajax({
        async: true,
        type: "POST",
        url: 'EgresoX/mostrarDatos', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
       
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/egresoSinRemito.js", function( data, textStatus, jqxhr ) {
              active=false;
            });

      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'nuevoArt':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatosNuevoArt', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/nuevoArt.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'eliminarArt':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatosEliminarArt', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/eliminarArt.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'nuevoProv':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Proveedor/mostrarDatosNuevoProv', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/nuevoProv.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("Error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'eliminarProv':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Proveedor/mostrarDatosEliminarProv', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/eliminarProv.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

      case 'nuevoUnidad':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Unidad/mostrarDatosNuevoUnidad', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/nuevoUnidad.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'eliminarUnidad':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Unidad/mostrarDatosEliminarUnidad', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/eliminarUnidad.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;


// case 'inventarioCambio':
//       $.ajax({
//         async: true,
//         type: "POST",
//         url: 'Producto/mostrarDatosInventario',
//         cache: false,
//         data: 'json',
//         dataType: 'json',
//       })
//       .done(function(data) {
//         $(".content-wrapper").empty().append(data);

//         if(active) { xhr.abort(); }
//             active=true;
//             xhr = $.getScript( "/libreria/theme/js/inventarioCambio.js", function( data, textStatus, jqxhr ) {
//               active=false;
//             });
//       })
//       .fail(function() {
//         alert("error. Consulte con el administrador de sistemas.")
//       });
//       break;

//       case 'stockMin':
//       $.ajax({
//         async: true,
//         type: "POST",
//         url: 'Producto/mostrarDatosStockMin',
//         cache: false,
//         data: 'json',
//         dataType: 'json',
//       })
//       .done(function(data) {
//         $(".content-wrapper").empty().append(data);

//         if(active) { xhr.abort(); }
//             active=true;
//             xhr = $.getScript( "/libreria/theme/js/stockMin.js", function( data, textStatus, jqxhr ) {
//               active=false;
//             });
//       })
//       .fail(function() {
//         alert("error. Consulte con el administrador de sistemas.")
//       });
//       break;


    case 'anularMovimiento':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Movimiento/mostrarDatosAnular', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/anularMovimiento.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'anularNota':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Nota/mostrarDatosAnular', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/anularNota.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'anularAutorizacion':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Remito/mostrarDatosAnular', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/anularAutorizacion.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'anularRemito':
      $.ajax({
        async: true,
        type: "POST",
        url: 'CerrarRemito/mostrarDatosAnular', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/anularRemito.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'remitoPorFecha':
      $.ajax({
        async: true,
        type: "POST",
        url: 'CerrarRemito/mostrarDatosFecha', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaRemitoFecha.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

     case 'remitoPorFechaOld':
      $.ajax({
        async: true,
        type: "POST",
        url: 'CerrarRemito/mostrarDatosFechaO', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaRemitoFechaOld.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("Error 846. Consulte con el administrador de sistemas.")
      });
      break;  


    case 'autorizacionPorFecha':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Remito/mostrarDatosFecha', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaAutorizacionFecha.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

      case 'autorizacionPorFechaOld':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Remito/mostrarDatosFechaOl', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaAutorizacionFechaOld.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;



    case 'movimientoPorFecha':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Movimiento/mostrarDatosFecha', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaMovimientoFecha.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'movimientoPorFechaOld':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Movimiento/mostrarDatosFechaO', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaMovimientoFechaOld.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;  


    case 'notaPorFecha':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Nota/mostrarDatosFecha', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/consultaNotaFecha.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;


    case 'inventarioCambio':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatosInventario', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/inventarioCambio.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    // case 'asignarSeguimiento':
    //   $.ajax({
    //     async: true,
    //     type: "POST",
    //     url: 'Producto/mostrarDatosSeguimiento', 
    //     cache: false,
    //     data: 'json',
    //     dataType: 'json',
    //   })
    //   .done(function(data) {
    //     $(".content-wrapper").empty().append(data);
        
    //     if(active) { xhr.abort(); }
    //         active=true;
    //         xhr = $.getScript( "/libreria/theme/js/asignarSeguimiento.js", function( data, textStatus, jqxhr ) {
    //           active=false;
    //         });
    //   })
    //   .fail(function() {
    //     alert("error. Consulte con el administrador de sistemas.")
    //   });
    //   break;

    case 'stockMin':
      $.ajax({
        async: true,
        type: "POST",
        url: 'Producto/mostrarDatosStockMin', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        
        if(active) { xhr.abort(); }
            active=true;
            xhr = $.getScript( "/libreria/theme/js/stockMin.js", function( data, textStatus, jqxhr ) {
              active=false;
            });
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    // case 'estadisticas':
    //   $.ajax({
    //     async: true,
    //     type: "POST",
    //     url: 'Producto/mostrarDatosEstadisticas', 
    //     cache: false,
    //     data: 'json',
    //     dataType: 'json',
    //   })
    //   .done(function(data) {
    //     $(".content-wrapper").empty().append(data);
        
    //     if(active) { xhr.abort(); }
    //         active=true;
    //         xhr = $.getScript( "/libreria/theme/js/estadisticas.js", function( data, textStatus, jqxhr ) {
    //           active=false;
    //         });
    //   })
    //   .fail(function() {
    //     alert("error. Consulte con el administrador de sistemas.")
    //   });
    //   break;

    default:
        alert ('Menu 973');
      break;
  }
});


//funciones para el menu de unidades 
$(".menuunidades").click(function(event) {
  var loading='<div style="margin-top:50px;" class="col-xs-12 text-center"><button type="button" class="btn btn-default btn-lrg ajax" title="CARGANDO..."><i class="fa fa-spin fa-refresh"></i>&nbsp; CARGANDO...</button></div>'
  var dato=$(this).attr('id');
  if (dato!="cambiarFoto"){
    $(".content-wrapper").empty().append(loading);  
  }
  
  //collapsa el sidebar en version movil
  if ($('.skin-blue').hasClass('sidebar-open')){
    $('.skin-blue').removeClass('sidebar-open');
  }
  var dato=$(this).attr('id');
  console.log(dato);
  switch(dato) {
    
    case 'ingresoU':
      $.ajax({
        async: true,
        type: "POST",
        url: 'IngresoGeneral/mostrarDatos', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/unidades_ingreso.js");
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;

    case 'egresoUnidades':
      $.ajax({
        async: true,
        type: "POST",
        url: 'EgresoUnidades/mostrarDatosMenu', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/unidades_egresoMenu.js");
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;
    case 'consultaStockUnidades':
      $.ajax({
        async: true,
        type: "POST",
        url: 'StockUnidades/mostrarDatosMenu', 
        cache: false,
        data: 'json',
        dataType: 'json',
      })
      .done(function(data) {
        $(".content-wrapper").empty().append(data);
        $.getScript("/libreria/theme/js/unidades_stockMenu.js");
      })
      .fail(function() {
        alert("error. Consulte con el administrador de sistemas.")
      });
      break;
    default:
        alert ('Menu 1048');
      break;
  }
});




/*$("#Producto").click(function(event) {
  
//event.preventDefault();
    $.ajax({
            async: true,
            type: "POST",
            url:'index.php/Producto/mostrarDatosTabla', 
            cache: false,
            data: 'json',
            dataType: 'json',
            
         //data: {id_producto: "producto"},           
            
    })
    .done(function(data) {
      if(!$.isEmptyObject(data)){
          $(".content-wrapper").empty();
          $(".content-wrapper").html(data);
         // console.log(data);
        }
        })
        .fail(function() {
          alert("error. Consulte con el administrador de sistemas.")
        });

});*/


