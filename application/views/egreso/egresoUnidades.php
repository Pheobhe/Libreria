
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
      <h1>
        Egreso Unidades
        <small>Egreso de Productos</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Egreso</a></li>
        <li class="active">Egreso Unidades</li>
      </ol>

      <div class="row" style="margin-top:30px;">
        <div class="col-md-3">
          <button class="btn btn-app" id="volverEgreso"><- VOLVER</button>
          
        </div>
      </div>
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">


    <form id="mov" action="POST">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Ingresar datos</h3>
            </div>
            <div class="box-body">    


            <div class="row">
              <div class="col-md-3">
                  <div class="form-group">
                    <label>Unidad</label>
                                     
                    <select disabled id="selectDestino" class="form-control select2" style="width: 100%;">
                    <option value="<?php echo $id_destino ?>"><?php echo $nombre;?></option> 
                    </select>      
                  </div>
                </div>
            </div>

              <div class="row">
                

                <div class="col-xs-3">
                <!-- Date dd/mm/yyyy -->
                  <div class="form-group">
                    <label>Fecha :</label>

                    <div class="input-group">
                      <div id="fechaHoy" class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="datepicker" id="datepicker" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                </div>



                <div class="col-xs-3">
                  <div class="form-group">
                  <label>Responsable</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                      <input required id="responsable" name="responsable" type="text" class="form-control" placeholder="Responsable">
                    </div>
                  </div>
                </div>

                

                

                <div class="col-xs-3">
                  <div class="form-group">
                    <label>Usuario</label>
                    <select disabled id="selectUsuario" class="form-control select2" style="width: 100%;">                  
                    </select>                
                  </div>
                </div>

              </div>

              

            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <div class="row no-print">
        <div class="col-xs-12">
          <button id="consultarArt" type="button" class="btn btn-app" data-toggle="modal" data-target=".consultarart">
            <i class="fa fa-plus"></i>Agregar Producto
          </button>
          <button id="ingresarRemito" type="button" class="btn btn-app">
            <i class="fa fa-save"></i>Guardar
          </button>
          <label id="errorStock" style="color:#f56954;"></label>
          <center><div id="result" style="margin-top:50px;"></div></center>

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
               <thead><tr><th>Id</th><th>Producto</th><th>Presentaci??n</th><th>Total</th><th>Cantidad</th></tr></thead>

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
  

 <div id="impresion" >
      
      <button style="display:none;" id="imp">IMPRIMIR</button>
    </div>
  
</div>
<!-- ./wrapper -->



<!--Modal Agregar Producto-->
    <div class="modal fade consultarart bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Consultar Producto</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              
              <br>

              <div class="form-group">
                <label>Nombre</label>
                <select id="consultaNombre" class="form-control select2" style="width: 100%;">
                 
                </select>
                
              </div>
              
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


   