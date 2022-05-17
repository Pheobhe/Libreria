
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">

    
      <h1>
        Movimiento
        <small>Consulta de Ingreso de Productos</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Consultas</a></li>
        <li class="active">Consultar Movimiento</li>
      </ol>
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
    <div class="row" style="margin-bottom:50px;">
      <div class="col-xs-6">
        <label>Número de Movimiento</label>
        <select id="selectMovimiento" class="form-control select2" style="width: 100%;">
        </select>
      </div>
    </div>  

    <form id="mov" action="POST">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Datos de movimiento</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-2">
                  <div class="form-group">
                  <label>Numero Remito</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
                      <input disabled id="numremito" name="numremito" type="text" class="form-control" placeholder="N° Remito" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-3">
                <!-- Date dd/mm/yyyy -->
                  <div class="form-group">
                    <label>Fecha de Ingreso:</label>

                    <div class="input-group">
                      <div  id="fechaHoy" class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input disabled type="text" name="datepicker" id="datepicker" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                </div>

                <div class="col-xs-3">
                  <div class="form-group">
                    <label>Proveedor</label>
                    <input disabled id="selectProveedor" type="text" class="form-control">                  
                                  
                  </div>
                </div>

                <div class="col-xs-3">
                  <div class="form-group">
                    <label>Usuario</label>
                    <input disabled id="selectUsuario" type="text" class="form-control ">                  
                                  
                  </div>
                </div>

                <div class="col-xs-3">
                  <div class="form-group">
                  <label>Responsable</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                      <input disabled required id="responsable" name="responsable" type="text" class="form-control" placeholder="Responsable">
                    </div>
                  </div>
                </div>

              </div>

              

            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
             <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">
               <thead><tr><th>Id</th><th>Nombre</th><th>Unidad</th><th>Cantidad</th></th></tr></thead>

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
  


  
</div>
<!-- ./wrapper -->