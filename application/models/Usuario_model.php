<?php
Class Usuario_model extends CI_Model
{
   function __construct() {
        parent::__construct();
    }

 function login($username, $password)
 {
   $this -> db -> select('id_usuario, alias, password');
   $this -> db -> from('usuarios');
   $this -> db -> where('alias', $alias);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }


 function obtenerPass($usuario){
       $this->db->select('password');
       $this->db->from('usuarios');
       $this->db->where('email', $usuario);
       $this->db->limit(1);

       $query = $this->db->get();

      foreach ($query->result() as $fila){
                                     $dato = $fila->password;
                                }
       if(isset($dato))
       {
         return $dato;
       }
       else
       {
         return false;
       }

 }


 function getListaUsuarios()
    {
        $this->db->select('alias');
        $this->db->from('usuarios');
        $this->db->where('id_usuario>','0');
        //$this->db->group_by('alias');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

 function obtenerRol($usuario){
       $this->db->select('rol');
       $this->db->from('usuarios');
       $this->db->where('email', $usuario);
       $this->db->limit(1);

       $query = $this->db->get();

      foreach ($query->result() as $fila){
                                     $dato = $fila->rol;
                                }
       if(isset($dato))
       {
         return $dato;
       }
       else
       {
         return false;
       }

 }

 function obtenerAlias($usuario){
       $this->db->select('alias');
       $this->db->from('usuarios');
       $this->db->where('email', $usuario);
       $this->db->limit(1);

       $query = $this->db->get();

      foreach ($query->result() as $fila){
                                     $dato = $fila->alias;
                                }
       if(isset($dato))
       {
         return $dato;
       }
       else
       {
         return false;
       }

 }

function obtenerId($usuario){
  $this->db->select('id_usuario');
  $this->db->from('usuarios');
  $this->db->where('email',$usuario);
  $query=$this->db->get();
  foreach ($query->result() as $fila)
  {
    $data = $fila->id_usuario;
  }
  if (isset ($data)){
   return $data; 
  }
  
}

function insertarImagen($imagen,$id){
$data = array(
       'imagen' => $imagen
    ); 

    $this->db->where('id_usuario', $id);
    $this->db->update('usuarios', $data);



  $this->db->select('imagen');
  $this->db->from('usuarios');
  $this->db->where('id_usuario',$id);
  $query=$this->db->get();

  foreach ($query->result() as $fila)
  {
    $data = $fila->imagen;
  }
    
    return $data;
}

function obtenerImagenPerfil($id){
    $this->db->select('imagen');
    $this->db->from('usuarios');
    $this->db->where('id_usuario',$id);
    $query=$this->db->get();
    foreach ($query->result() as $fila)
    {
      $data = $fila->imagen;
    }
      return $data;
 }

 



}
?>