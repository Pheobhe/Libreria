<!DOCTYPE html>
<html>
<head>
    
 <!-- alert("Header en Localhost");  -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de Libreria DPSP| Panel de Control </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/skins/skin-green.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>bootstrap/css/style.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/select2/select2.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/AdminLTE.min.css">
  
  <link rel="shortcut icon" href="<?php echo base_url('theme/');?>dist/img/favicon_NU.png" type="<?php echo base_url('theme/');?>dist/img/favicon_NU.png"/>



</head>
<body class="hold-transition skin-green sidebar-mini">

<div class="row">
  <div class="col-md-12">
    <div class="headersalud">
           <img src="<?php echo base_url('theme/');?>dist/img/salud_justicia_logo2021.png"> 
  
    </div>
  </div>
</div>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>L e I</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Libreria e Insumos</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a id="navbarprincipal" href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Abrir navegacion</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">1</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tenes 1 mensaje</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('theme/');?>dist/img/user2-160x160.jpg" class="imagenPerfil img-circle" alt="User Image">
                      </div>
                      <h4>
                        Funcion en desarrollo
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>en desarrollo</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todos los mensajes</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">3</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tenes 3 notifiaciones</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <!-- <li>
                    <a href="#" id="artPorVencer">
                      <i class="fa fa-warning text-red"></i>Productos Por Vencer
                    </a>
                  </li> -->
                  <li>
                    <a href="#" id="artStockMin">
                      <i class="fa fa-warning text-yellow"></i>Producto Por Debajo del Mínimo
                    </a>
                  </li>
                  <li>
                    <a href="#" id="artSinStock">
                      <i class="fa fa-warning text-yellow"></i>Producto Sin Stock
                    </a>
                  </li>
                 
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todo</a></li>
            </ul>
          </li>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('theme/');?>dist/img/user2-160x160.jpg" class="user-image imagenPerfil"  alt="User Image">
              <span class="hidden-xs"><?php if( isset($_SESSION['alias']) ) {echo $_SESSION['alias']; }?></span>
            </a>
            <ul class="dropdown-menu" style="border: 1px solid #BBB;">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('theme/');?>dist/img/user2-160x160.jpg" class="img-circle menuconsultas imagenPerfil" id="cambiarFoto" alt="User Image">

                <p>
                  <?php if( isset($_SESSION['alias']) ) {echo $_SESSION['alias']; }?>                  <small>DPSP</small>
                </p>
                
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" id="acerca" class="btn btn-default btn-flat">Acerca De...</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url().'index.php/Login/logout'?>" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('theme/');?>dist/img/user2-160x160.jpg" class="img-circle imagenPerfil" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['alias'];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">NAVEGACION PRINCIPAL</li>
        <li><a class="menudin" id="Dashboard" href="#"><i class="fa text-aqua fa-laptop"></i> <span>Panel de Control</span></a></li>
        <li class="treeview">
          <a  href="#">
            <i class="fa text-yellow fa-book"></i> <span>Fichas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a class="menudin" id="producto" href="#" ><i class="fa fa-medkit"></i> Productos</a></li>
            <li><a class="menudin" id="unidad" href="#"><i class="fa fa-hospital-o"></i> Destinos</a></li>
            <li><a class="menudin" id="proveedor" href="#"><i class="fa fa-truck"></i> Proveedores</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa text-green fa-files-o"></i>
            <span>Ingreso</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a class="menudin" id="movimiento" href="#"><i class="fa fa-arrow-right"></i> Movimiento</a></li>
            <li><a class="menudin" id="nota" href="#"><i class="fa  fa-mail-forward"></i> Nota Devolucion</a></li> 
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa text-red fa-files-o"></i>
            <span>Egreso</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu"> 
            <li><a class="menudin" id="remito" href="#"><i class="fa fa-check-square-o"></i> Autorizar Remito</a></li>
            <li><a class="menudin" id="cerrarRemito" href="#"><i class="fa fa-arrow-left"></i>Cerrar Remito</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa text-olive fa-align-left"></i>
            <span>Stock</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a class="menuconsultas" id="consultaStock" href="#"><i class="fa fa-ambulance"></i>Stock Fisico</a></li>
            <!-- <li><a class="menuconsultas" id="consultaStockGestion" href="#"><i class="fa fa-building"></i>Stock en Gestion</a></li> -->
           <!-- <li><a class="menuconsultas" id="consultaStockGestion" href="#"><i class="fa fa-building"></i>Stock Lógico</a></li> -->
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa text-teal fa-search"></i><span>Consultas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>


          <ul class="treeview-menu" style="display: none;">
            
            <li>
              <a href="#"><i class="fa fa-folder"></i> Ingreso
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
             <ul class="treeview-menu">
                <li><a class="menuconsultas" id="consultaMovimiento" href="#"><i class="fa  fa-file-text-o"></i>Movimiento</a></li>
                 <li><ol><a style="color:#F1D8AF;" class="menuconsultas" id="consultaMovimientoOld" href="#"><i class="fa fa-archive"></i>Histórico</a></ol></li>
                <li><a href="#" class="menuadmin" id="movimientoPorFecha"><i class="fa fa-calendar"></i>Movimiento por Fecha</a></li>
                 <li><ol><a style="color:#F1D8AF;" href="#" class="menuadmin" id="movimientoPorFechaOld"><i class="fa fa-archive"></i>Histórico</a></ol></li>
                <li><a class="menuconsultas" id="consultaNota" href="#"><i class="fa fa-file-text-o"></i>Nota Devolucion</a></li>
                <li><a href="#" class="menuadmin" id="notaPorFecha"><i class="fa fa-calendar"></i>Nota Devolucion por Fecha</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-folder"></i> Egreso
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
             <ul class="treeview-menu">
                <li><a class="menuconsultas" id="consultaAutorizacion" href="#"><i class="fa fa-file-text-o"></i>Autorizaciones</a></li>
                   <li><ol><a style="color:#F1D8AF;" class="menuconsultas" id="consultaAutorizacionOld" href="#"><i class="fa fa-file-text-o"></i>Histórico</a></ol></li>
                <li><a href="#" class="menuadmin" id="autorizacionPorFecha"><i class="fa fa-calendar"></i>Autorizacion por Fecha</a></li>
                   <li><ol><a style="color:#F1D8AF;" class="menuadmin" id="autorizacionPorFechaOld" href="#"><i class="fa fa-file-text-o"></i>Histórico</a></ol></li>

                <li><a class="menuconsultas" id="consultaRemito" href="#"><i class="fa  fa-file-text-o"></i>Remitos</a></li>
                   <li><ol><a style="color:#F1D8AF;" class="menuconsultas" id="consultaRemitoOld" href="#"><i class="fa fa-file-text-o"></i>Histórico</a></ol></li>
                   
                <li><a href="#" class="menuadmin" id="remitoPorFecha"><i class="fa  fa-calendar"></i>Remito por Fecha</a></li>
                     <li><ol><a style="color:#F1D8AF;" class="menuadmin" id="remitoPorFechaOld" href="#"><i class="fa fa-file-text-o"></i>Histórico</a></ol></li>
              </ul>
            </li>

