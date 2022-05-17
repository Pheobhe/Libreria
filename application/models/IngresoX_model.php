<?php
class IngresoX_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function addIngresoX($cab,$detalle)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
        $data = array(
            'fec_ingresox' => $date->format('Y-m-d'),
            //'id_destino' => $cab['id_provedor'],
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'fec_mov'=>$fecha,
            'activo' => '1',
            'motivo'=> $cab['nro_remito']
        );
        $this->db->trans_start();
        $this->db->insert('ingresox_remito', $data);
        $insert_id = $this->db->insert_id();

        foreach ($detalle as $fila){
            //$fec_venc = DateTime::createFromFormat('d/m/Y', $fila['fec_venc']);
            //$fila['fec_venc']=$fec_venc->format('Y-m-d');
            $fila['id_ingresox']=$insert_id;
            $fila['activo']=1;
            $fila['fec_mov']=$fecha;
            $this->db->insert('ingresox_producto',$fila);
            //var_dump($fila);
        }

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;
       
    }


    function getNotas(){
        $this->db->select('id_devolucion');
        $this->db->from('devolucion_remito');
        $this->db->where('id_devolucion>','0');
        $this->db->order_by('id_devolucion','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getNotaById($Id){

        $this->db->select('dr.id_devolucion,dr.fec_devolucion,d.nombre as origen,us.alias,dr.responsable,dr.motivo,dr.id_producto as codigo, p.producto, p.presentacion,
p.nombre as nombrePres,dr.cantidad');
        $this->db->from('devolucion_remito dr');
        $this->db->join('devolucion_producto dp','dr.id_devolucion=dp.id_devolucion');
        $this->db->join('destino d ','dr.id_destino=d.id_destino');
        $this->db->join('usuarios us ','dr.id_usuario=us.id_usuario');
        $this->db->join('producto p ','dp.id_producto=p.id_producto');
        
        $this->db->where('dr.id_devolucion',$Id);

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getCantidadProductos(){
        $query=$this->db->get('ingreso_remito');
        $data['cantidad']=$query->num_rows();
        return $data;
    }

    function getUltimosIngresos(){
        $this->db->select('i.id_producto,p.nombre,i.cantidad');
        $this->db->from('ingreso_producto i');
        $this->db->join('producto p','i.id_producto=p.id_producto');
        $this->db->where('i.id_ingreso>','0');
        $this->db->order_by('i.id_ingreso','DESC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }
}