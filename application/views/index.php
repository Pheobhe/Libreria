
 <?php 
//setear el tiempo de inactividad permitido
 $tiempoInactividadPermitido=999999999999;

 if($this->session->userdata('logged_in'))
   {
            //como ya ingreso y se logueo el usuario reinicio las variables de bloqueo e intentos
              $_SESSION['bloquear']=0;
              $_SESSION['intentos'] = 0; 

   
     if( isset($_SESSION['ultimo_acceso']) ) {
      $inactividad=(time() - $_SESSION['ultimo_acceso']);
      echo "<script>console.log('inac:'+'".$_SESSION['ultimo_acceso']."')</script>";
         if ($inactividad > $tiempoInactividadPermitido){
                 $this->session->set_flashdata('mensaje', 'ha superado el tiempo de inactividad debera loguearse de nuevo');
                 //$this->session->set_flashdata('email',$this->session->userdata('logged_in'));
              
                 //redireccionar al login para que ingrese sus datos nuevamente
                  redirect('/Login');
                  session_destroy();//destruir variables de sesion
         }else{
          //echo "<br>inactividad:".$inactividad;
          //echo "<br>ultimo acceso".$_SESSION['ultimo_acceso'];  
         }
      
     }
   }
   else
   {
    $this->session->set_flashdata('mensaje', 'Ud debera loguearse');
    redirect(base_url());
   }
 
 
  echo "<input type='hidden' class='id_usuario' value=".$this->session->userdata('id_usuario').">";
 
?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Panel de Control
        <small>Datos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Panel de Control</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="cantIngresos">&nbsp;&nbsp;</h3>
              <p>Ingresos</p>
            </div>
            <div class="icon">
              <i class="ion ion-archive"></i>
            </div>
            <a href="#" id="masinfoing" class="menuconsultas small-box-footer">M&aacute;s Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
<!-- ***************************************** -->        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="cantAuts">&nbsp;&nbsp;</h3>
              <p>Autorizaciones</p>
            </div>
            <div class="icon">
              <i class="ion ion-paper-airplane"></i>
            </div>
            <a href="#" class=" small-box-footer">M&aacute;s Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
