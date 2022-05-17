<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockUnidades extends CI_Controller {


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
		$data['stockUnidades'] = $this->load->view('consulta/stockUnidades', $data, TRUE);
		echo json_encode($data['stockUnidades']);
	}

	//Funciones para Mostrar views
	public function mostrarDatosMenu()
	{
		$data['stockUnidadesMenu'] = $this->load->view('consulta/stockUnidadesMenu', NULL, TRUE);
		echo json_encode($data['stockUnidadesMenu']);
	}

	//obtener el stock de todos los Productos
	public function getAllStockUnidades()
	{
		$id_destino=$this->input->post('id_destino');
		$this->load->model('StockUnidades_model');
		$data['Productos']=$this->StockUnidades_model->getAllStockUnidades($id_destino);
		if ($data['Productos']){
          echo json_encode($data['Productos']);		
		}else{
		  	$vista="<h3>No hay Productos</h3>";
		  	echo json_encode($vista);	
		}	
	}

	//obtener stock agrupado por id
	public function getAllStockIdUnidades()
	{
		$id_destino=$this->input->post('id_destino');
		$this->load->model('StockUnidades_model');
		$data['Productos']=$this->StockUnidades_model->getAllStockIdUnidades($id_destino);
		if ($data['Productos']){
          echo json_encode($data['Productos']);		
		}else{
		  	$vista="<h3>No hay Productos</h3>";
		  	echo json_encode($vista);	
		}	
	}


}