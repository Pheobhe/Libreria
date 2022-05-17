<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CerrarRemito extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('session'));
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
		if($this->session->userdata('rol') == FALSE || $this->session->userdata('rol') != 'cierre')
		{
			redirect(base_url().'index.php/login');
		}
		redirect(base_url().'index.php/Dashboard');

	}
	//Funciones para Mostrar views
	public function mostrarDatos()
	{
		$data['cerrarRemito'] = $this->load->view('egreso/cerrarRemito', NULL, TRUE);
		echo json_encode($data['cerrarRemito']);
	}

	public function mostrarDatosConsulta()
	{	
		$data['consultaRemito'] = $this->load->view('consulta/consultaRemito', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['consultaRemito']);	
	}


	public function mostrarDatosConsultaO()
	{	
		$data['consultaRemitoOld'] = $this->load->view('consulta/consultaRemitoOld', NULL, TRUE);
		echo json_encode($data['consultaRemitoOld']);	
	}
	public function mostrarDatosAnular()
	{	
		$data['anularRemito'] = $this->load->view('egreso/anularRemito', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['anularRemito']);	
	}

	public function mostrarDatosFecha()
	{	
		$data['consultaRemitoFecha'] = $this->load->view('consulta/consultaRemitoFecha', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['consultaRemitoFecha']);	
	}

	public function mostrarDatosFechaO()
		{	
			$data['consultaRemitoFechaOld'] = $this->load->view('consulta/consultaRemitoFechaOld', NULL, TRUE);
			//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
			echo json_encode($data['consultaRemitoFechaOld']);	
		}


	public function getCantidadEgresos()
	{
		$this->load->model('CerrarRemito_model');
		$data['Egresos']=$this->CerrarRemito_model->getCantidadEgresos();
		if ($data['Egresos']){
			//var_dump($data['Productos']);
          echo json_encode($data['Egresos']);		
		}else{
		  	$vista="0";
		  	echo json_encode($vista);	
		}	
	}


	public function imprimir(){
		$this->load->model('CerrarRemito_model');
		//var_dump($this->input->post());
		$data['id']=$this->input->post('id');
		$resultado=$this->CerrarRemito_model->imprimir($data['id']);
		echo json_encode($resultado);
	}

	
	//Funciones para Cerrar Autorizaciones.
	public function getAutorizacionById(){
		$this->load->model('Remito_model');
		$id=$this->input->post('id_autorizacion');
		$resultado=$this->Remito_model->getAutorizacionById($Id);
		echo json_encode($resultado);
	}

	public function getAutorizaciones(){ //carga el select con los id_autorizacion
		$this->load->model('CerrarRemito_model');
		$resultado=$this->CerrarRemito_model->getAutorizaciones();
		echo json_encode($resultado);
	}

	public function cerrar(){
		$this->load->model('CerrarRemito_model');
		$data['id']=$this->input->post('id_autorizacion');
		$data['usuario']=$this->input->post('usuario');
		$data['responsable']=$this->input->post('responsable');
		//var_dump($this->input->post());
		$resultado=$this->CerrarRemito_model->cerrar($data['id'],$data['usuario'],$data['responsable']);
		echo json_encode($resultado);
	}


	//funciones consulta de remitos

	public function getRemitos(){
		$this->load->model('CerrarRemito_model');
		$resultado=$this->CerrarRemito_model->getRemitos();
		echo json_encode($resultado);
	}

	//funciones consulta de remitos antiguos
	public function getRemitosOld(){
		$this->load->model('CerrarRemito_model');
		$resultado=$this->CerrarRemito_model->getRemitosOld();
		echo json_encode($resultado);
	}


public function getRemitosSelect2()
	{
		$json = [];
		$this->load->database();
		if(!empty($this->input->get("q")))
		{
			$this->db->like('id_egreso', $this->input->get("q"));
			$query = $this->db->select('id_egreso')
								->limit(20)
     							->where('activo','1')
								->order_by('id_egreso')
								->get("egreso_remito");
			$json = $query->result();
		}
		$results=array('results'=>$json);
		echo json_encode($results);
	}


public function getRemitosSelect2Old()
	{
		$json = [];
		$this->load->database();
		if(!empty($this->input->get("q")))
		{
			$this->db->like('id_egreso', $this->input->get("q"));
			$query = $this->db->select('id_egreso')
								->limit(20)
     							->where('activo','1')
								->order_by('id_egreso')
								->get("egreso_remitoo");
			$json = $query->result();
		}
		$results=array('results'=>$json);
		echo json_encode($results);
	}


	public function getRemitoById(){
		$this->load->model('CerrarRemito_model');
		$id=$this->input->post('id_egreso');
		$resultado=$this->CerrarRemito_model->getRemitoById($id);
		echo json_encode($resultado);
	}

	public function getRemitoByIdOld(){
		$this->load->model('CerrarRemito_model');
		$id=$this->input->post('id_egreso');
		$resultado=$this->CerrarRemito_model->getRemitoByIdOld($id);
		echo json_encode($resultado);
	}

	public function anularRemito(){
		$this->load->model('CerrarRemito_model');
		$id_autorizacion=$this->input->post('id_autorizacion');
		$id_usuario=$this->input->post('id_usuario');
		$resultado=$this->CerrarRemito_model->anularRemito($id_autorizacion, $id_usuario);
		echo json_encode($resultado);
	}


	public function getRemitoByFecha(){
		$this->load->model('CerrarRemito_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		$resultado=$this->CerrarRemito_model->getRemitoByFecha($fechaIn,$fechaFin);
		echo json_encode($resultado);
	}

	public function getRemitoByFechaOld(){
			$this->load->model('CerrarRemito_model');
			$fechaIn=$this->input->post('fechaIn');
			$fechaFin=$this->input->post('fechaFin');
			$resultado=$this->CerrarRemito_model->getRemitoByFechaOld($fechaIn,$fechaFin);
			echo json_encode($resultado);
		}





}