<li>
                <a href="#"><i class="fa fa-folder"></i> Generales
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a class="menuconsultas" id="consultaProducto" href="#"><i class="fa  fa-file-text-o"></i>Por Articulo</a></li>
                  <li><a class="menuconsultas" id="consultaDestino" href="#"><i class="fa  fa-file-text-o"></i>Por Destino</a></li>
                   <li><a class="menuconsultas" id="consultaProductoFecha" href="#"><i class="fa  fa-file-text-o"></i>Por Fecha</a></li> 
                 <!--  <li><a class="menuconsultas" id="consultaDestinoFechaArt" href="#"><i class="fa  fa-file-text-o"></i>Por Articulo/Fecha/Destino</a></li> -->
                  <!-- <li><a class="menuconsultas" id="consultaProductoVencimiento" href="#"><i class="fa  fa-file-text-o"></i>Proximos a vencer</a></li> -->
                  <!-- <li><a class="menuconsultas" id="consultaProductoVencidos" href="#"><i class="fa  fa-file-text-o"></i>Articulos Vencidos</a></li> -->
                 <!--  <li><a class="menuconsultas" id="consultaProductosDestino" href="#"><i class="fa  fa-file-text-o"></i>Articulos\Destino</a></li>
                  <li><a class="menuconsultas" id="consultaProductosSeguimiento" href="#"><i class="fa  fa-file-text-o"></i>Articulos en Seguimiento</a></li> -->

                </ul>
              </li>




          </ul>
    </li>
   


            <!-- <li> -->
               <!--  <a href="#"><i class="fa fa-folder"></i> Generales
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a> -->
               <!--  <ul class="treeview-menu">
                  <li><a class="menuconsultas" id="consultaProducto" href="#"><i class="fa  fa-file-text-o"></i>Por Producto</a></li>
                  <li><a class="menuconsultas" id="consultaDestino" href="#"><i class="fa  fa-file-text-o"></i>Por Destino</a></li>
                  <li><a class="menuconsultas" id="consultaProductoFecha" href="#"><i class="fa  fa-file-text-o"></i>Por Fecha</a></li>
                  <li><a class="menuconsultas" id="consultaProductosDestino" href="#"><i class="fa  fa-file-text-o"></i>Productos\Destino</a></li>
                 
 
                </ul> -->
              <!-- </li> -->
            
            

          <!-- </ul>
        </li> -->

         <!-- <li class="treeview"> -->
         <!--  <a href="#">
            <i class="fa text-teal  fa-bar-chart-o"></i> <span>Estadísticas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a> -->
          <!-- <ul class="treeview-menu" style="display: none;"> -->
            
            <!-- <li><a href="#" class="menuadmin" id="estadisticas"><i class="fa fa-pie-chart"></i>Generales</a></li> -->
            

          <!-- </ul> -->
        <!-- </li> -->

