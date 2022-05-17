<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library(array('session', 'form_validation'));
		$this->load->library('ajax');
		if ($this->input->is_ajax_request())
			{
				if (!$this->ajax->resolverCredenciales()){
					exit;
				}
			}
	}



	public function index()
	{
		
		
	}

	public function mostrarDatos()
	{
		$data['producto'] = $this->load->view('fichas/productos/data', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['producto']);
	}

	

	public function mostrarDatosConsulta()
	{	
		$data['consultaStock'] = $this->load->view('consulta/consultaStock', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['consultaStock']);	
	}

	public function mostrarDatosConsultaGestion()
	{	
		$data['consultaStockGestion'] = $this->load->view('consulta/consultaStockGestion', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['consultaStockGestion']);	
	}

	public function mostrarDatosNuevoArt()
	{	
		$data['nuevoproducto'] = $this->load->view('fichas/productos/nuevoproducto', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['nuevoproducto']);	
	}

	public function mostrarDatosEliminarArt()
	{	
		$data['eliminarproducto'] = $this->load->view('fichas/productos/eliminarProducto', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['eliminarproducto']);	
	}

	public function mostrarDatosInventario()
	{	
		$data['inventarioCambio'] = $this->load->view('fichas/productos/inventarioCambio', NULL, TRUE);
		echo json_encode($data['inventarioCambio']);	
	}

	// public function mostrarDatosSeguimiento()
	// {	
	// 	$data['seguimiento'] = $this->load->view('fichas/productos/seguimiento', NULL, TRUE);
	// 	//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
	// 	echo json_encode($data['seguimiento']);	
	// }

	public function mostrarDatosStockMin()
	{	
		$data['StockMin'] = $this->load->view('fichas/productos/stockMin', NULL, TRUE);
		echo json_encode($data['StockMin']);	
	}

	// public function mostrarDatosEstadisticas()
	// {	
	// 	$data['estadisticas'] = $this->load->view('consulta/estadisticas', NULL, TRUE);
	// 	//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
	// 	echo json_encode($data['estadisticas']);	
	// }

	public function getProductos()  //oookkkkkk producto de Fichas NO TOCAR
	{
		
		if($this->session->logged_in==TRUE){
			$this->load->model('Producto_model');
			$data['productos']=$this->Producto_model->getProductos();
			if ($data['productos']){
	          echo json_encode($data['productos']);		
			}else{
			  	$vista="<h3>No hay productos</h3>";
			  	echo json_encode($vista);	
			}	
		}else{
			echo json_encode("acceso_denegado");
		}
	}

	public function getCantidadProductos()
	{
		$this->load->model('Producto_model');
		$data['productos']=$this->Producto_model->getCantidadProductos();
		if ($data['productos']){
			//var_dump($data['productos']);
          echo json_encode($data['productos']);		
		}else{
		  	$vista="0";
		  	echo json_encode($vista);	
		}	
	}

	public function addProducto()
	{
		$this->load->model('Producto_model');
		$producto=$this->input->post('producto');
	    $stock_minimo=$this->input->post('stock_minimo');
		$presentacion=$this->input->post('presentacion');
		$resultado=$this->Producto_model->addproducto($producto,$stock_minimo,$presentacion);
		echo json_encode($resultado);
	}

	public function deleteProducto()
	{
		$this->load->model('Producto_model');
		$id_producto=$this->input->post('id_producto');
		$resultado=$this->Producto_model->deleteProducto($id_producto);
		echo json_encode($resultado);
	}

	public function getPresentacion()
	{
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getPresentacion();
		echo json_encode($resultado);
	}

	
	public function getNombresArt()
	{
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getNombresArt();
		echo json_encode($resultado);
	}

	// public function getNombresArtSeguimiento()
	// {
	// 	$this->load->model('Producto_model');
	// 	$resultado=$this->Producto_model->getNombresArtSeguimiento();
	// 	echo json_encode($resultado);
	// }

	public function getNombresArtEliminar()
	{
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getNombresArtEliminar();
		echo json_encode($resultado);
	}

	public function getProductosNombre()
	{
		$nombre=$this->input->post('producto');
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getProductosNombre($nombre);
		echo json_encode($resultado);
	}

	public function getProductosId()
	{
		$id=$this->input->post('id_producto');
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getProductosId($id);
		echo json_encode($resultado);
	}

	public function getProductosstock(){
		$nombre=$this->input->post('nombre');
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getProductosStock($nombre);
		echo json_encode($resultado);
	}

	public function getnombresArtConStock() 
	{
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getNombresArtConStock();
		echo json_encode($resultado);
	}


	//Funcion para consulta de stock por id_producto getProductoById
	public function getProductoById(){

		$this->load->model('Producto_model');
		$id=$this->input->post('id_producto');
		$resultado=$this->Producto_model->getProductoById($id);
		echo json_encode($resultado);
	}

	//Funcion para consulta de stock por id_producto
	public function getproductoByIdGestion(){
		$this->load->model('Producto_model');
		$id=$this->input->post('id_producto');
		$resultado=$this->Producto_model->getproductoByIdGestion($id);
		echo json_encode($resultado);
	}

	//obtener el stock de todos los productos
	public function getAllStock()
	{
		$this->load->model('Producto_model');
		$data['productos']=$this->Producto_model->getAllStock();
		if ($data['productos']){
          echo json_encode($data['productos']);		
		}else{
		  	$vista="<h3>No hay productos</h3>";
		  	echo json_encode($vista);	
		}	
	}

	//obtiene todo el stock de una unidad seleccionada
	public function getAllStockUnidades()
	{
		$id_destino=1;//$this->input->post->('id_destino')
		$this->load->model('Producto_model');
		$data['productos']=$this->Producto_model->getAllStockUnidades($id_destino);
		if ($data['productos']){
          echo json_encode($data['productos']);		
		}else{
		  	$vista="<h3>No hay productos</h3>";
		  	echo json_encode($vista);	
		}	
	}

	//obtener el stock de todos los productos restando los pendientes
	public function getAllStockGestion()
	{
		$this->load->model('Producto_model');
		$data['productos']=$this->Producto_model->getAllStockGestion();
		if ($data['productos']){
          echo json_encode($data['productos']);		
		}else{
		  	$vista="<h3>No hay productos</h3>";
		  	echo json_encode($vista);	
		}	
	}
	//obtener stock agrupado por id
	public function getAllStockId()
	{
		$this->load->model('Producto_model');
		$data['productos']=$this->Producto_model->getAllStockId();
		if ($data['productos']){
          echo json_encode($data['productos']);		
		}else{
		  	$vista="<h3>No hay productos</h3>";
		  	echo json_encode($vista);	
		}	
	}

	//obtener stock agrupado por id
	public function getAllStockIdGestion()
	{
		$this->load->model('Producto_model');
		$data['productos']=$this->Producto_model->getAllStockIdGestion();
		if ($data['productos']){
          echo json_encode($data['productos']);		
		}else{
		  	$vista="<h3>No hay productos</h3>";
		  	echo json_encode($vista);	
		}	
	}

	//consulta producto por presentacion en consulta de stock; 
	public function getProductoByPre(){
		$this->load->model('Producto_model');
		$pre=$this->input->post('presentacion');
		$resultado=$this->Producto_model->getProductoByPre($pre);
		echo json_encode($resultado);
	}

	public function getProductosPre(){ 
		$this->load->model('producto_model');
		$pre=$this->input->post('presentacion');
		$resultado=$this->producto_model->getProductosPre($pre);
		echo json_encode($resultado);
	}

	//consulta producto por presentacion en consulta de stock;
	public function getProductoByPreGestion(){
		$this->load->model('Producto_model');
		$pre=$this->input->post('presentacion');
		$resultado=$this->Producto_model->getProductoByPreGestion($pre);
		echo json_encode($resultado);
	}

	public function getProductosPreGestion(){
		$this->load->model('Producto_model');
		$pre=$this->input->post('presentacion');
		$resultado=$this->Producto_model->getproductosPreGestion($pre);
		echo json_encode($resultado);
	}

	
	public function getSinStockGestion(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getSinStockGestion();
		echo json_encode($resultado);
	}


	public function getDatosInv()
	{
		$this->load->model('Producto_model');
		$camTamInv=$this->input->post('camTamInv');
		$resultado=$this->Producto_model->getDatosInv($camTamInv);
		echo json_encode($resultado);
	}



	public function actualizarInv()
	{
		$this->load->model('Producto_model');
		$camTamInv=$this->input->post('camTamInv');
		$inventario=$this->input->post('inventario');
		$resultado=$this->Producto_model->actualizarInv($camTamInv,$inventario);
		echo json_encode($resultado);
	}

	

	public function actualizarStockMin(){
		$this->load->model('Producto_model');
		$id=$this->input->post('idart');
		$stock_minimo=$this->input->post('stock_minimo');
		$resultado=$this->Producto_model->actualizarStockMin($id,$stock_minimo);
		echo json_encode($resultado);
	}


	/*DASHBOARD*/  
	public function getCantidadDashboard(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getCantidadDashboard();
		echo json_encode($resultado);
	}

	

	public function getStockMin(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getStockMin();
		echo json_encode($resultado);
	}

	public function getSinStock(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getSinStock();
		echo json_encode($resultado);
	}

	/*ESTADISTICAS*/

	public function getproductosDia(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getproductosDia();
		echo json_encode($resultado);
	}

	public function getConsumos(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getConsumos();
		echo json_encode($resultado);
	}
	public function getproductosMasConsumos(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getproductosMasConsumos();
		echo json_encode($resultado);
	}


	public function getPresentacionConsumo(){
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->getPresentacionConsumo();
		echo json_encode($resultado);
	}


	public function obtenerProductosById(){ 
		$this->load->model('Producto_model');
		$id_producto=$this->input->post('id_producto');
		$resultado=$this->Producto_model->getProducto($id_producto);
		echo json_encode($resultado);
	}

	public function obtenerProductosByIdSeguimiento()
	{
		$this->load->model('Producto_model');
		$id_producto=$this->input->post('id_producto');
		$tamano=$this->input->post('tamano');
		$inventario=$this->input->post('inventario');
		$resultado=$this->Producto_model->getProductosSeguimiento($id_producto,$tamano,$inventario);
		echo json_encode($resultado);
	}





	public function obtenerProductosByDestino(){
		$this->load->model('Producto_model');
		$id_destino=$this->input->post('id_destino');
		$resultado=$this->Producto_model->getProductosDestino($id_destino);
		echo json_encode($resultado);
	}

	public function mostrarVistaProductos(){
		$data['producto'] = $this->load->view('consulta/consultaProducto', NULL, TRUE);
		echo json_encode($data['producto']);
	}

	public function mostrarVistaProductosFecha()
	{	
		$data['producto'] = $this->load->view('consulta/consultaProductoFecha', NULL, TRUE);
		echo json_encode($data['producto']);	
	}

	public function mostrarVistaProductosSeguimiento()
	{	
		$data['consultaSeguimiento'] = $this->load->view('consulta/consultaSeguimiento', NULL, TRUE);
		echo json_encode($data['consultaSeguimiento']);	
	}


	public function mostrarVistaConsultaDestino()
	{	
		$data['consultaDestino'] = $this->load->view('consulta/consultaDestino', NULL, TRUE);
		echo json_encode($data['consultaDestino']);	
	}
	// public function mostrarVistaProductosDestino()
	// {	
	// 	$data['productosDestino'] = $this->load->view('consulta/consultaDobleEntrada', NULL, TRUE);
	// 	echo json_encode($data['productosDestino']);	
	// }

	public function getProductoByFecha()
	{	
		$this->load->model('Producto_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		//$fechaIn = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$fechaIn);
		//$fechaFin = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$fechaFin);
		$resultado=$this->Producto_model->getProductosByFecha($fechaIn,$fechaFin);
		echo json_encode($resultado);	
	}

	

	//funcion para crear el cuadro de doble entrada entre productos y destinos.
	public function dobleEntrada()
	{
		$inicio=$this->input->post('fechaIn');
		$fin=$this->input->post('fechaFin');
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->dobleEntrada($inicio,$fin);
		echo json_encode($resultado);	
	}


	//funcion para añadir producto a seguimiento
	public function setSeguimiento()
	{
		$id_producto=$this->input->post('id_producto');
		$tamano=$this->input->post('tamano');
		$inventario=$this->input->post('inventario');
		$this->load->model('Producto_model');
		$resultado=$this->Producto_model->setSeguimiento($id_producto, $tamano, $inventario);
		echo json_encode($resultado);	
	}



}