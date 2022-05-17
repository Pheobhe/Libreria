<?php
class Unidad_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function getUnidades()
    {
    	 $this->db->select('nombre as Nombre,direccion as Dirección,telefono as Teléfono,contacto as Contacto,cod_postal as C_Postal');
        $this->db->from('destino');
        $this->db->where('id_destino>','0');
        $this->db->where('activo','1');
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    function getNombreUnidades()
    {
        $this->db->select('nombre,id_destino');
        $this->db->from('destino');
        $this->db->where('id_destino>','0');
        $this->db->group_by('nombre');
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getUnidadesNombre($nombre)
    {
        $this->db->select('id_destino as id, nombre, direccion, telefono, contacto, cod_postal');
        $this->db->from('destino');
        $this->db->where('nombre',$nombre);
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function addUnidad($nombre,$direccion,$telefono,$contacto,$cod_postal)
    {
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'nombre' => $nombre,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'contacto'=>$contacto,
            'cod_postal'=>$cod_postal,
            'activo' => '1',
            'fec_mov'=> $fecha
        );
        $this->db->insert('destino', $data); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function deleteUnidad($id_destino)
    {
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_destino',$id_destino);
        $this->db->update('destino',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
        //preguntar si hay que eliminar todos los movimientos de ese Producto
    }

}