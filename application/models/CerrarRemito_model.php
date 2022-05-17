<?php
class CerrarRemito_model extends CI_Model {
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
            //'lote' => $lote,
            'fec_mov'=>$fecha,
            'activo' => '1'

           // 'fec_venc'=> $fec_venc
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
        

        $date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
        $data = array(
            'fec_autorizado' => $date->format('Y-m-d'),
            'id_destino' => $cab['destino'],
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'observaciones' => $cab['observaciones'],    
            'fec_mov'=>$fecha,
            'activo' => '1',
            'estado' => 'au'
            
        );
        $this->db->trans_start();
        $this->db->insert('autorizacion_remito', $data);
        $insert_id = $this->db->insert_id();

        
        $i=0;
        foreach ($detalle as $fila){
            
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');        
        $this->db->order_by('id_producto');
        $this->db->where('id_producto',$fila['id_producto']);
       
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
                    'id_autorizacion' => $insert_id,
                    'cantidad' => $qq,
                    
                    'fec_mov'=>$fecha,
                    'activo' => '1'
             
                );
                $this->db->insert('egreso_temp', $data);
            //var_dump($fila);
            }
            $this->db->trans_complete();

            return ($this->db->trans_status() === FALSE) ? false: $insert_id;
        }
        //return $data;
    }

    function actualizarCant($id){
        //echo $id;
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        //$this->db->order_by('id_producto');
        $this->db->where('id_producto',$id);
        $query=$this->db->get();
        $data=$query->result();
        return $data;

    }

    function getTotal($id){
        //echo $id;
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        $this->db->where('id_producto',$id);   
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getCantidadEgresos(){
        $this->db->where('activo','1');
        $query=$this->db->get('egreso_remito');
        $data['cantidad']=$query->num_rows();
        return $data;
    }

    function imprimir($id){

     
        $this->db->select('er.id_egreso,er.responsable,er.fec_mov,er.id_autorizacion,d.nombre as destino, em.id_producto, p.producto, p.presentacion,(em.cantidad)*-1 as cant,u.alias, ar.observaciones, em.tamano, oficio');
        $this->db->from('egreso_remito er');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->join('egreso_producto em','ar.id_autorizacion=em.id_autorizacion');
        $this->db->join('producto p','em.id_producto=p.id_producto');
        $this->db->join('destino d','d.id_destino=ar.id_destino');
        $this->db->join('usuarios u','u.id_usuario=er.id_usuario');
        $this->db->where('er.id_egreso',$id);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getAutorizaciones(){
        $this->db->select('id_autorizacion');
        $this->db->from('autorizacion_remito');
        $this->db->where('estado','au');
        $this->db->order_by('id_autorizacion','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getRemitos(){
        $this->db->select('id_egreso');
        $this->db->from('egreso_remito');
        $this->db->where('activo','1');
             $this->db->order_by('id_egreso','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


//trae los historicos de remitos
     function getRemitosOld(){
        $this->db->select('id_egreso');
        $this->db->from('egreso_remitoo');
        $this->db->where('activo','1');
        $this->db->order_by('id_egreso','ASC');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getAutorizacionById($Id){

        $this->db->select('ar.id_autorizacion,ar.fec_autorizado,d.nombre as destino,us.alias,ar.responsable,et.id_producto as id,p.presentacion,p.Producto,(et.cantidad)*-1 as cant,ar.estado');
        $this->db->from('autorizacion_remito ar');
        $this->db->join('egreso_temp et','ar.id_autorizacion=et.id_autorizacion');
        $this->db->join('destino d','ar.id_destino=d.id_destino');
        $this->db->join('usuarios us ','ar.id_usuario=us.id_usuario');
        $this->db->join('producto p ','et.id_producto=p.id_producto');
        $this->db->where('ar.id_autorizacion',$Id);

        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


    function cerrar($id_autorizacion,$id_usuario,$responsable){

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        $fecha=date("Y-m-d H:i:s"); 


        $this->db->trans_start();
        //Inserto los datos del remito cerrado en egreso_remito
        $data = array(
                    'id_autorizacion' => $id_autorizacion,                    
                    'fec_mov'=>$fecha,
                    'activo' => '1',
                    'responsable' => $responsable,
                    'id_usuario' => $id_usuario,
                    //'observaciones' => $observaciones
                );
        $this->db->insert('egreso_remito', $data);
        $insert_id = $this->db->insert_id();


        // Busco los datos del egreso_temp para luego insertarlo en el egreso_producto

        $this->db->select('id_producto, id_autorizacion, cantidad, activo,tamano,inventario');
        $this->db->from('egreso_temp');
        $this->db->where('id_autorizacion',$id_autorizacion);
        $query=$this->db->get();
        $data=$query->result();
        
        //inserto en egreso_producto
        foreach ($query->result() as $row)
            {
                $row->fec_mov=$fecha;
                $this->db->insert('egreso_producto',$row);
            }
        
        //update a estado entregado en autorizacion_remito
        $auto = array(
               'estado' => "en",
               'fec_mov'=> $fecha
            );

        $this->db->where('id_autorizacion', $id_autorizacion);
        $this->db->update('autorizacion_remito', $auto); 

        //update de activo en 0 en egreso_temp
        $temp= array(
                'activo' => 0,
                'fec_mov' =>$fecha
            );

        $this->db->where('id_autorizacion', $id_autorizacion);
        $this->db->update('egreso_temp', $temp); 

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: $insert_id;

    }


    function getRemitoById($id){
         $this->db->select('ar.observaciones, er.id_egreso,er.responsable as responsable,u.alias,er.fec_mov,er.id_autorizacion,d.nombre as destino, em.id_producto as Código,p.producto as Producto,p.presentacion as Presentación,
        (em.cantidad)*-1 as Cantidad');
        $this->db->from('egreso_remito er');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->join('egreso_producto em','ar.id_autorizacion=em.id_autorizacion');
        $this->db->join('producto p','em.id_producto=p.id_producto');
        $this->db->join('destino d','d.id_destino=ar.id_destino');
        $this->db->join('usuarios u','u.id_usuario=er.id_usuario');
        $this->db->where('er.id_egreso',$id);
        $this->db->where('em.activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }



    function getRemitoByIdOld($id){
         $this->db->select('ar.observaciones, er.id_egreso,er.responsable as responsable,u.alias 
            ,er.fec_mov,er.id_autorizacion,d.nombre as destino, em.id_producto as Código,p.producto as Producto,p.presentacion as Presentación,
        (em.cantidad)*-1 as Cantidad ');
        $this->db->from('egreso_remitoo er');
        $this->db->join('autorizacion_remitoo ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->join('egreso_productoo em','ar.id_autorizacion=em.id_autorizacion');
        $this->db->join('productoo p','em.id_producto=p.id_producto');
        $this->db->join('destino d','d.id_destino=ar.id_destino');
        $this->db->join('usuarioso u','u.id_usuario=er.id_usuario');
        $this->db->where('er.id_egreso',$id);
        $this->db->where('em.activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }



    function anularRemito($id_autorizacion, $id_usuario){

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->db->trans_start();
        //anulo autorizacion

        $fecha=date("Y-m-d H:i:s"); 
        $data0 = array(
            'activo' => '0',
            'estado' => 'ca',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_autorizacion',$id_autorizacion);
        $this->db->update('autorizacion_remito',$data0);
        $data1=array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );

        $this->db->where('id_autorizacion',$id_autorizacion);
        $this->db->update('egreso_temp',$data1);
        $data3=array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );


        $this->db->where('id_autorizacion',$id_autorizacion);
        $this->db->update('egreso_remito',$data3);

        $this->db->where('id_autorizacion',$id_autorizacion);
        $this->db->update('egreso_producto',$data3);
        $data4=array(
            'id_usuario'=>$id_usuario,
            'id_autorizacion' => $id_autorizacion,
            'fec_mov'=> $fecha
          );
          $this->db->insert('remito_anulados',$data4);

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;
    
    }


    function getRemitoByFecha($fechaIn,$fechaFin){

      
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
        
        $fechaFin=$fechaFin->setTime(23,59);



        $this->db->select('er.id_egreso as N°Remito,er.id_autorizacion as N°Autorizacion,er.fec_mov as Fecha,d.nombre as Destino,u.alias as Usuario,er.responsable as Responsable, observaciones as Observaciones');
        $this->db->from('egreso_remito er');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->join('destino d', 'd.id_destino=ar.id_destino');
        $this->db->join('usuarios u', 'u.id_usuario=er.id_usuario');
        $this->db->where('er.fec_mov>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('er.fec_mov<=',$fechaFin->format('Y-m-d H:i:s'));
        //$this->db->where('er.fec_mov BETWEEN "'.$fechaIn.'" AND "'.$fechaFin.'"',false);
        $this->db->where('ar.activo','1');
        $this->db->order_by('er.id_egreso');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


    function getRemitoByFechaOld($fechaIn,$fechaFin){

      
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
        
        $fechaFin=$fechaFin->setTime(23,59);


        $this->db->select('er.id_egreso as N°Remito,er.id_autorizacion as N°Autorizacion,er.fec_mov as Fecha,d.nombre as Destino,u.alias as Usuario,er.responsable as Responsable, observaciones as Observaciones');
        $this->db->from('egreso_remitoo er');
        $this->db->join('autorizacion_remitoo ar','ar.id_autorizacion=er.id_autorizacion');
        $this->db->join('destino d', 'd.id_destino=ar.id_destino');
        $this->db->join('usuarioso u', 'u.id_usuario=er.id_usuario');
        $this->db->where('er.fec_mov>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('er.fec_mov<=',$fechaFin->format('Y-m-d H:i:s'));
        $this->db->where('ar.activo','1');
        $this->db->order_by('er.id_egreso');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


}