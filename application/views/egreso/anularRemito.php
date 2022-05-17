
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">



      
      <h1>
        Consultar Remitos
        <small>Remitos</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Consultas</a></li>
        <li class="active">Consultar Autorizacion</li>
      </ol>
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
    <div class="row" style="margin-bottom:50px;">
      <div class="col-xs-6">
        <label>Número de Remito</label>
        <select id="selectAutorizacion" class="form-control select2" style="width: 100%;">
        </select>
      </div>
      <div class="col-xs-6">
        <div id="impresion">
          
          <button class="btn btn-app avoid-this" id="anularRem">
                <i class="fa fa-remove"></i> Anular
          </button>
        </div>
      </div>
    </div>  

    <div class="row">
      <div class="col-md-12">
        <center><div id="result" ></div></center> 
      </div>
    </div> 

    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                Al anular un Remito también se anulará la autorización asociada.
        </div>
      </div>
    </div>
    <form id="mov" action="POST">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Datos Remito</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-2">
                  <div class="form-group">
                  <label>Número Autorización</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
                      <input disabled id="numauto" name="numauto" type="text" class="form-control" placeholder="N° Autorizacion" required>
                    </div>
                  </div>
                </div>
                <div class="col-xs-2">
                  <div class="form-group">
                  <label>Número Remito</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
                      <input disabled id="numRem" name="numRem" type="text" class="form-control" placeholder="N° Remito" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-3">
                <!-- Date dd/mm/yyyy -->
                  <div class="form-group">
                    <label>Fecha:</label>

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
                    <label>Destino</label>
                    <input disabled id="selectDestino" type="text" class="form-control">                  
                                  
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
              <h3 class="box-title">Lista de Productos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
             <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">
                <thead><tr><th>id</th><th>Nombre</th><th>Unidad</th><th>Descripcion</th><th>Cantidad</th></th></tr></thead>

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
   <!-- precarga de imagenes -->
   <img class="img-responsive" src="../theme/dist/img/membrete.png" alt="Inicio" style="display:none">
   <img class="img-responsive" src="../theme/dist/img/original.png" alt="Inicio" style="display:none">
   <img class="img-responsive" src="../theme/dist/img/duplicado.png" alt="Inicio" style="display:none">
   <img class="img-responsive" src="../theme/dist/img/triplicado.png" alt="Inicio" style="display:none">


  
</div>
<!-- ./wrapper -->