<!-- </li> -->
      
<!-- aca va Admin de administradores -->


           
              </ul>
             </li> 

          </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

          <div id="modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Cambiar Foto de Perfil</h4>
                </div>
                <div class="modal-body">
                  <form role="form" accept-charset="utf-8" method="POST" enctype="multipart/form-data" id="formImagenes" >
                  <div class="form-group">
                    <label for="imagen">Subir Foto...</label>
                      <input type="file" name="imagen"/>
                  </div>
                  
                </form>
                </div>
                <div class="modal-footer">
                  <label id="mensaje"></label>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" id="enviarImagenes">Guardar Cambios</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->


<div id="modalAcerca" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Acerca De...</h4>
                </div>
                <div class="modal-body">
                  <h4>Sistema de Libreria e Insumos para la Direccion Provincial de Salud Penitenciaria</h4>
                  <p>DPIYCMJYDHGP - Desarrollo</p>
                  <p><b>Desarrollo: Defalco Lorena</b></p>
                  <p><b>Colaboradores: Catena Pablo</b></p>
                </div>
                <div class="modal-footer">
                  <label id="mensaje"></label>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->




<div id="modalNotifiacion" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Notificaciones 0</h4>
                </div>
                <div class="modal-body">
                  <table id="tablaNotificacion" class="table table-bordered table-striped table-hover"></table>
                  
                </div>
                <div class="modal-footer">
                  <label id="mensaje"></label>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

          <div id="modalNotifiacion2" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Notificaciones 1</h4>
                </div>
                <div class="modal-body">
                 
                  <table id="tablaNotificacion2" class="table table-bordered table-striped table-hover"></table>
                </div>
                <div class="modal-footer">
                  <label id="mensaje"></label>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

          <div id="modalNotifiacion3" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Notificaciones 2</h4>
                </div>
                <div class="modal-body">
                 
                  <table id="tablaNotificacion3" class="table table-bordered table-striped table-hover"></table>
                </div>
                <div class="modal-footer">
                  <label id="mensaje"></label>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

