</head>
    <section class="content-header">
      
      <h1>
        Autorización
         <small>Histórico</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Consultas</a></li>
        <li class="active">Histórico de Autorización</li>
      </ol>
    </section>
 
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
    <div class="row" style="margin-bottom:50px;">
      <div class="col-xs-6">
        <label>Número</label>
        <select id="selectAutorizacion" class="form-control select2" style="width: 100%;">
        </select>
      </div>
     <!--  <div class="col-xs-6">
        <div id="impresion">
          
          <button class="btn btn-app avoid-this" id="imp">
                <i class="fa fa-print"></i> IMPRIMIR
          </button>
        </div>
      </div> -->
    </div>  

    <form id="mov" action="POST">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Datos Autorización</h3>
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
<div class="row">
                <div class="col-xs-3">
                  <div class="form-group">
                  <label>Destinatario</label>
                     <input disabled required id="destinatario" name="destinatario" type="text" class="form-control" placeholder="Destinatario">
                    </div>
                  
                </div>
                  <div class="col-xs-3">
                    <div class="form-group">
                  <label>Número Expte. GDEBA</label>
                      <input disabled required id="oficio" name="oficio" type="text" class="form-control" placeholder="Gdeba">
                  </div>
                </div>
          </div> 
          
            <div class="row">
                <div class="col-xs-12">
                   <div class="form-group">
                      <label>Observaciones</label>
                      <input disabled id="observaciones" name="obs" type="text" class="form-control" placeholder="Observaciones">
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
               <thead><tr><th>Id</th><th>Nombre</th><th>Unidad</th><th>Descripcion</th><th>Cantidad</th></th></tr></thead>

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


  
</div>
<!-- ./wrapper -->