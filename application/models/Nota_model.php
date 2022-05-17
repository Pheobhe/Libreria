<?php
class Nota_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function addNota($cab,$detalle)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
//INSERT INTO `devolucion_remito`(`id_devolucion`, `fec_devolucion`, `id_destino`, `id_usuario`, `fec_mov`, `activo`, `responsable`, `motivo

        $data = array(
            'fec_devolucion' => $date->format('Y-m-d'),
            'id_destino' => $cab['id_provedor'],
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'fec_mov'=>$fecha,
            'activo' => '1',
            'motivo'=> $cab['nro_remito']
        );
        $this->db->trans_start();
        $this->db->insert('devolucion_remito', $data);
        $insert_id = $this->db->insert_id();

        foreach ($detalle as $fila){
            //$fec_venc = DateTime::createFromFormat('d/m/Y', $fila['fec_venc']);
            //$fila['fec_venc']=$fec_venc->format('Y-m-d');
            $fila['id_devolucion']=$insert_id;
            $fila['activo']=1;
            $fila['fec_mov']=$fecha;
            $this->db->insert('devolucion_producto',$fila);
            
            //var_dump($fila);
            //devolucion_producto`(`id_devolucion_producto`, `id_devolucion`, `id_producto`, `cantidad`, `tamano`, `fec_mov`, `activo`)
        }

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;
       
    }


    function getNotas(){
        $this->db->select('id_devolucion');
        $this->db->from('devolucion_remito');
        $this->db->where('id_devolucion>','0');
        $this->db->where('activo','1');
        $this->db->order_by('id_devolucion','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getNotaById($Id){

        /*SELECT dr.id_devolucion,dr.fec_devolucion,d.nombre as origen,us.alias,dr.responsable,dr.motivo,dm.id_producto as codigo, p.Producto, p.presentacion, p.nombre as nombrePres, dm.lote,dm.fec_venc,dm.cantidad   FROM
devolucion_remito dr
JOIN devolucion_producto dm ON dr.id_devolucion=dm.id_devolucion
JOIN destino d ON dr.id_destino=d.id_destino
JOIN usuarios us ON dr.id_usuario=us.id_usuario
JOIN producto p ON dm.id_producto=p.id_producto

WHERE dr.id_devolucion=1*/
        $this->db->select('dr.id_devolucion,dr.fec_devolucion,d.nombre as origen,us.alias,dr.responsable,dr.motivo,dp.id_producto as codigo, p.producto, p.presentacion,
');
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
        $this->db->where('activo','1');
        $query=$this->db->get('ingreso_remito');
        $data['cantidad']=$query->num_rows();
        return $data;
    }

    function getUltimosIngresos(){
        $this->db->select('i.id_producto,p.nombre,p.droga,i.cantidad');
        $this->db->from('ingreso_producto i');
        $this->db->join('producto p','i.id_producto=p.id_producto');
        $this->db->where('i.id_ingreso>','0');
        $this->db->where('i.activo','1');
        $this->db->order_by('i.id_ingreso','DESC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function anularNota($id_devolucion){

        $this->db->trans_start();
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_devolucion',$id_devolucion);
        $this->db->update('devolucion_remito',$data);



        $this->db->where('id_devolucion',$id_devolucion);
        $this->db->update('devolucion_producto',$data);

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;   
    }

    function getNotaByFecha($fechaIn,$fechaFin){

        /*SELECT dr.id_devolucion as N°Ingreso,dr.motivo as Motivo, dr.fec_devolucion as Fecha,d.nombre as Destino,u.alias as Usuario, dr.responsable FROM devolucion_remito dr
        JOIN destino d ON d.id_destino=dr.id_destino
        JOIN usuarios u ON u.id_usuario=dr.id_usuario
        WHERE dr.fec_devolucion>="2017-02-01" AND dr.fec_devolucion<="2017-02-17" AND dr.activo=1
        ORDER BY dr.id_devolucion*/
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
        
        $fechaFin=$fechaFin->setTime(23,59);



        $this->db->select('dr.id_devolucion as N°Ingreso,dr.motivo as Motivo, dr.fec_devolucion as Fecha,d.nombre as Destino,u.alias as Usuario, dr.responsable');
        $this->db->from('devolucion_remito dr');
        
        $this->db->join('destino d', 'd.id_destino=dr.id_destino');
        $this->db->join('usuarios u', 'u.id_usuario=dr.id_usuario');
        $this->db->where('dr.fec_devolucion>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('dr.fec_devolucion<=',$fechaFin->format('Y-m-d H:i:s'));
        //$this->db->where('er.fec_mov BETWEEN "'.$fechaIn.'" AND "'.$fechaFin.'"',false);
        $this->db->where('dr.activo','1');
        $this->db->order_by('dr.id_devolucion');
        $query=$this->db->get();
        $data=$query->result();
        return $data;


    }
}