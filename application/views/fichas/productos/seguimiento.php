  
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    
        <section class="content-header">
	      <h1>
	        Seguimiento
	        <small>Asignar Seguimiento</small>
	      </h1>
	      
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
	        <li><a href="#">Inventario</a></li>
	        <li class="active">Asignar Seguimiento</li>
	      </ol>
	    </section>
	   
	    <section class="content">
	    	<form id="formNuevo" action="POST">
	    		<div class="row">
	    			<div class="col-md-12">
	    				<select id="selectProducto" class="form-control select2" style="width: 100%;">
        				</select>
	    			</div>
	    		</div>
	    		<div class="row" style="margin-top:50px;">
			        <div class="col-xs-12">
			          <div class="box">
			            <div class="box-header">
			              <h3 class="box-title">Lista de Productos</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body table-responsive no-padding">
			            
				            <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">
				               <thead><tr><th>Codigo</th><th>Producto</th><th>Presentación</th><th>Cantidad</th></tr></thead>
				            </table>
			              
			            </div>
			            <!-- /.box-body -->
			          </div>
			          <!-- /.box -->
			        </div>
			        <!-- /.col -->
			     </div>
        
	      
	        <center><div id="result" style="margin-top:50px;"></div></center>
        </section>
        </form> 

</div>
<!-- ./wrapper -->

<!--Modal Consulta de Producto-->
    <div class="modal fade consultarRem bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Asignar Seguimiento</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              
              
              <div class="box-body table-responsive no-padding">
                
                	<div class="col-md-12">
                		<div id="resultado"></div>
	                </div>
               
              </div>
            </div>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>