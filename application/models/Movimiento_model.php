<?php
class Movimiento_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function addMovimiento($cab,$detalle)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'fec_ingreso' => $date->format('Y-m-d'),
            'id_provedor' => $cab['id_provedor'],
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'fec_mov'=>$fecha,
            'activo' => '1',
            'nro_remito'=> $cab['nro_remito']
        );
        $this->db->trans_start();
        $this->db->insert('ingreso_remito', $data);            //este ingreso_remito es de movimientos!!!
        $insert_id = $this->db->insert_id();

        foreach ($detalle as $fila){
          
            $fila['id_ingreso']=$insert_id;
            $fila['activo']='1';
            $fila['fec_mov']=$fecha;
            $this->db->insert('ingreso_producto',$fila);
            //var_dump($fila);
        }

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;
       
    }

    //  function addMovimiento($cab,$detalle)
    

    function checkRepetido($cab){
        $data = array(
            'id_provedor' => $cab['id_provedor'],
            'nro_remito'=> $cab['nro_remito']
        );

        $this->db->select('*');
        $this->db->from('ingreso_remito');
        $this->db->where('id_provedor',$cab['id_provedor']);
        $this->db->where('nro_remito',$cab['nro_remito']);
        $query=$this->db->get();

        if($query->num_rows()==0){
            return true;
        }else{
            return false;
        }

    }


    function getMovimientosO(){
        $this->db->select('id_ingreso');
        $this->db->from('ingreso_remitoo');
        $this->db->where('id_ingreso>','0');
        $this->db->where('activo','1');
        $this->db->order_by('id_ingreso','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getMovimientos(){
        $this->db->select('id_ingreso');
        $this->db->from('ingreso_remito');
        $this->db->where('id_ingreso>','0');
        $this->db->where('activo','1');
        $this->db->order_by('id_ingreso','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getMovimientoById($Id){

       $this->db->select('id_ingreso,fec_ingreso,nombreProv,alias,responsable as Responsable,nro_remito,id_producto as Id,presentacion as Presentación,producto as Produto,cantidad as Cantidad');
        $this->db->from('v_ingresos_completa');
        $this->db->where('id_ingreso',$Id);

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }
     function getMovimientooById($Id){

       $this->db->select('id_ingreso,fec_ingreso,nombreProv,alias,responsable as Responsable,nro_remito,id_producto as Id,presentacion as Presentación,producto as Produto,cantidad as Cantidad');
        $this->db->from('v_ingresos_completao');
        $this->db->where('id_ingreso',$Id);

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


    function getCantidadIngresos(){
        $this->db->where('activo','1');
        $query=$this->db->get('ingreso_remito');
        $data['cantidad']=$query->num_rows();
        $this->db->where('activo','1');
        $query=$this->db->get('devolucion_remito');
        $data['devolucion']=$query->num_rows();
        return $data;
    }

    function getUltimosIngresos(){    //ok
        $this->db->select('i.id_producto,p.producto,p.presentacion,i.cantidad');
        $this->db->from('ingreso_producto i');
        $this->db->join('producto p','i.id_producto=p.id_producto');
        $this->db->where('i.id_ingreso>','0');
        $this->db->where('i.activo','1');
        $this->db->order_by('i.id_ingreso','DESC');
        $this->db->limit('4');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function anularMovimiento($id_ingreso){

        $this->db->trans_start();
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_ingreso',$id_ingreso);
        $this->db->update('ingreso_remito',$data);



        $this->db->where('id_ingreso',$id_ingreso);
        $this->db->update('ingreso_producto',$data);

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;
    }

    function getMovimientoByFecha($fechaIn,$fechaFin){

        /*SELECT ir.id_ingreso as N°Ingreso,ir.nro_remito as N°Remito, ir.fec_ingreso as Fecha,p.nombre as Proveedor,u.alias as Usuario, ir.responsable FROM ingreso_remito ir
        JOIN proveedor p ON p.id_provedor=ir.id_provedor
        JOIN usuarios u ON u.id_usuario=ir.id_usuario
        WHERE ir.fec_ingreso>="2017-02-01" AND ir.fec_ingreso<="2017-02-17" AND ir.activo=1
        ORDER BY ir.id_ingreso*/
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
        
        $fechaFin=$fechaFin->setTime(23,59);

        $this->db->select('ir.id_ingreso as N°Ingreso,ir.nro_remito as N°Remito, ir.fec_ingreso as Fecha,p.nombre as Proveedor,u.alias as Usuario, ir.responsable');
        $this->db->from('ingreso_remito ir');
        
        $this->db->join('proveedor p', 'p.id_provedor=ir.id_provedor');
        $this->db->join('usuarios u', 'u.id_usuario=ir.id_usuario');
        $this->db->where('ir.fec_ingreso>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('ir.fec_ingreso<=',$fechaFin->format('Y-m-d H:i:s'));
        //$this->db->where('er.fec_mov BETWEEN "'.$fechaIn.'" AND "'.$fechaFin.'"',false);
        $this->db->where('ir.activo','1');
        $this->db->order_by('ir.id_ingreso');
        $query=$this->db->get();
        $data=$query->result();
        return $data;


    }


    function getMovimientoOByFecha($fechaIn,$fechaFin){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
        
        $fechaFin=$fechaFin->setTime(23,59);

        $this->db->select('ir.id_ingreso as N°Ingreso,ir.nro_remito as N°Remito, ir.fec_ingreso as Fecha,p.nombre as Proveedor,u.alias as Usuario, ir.responsable as Responsable');
        $this->db->from('ingreso_remitoo ir');
        $this->db->join('proveedor p', 'p.id_provedor=ir.id_provedor');
        $this->db->join('usuarioso u', 'u.id_usuario=ir.id_usuario');
        $this->db->where('ir.fec_ingreso>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('ir.fec_ingreso<=',$fechaFin->format('Y-m-d H:i:s'));
        $this->db->where('ir.activo','1');
        $this->db->order_by('ir.id_ingreso');
        $query=$this->db->get();
        $data=$query->result();
        return $data;


    }
}