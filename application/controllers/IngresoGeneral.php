<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IngresoGeneral extends CI_Controller {


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
		if($this->session->userdata('rol') == FALSE || $this->session->userdata('rol') != 'unidades')
		{
			redirect(base_url().'index.php/login');
		}
		redirect(base_url().'index.php/Dashboard');
	}
	//Funciones para Mostrar views
	public function mostrarDatos()
	{
		$data['ingresoGeneral'] = $this->load->view('ingreso/movimiento/ingresoGeneral', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['ingresoGeneral']);
	}

	//funciones para cargar los datos de los remitos
	//carga numero de remitos segun permisos
	public function getRemitosByPermiso()
	{
		$usuario=$_SESSION['id_usuario'];
		//$usuario=1;
		$this->load->model('Unidades_model');
		$permisos=$this->Unidades_model->obtenerPerfilUnidades($usuario);
		//funciones consulta de remitos
		$this->load->model('IngresoGeneral_model');
		$resultado=$this->IngresoGeneral_model->getRemitosByPermiso($permisos);
		echo json_encode($resultado);
	}

	//carga los datos de los productos de los remitos
	public function cargarDatosRemitos()
	{
		$id_egreso=$this->input->post('id_egreso');
		$this->load->model('IngresoGeneral_model');
		$resultado=$this->IngresoGeneral_model->cargarDatosRemitos($id_egreso);
		echo json_encode($resultado);
	}

	//carga la cabecera del remito seleccionado
	public function cargarCabeceraRemitos()
	{
		$id_egreso=$this->input->post('id_egreso');
		$this->load->model('IngresoGeneral_model');
		$resultado=$this->IngresoGeneral_model->cargarCabeceraRemitos($id_egreso);
		echo json_encode($resultado);
	}


	//ingreso el remito confirmando los Productos
	public function ingresarRemito()
	{
		$data['id']=$this->input->post('id_remito');
		$data['usuario']=$this->input->post('usuario');
		$data['responsable']=$this->input->post('responsable');
		$this->load->model('IngresoGeneral_model');
		$resultado=$this->IngresoGeneral_model->ingresarRemito($data['id'],$data['usuario'],$data['responsable']);
		echo json_encode($resultado);
	}


}