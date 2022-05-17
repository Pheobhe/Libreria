<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 */
class Consultas extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
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
		if($this->session->userdata('rol') == FALSE || $this->session->userdata('rol') != 'consultas')
		{
			redirect(base_url().'index.php/login');
		}
		redirect(base_url().'index.php/Dashboard');

	}
}