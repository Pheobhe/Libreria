<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento extends CI_Controller {


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
		$data['movimiento'] = $this->load->view('ingreso/movimiento/movimiento', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['movimiento']);
	}

	public function mostrarDatosConsulta()
	{	
		$data['consultaMovimiento'] = $this->load->view('consulta/consultaMovimiento', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['consultaMovimiento']);	
	}
	public function mostrarDatosConsultaO()
	{	
		$data['consultaMovimientoOld'] = $this->load->view('consulta/consultaMovimientoOld', NULL, TRUE);
		echo json_encode($data['consultaMovimientoOld']);	
	}

 	public function mostrarDatosAnular()
	{
		$data['anularMovimiento'] = $this->load->view('ingreso/movimiento/anularMovimiento', NULL, TRUE);
		echo json_encode($data['anularMovimiento']);
	}

	public function mostrarDatosFecha()
	{	
		$data['consultaMovimientoFecha'] = $this->load->view('consulta/consultaMovimientoFecha', NULL, TRUE);
		echo json_encode($data['consultaMovimientoFecha']);	
	}


	public function mostrarDatosFechaO()
	{	
		$data['consultaMovimientoFechaOld'] = $this->load->view('consulta/consultaMovimientoFechaOld', NULL, TRUE);
		echo json_encode($data['consultaMovimientoFechaOld']);	
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

	public function addMovimiento()
	{
		$this->load->model('Movimiento_model');
		$data['detalle']=$this->input->post('data');
		$data['cab']=$this->input->post('cab');
		$resultado=$this->Movimiento_model->addMovimiento($data['cab'],$data['detalle']);
		echo json_encode($resultado);
	}

	public function checkRepetido()
	{
		$this->load->model('Movimiento_model');
		//$data['detalle']=$this->input->post('data');
		$data['cab']=$this->input->post('cab');
		$resultado=$this->Movimiento_model->checkRepetido($data['cab']);
		echo json_encode($resultado);
	}

	//Funciones para Consultar Movimientos.
	public function getMovimientoById(){
		$this->load->model('Movimiento_model');
		$id=$this->input->post('id_ingreso');
		$resultado=$this->Movimiento_model->getMovimientoById($id);
		echo json_encode($resultado);
	}

	//Funciones para Consultar Movimientos viejos
	public function getMovimientooById(){
		$this->load->model('Movimiento_model');
		$id=$this->input->post('id_ingreso');
		$resultado=$this->Movimiento_model->getMovimientooById($id);
		echo json_encode($resultado);
	}

	public function getMovimientosO(){
		$this->load->model('Movimiento_model');
		$resultado=$this->Movimiento_model->getMovimientosO();
		echo json_encode($resultado);
	}
	public function getMovimientos(){
		$this->load->model('Movimiento_model');
		$resultado=$this->Movimiento_model->getMovimientos();
		echo json_encode($resultado);
	}

	public function getCantidadIngresos()
	{
		$this->load->model('Movimiento_model');
		$data['Ingresos']=$this->Movimiento_model->getCantidadIngresos();
		if ($data['Ingresos']){
			//var_dump($data['productos']);
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
			//var_dump($data['productos']);
          echo json_encode($data['UltimosIng']);		
		}else{
		  	$vista="0";
		  	echo json_encode($vista);	
		}	

	}


	public function anularMovimiento(){
		$this->load->model('Movimiento_model');
		$id_ingreso=$this->input->post('id_ingreso');
		$resultado=$this->Movimiento_model->anularMovimiento($id_ingreso);
		echo json_encode($resultado);
	}

	public function getMovimientoOByFecha(){
		$this->load->model('Movimiento_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		$resultado=$this->Movimiento_model->getMovimientoOByFecha($fechaIn,$fechaFin);
		echo json_encode($resultado);
	}


	public function getMovimientoByFecha(){
		$this->load->model('Movimiento_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		$resultado=$this->Movimiento_model->getMovimientoByFecha($fechaIn,$fechaFin);
		echo json_encode($resultado);
	}


}