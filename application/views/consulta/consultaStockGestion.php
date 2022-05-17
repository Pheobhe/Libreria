
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">



      
      <h1>
        Consultar Stock D.P.S.P
        <small>Productos para Autorizar</small>
      </h1>
      
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Stock</a></li>
        <li class="active">Stock sin Descuento</li>
      </ol>
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-xs-6">
        <label>Por Presentacion:</label>
        <select id="selectPresentacion" class="form-control select2" style="width: 100%;"></select>
      </div>
      <div class="col-xs-6">
        <label>Por Producto:</label>
        <select id="selectProducto" class="form-control select2" style="width: 100%;"></select>
      </div>
    </div>
    <div class="row" style="margin-top:50px;">
      
      <div class="col-xs-6">
        <div id="impresion">
         
          <button class="btn btn-app avoid-this" id="showallid">
                <i class="ion ion-ios-pricetags-outline"></i> MOSTRAR POR PRODUCTO
          </button>
          <button class="btn btn-app avoid-this" id="resetfilter">
                <i class="fa fa-refresh"></i> RESETEAR FILTROS
          </button>
        </div>
      </div>
      
      
    </div>  

    <div class="row text-center" id="legend" style="margin-top:50px;margin-bottom:20px;">
      
    </div>

    <form id="mov" action="POST">
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Productos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
             <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">
               <thead><tr><th>Codigo</th><th>Producto</th><th>Presentación</th><th>Cantidad</th><th>Stock Mínimo</th></tr></thead>

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