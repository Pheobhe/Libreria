<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {



	 public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
        $this->load->model('Usuario_model');
        $this->load->helper('cookie');
        $this->load->library('ajax');
		if ($this->input->is_ajax_request())
			{
				if (!$this->ajax->resolverCredenciales()){
					exit;
				}
			}
			
         if (!isset($_SESSION['tiempoEspera'])){
         	 $_SESSION['tiempoEspera']=15; //setear tiempo de espera luego de cantidad de intentos fallidos es en segundos
         }
        if (!isset($_SESSION['bloquear'])){
           $_SESSION['bloquear']=0;	//por defecto el formulario no esta bloqueado
        }
        if (!isset($_SESSION['intentos'])) {
		    $_SESSION['intentos'] = 0;//por defecto los intentos comienzan en 0
		}

    }

	public function index()
	{
		$this->load->view('autentificacion/login');
	}

	 function logout()
	 {
	  // destruir session y redirigir al index
	        $data = array('login' => '', 'uname' => '', 'uid' => '');
	        $this->session->unset_userdata($data);
	        $this->session->sess_destroy();
	 		redirect(base_url());
	 }
	 function ingreso()
	 {
	 		$this->load->view('autentificacion/ingreso');

	 }
	 function errorIncognito()
	 {
	 		$this->load->view('autentificacion/errorIncognito');

	 }
	 function actualizarTiempo()
	 {
	 		 $_SESSION['ultimo_acceso'] = time();

	 }

	 public function getCurrentUser()
	 {
	 	//var_dump($this->session);
	 	$this->load->model('Usuario_model');
	 	$data['nombre']=$this->session->alias;
	 	$data['id']=$this->session->id_usuario;
	 	//$data['id']=$this->Usuario_model->obtenerId($data['nombre']);
	 	echo json_encode($data);
	 }

	
}
