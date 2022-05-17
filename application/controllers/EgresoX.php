<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EgresoX extends CI_Controller {


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
		$data['egresoSinRemito'] = $this->load->view('egreso/egresoSinRemito', NULL, TRUE);
		echo json_encode($data['egresoSinRemito']);
	}

	public function mostrarDatosConsulta()
	{	
		$data['consultaAutorizacion'] = $this->load->view('consulta/consultaAutorizacion', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['consultaAutorizacion']);	
	}


	public function addEgresoTemp()
	{
		$this->load->model('Remito_model');
		$id=$this->input->post('id');
		$cantidad=$this->input->post('cantidad');
		$activo=1;
		//$lote=$this->input->post('lote');
		//$fec_venc=$this->input->post('fec_venc');
		$resultado=$this->Remito_model->addEgresoTemp($id,$cantidad,$activo);
		echo json_encode($resultado);
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

	public function actualizarCant(){
		$this->load->model('Remito_model');
		$data['id']=$this->input->post('id');
		//$data['lote']=$this->input->post('lote');
		//$data['fec_venc']=$this->input->post('fec_venc');
		$resultado=$this->Remito_model->actualizarCant($data['id']);
		echo json_encode($resultado);
	}

	public function getTotal(){
		$this->load->model('Remito_model');
		$data['id']=$this->input->post('id');
		//$data['lote']=$this->input->post('lote');
		//$data['fec_venc']=$this->input->post('fec_venc');
		//$data['inventario']=$this->input->post('inventario');,$data['inventario')
		//var_dump($data);
		$resultado=$this->Remito_model->getTotal($data['id'];
		echo json_encode($resultado);
	}

	public function getCantidadEgresos()
	{
		$this->load->model('Remito_model');
		$data['Egresos']=$this->Remito_model->getCantidadEgresos();
		if ($data['Egresos']){
			//var_dump($data['Productos']);
          echo json_encode($data['Egresos']);		
		}else{
		  	$vista="0";
		  	echo json_encode($vista);	
		}	
	}


	public function imprimir(){
		$this->load->model('Remito_model');
		//var_dump($this->input->post());
		$data['id']=$this->input->post('id');
		$resultado=$this->Remito_model->imprimir($data['id']);
		echo json_encode($resultado);
	}


	
	//Funciones para Consultar Autorizaciones.
	public function getAutorizacionById(){
		$this->load->model('Remito_model');
		$id=$this->input->post('id_autorizacion');
		$resultado=$this->Remito_model->getAutorizacionById($id);
		echo json_encode($resultado);
	}

	public function getAutorizaciones(){
		$this->load->model('Remito_model');
		$resultado=$this->Remito_model->getAutorizaciones();
		echo json_encode($resultado);
	}

	public function checkCambioInventario(){
		$this->load->model('EgresoX_model');
		$producto=$this->input->post('data');
		//var_dump($Producto); 
		$resultado=$this->EgresoX_model->checkCambioInventario($producto);
		echo json_encode($resultado);
	}





}