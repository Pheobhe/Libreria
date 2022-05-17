<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
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
	//Funciones para Mostrar views
	public function mostrarDatos()
	{
		$data['nota'] = $this->load->view('ingreso/movimiento/nota', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['nota']);
	}

	public function mostrarDatosConsulta()
	{	
		$data['consultaNota'] = $this->load->view('consulta/consultaNota', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['consultaNota']);	
	}

	public function mostrarDatosAnular()
	{	
		$data['anularNota'] = $this->load->view('ingreso/movimiento/anularNota', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['anularNota']);	
	}

	public function mostrarDatosFecha()
	{	
		$data['consultaNotaFecha'] = $this->load->view('consulta/consultaNotaFecha', NULL, TRUE);
		echo json_encode($data['consultaNotaFecha']);	
	}

	//Funciones Para Ingreso Movimiento
	public function getProveedores()
	{
		$this->load->model('Proveedor_model');
		$resultado=$this->Proveedor_model->getListaProveedores();
		echo json_encode($resultado);
	}

	public function getUsuarios()
	{
		$this->load->model('Usuario_model');
		$resultado=$this->Usuario_model->getListaUsuarios();
		echo json_encode($resultado);
	}

	public function addNota()
	{
		$this->load->model('Nota_model');
		$data['detalle']=$this->input->post('data');
		$data['cab']=$this->input->post('cab');
		$resultado=$this->Nota_model->addNota($data['cab'],$data['detalle']);
		echo json_encode($resultado);
	}

	//Funciones para Consultar Movimientos.
	public function getNotaById(){
		$this->load->model('Nota_model');
		$id=$this->input->post('id_devolucion');
		$resultado=$this->Nota_model->getNotaById($id);
		echo json_encode($resultado);
	}

	
	public function getCantidadIngresos()
	{
		$this->load->model('Movimiento_model');
		$data['Ingresos']=$this->Movimiento_model->getCantidadProductos();
		if ($data['Ingresos']){
			//var_dump($data['Productos']);
          echo json_encode($data['Ingresos']);		
		}else{
		  	$vista="0";
		  	echo json_encode($vista);	
		}	
	}


	public function getUltimosIngresos(){
		$this->load->model('Movimiento_model');
		$data['UltimosIng']=$this->Movimiento_model->getUltimosIngresos();
		if ($data['UltimosIng']){
			//var_dump($data['Productos']);
          echo json_encode($data['UltimosIng']);		
		}else{
		  	$vista="0";
		  	echo json_encode($vista);	
		}	

	}

	public function getNotas(){
		$this->load->model('Nota_model');
		$resultado=$this->Nota_model->getNotas();
		echo json_encode($resultado);
	}

	public function anularNota(){
		$this->load->model('Nota_model');
		$id_devolucion=$this->input->post('id_devolucion');
		$resultado=$this->Nota_model->anularNota($id_devolucion);
		echo json_encode($resultado);
	}

	public function getNotaByFecha(){
		$this->load->model('Nota_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		$resultado=$this->Nota_model->getNotaByFecha($fechaIn,$fechaFin);
		echo json_encode($resultado);
	}

}