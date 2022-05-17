<?php
class Remito_model extends CI_Model {
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
            'activo' => '1',
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
       
        $i=0;
        foreach ($detalle as $fila){
            
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) 
            UNION ALL (SELECT * FROM v_ingresos_stock) 
            UNION ALL (SELECT * FROM v_egresos_stock) 
            UNION ALL (SELECT * FROM v_egresos_temp_stock)
            UNION ALL (SELECT * FROM v_egresosx_stock)
            UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('concat(id_producto,tamano,inventario)',false);
        $this->db->order_by('id_producto');
        $this->db->where('id_producto',$fila['id_producto']);
        $this->db->where('inventario',$fila['inventario']);
        $this->db->where('activo','1');
        // solo muestra los resultados mayores a 0
        $this->db->having('total >',false);
        $query=$this->db->get();
         foreach ($query->result() as $row)
            {
                    if($row->total<$fila['cantidad']){

                        
                        $error[$i]['id']=$fila['id_producto'];
                        $error[$i]['inventario']=$fila['inventario'];
                        $i++;
                    }  
            }

        }

        if (isset($error)){
            return $error;
        }else{



        $date = DateTime::createFromFormat('d/m/Y', $cab['fec_ingreso']);
        $fecha=date("Y-m-d H:i:s"); 
        //echo $date->format('Y-m-d');
        $data = array(
            'fec_autorizado' => $date->format('Y-m-d'),
            'id_destino' => $cab['destino'],
            'id_usuario' => $cab['id_usuario'],
            'responsable' => $cab['responsable'],
            'destinatario' => $cab['destinatario'],
            'oficio' => $cab['oficio'],
            'observaciones' => $cab['observaciones'] ,  
            'fec_mov'=>$fecha,
            'activo' => '1',
            'estado' => 'au'
           
        );
        $this->db->trans_start();
        $this->db->insert('autorizacion_remito', $data);
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
                    'id_autorizacion' => $insert_id,
                    'cantidad' => $qq,                   
                    'fec_mov'=>$fecha,
                    'activo' => '1',
                    'tamano'=>$fila['tamano'],
                    'inventario'=>$fila['inventario']

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
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) UNION ALL(SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        $this->db->where('id_producto',$id);
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;

    }

    function getTotal($id,$inventario){
        //echo $id;
        $this->db->select('sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
         $this->db->group_by('concat(id_producto,tamano,inventario)',false);
        //$this->db->group_by('fec_venc');
        //$this->db->group_by('lote');
        $this->db->order_by('id_producto');
        $this->db->where('id_producto',$id);
        // agregado para usar el inventario
        $this->db->where('inventario',$inventario);
        $this->db->where('activo','1');
        $this->db->having('total >',false);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getCantidadEgresos(){
        $this->db->where('activo','1');
        $query=$this->db->get('autorizacion_remito');
        $data['cantidad']=$query->num_rows();
        return $data;
    }


    function imprimir($id){
//e.inventario,
        $this->db->select('a.destinatario, a.id_autorizacion, a.fec_autorizado, a.responsable, u.alias,d.nombre as destino, e.id_producto, p.producto, p.presentacion, (e.cantidad)*-1 as cant, oficio, e.tamano, a.observaciones');
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

     

    // function getAutorizaciones(){
    //     $this->db->select('id_autorizacion');
    //     $this->db->from('autorizacion_remito');
    //     $this->db->where('id_autorizacion>','0');
    //      $this->db->where('activo','1');
    //     $this->db->order_by('id_autorizacion','ASC');
    //     $query=$this->db->get();
    //     $data=$query->result();
    //     return $data;
    // }

    // function getAutorizacionesO(){
    //     $this->db->select('id_autorizacion');
    //     $this->db->from('autorizacion_remitoo');
    //     $this->db->where('id_autorizacion>','0');
    //   //  $this->db->where('estado','en');
    //     $this->db->order_by('id_autorizacion','ASC');
    //     $query=$this->db->get();
    //     $data=$query->result();
    //     return $data;
    // }


    function getAutorizacionById($Id){    
        
    $this->db->select('ar.observaciones as Observaciones, ar.destinatario,ar.oficio,ar.id_autorizacion, ar.fec_autorizado, d.nombre as destino,us.alias,ar.responsable as Responsable, et.id_producto as Id,p.presentacion as Presentación,p.producto as Producto,(et.cantidad*-1) as Cantidad ,ar.estado as Estado,et.tamano as Tamaño, et.inventario as Inventario, ar.oficio'); 
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

 function getAutorizacionoById($Id){    
     $this->db->select('ar.observaciones, ar.destinatario,ar.oficio,ar.id_autorizacion, ar.fec_autorizado, d.nombre as destino,us.alias,ar.responsable, et.id_producto as Id,p.presentacion as Presentación,p.producto as Producto,(et.cantidad*-1) as Cantidad ,ar.estado as Estado,et.tamano as Tamaño, et.inventario as Inventario'); 
        $this->db->from('autorizacion_remitoo ar');
        $this->db->join('egreso_tempo et','ar.id_autorizacion=et.id_autorizacion');
        $this->db->join('destino d','ar.id_destino=d.id_destino');
        $this->db->join('usuarioso us ','ar.id_usuario=us.id_usuario');
        $this->db->join('productoo p ','et.id_producto=p.id_producto');
        $this->db->where('ar.id_autorizacion',$Id);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }



    function anularAutorizacion($id_autorizacion,$id_usuario){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->db->trans_start();
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'activo' => '0',
            'estado' => 'ca',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_autorizacion',$id_autorizacion);
        $this->db->update('autorizacion_remito',$data);


        $data2=array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );

        $this->db->where('id_autorizacion',$id_autorizacion);
        $this->db->update('egreso_temp',$data2);


        $data3=array(
            'id_usuario'=>$id_usuario,
            'id_autorizacion' => $id_autorizacion,
            'fec_mov'=> $fecha
            );

        $this->db->insert('autorizacion_anuladas',$data3);

        $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
        return ($this->db->trans_status() === FALSE) ? false: true;

        
    }

    function getAutorizacionByFecha($fechaIn,$fechaFin){

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
     
        $fechaFin=$fechaFin->setTime(23,59);


        $this->db->select('ar.id_autorizacion as N°Autorizacion,ar.fec_autorizado as Fecha,d.nombre as Destino,u.alias as Usuario,ar.responsable as Responsable,ar.estado as Estado');
        $this->db->from('autorizacion_remito ar');
        
        $this->db->join('destino d', 'd.id_destino=ar.id_destino');
        $this->db->join('usuarios u', 'u.id_usuario=ar.id_usuario');
        $this->db->where('ar.fec_autorizado>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('ar.fec_autorizado<=',$fechaFin->format('Y-m-d H:i:s'));
        //$this->db->where('er.fec_mov BETWEEN "'.$fechaIn.'" AND "'.$fechaFin.'"',false);
        $this->db->where('ar.estado!=','ca');
        $this->db->order_by('ar.id_autorizacion');
        $query=$this->db->get();
        $data=$query->result();
        return $data;


    }

    function getAutorizacionByFechaOld($fechaIn,$fechaFin){

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        $fechaIn=$fechaIn->setTime(00,00);
        $fechaFin=$fechaFin->setTime(23,59);
        $this->db->select('ar.id_autorizacion as N°Autorizacion,ar.fec_autorizado as Fecha,d.nombre as Destino,u.alias as Usuario,ar.responsable as Responsable,ar.estado as Estado');
        $this->db->from('autorizacion_remitoo ar');
        
        $this->db->join('destino d', 'd.id_destino=ar.id_destino');
        $this->db->join('usuarioso u', 'u.id_usuario=ar.id_usuario');
        $this->db->where('ar.fec_autorizado>=',$fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('ar.fec_autorizado<=',$fechaFin->format('Y-m-d H:i:s'));
        $this->db->where('ar.estado!=','ca');
        $this->db->order_by('ar.id_autorizacion');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }




  function getAutorizacionByIdListado($idAut)
  { 

    //ar.id_autorizacion,ar.fec_mov,d.nombre,responsable,destinatario,oficio
    $this->db->select('ar.id_autorizacion as N°Autorizacion,ar.fec_autorizado as Fecha,d.nombre as Destino,ar.responsable as Responsable,ar.destinatario as Destinatario,ar.oficio as Oficio');
    $this->db->from('autorizacion_remito ar');
    $this->db->join('destino d', 'd.id_destino=ar.id_destino');
    //$this->db->join('usuarios u', 'u.id_usuario=ar.id_usuario');
    $this->db->where('ar.id_listado',$idAut);
    $this->db->where('ar.estado!=','ca');
    $this->db->order_by('ar.id_autorizacion');
    $query=$this->db->get();
    $data=$query->result();
    return $data;
  }

  function checkBloqueo($id,$tamano,$inventario)
  {
    $this->db->select('pb.id_bloqueo,pb.id_producto,pb.tamano,pb.inventario');
    $this->db->from('producto_bloqueo pb');
    $this->db->where('pb.id_producto',$id);
    $this->db->where('pb.tamano',$tamano);
    $this->db->where('pb.inventario',$inventario);
    $this->db->where('pb.activo','1');
    $query=$this->db->get();
    if ($query->num_rows() > 0)
    {
      $resultado=$query->row();
      return $resultado->id_bloqueo;
    }
    else
    {
      return 0;
    }
  }

  function checkPin($pin,$id_bloqueo)
  {
    $this->db->select('pb.id_producto, pb.tamano,pb.inventario');
    $this->db->from('producto_bloqueo pb');
    $this->db->where('pb.id_bloqueo',$id_bloqueo);
    $this->db->where('pb.clave',$pin);
    $this->db->where('pb.activo','1');
    $query=$this->db->get();
    if ($query->num_rows() > 0)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }

   function setBloqueo($id_producto,$tamano,$inventario,$pin)
  {
    $this->db->from('producto_bloqueo');
    $this->db->where('id_producto',$id_producto);
    $this->db->where('tamano',$tamano);
    $this->db->where('inventario',$inventario);
    $rs=$this->db->get();
    $medicamento=$rs->row_array();
    //echo $rs->num_rows();
    if ($rs->num_rows()==0)
    {
      //date_default_timezone_set('America/Argentina/Buenos_Aires');
      $fecha=date("Y-m-d H:i:s");
      $data=array(
        'id_producto' => $id_producto,
        'tamano' => $tamano,
        'inventario' => $inventario,
        'clave'=>$pin,
        'activo' => 1,
        'fec_mov' =>  $fecha
      );
      $this->db->insert('producto_bloqueo',$data);
      return true;
    }
    else
    {
      return false;
    }
  }

}