<?php
class IngresoGeneral_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function getRemitosByPermiso($permisos){
        /*SELECT * FROM egreso_remito er 
        JOIN autorizacion_remito ar ON ar.id_autorizacion=er.id_autorizacion
        WHERE ar.id_destino IN(2,3) AND er.activo=1*/
        foreach ($permisos as $key => $value) {
           $array[]=$value->id_destino;
        }
        //$array=array('2','3');
        $this->db->select('er.id_egreso');
        $this->db->from('egreso_remito er');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->where_in('ar.id_destino',$array);
        $this->db->where('er.confirmado','0');
        $this->db->where('er.activo','1');
        $this->db->order_by('er.id_egreso','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function cargarDatosRemitos($id_egreso){
       
        $this->db->select('ep.id_producto as codigo,p.presentacion,p.producto, ep.cantidad*(-1) as cantidad ');
        $this->db->from('egreso_producto ep');
        $this->db->join('egreso_remito er','er.id_autorizacion=em.id_autorizacion');
        $this->db->join('producto p','p.id_producto=ep.id_producto');
        $this->db->where('er.id_egreso',$id_egreso);
        $this->db->where('em.activo','1');

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function cargarCabeceraRemitos($id_egreso){
      
        $this->db->select('er.id_egreso,er.fec_mov,d.nombre as destino,us.alias,er.responsable,  ar.observaciones as Observaciones'); 8
        $this->db->from('egreso_remito er');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->join('destino d','d.id_destino=ar.id_destino');
        $this->db->join('usuarios us','us.id_usuario=er.id_usuario');
        $this->db->where('er.id_egreso',$id_egreso);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    //ingresa un remito a unidades y marca como confirmado(1) el egreso de libreria
    function ingresarRemito($id,$usuario,$responsable){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        $fecha=date("Y-m-d H:i:s"); 


        $this->db->trans_start();
        //Inserto los datos del remito cerrado en egreso_remito
        $data = array(
                    'id_remito' => $id,                    
                    'fec_mov'=>$fecha,
                    'activo' => '1',
                    'responsable' => $responsable,
                    'id_usuario' => $usuario,
                    'observaciones' => $observaciones


                );
        $this->db->insert('ingreso_unidades', $data);
        $insert_id = $this->db->insert_id();

        $data=array(
            'confirmado'=>'1'
            );
        $this->db->where('id_egreso',$id);
        $this->db->update('egreso_remito',$data);
        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: $insert_id;
    }

}