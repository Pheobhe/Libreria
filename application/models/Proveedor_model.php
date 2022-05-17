<?php
class Proveedor_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function getProveedores()
    {
        $this->db->select('nombre as Nombre,cuit as Cuit,direccion as Dirección,telefono as Teléfono, email as Correo ,contacto as Contacto');
        $this->db->from('proveedor');
        $this->db->where('id_provedor>','0');
        $this->db->where('activo','1');
    	$query = $this->db->get();
    	$data=$query->result();
    	return $data;
    }

    function getNombreProveedores()
    {
        $this->db->select('nombre,id_provedor');
        $this->db->from('proveedor');
        $this->db->where('id_provedor>','0');
        $this->db->where('activo','1');
        //$this->db->group_by('nombre');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getProveedoresNombre($nombre)
    {
        $this->db->select('id_provedor as id, nombre, cuit, direccion, telefono, email, contacto');
        $this->db->from('proveedor');
        $this->db->where('nombre',$nombre);
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


    function getListaProveedores()
    {
        $this->db->select('nombre, id_provedor');
        $this->db->from('proveedor');
        $this->db->where('id_provedor>','0');
        $this->db->group_by('nombre');
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function addProveedor($nombre,$cuit,$direccion,$telefono,$email,$contacto)
    {
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'nombre' => $nombre,
            'cuit' => $cuit,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'email'=>$email,
            'contacto'=>$contacto,
            'activo' => '1',
            'fec_mov'=> $fecha
        );
        $this->db->insert('proveedor', $data); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function deleteProveedor($id_provedor)
    {
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_provedor',$id_provedor);
        $this->db->update('proveedor',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
        //preguntar si hay que eliminar todos los movimientos de ese Producto
    }

}