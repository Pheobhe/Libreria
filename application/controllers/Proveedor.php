<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {


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
		$data['proveedor'] = $this->load->view('fichas/proveedores/proveedores', NULL, TRUE);
		echo json_encode($data['proveedor']);		
	}

	public function mostrarDatosNuevoProv()
	{	
		$data['nuevoProveedor'] = $this->load->view('fichas/proveedores/nuevoProveedor', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['nuevoProveedor']);	
	}

	public function mostrarDatosEliminarProv()
	{	
		$data['eliminarProveedor'] = $this->load->view('fichas/proveedores/eliminarProveedor', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['eliminarProveedor']);	
	}

	public function getProveedores()
	{
		$this->load->model('Proveedor_model');
		$data['Proveedores']=$this->Proveedor_model->getProveedores();
		if ($data['Proveedores']){
          echo json_encode($data['Proveedores']);		
		}else{
		  	$vista="<h3>No hay proveedores</h3>";
		  	echo json_encode($vista);	
		}	
	}

	public function getNombreProveedores()
	{
		$this->load->model('Proveedor_model');
		$resultado=$this->Proveedor_model->getNombreProveedores();
		echo json_encode($resultado);
	}

	public function getProveedoresNombre()
	{
		$nombre=$this->input->post('nombre');
		$this->load->model('Proveedor_model');
		$resultado=$this->Proveedor_model->getProveedoresNombre($nombre);
		echo json_encode($resultado);
	}

	public function addProveedor()
	{
		$this->load->model('Proveedor_model');
		$nombre=$this->input->post('nombre');
		$cuit=$this->input->post('cuit');
		$direccion=$this->input->post('direccion');
		$telefono=$this->input->post('telefono');
		$email=$this->input->post('email');
		$contacto=$this->input->post('contacto');
		$resultado=$this->Proveedor_model->addProveedor($nombre,$cuit,$direccion,$telefono,$email,$contacto);
		echo json_encode($resultado);
	}

	public function deleteProveedor()
	{
		$this->load->model('Proveedor_model');
		$id_provedor=$this->input->post('id_provedor');
		$resultado=$this->Proveedor_model->deleteProveedor($id_provedor);
		echo json_encode($resultado);
	}


}