
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">



      
      <h1>
        Consultar Productos\Destinos
        <small>Consulta General</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Consultas</a></li>
        <li><a href="#">General</a></li>
        <li class="active">Productos\Destinos</li>
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
          
          <button class="btn btn-app avoid-this" id="buscarArtDes">
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
              <h3 class="box-title">Productos/Destinos:</h3>
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

</div>
<!-- ./wrapper -->