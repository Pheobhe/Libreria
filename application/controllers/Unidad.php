<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidad extends CI_Controller {


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

	public function mostrarDatos()
	{
		$data['unidad'] = $this->load->view('fichas/unidades/unidades', NULL, TRUE);
		echo json_encode($data['unidad']);		
	}

	public function mostrarDatosNuevoUnidad()
	{	
		$data['nuevoUnidad'] = $this->load->view('fichas/unidades/nuevoUnidad', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['nuevoUnidad']);	
	}

	public function mostrarDatosEliminarUnidad()
	{	
		$data['eliminarUnidad'] = $this->load->view('fichas/unidades/eliminarUnidad', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['eliminarUnidad']);	
	}

	public function getUnidades()
	{
		$this->load->model('Unidad_model');
		$data['Unidades']=$this->Unidad_model->getUnidades();
		if ($data['Unidades']){
          echo json_encode($data['Unidades']);		
		}else{
		  	$vista="<h3>No hay Productos</h3>";
		  	echo json_encode($vista);	
		}	
	}

	public function getNombreUnidades()
	{
		$this->load->model('Unidad_model');
		$resultado=$this->Unidad_model->getNombreUnidades();
		echo json_encode($resultado);
	}

	public function getUnidadesNombre()
	{
		$nombre=$this->input->post('nombre');
		$this->load->model('Unidad_model');
		$resultado=$this->Unidad_model->getUnidadesNombre($nombre);
		echo json_encode($resultado);
	}

	public function addUnidad()
	{
		$this->load->model('Unidad_model');
		$nombre=$this->input->post('nombre');
		$direccion=$this->input->post('direccion');
		$telefono=$this->input->post('telefono');
		$contacto=$this->input->post('contacto');
		$cod_postal=$this->input->post('cod_postal');
		$resultado=$this->Unidad_model->addUnidad($nombre,$direccion,$telefono,$contacto,$cod_postal);
		echo json_encode($resultado);
	}

	public function deleteUnidad()
	{
		$this->load->model('Unidad_model');
		$id_destino=$this->input->post('id_destino');
		$resultado=$this->Unidad_model->deleteUnidad($id_destino);
		echo json_encode($resultado);
	}
}