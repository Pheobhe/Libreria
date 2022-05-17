  
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    
        <section class="content-header">
	      <h1>
	        Inventario
	        <small>Cambiar ubicación</small>
	      </h1>
	      
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
	        <li><a href="#">Inventario</a></li>
	        <li class="active">Cambio ubicación</li>
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
			              <h3 class="box-title">Lista de Articulos</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body table-responsive no-padding">
			            
				            <table id="tablaPrincipal" class="table table-bordered table-striped table-hover">
				               <thead><tr><th>Codigo</th><th>Producto</th><th>Presentacion</th><th>Fecha Vencimiento</th><th>Cantidad</th><th>Tamaño</th><th>Inventario</th></tr></thead>
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

<!--Modal Consulta de Articulo-->
    <div class="modal fade consultarRem bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Cambiar Ubicacion Inventario</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
             <div class="box-body table-responsive no-padding">
              
             	<div class="col-md-12">
            		<input type="hidden" disabled="true"  name="camTamInv" id="camTamInv">
		                <select id="inventario" class="form-control select2" style="width:100%">
		                	
		                </select>
	                </div>
               
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="button" id="guardarInv" class="btn btn-success pull-right" data-dismiss="modal">Guardar</button>
          </div>
        </div>
      </div>
    </div>