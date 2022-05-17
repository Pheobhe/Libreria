<?php
class EgresoX_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function addEgresoTemp($id,$cantidad,$activo)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        //$date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
        $data = array(
            'id_producto' => $id,
            'id_autorizacion' => 1,
            'cantidad' => $cantidad*-1,
           // 'lote' => $lote,
            'fec_mov'=>$fecha,
            'activo' => '1',
            //'fec_venc'=> $fec_venc
        );
        $this->db->trans_start();
        $this->db->insert('egreso_temp', $data);
        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;
       
    }


    function getMovimientos(){
        $this->db->select('id_ingreso');
        $this->db->from('ingreso_remito');
        $this->db->where('id_ingreso>','0');
        $this->db->order_by('id_ingreso','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getMovimientoById($Id){

        $this->db->select('id_ingreso,fec_ingreso,nombreProv,alias,responsable,nro_remito,id_producto as id,unidad,cantidad');
        $this->db->from('v_ingresos_completa');
        $this->db->where('id_ingreso',$Id);

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getCantidadProductos(){
        $query=$this->db->get('ingreso_remito');
        $data['cantidad']=$query->num_rows();
        return $data;
    }


    function checkStock($detalle,$cab)
    {
         date_default_timezone_set('America/Argentina/Buenos_Aires');
       
        $i=0;
        foreach ($detalle as $fila){
            
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) UNION ALL(SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
     
        $this->db->order_by('id_producto');
        $this->db->where('id_producto',$fila['id_producto']);
      
        $this->db->where('activo','1');
        $query=$this->db->get();
        
            foreach ($query->result() as $row)
            {
                    if($row->total<$fila['cantidad']){
                        $error[$i]['id']=$fila['id_producto'];
                  
                        $i++;
                    }  
            }

        }

        if (isset($error)){
            return $error;
        }else{



        $date = DateTime::createFromFormat('d/m/Y', $cab['fec_egresox']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
        $data = array(
            'fec_egresox' => $date->format('Y-m-d'),
            'motivo' => $cab['motivo'],
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'fec_mov'=>$fecha,
            'activo' => '1',
            //'estado' => 'au'
            
        );
        $this->db->trans_start();
        $this->db->insert('egresox_remito', $data);
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
                    'id_egresox' => $insert_id,
                    'cantidad' => $qq,
                    
                    'fec_mov'=>$fecha,
                    'activo' => '1',
                 
                );
                $this->db->insert('egresox_producto', $data);
            //var_dump($fila);
            }
            $this->db->trans_complete();

            return ($this->db->trans_status() === FALSE) ? false: $insert_id;
        }
        //return $data;
    }

    function actualizarCant($id,$lote,$fec_venc){
        //echo $id;
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) UNION ALL(SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        
        //$this->db->order_by('id_producto');
        $this->db->where('id_producto',$id);
       
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;

    }

    function getTotal($id,){
        //echo $id;
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
       // $this->db->group_by('fec_venc');
       // $this->db->group_by('lote');
        //$this->db->order_by('id_producto');
        $this->db->where('id_producto',$id);
        $this->db->where('lote',$lote);
       // $this->db->where('fec_venc',$fec_venc);
       // $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getCantidadEgresos(){
        $query=$this->db->get('autorizacion_remito');
        $data['cantidad']=$query->num_rows();
        return $data;
    }


    function imprimir($id){

      
        $this->db->select('a.id_autorizacion, a.fec_autorizado, a.responsable,u.alias,d.nombre as destino,
        e.id_producto,p.producto,p.presentacion,(e.cantidad)*-1 as cant');
        $this->db->from('autorizacion_remito a');
        $this->db->join('egreso_temp e','a.id_autorizacion=e.id_autorizacion');
        $this->db->join('producto p','e.id_producto=p.id_producto');
        $this->db->join('destino d','d.id_destino=a.id_destino');
        $this->db->join('usuarios u','u.id_usuario=a.id_usuario');
        $this->db->where('a.id_autorizacion',$id);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getAutorizaciones(){
        $this->db->select('id_autorizacion');
        $this->db->from('autorizacion_remito');
        $this->db->where('id_autorizacion>','0');
        $this->db->order_by('id_autorizacion','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getAutorizacionById($Id){

    
        $this->db->select('ar.id_autorizacion,ar.fec_autorizado,d.nombre as destino,us.alias,ar.responsable,et.id_producto as id,m.presentacion,m.producto,(et.cantidad*-1) as cant,ar.estado');
        $this->db->from('autorizacion_remito ar');
        $this->db->join('egreso_temp et','ar.id_autorizacion=et.id_autorizacion');
        $this->db->join('destino d','ar.id_destino=d.id_destino');
        $this->db->join('usuarios us ','ar.id_usuario=us.id_usuario');
        $this->db->join('producto m ','et.id_producto=m.id_producto');
       
        $this->db->where('ar.id_autorizacion',$Id);

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    // function checkCambioInventario($Producto){
    //     /*SELECT * FROM `egreso_temp` WHERE concat(id_producto)=251 and activo=1*/
    //     $i=0;
    //     $data="vacio";
    //     foreach ($Producto as $datos) {

    //         $concatenados=$datos['id_producto'];

    //         $this->db->select("*");
    //         $this->db->from("egreso_temp");
    //         $this->db->where("concat(id_producto)",$concatenados);
    //         $this->db->where("activo","1");
    //         $query=$this->db->get();
    //         $rowcount = $query->num_rows();
    //         if($rowcount>0){
    //             $error[$i]['id']=$datos['id_producto'];
    //             $error[$i]['lote']=$datos['lote'];
    //             $error[$i]['fec_venc']=$datos['fec_venc'];
    //             $i++;
    //         }  
            

    //     }
        
    //     if (isset($error)){
    //         return $error;
    //     }else{
    //         return true;
    //     }
    // }
}