<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerificarLogin extends CI_Controller {

	const MAX_INTENTOS  = 3; //cantidad de intentos para loguearse
	 public function __construct()
    {
        parent::__construct();
        
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
        $this->load->model('Usuario_model');
        $this->load->library('encrypt');
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
		//$this->load->view('autentificacion/form_ingreso')
		$encrypted_string = $this->encrypt->encode($this->input->post('usuario'));
		//echo "encriptado".$encrypted_string;

		//echo "desencriptado".$this->encrypt->decode($encrypted_string);
		//echo "<br>max intentos:".static::MAX_INTENTOS;
		//echo "<br>max intentos:".static::MAX_INTENTOS;
		$this->comprobarCredenciales();
	}
    

    public function comprobarCredenciales()
	{
		$hashBD = $this->obtenerPasswordBD($this->input->post('usuario'));//obtiene el hash de la bd del usuario
		if ($this->getIntentos()<=static::MAX_INTENTOS){
             //echo $this->getIntentos();
	             $this->setIntentos();//incrementar intento

	             //comprobar si coincide contraseña del input y contraseña de la BD de el usuario $this->input->post('usuario') 
			if($this->comprobar_pass($this->input->post('password') , $hashBD) ){
	             $this->session->sess_expiration = 10;
	             $this->session->sess_expire_on_close = TRUE;
	             $rol = $this->obtenerRol($this->input->post('usuario'));
	             $alias = $this->obtenerAlias($this->input->post('usuario'));
	             $id = $this->obtenerId($this->input->post('usuario'));
	            $_SESSION['bloquear']=0;
  				$_SESSION['ultimo_acceso'] = time(); 
	            
			       $usuario_data = array(
					   'nombre' => $this->input->post('usuario'),
					   'logged_in' => TRUE,
					   'alias' => $alias,
					   'rol' => $rol,
					   'id_usuario' => $id
					);

				$_SESSION['id_usuario'] = $id;
	             //$this->session->set_userdata('logged_in', $usuario_data);
	             $this->session->set_userdata($usuario_data);
	             //redirect('/Login/ingreso');
	              $this->comprobarRol($rol);
             
			}else{
				//echo "usuario o contraseña incorrecto";
				$this->session->set_flashdata('mensaje', 'Usuario o contraseña incorrecto');
				redirect(base_url());
			}
	}else{
			//echo "supero la cantidad de intentos";
			$_SESSION['bloquear'] = 1; //bloquear
			$_SESSION['espera']=time();
			$this->session->set_flashdata('mensaje', 'supero la cantidad de intentos,intentelo nuevamente en '.$_SESSION["tiempoEspera"].' segundos');
			$this->session->set_flashdata('intento', FALSE);
    		redirect(base_url());

	}
}

	public function comprobarRol($rol){
		switch ($rol) {
			case '':
				$data['token'] = $this->token();
				
				$this->load->view('autentificacion/login',$data);
				break;
			case 'administrador':
				redirect(base_url().'index.php/admin');//  super usuario puede hacer todo
				break;
			case 'consultas':
				redirect(base_url().'index.php/consultas');// solo puede consultar
				break;	
			case 'autorizar':
				redirect(base_url().'index.php/autorizaciones');//usuario que sirve para autorizar remitos
				break;
			case 'cierre':
				redirect(base_url().'index.php/cerrarRemito');//usuario que sirve para cerrar remitos
				break;
			case 'unidades':
				redirect(base_url().'index.php/Unidades');//usuario que sirve para cerrar remitos
				break;
			default:		
				$this->load->view('autentificacion/login',$data);
				break;		
		}
	}

	 public function getIntentos()
	{
		return $_SESSION['intentos'];
	}
    
    public function setIntentos()
	{
		$_SESSION['intentos']=$_SESSION['intentos']+1;
	}

	public function genera_hash($password){
		$hash=password_hash($password, PASSWORD_DEFAULT);
		echo $hash;
		return $hash;
	}

   public function comprobar_pass($pass,$hash){
    if (password_verify($pass, $hash)) { 
		    return 1;//si es uno coinciden los hashs
		} else { 
		    return 0;//error de contraseña
		} 
   }

   public function obtenerPasswordBD($usuario){
   $hash =	$this->Usuario_model->obtenerPass($usuario);
   return $hash;
   }

    public function obtenerRol($usuario){
   $rol =	$this->Usuario_model->obtenerRol($usuario);
   return $rol;
   }

   public function obtenerAlias($usuario){
   $alias =	$this->Usuario_model->obtenerAlias($usuario);
   return $alias;
   }
   public function obtenerId($usuario){
   $id = $this->Usuario_model->obtenerId($usuario);
   return $id;
   }

   public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}
	

}