<!-- ****************************************** -->

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="cantEgresos">&nbsp;&nbsp;</h3>
              <p>Egresos</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#"  class=" small-box-footer">M&aacute;s Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="cantProductos">&nbsp;&nbsp;</h3>
              <p>Productos</p>
            </div>
            <div class="icon">
              <i class="ion ion-medkit"></i>
            </div>
            <a href="#" id="masinfoart" class="menuconsultas small-box-footer">M&aacute;s Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
      </div>

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="#" id="artstockminwidget"><div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-warning"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Productos Stock Mínimo</span>
              <span class="info-box-number" id="artstockminspan">&nbsp;&nbsp;</span>

              <div class="progress">
                <div class="progress-bar" style="width: 5%"></div>
              </div>
                  <span class="progress-description">
                    VER
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div></a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="#" id="artvencerwidget"><div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Productos por vencer</span>
              <span class="info-box-number" id="artporvencerspan">&nbsp;&nbsp;</span>

              <div class="progress">
                <div class="progress-bar" style="width: 15%"></div>
              </div>
                  <span class="progress-description">
                    VER
                  </span>
            </div> -->
            <!-- /.info-box-content -->
          <!-- </div></a> -->
          <!-- /.info-box -->
        <!-- </div> -->
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="#" id="artsinstockwidget"><div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa  fa-cart-arrow-down"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Productos sin Stock</span>
              <span class="info-box-number" id="artsinstockspan">&nbsp;&nbsp;</span>

              <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
              </div>
                  <span class="progress-description">
                    VER
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div></a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
  <!-- desde aca -->
        
        <!-- right col (We are only adding the ID to make the widgets sortable)--> <!-- en panel de negacion principal -->
       <!--  <section class="col-lg-6 connectedSortable">

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Estadísticas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div> -->
              <!-- /////////////////////////////.box-header -->
            <!-- <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div> -->
                  <!-- .//////////////////////////////////chart-responsive -->
                <!-- </div> -->
                <!-- /.col -->
                <!-- <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-red"></i> Movimientos</li>
                    <li><i class="fa fa-circle-o text-green"></i> Autorizaciones</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> Remitos</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> Devoluciones</li> -->
                    <!--///////////////////////////////////////////<li><i class="fa fa-circle-o text-light-blue"></i> Anulados</li>
                    ////////////////////////////////////<li><i class="fa fa-circle-o text-gray"></i> Otros</li>-->
                <!--   </ul> -->
               <!--  </div> -->
                <!-- ////////////////////////////////.col -->
              <!-- </div> -->
              <!-- ////////////////////////.row -->
            <!-- </div> -->
            <!-- /////////////////////////.box-body -->
            <!-- div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="#">Movimientos
                  <span id="spanIng" class="pull-right text-green"><i class="fa "></i> </span></a></li>
                <li><a href="#">Remitos 
                  <span id="spanEgr" class="pull-right text-red"><i class="fa "></i> </span></a></li>
                <li><a href="#">Autorizaciones <span id="spanAut" class="pull-right text-yellow"><i class=" fa "></i> </span></a>
                 <li><a href="#">Devoluciones <span id="spanDev" class="pull-right text-blue"><i class=" fa "></i> </span></a>
                </li>
                
              </ul>
            </div> -->
            <!-- /////////////////////.footer -->
          <!-- </div> -->
          <!-- /.box -->

        <!-- </section> -->
        <!--//////////// right col -->
        <!-- <section class="col-lg-6 connectedSortable"> -->
          <!-- /////////////////PRODUCT LIST -->
          <!-- <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ultimos Ingresos</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div> -->
            <!-- ///////////////////////.box-header -->
            <!--  <div class="box-body">
              <ul class="products-list product-list-in-box">
                <li class="item">
                  <div class="product-img">
                    <span style="font-size:32px;"  class="text-center ion ion-ios-pulse-strong" alt="Product Image"></span>
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" id="ultimoIngreso0" class="product-title">
                      <span class="label label-success pull-right" id="ultimoIngresoCant0"></span></a>
                        <span id="ultimoIngresoCat0" class="product-description">
                          
                        </span>
                  </div>
               </li>  -->
                <!-- //////////////////////.item -->
               <!--  <li class="item">
                  <div class="product-img">
                    <span style="font-size:32px;"  class="text-center fa  fa-medkit" alt="Product Image"></span>
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" id="ultimoIngreso1" class="product-title">
                      <span class="label label-info pull-right" id="ultimoIngresoCant1"></span></a>
                        <span id="ultimoIngresoCat1" class="product-description">
                          
                        </span>
                  </div>
                </li> -->
                <!-- ///////////////////////.item -->
               <!--  <li class="item">
                  <div class="product-img">
                    <span style="font-size:32px;"  class="text-center ion ion-ios-medkit" alt="Product Image"></span>
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" id="ultimoIngreso2" class="product-title">
                      <span class="label label-danger pull-right" id="ultimoIngresoCant2"></span></a>
                        <span id="ultimoIngresoCat2" class="product-description">
                          
                        </span>
                  </div>
                </li> -->
                <!-- //////////////////////////////////.item -->
               <!--  <li class="item">
                  <div class="product-img">
                    <span style="font-size:32px;"  class="text-center ion ion-erlenmeyer-flask" alt="Product Image"></span>
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" id="ultimoIngreso3" class="product-title">
                      <span class="label label-warning pull-right" id="ultimoIngresoCant3"></span></a>
                        <span id="ultimoIngresoCat3" class="product-description">
                          
                        </span>
                  </div>
                </li> -->
                <!-- //////////////////////////////.item -->
              <!-- </ul> -->
            <!-- </div> -->
            <!-- //////////////////////////////////.box-body -->
            <!-- <div class="box-footer text-center">
              <a href="javascript:void(0)" id="verIngresos" class="menuconsultas uppercase">Ver Todos</a>
            </div> -->
            <!-- /////////////////////////////////////////.box-footer -->
          </div>
          <!-- ////////////////////////////////////////.box -->

        </section>



      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
    </div>
    <script>

/*document.addEventListener("click", function() {
  console.log("reiniciar tiempo"); 
    //reiniciar el tiempo de sesion
    $.ajax({
      async: true,
      type: "POST",
      url: 'Login/actualizarTiempo', 
      cache: false,
      data: 'json',
      dataType: 'json',
    })
})*/


</script>

