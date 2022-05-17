  
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    
        <section class="content-header">
	      <h1>
	        Productos
	        <small>Nuevo Producto</small>
	      </h1>
	      
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
	        <li><a href="#">Fichas</a></li>
	        <li class="active">Productos</li>
	      </ol>
	    </section>
	   
	    <section class="content">
	    	<form id="formNuevo" action="POST">
	    	<div class="row">
	    		<div class="col-md-12">
	    		 
	              <div class="input-group">
	                <span class="input-group-addon">Producto:</span>
	                <input type="text" value="" placeholder="Nombre del Producto" class="form-control" name="nombreProducto" id="nombreProducto">
	              </div>
	              <!-- nombreProducto -->
	            </div>
	             
	        </div>
	        <div class="row">
	        	<!-- <div class="col-md-12"> -->
	              <div class="form-group">
	               
	              </div>
	            <!-- </div> -->
	        </div>
	        <div class="row">
	    		<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Stock Mínimo:</span>
	                <input id="stock_minimo" name="stock_minimo"  type="text" class="form-control" placeholder="Stock Minimo">
	              </div>
	            </div>
	        </div>

	       
          	<div class="row">
	        	<div class="col-md-12">
	              <div class="form-group">
	                <label>Presentación :</label>
	                <select id="presentacion" class="form-control select2" style="width: 100%;">
	                	<option id='LIBRERIA'>LIBRERIA</option>
						<option id='INSUMOS'>INSUMOS</option>
						<option id='MOBILIARIO'>MOBILIARIO</option>
					</select>
	              </div>
	            </div>
	        </div>
        
	        <button type="button" id="addProducto" class="btn btn-primary pull-right">Guardar</button>
	        <center><div id="result" style="margin-top:50px;"></div></center>
        </section>
        </form> 

</div>
<!-- ./wrapper -->

