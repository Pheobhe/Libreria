<?php
class EgresoUnidades_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
   
    function getNombresArtConStockUnidades($id_destino)
    {
       
        $this->db->select('id_producto, producto, sum(cantidad) as total');
        $this->db->from('(
        (
        SELECT em.id_producto,(em.cantidad*-1) as cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo
        FROM ingreso_unidades iu
        JOIN egreso_remito er ON er.id_egreso=iu.id_remito
        JOIN autorizacion_remito ar ON ar.id_autorizacion=er.id_autorizacion
        JOIN egreso_producto em ON em.id_autorizacion=ar.id_autorizacion
        JOIN producto p ON p.id_producto=em.id_producto
        JOIN destino d ON d.id_destino=ar.id_destino
        WHERE ar.id_destino='.$id_destino.')
            UNION ALL (
        SELECT emu.id_producto,emu.cantidad,emu.lote,emu.fec_venc,p.producto,p.stock_minimo,p.presentacion,p.cod_barra,p.activo, FROM egreso_remito_unidades eru
        JOIN egreso_producto_unidades emu ON eru.id_egreso=emu.id_remito_unidades
        JOIN producto p ON m.id_producto=emu.id_producto
        JOIN destino d ON eru.id_destino=d.id_destino
        WHERE eru.id_destino='.$id_destino.')
                    ) as aux');
        $this->db->where('activo','1');
        $this->db->group_by('producto');
        $this->db->having('total >',false);
        
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    //obtiene el stock de los Productos por nombre (segun destino)
    function getProductosStockUnidades($nombre,$id_destino)
    {
        
             $this->db->select('id_producto, producto, presentacion, sum(cantidad) as total,');
        $this->db->from('((
        SELECT em.id_producto,(em.cantidad*-1) as cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo
        FROM ingreso_unidades iu
        JOIN egreso_remito er ON er.id_egreso=iu.id_remito
        JOIN autorizacion_remito ar ON ar.id_autorizacion=er.id_autorizacion
        JOIN egreso_producto em ON em.id_autorizacion=ar.id_autorizacion
        JOIN producto p ON p.id_producto=em.id_producto
        JOIN destino d ON d.id_destino=ar.id_destino
        WHERE ar.id_destino='.$id_destino.')
            UNION ALL (
        SELECT epu.id_producto,epu.cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo FROM egreso_remito_unidades eru
        JOIN egreso_producto_unidades epu ON eru.id_egreso=epu.id_remito_unidades
        JOIN producto p ON p.id_producto=epu.id_producto
        JOIN destino d ON eru.id_destino=d.id_destino
        WHERE eru.id_destino='.$id_destino.')
                    ) as aux');
        $this->db->group_by('concat(id_producto)',false);
        $this->db->order_by('id_producto');
        $this->db->where('producto',$nombre);
        $this->db->where('activo','1');
        $this->db->having('total >',false);
        $query=$this->db->get();
        $data=$query->result();
        return $data;       
    }

    function checkStockUnidades($detalle,$cab,$id_destino)
    {
         date_default_timezone_set('America/Argentina/Buenos_Aires');
        /*SELECT sum(cantidad) as total 
            FROM 
        ((SELECT * FROM v_ingresos_stock) UNION (SELECT * FROM v_egresos_stock) UNION (SELECT * FROM v_egresos_temp_stock)) as aux
        WHERE id_producto=56 
        AND fec_venc="2017-01-25"
        AND lote="2"
        */


        $i=0;
        foreach ($detalle as $fila){
            
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((
        SELECT ep.id_producto,(ep.cantidad*-1) as cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo
        FROM ingreso_unidades iu
        JOIN egreso_remito er ON er.id_egreso=iu.id_remito
        JOIN autorizacion_remito ar ON ar.id_autorizacion=er.id_autorizacion
        JOIN egreso_producto ep ON ep.id_autorizacion=ar.id_autorizacion
        JOIN producto p ON p.id_producto=ep.id_producto
        JOIN destino d ON d.id_destino=ar.id_destino
        WHERE ar.id_destino='.$id_destino.')
            UNION ALL (
        SELECT epu.id_producto,epu.cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo
        FROM egreso_remito_unidades eru
        JOIN egreso_producto_unidades epu ON eru.id_egreso=epu.id_remito_unidades
        JOIN producto p ON p.id_producto=epu.id_producto
        JOIN destino d ON eru.id_destino=d.id_destino
        WHERE eru.id_destino='.$id_destino.')
                    ) as aux');
        $this->db->group_by('fec_venc');
        $this->db->group_by('lote');
        $this->db->order_by('id_producto');
        $this->db->where('id_producto',$fila['id_producto']);
        $this->db->where('fec_venc',$fila['fec_venc']);
        $this->db->where('lote',$fila['lote']);
        $this->db->where('activo','1');
        $query=$this->db->get();
        
            foreach ($query->result() as $row)
            {
                    if($row->total<$fila['cantidad']){
                        $error[$i]['id']=$fila['id_producto'];
                        $error[$i]['lote']=$fila['lote'];
                        $error[$i]['fec_venc']=$fila['fec_venc'];
                        $i++;
                    }  
            }

        }

        if (isset($error)){
            return $error;
        }else{



        $date = DateTime::createFromFormat('d/m/Y', $cab['fecha']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
        $data = array(
            'fecha' => $date->format('Y-m-d'),
            //'motivo' => $cab['motivo'],
            'id_destino' => $id_destino,
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'fec_mov'=>$fecha,
            'activo' => '1'
            //'fecha' => $cab['fecha']
            //'estado' => 'au'
            
        );
        $this->db->trans_start();
        $this->db->insert('egreso_remito_unidades', $data);
        $insert_id = $this->db->insert_id();

      

            //$this->db->trans_start();
            foreach ($detalle as $fila){
                if($fila['cantidad']<0){
                    $qq=$fila['cantidad'];
                }else{
                    $qq=$fila['cantidad']*-1;
                }
                //$date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
                $fecha=date("Y-m-d H:i:s"); 
                //echo $date->format('Y-m-d');
                $data = array(
                    'id_producto' => $fila['id_producto'],
                    'id_remito_unidades' => $insert_id,
                    'cantidad' => $qq,
                    'lote' => $fila['lote'],
                    'fec_mov'=>$fecha,
                    'activo' => '1'
                   
                );
                $this->db->insert('egreso_producto_unidades', $data);
            //var_dump($fila);
            }
            $this->db->trans_complete();

            return ($this->db->trans_status() === FALSE) ? false: $insert_id;
        }
        //return $data;
    }

     function getTotalUnidades($id,$id_destino){
        //echo $id;
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((
        SELECT ep.id_producto,(ep.cantidad*-1) as cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo
        FROM ingreso_unidades iu
        JOIN egreso_remito er ON er.id_egreso=iu.id_remito
        JOIN autorizacion_remito ar ON ar.id_autorizacion=er.id_autorizacion
        JOIN egreso_producto ep ON ep.id_autorizacion=ar.id_autorizacion
        JOIN producto p ON p.id_producto=ep.id_producto
        JOIN destino d ON d.id_destino=ar.id_destino
        WHERE ar.id_destino='.$id_destino.')
            UNION ALL (
        SELECT epu.id_producto,epu.cantidad,p.producto,p.stock_minimo,p.presentacion,p.activo
        FROM egreso_remito_unidades eru
        JOIN egreso_producto_unidades epu ON eru.id_egreso=epu.id_remito_unidades
        JOIN producto p ON p.id_producto=epu.id_producto
        JOIN destino d ON eru.id_destino=d.id_destino
        WHERE eru.id_destino='.$id_destino.')
                    ) as aux');
        $this->db->group_by('fec_venc');
        $this->db->group_by('lote');
        //$this->db->order_by('id_producto');
        $this->db->where('id_producto',$id);
        //$this->db->where('lote',$lote);
       // $this->db->where('fec_venc',$fec_venc);
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    

    
}