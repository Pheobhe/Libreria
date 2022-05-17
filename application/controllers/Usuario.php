<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 */
class Usuario extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url','form'));
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

	public function insertarImagen()
	 	{ 
	 					
	 					//echo file_get_contents($_FILES['imagen']['tmp_name']);
	 					$imagenBinaria = file_get_contents($_FILES['imagen']['tmp_name']);
	 					$nombreArchivo = $_FILES['imagen']['name'];
	 				
	 					//extensiones permitidas
	 					$extensiones = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
	 					$partes = explode('.', $nombreArchivo);
	 					$extension = $partes[1];
	 					$extension = strtolower($partes[1]);

	 					if (!in_array($extension, $extensiones)){
	 						echo "extension incorrecta";
	 					}else{
	 						echo "extension correcta";
	 						//hacer las comprobaciones pertinentes y si es correcta insertarla a la bbdd
	 						$this->load->model('Usuario_model');
	 						$imagen = $this->Usuario_model->insertarImagen($imagenBinaria,1);
	 						$varImagen = "<img src='data:image/png;base64,'".base64_encode($imagen);
	 						//echo '<img src="data:image/png;base64,'.$varImagen.'">';
							echo json_encode('<img src="data:image/png;base64,'.base64_encode($varImagen).'">');
			            
	 					}
	 					
			       
	 	} 

	public function obtenerImagenPerfil(){
	  //$id = $this->input->post('id');
		$id=1;
	  $this->load->model('Usuario_model');
	  $imagen = $this->Usuario_model->obtenerImagenPerfil($id);
	  echo json_encode('data:image/png;base64,'.base64_encode($imagen));
	}

}