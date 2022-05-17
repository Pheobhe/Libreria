<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		 $this->load->library(array('session', 'form_validation'));
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
		$rol=$this->session->userdata('rol');
		switch ($rol){
			case 'administrador':   //aca es
			$this->load->view('header');
			$this->load->view('index');
			$this->load->view('footer');
			// break;
			// case 'consultas':
			// $this->load->view('header_consultas');
			// $this->load->view('index');
			// $this->load->view('footer');
			break;
			case 'autorizar':
			$this->load->view('header_autorizaciones');
			$this->load->view('index');
			$this->load->view('footer');
			// break;
			// case 'cierre':
			// $this->load->view('header_cierres');
			// $this->load->view('index');
			// $this->load->view('footer');
			
			break;
			
		}
		
	}

	public function mostrarDatos()
	{
		
		$data['dashboard'] = $this->load->view('index', NULL, TRUE);
		//$data['Productojs']=$this->load->view('Productojs', NULL, TRUE);
		echo json_encode($data['dashboard']);
		
	}




}
