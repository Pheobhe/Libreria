  
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    
        <section class="content-header">
	      <h1>
	        Proveedores
	        <small>Nuevo Proveedor</small>
	      </h1>
	      
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
	        <li><a href="#">Fichas</a></li>
	        <li class="active">Proveedores</li>
	      </ol>
	    </section>
	   
	    <section class="content">
	    	<form id="formNuevo" action="POST">
	    	<div class="row">
	    		<div class="col-md-12">
	    		 
	              <div class="input-group">
	                <span class="input-group-addon">Nombre:</span>
	                <input type="text" value="" placeholder="nombre" class="form-control" name="nombreProveedor" id="nombreProveedor">
	              </div>
	              <br>
	            </div>
	             
	        </div>
	        <div class="row">
	        	<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Cuit:</span>
	                <input id="cuit" name="cuit"  type="text" class="form-control" placeholder="Cuit">
	              </div>
	              <br>
	            </div>
	        </div>
	        <div class="row">
	    		<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Direccion:</span>
	                <input id="direccion" name="direccion"  type="text" class="form-control" placeholder="Direccion">
	              </div>
	              <br>
	            </div>
	        </div>
	        <div class="row">
	    		<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Telefono:</span>
	                <input id="telefono" name="telefono"  type="text" class="form-control" placeholder="telefono">
	              </div>
	              <br>
	            </div>        
          	</div>
          	<div class="row">
	    		<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Email:</span>
	                <input id="email" name="email"  type="text" class="form-control" placeholder="Email">
	              </div>
	              <br>
	            </div>        
          	</div>

          	<div class="row">
	    		<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Contacto:</span>
	                <input id="contacto" name="contacto"  type="text" class="form-control" placeholder="Contacto">
	              </div>
	              <br>
	            </div>        
          	</div>
        
	        <button type="button" id="addProveedor" class="btn btn-primary pull-right">Guardar</button>
	        <center><div id="result" style="margin-top:50px;"></div></center>
        </section>
        </form> 
</div>
<!-- ./wrapper -->

