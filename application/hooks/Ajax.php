<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
class Ajax extends CI_Controller {
    private $ci;
    public function Ajax(){
        $this->ci =& get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }
    
    
    public function requestAjax(){
          $uri=$this->ci->uri->segment(0);
          $controlador=$this->ci->uri->segment(1);
          $metodo=$this->ci->uri->segment(2);
          $permitidoConsultas=array("mostrarDatosConsulta","getUltimosIngresos","Login", "NULL", "VerificarLogin");
          $permitidoCerrar;
          $permitidoAutorizar;
          //var_dump($uri);

          $rol = $this->ci->session->userdata('rol');
         
          switch ($rol) {
            case 'autorizar':
               if (!in_array($metodo, $permitidoAutorizar)){die;}
              break;
            case 'cerrar':
               if (!in_array($metodo, $permitidoCerrar)){die;}
              break;
            case 'consultas':
               if (!in_array($metodo, $permitidoConsultas)){die;}
              break;
            case 'administrador':
               if (!in_array($metodo, $permitidoConsultas)){die;}
              break;
            default:
              die;
              break;
          }

    }
}
?>