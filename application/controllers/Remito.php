<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remito extends CI_Controller {


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
		$data['remito'] = $this->load->view('egreso/remito', NULL, TRUE);
		echo json_encode($data['remito']);
	}

	public function mostrarDatosConsulta()
	{
		$data['consultaAutorizacion'] = $this->load->view('consulta/consultaAutorizacion', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['consultaAutorizacion']);
	}

	public function mostrarDatosConsultaO()
	{
		$data['consultaAutorizacionOld'] = $this->load->view('consulta/consultaAutorizacionOld', NULL, TRUE);
		//$data['productojs']=$this->load->view('productojs', NULL, TRUE);
		echo json_encode($data['consultaAutorizacionOld']);
	}


	// public function mostrarDatosConsultaListadoAut()
	// {
	// 	$data['consultaListadoAut'] = $this->load->view('consulta/consultaListadoAut', NULL, TRUE);
	// 	echo json_encode($data['consultaListadoAut']);
	// }

	public function mostrarDatosAnular()
	{
		$data['anularAutorizacion'] = $this->load->view('egreso/anularAutorizacion', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['anularAutorizacion']);
	}

	public function mostrarDatosFecha()
	{
		$data['consultaAutorizacionFecha'] = $this->load->view('consulta/consultaAutorizacionFecha', NULL, TRUE);
		echo json_encode($data['consultaAutorizacionFecha']);
	}

	public function mostrarDatosFechaOl()
	{
		$data['consultaAutorizacionFechaOld'] = $this->load->view('consulta/consultaAutorizacionFechaOld', NULL, TRUE);
		echo json_encode($data['consultaAutorizacionFechaOld']);
	}

	// public function mostrarDatosBloqueo()
	// {
	// 	$data['Bloqueo'] = $this->load->view('fichas/articulos/bloqueo', NULL, TRUE);
	// 	echo json_encode($data['Bloqueo']);
	// }

	// public function mostrarDatosListadoAut()
	// {
	// 	$data['ListadoAut'] = $this->load->view('egreso/listadoAut', NULL, TRUE);
	// 	echo json_encode($data['ListadoAut']);
	// }

	public function imprimirListado()
	{
		$this->load->model('Remito_model');
		$autorizaciones=$this->input->post('autorizaciones');
		$data['usuario']=$this->input->post('usuario');
		
		$resultado=$this->Remito_model->imprimirListado($autorizaciones,$data['usuario']);

		$resultadoArray=array(
			"fechaActual" => date("d/m/Y h:i:s"),
			"resultado" =>$resultado,
		);
		echo json_encode($resultadoArray);
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
		$this->load->model('Remito_model');
		$data['detalle']=$this->input->post('data');
		$data['cabecera']=$this->input->post('cab');
		$resultado=$this->Remito_model->checkStock($data['detalle'],$data['cabecera']);
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
		$data['inventario']=$this->input->post('inventario');
		//var_dump($data);
		$resultado=$this->Remito_model->getTotal($data['id'],$data['inventario']);
		echo json_encode($resultado);
	}

	// public function getCantidadEgresos()
	// {
	// 	$this->load->model('Remito_model');
	// 	$data['Egresos']=$this->Remito_model->getCantidadEgresos();
	// 	if ($data['Egresos']){
	// 		//var_dump($data['Productos']);
 //          echo json_encode($data['Egresos']);
	// 	}else{
	// 	  	$vista="0";
	// 	  	echo json_encode($vista);
	// 	}
	// }


	public function imprimir(){
		$this->load->model('Remito_model');
		//var_dump($this->input->post());
		$data['id']=$this->input->post('id');
		$resultado=$this->Remito_model->imprimir($data['id']);
		echo json_encode($resultado);
	}

	
	// public function reImprimirListado()
	// {
	// 	$this->load->model('Remito_model');
	// 	$data['id']=$this->input->post('id');
	// 	$resultado=$this->Remito_model->reImprimirListado($data['id']);
	// 	echo json_encode($resultado);
	// }

	//Funciones para Consultar Autorizaciones.
	public function getAutorizacionById(){
		$this->load->model('Remito_model');
		$id=$this->input->post('id_autorizacion');
		$resultado=$this->Remito_model->getAutorizacionById($id);
		echo json_encode($resultado);
	}

	//Funciones para Consultar Autorizaciones historico.
	public function getAutorizacionOById(){
		$this->load->model('Remito_model');
		$id=$this->input->post('id_autorizacion');
		$resultado=$this->Remito_model->getAutorizacionoById($id);
		echo json_encode($resultado);
	}

	public function getAutorizacionesSelect2()
		{
			$json = [];
			$this->load->database();
			if(!empty($this->input->get("q")))
			{
				$this->db->like('id_autorizacion', $this->input->get("q"));
				$query = $this->db->select('id_autorizacion')
									->limit(20)
									->order_by('id_autorizacion')
									->get("autorizacion_remito");
				$json = $query->result();
			}
			$results=array('results'=>$json);
			echo json_encode($results);
		}

	public function getAutorizacionesOldSelect2()
		{
			$json = [];
			$this->load->database();
			if(!empty($this->input->get("q")))
			{
				$this->db->like('id_autorizacion', $this->input->get("q"));
				$query = $this->db->select('id_autorizacion')
									->limit(20)
									->order_by('id_autorizacion')
									->get("autorizacion_remitoo");
				$json = $query->result();
			}
			$results=array('results'=>$json);
			echo json_encode($results);
		}


	public function getAutorizaciones(){
		$this->load->model('Remito_model');
		$resultado=$this->Remito_model->getAutorizaciones();
		echo json_encode($resultado);
	}

	// public function getAutorizacionesO(){
	// 	$this->load->model('Remito_model');
	// 	$resultado=$this->Remito_model->getAutorizacionesO();
	// 	echo json_encode($resultado);
	// }


	
	// public function getListadosSelect2()
	// {
	// 	$json = [];
	// 	$this->load->database();
	// 	if(!empty($this->input->get("q")))
	// 	{
	// 		$this->db->like('id_autorizacion_listado', $this->input->get("q"));
	// 		$query = $this->db->select('id_autorizacion_listado')
	// 							->limit(20)
	// 							->order_by('id_autorizacion_listado')
	// 							->get("autorizacion_listado");
	// 		$json = $query->result();
	// 	}
	// 	$results=array('results'=>$json);
	// 	echo json_enco
	// }

	public function anularAutorizacion(){
		$this->load->model('Remito_model');
		$id_autorizacion=$this->input->post('id_autorizacion');
		$id_usuario=$this->input->post('id_usuario');
		$resultado=$this->Remito_model->anularAutorizacion($id_autorizacion,$id_usuario);
		echo json_encode($resultado);
	}

	public function getAutorizacionByFecha(){
		$this->load->model('Remito_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		$resultado=$this->Remito_model->getAutorizacionByFecha($fechaIn,$fechaFin);
		echo json_encode($resultado);
	}

	public function getAutorizacionOldByFecha(){
		$this->load->model('Remito_model');
		$fechaIn=$this->input->post('fechaIn');
		$fechaFin=$this->input->post('fechaFin');
		$resultado=$this->Remito_model->getAutorizacionByFechaOld($fechaIn,$fechaFin);
		echo json_encode($resultado);
	}



	public function getAutorizacionByIdListado()
	{
		$this->load->model('Remito_model');
		$idAut=$this->input->post('idAut');
		$resultado=$this->Remito_model->getAutorizacionByIdListado($idAut);
		echo json_encode($resultado);
	}


	public function checkBloqueo()
	{
		$this->load->model('Remito_model');
		$id=$this->input->post('id');
		//$lote=$this->input->post('lote');
		//$fec_venc=$this->input->post('fec_venc');
		$tamano=$this->input->post('tamano');
		$inventario=$this->input->post('inventario');
		$resultado=$this->Remito_model->checkBloqueo($id,$tamano,$inventario);
		echo json_encode($resultado);
	}

	public function checkPin()
	{
		$this->load->model('Remito_model');
		$pin=$this->input->post('pin');
		$id_bloqueo=$this->input->post('id_bloqueo');
		$resultado=$this->Remito_model->checkPin($pin,$id_bloqueo);
		echo json_encode($resultado);
	}

	public function setBloqueo()
	{
		$id_producto=$this->input->post('id_producto');
		//$lote=$this->input->post('lote');
		//$fec_venc=$this->input->post('fec_venc');
		$tamano=$this->input->post('tamano');
		$inventario=$this->input->post('inventario');
		$pin=$this->input->post('pin');
		$this->load->model('Remito_model');
		$resultado=$this->Remito_model->setBloqueo($id_producto,$tamano,$inventario,$pin);
		echo json_encode($resultado);
	}




}
