


  
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">


      <!--<button type="button" id="newArt" class="btn btn-app" data-toggle="modal" data-target=".newart">
        <i class="fa fa-edit"></i>Nuevo
      </button>-->

      <button id="consultarArt" type="button" class="btn btn-app" data-toggle="modal" data-target=".consultarart">
        <span class="badge bg-green"></span><i class="fa fa-barcode"></i>Consultar
      </button>

      
      <h1>
        Productos
        <small>Listado de Productos</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Fichas</a></li>
        <li class="active">Producto</li>
      </ol>
    </section>
    
    <!--Modals-->

    <!--Modal Alta de Producto-->
    <div class="modal fade newart bs-example-modal-lg" id="modalProducto" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar Nuevo Producto</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="input-group">
                <span class="input-group-addon">Nombre:</span>
                <input name="nombreproducto" type="text" class="form-control" placeholder="Nombre Producto">
              </div>
              <br>
              <div class="form-group">
                <label>Marca</label>
                <select id="marca" class="form-control select2" style="width: 100%;">
                  
                </select>
              </div>

              <div class="form-group">
                <label>Droga</label>
                <select id="droga" class="form-control select2" style="width: 100%;">
                  <option selected="selected">PEDIATRICOS</option>
                  <option>ANTIBIOTICOS</option>
                  <option>PRESENTACION1</option>
                  <option>PRESENTACION2</option>
                  <option>PRESENTACION3</option>
                  <option>PRESENTACION4</option>
                  
                </select>
              </div>

              <div class="form-group">
                <label>Presentación</label>
                <select id="presentacion" class="form-control select2" style="width: 100%;">
                  <option selected="selected">1</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="button" id="addProducto" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
    </div>


<!--Modal Consulta de Producto-->
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
                  <option selected="selected">Aspirina</option>
                  <option>Viagra</option>
                  <option>Ibuprofeno</option>
                  <option>Clona</option>
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


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
            

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
             <table id="tablaPrincipal" class="table table-bordered table-striped table-hover"></table>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  


  
</div>
<!-- ./wrapper -->



