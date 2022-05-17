
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">



      
      <h1>
        Ingreso
        <small>Ingreso General</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ingreso</a></li>
        <li class="active">Ingreso General</li>
      </ol>
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
    <div class="row" style="margin-bottom:50px;">
    <form id="close" action="javascript:void(0);">
      <div class="col-xs-6 col-md-3 ">
        <label>Número de Remito</label>
        <select id="selectRemito" class="inputs form-control select2" style="width: 100%;">
        </select>
      </div>
      <div class="col-xs-6 col-md-3">
        <div class="form-group">
        <label>Responsable Ingreso</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
            <input required id="responsableIng" name="responsableIng" type="text" class="inputs form-control" placeholder="Responsable Ingreso">
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <div id="impresion">
          
          <button class="inputs btn btn-app avoid-this" type="button" id="cerrar">
                <i class="fa fa-file-text-o"></i> Ingresar
          </button>
        </div>
      </div>
      </form>
    </div> 

    <div class="row">
      <div class="col-md-12">
        <center><div id="result" style="margin-top:50px;"></div></center>
      </div>
    </div> 

    <form id="mov" action="javascript:void(0);">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Datos Remito</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                  <label>Número Remito</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
                      <input disabled id="numauto" name="numauto" type="text" class="form-control" placeholder="N° Autorizacion" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
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

                <div class="col-xs-6 col-md-3">
                  <div class="form-group">
                    <label>Destino</label>
                    <input disabled id="selectDestino" type="text" class="form-control">                  
                                  
                  </div>
                </div>

                <div class="col-xs-6 col-md-3">
                  <div class="form-group">
                    <label>Usuario</label>
                    <input disabled id="selectUsuario" type="text" class="form-control ">                  
                                  
                  </div>
                </div>

                <div class="col-xs-6 col-md-3 ">
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
               <thead><tr><th>Id</th><th>Presentación</th><th>Producto</th><th>Cantidad</th><th>Estado</th></tr></thead>

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