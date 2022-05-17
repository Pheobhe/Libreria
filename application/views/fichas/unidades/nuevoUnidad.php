  
</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    
        <section class="content-header">
	      <h1>
	        Unidades
	        <small>Nueva Unidad</small>
	      </h1>
	      
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
	        <li><a href="#">Fichas</a></li>
	        <li class="active">Unidades</li>
	      </ol>
	    </section>
	   
	    <section class="content">
	    	<form id="formNuevo" action="POST">
	    	<div class="row">
	    		<div class="col-md-12">
	    		 
	              <div class="input-group">
	                <span class="input-group-addon">Nombre:</span>
	                <input type="text" value="" placeholder="nombre" class="form-control" name="nombreUnidad" id="nombreUnidad">
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
	                <span class="input-group-addon">Contacto:</span>
	                <input id="contacto" name="contacto"  type="text" class="form-control" placeholder="Contacto">
	              </div>
	              <br>
	            </div>        
          	</div>

          	<div class="row">
	    		<div class="col-md-12">
	              <div class="input-group">
	                <span class="input-group-addon">Codigo Postal:</span>
	                <input id="codigoPostal" name="codigoPostal"  type="text" class="form-control" placeholder="Codigo Postal">
	              </div>
	              <br>
	            </div>        
          	</div>
        
	        <button type="button" id="addUnidad" class="btn btn-primary pull-right">Guardar</button>
	        <center><div id="result" style="margin-top:50px;"></div></center>
        </section>
        </form> 
</div>
<!-- ./wrapper -->

