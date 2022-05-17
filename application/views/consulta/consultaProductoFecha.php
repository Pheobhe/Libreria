
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">



      
      <h1>
        Consultar por fecha de Ingreso-Egreso
        <small>Consulta General</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Consultas</a></li>
        <li class="active">Consultar General</li>
      </ol>
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
    <div class="row" style="margin-bottom:50px;">
      <div class="col-xs-3">
        <div class="form-group">
          <label>Fecha Inicio:</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-fw fa-calendar-minus-o"></i></span>

              <input required type="text" name="fechaIn" id="fechaIn" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
            </div>
        </div>
      </div>

      <div class="col-xs-3">
        <div class="form-group">
          <label>Fecha Fin:</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-fw fa-calendar-plus-o"></i></span>
              <input required type="text" name="fechaFin" id="fechaFin" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
            </div>
        </div>
      </div>
    
      <div class="col-xs-6">
        <div id="impresion">
          
          <button class="btn btn-app avoid-this" id="buscar">
                <i class="fa fa-search"></i> BUSCAR
          </button>
        </div>
      </div>
    </div>  

    <form id="mov" action="POST">
      

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Productos:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
             <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">
               

             </table>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </form>
    </section>
    <!-- /.content -->
   
    <!--Modal Consulta de Producto-->
    <div class="modal fade consultarRem bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detalle Autorizacion</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              
              
              <div class="box-body table-responsive no-padding">
                <table id="tablaConsulta" class="table table-hover" cellspacing="0" width="100%">
                  
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div>












  
</div>
<!-- ./wrapper -->