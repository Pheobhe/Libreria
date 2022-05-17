</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    
        <section class="content-header">
	      <h1>
	        Productos
	        <small>Eliminar Producto</small>
	      </h1>
	      
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
	        <li><a href="#">Fichas</a></li>
	        <li class="active">Eliminar Producto</li>
	      </ol>
	    </section>

	    <section class="content">
	    	<div class="row">
	    		<div class="col-md-12">
	              <div class="form-group">
	                <label>Producto:</label>
	                <select id="selectProducto" class="form-control select2" style="width: 100%;">    
	                </select>
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

	    <button type="button" id="deleteProducto" class="btn btn-primary pull-right">Eliminar</button>

</div>
<!-- ./wrapper -->