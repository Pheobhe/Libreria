<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EgresoUnidades extends CI_Controller {


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
		$data['id_destino']=$this->input->post('id_destino');
		$data['nombre']=$this->input->post('nombre');
		$data['egresoUnidades'] = $this->load->view('egreso/egresoUnidades', $data, TRUE);
		echo json_encode($data['egresoUnidades']);
	}

	//Funciones para Mostrar views
	public function mostrarDatosMenu()
	{
		$data['egresoUnidadesMenu'] = $this->load->view('egreso/egresoUnidadesMenu', NULL, TRUE);
		echo json_encode($data['egresoUnidadesMenu']);
	}

	
	public function checkStock()
	{
		$this->load->model('EgresoX_model');
		$data['detalle']=$this->input->post('data');
		$data['cabecera']=$this->input->post('cab');
		$resultado=$this->EgresoX_model->checkStock($data['detalle'],$data['cabecera']);
		echo json_encode($resultado);
		//echo json_encode($resultado);
	}

	//funcion para obtener los nombres de los productos con stock, se usa para llenar el select.
	public function getNombresArtConStockUnidades()
	{
		$id_destino=$this->input->post('id_destino');
		$this->load->model('EgresoUnidades_model');
		$resultado=$this->EgresoUnidades_model->getNombresArtConStockUnidades($id_destino);
		echo json_encode($resultado);
	}
	//funcion para llenar la tabla de seleccion de Productos antes de hacer un egreso.
	public function getProductosStockUnidades(){
		$nombre=$this->input->post('nombre');
		$id_destino=$this->input->post('id_destino');
		$this->load->model('EgresoUnidades_model');
		$resultado=$this->EgresoUnidades_model->getProductosStockUnidades($nombre,$id_destino);
		echo json_encode($resultado);
	}

	//funcion que chequea el stock antes de hacer un egreso
	public function checkStockUnidades()
	{
		$this->load->model('EgresoUnidades_model');
		$data['detalle']=$this->input->post('data');
		$data['cabecera']=$this->input->post('cab');
		$id_destino=$this->input->post('id_destino');
		$resultado=$this->EgresoUnidades_model->checkStockUnidades($data['detalle'],$data['cabecera'],$id_destino);
		echo json_encode($resultado);
		//echo json_encode($resultado);
	}

	public function getTotalUnidades(){
		$this->load->model('EgresoUnidades_model');
		$data['id']=$this->input->post('id');
		$data['lote']=$this->input->post('lote');
		$data['fec_venc']=$this->input->post('fec_venc');
		$id_destino=$this->input->post('id_destino');
		//var_dump($data);
		$resultado=$this->EgresoUnidades_model->getTotalUnidades($data['id'],$data['lote'],$data['fec_venc'],$id_destino);
		echo json_encode($resultado);
	}



}