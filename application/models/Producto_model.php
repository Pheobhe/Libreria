
<?php
class Producto_model extends CI_Model {
    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    }

    function getProductos() //NO TOCAR
    {
        /*
        $this->db->select('m.id_producto as Codigo, m.producto as Producto, p.presentacion as presentacion');
        $this->db->from('producto m');
        $this->db->join('presentacion p', 'p.id_presentacion = m.id_presentacion');
        */

        $this->db->select('id_producto as Codigo, producto as Producto, presentacion as Presentacion, stock_minimo as Stock_Minimo');
        $this->db->from('producto');
        //$this->db->join('presentacion p', 'p.id_presentacion = m.id_presentacion');
        //$this->db->group_by('marca');
        $this->db->where('activo','1');
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    function getCantidadProductos(){
        $this->db->where('activo','1');
        $query=$this->db->get('producto');
        $data['cantidad']=$query->num_rows();
        return $data;
    }

    function getCantidadDashboard(){
        $this->db->where('activo','1');
        $query=$this->db->get('producto');
        $data['producto']=$query->num_rows();
        $this->db->where('activo','1');
        $query=$this->db->get('ingreso_remito');
        $data['ingresos']=$query->num_rows();
        $this->db->where('activo','1');
        $query=$this->db->get('devolucion_remito');
        $data['devoluciones']=$query->num_rows();
        $this->db->where('activo','1');
        $query=$this->db->get('autorizacion_remito');
        $data['autorizaciones']=$query->num_rows();
        $this->db->where('activo','1');
        $query=$this->db->get('egreso_remito');
        $data['remitos']=$query->num_rows();



        //cant art por vencer
       // $this->db->select('id_producto as Codigo, producto, presentacion, sum(cantidad) as total');
       // $this->db->from('(
       //(SELECT * FROM v_ingresos_nota_stock)
       // UNION ALL 
       // (SELECT * FROM v_ingresos_stock) 
      //  UNION ALL 
      //  (SELECT * FROM v_egresos_stock)
      //  UNION ALL 
      //  (SELECT * FROM v_egresos_temp_stock)
      //  UNION ALL 
      //  (SELECT * FROM v_egresosx_stock)
      //  UNION ALL 
      //  (SELECT * FROM v_ingresosx_stock)
      //      ) as aux');
      //  $this->db->where('activo','1');
        //$this->db->where('(fec_venc between now() and date_add(now(),interval 90 day))');
        //$this->db->group_by('concat(id_producto)',false);
      //  $this->db->group_by('id_producto',false);
      //  $this->db->having('total>',false);
      //  $this->db->order_by('total DESC');
      //  $query=$this->db->get();
        //$data['artvencer']=$query->num_rows();


        //cant art sin stock    //ca.presentacion,
        $this->db->select("DISTINCT(pr.id_producto), producto, presentacion, '0' as Total ");
        $this->db->from("(
        (select * from ingresos_egresos_stock)
        union all
        (select * from productos_sin_ingresos)
         ) aux1");
        $this->db->join("producto pr","aux1.id_producto=pr.id_producto","left");
        //$this->db->join("presentacion pr", "aux1.id_presentacion=ca.id_presentacion", "left");
        $this->db->order_by("id_producto");
        $query = $this->db->get();
        $data['sinstock']=$query->num_rows();

        //cant stock min
        $this->db->select('id_producto as Codigo, producto, presentacion,  sum(cantidad) as total, stock_minimo');
        $this->db->from('(
        (SELECT * FROM v_ingresos_stock) 
        UNION ALL 
        (SELECT * FROM v_egresos_stock)
        UNION ALL 
        (SELECT * FROM v_egresosx_stock)
        UNION ALL 
        (SELECT * FROM v_ingresosx_stock)
        ) as aux');
        $this->db->where('activo','1');
        $this->db->group_by('id_producto');
        $this->db->having('total>',false);
        $this->db->having('(sum(cantidad) - stock_minimo)<',true);
        $this->db->order_by('id_producto');
        $query=$this->db->get();
        $data['stockmin']=$query->num_rows();

        return $data;
    }

    function addProducto($producto,$stock_minimo,$presentacion)  
    {
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'producto' => $producto,
            'stock_minimo' => $stock_minimo,
            'presentacion' => $presentacion,
            'activo' => '1',
            'fec_mov'=> $fecha
           
        );
        $this->db->insert('producto', $data); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function deleteProducto($id_producto)
    {
        $fecha=date("Y-m-d H:i:s"); 
        $data = array(
            'activo' => '0',
            'fec_mov'=> $fecha
        );
        $this->db->where('id_producto',$id_producto);
        $this->db->update('producto',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
        //preguntar si hay que eliminar todos los movimientos de ese producto
    }

    function getPresentacion()
    {
        $this->db->select('id_presentacion, presentacion');
        $this->db->from('presentacion');
        $this->db->where('id_presentacion >','0');
        $this->db->group_by('presentacion');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }
// function getCategorias()
//     {
//         $this->db->select('categoria');
//         $this->db->from('categoria');
//         $this->db->where('id_categoria >','0');
//         $this->db->group_by('categoria');
//         $query=$this->db->get();
//         $data=$query->result();
//         return $data;
//     }

       
    function getNombresArt()
    {
        $this->db->select('producto, id_producto');
        $this->db->from('producto');
        $this->db->where('id_producto >','0');
        $this->db->where('activo','1');
        $this->db->group_by('producto');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }


     function getNombresArtSeguimiento()
     {
         $this->db->select('m.producto, ms.id_producto');
         $this->db->from('producto_seguimiento ms');
         $this->db->join('producto m','m.id_producto=ms.id_producto');
         $this->db->where('ms.id_producto>','0');
        $this->db->where('ms.activo','1');
         //$this->db->group_by('m.producto');
         $query=$this->db->get();
         $data=$query->result();
         return $data;
     }


    function getNombresArtEliminar()
    {
        $this->db->select('producto, id_producto');
        $this->db->from('producto');
        $this->db->where('id_producto>','0');
        $this->db->where('activo','1');
        //$this->db->group_by('producto');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getproductosNombre($nombre)
    {
        $this->db->select('id_producto as Codigo, producto as Producto,presentacion as Presentacion,stock_minimo as Stock_Minimo');
        $this->db->from('producto');
        //$this->db->join('presentacion p', 'p.id_categoria = m.id_categoria');
        $this->db->where('producto',$nombre);
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

    function getproductosId($id)
    {
        $this->db->select('id_producto as Codigo, producto as Producto,presentacion as Presentacion');
        $this->db->from('producto');
        //$this->db->join('presentacion p','p.id_presentacion = m.id_presentacion');
        $this->db->where('id_producto',$id);
        $this->db->where('activo','1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

     function getProductosStock($nombre)  //, inventario
    {
    
        $this->db->select('id_producto as ID, producto as Producto, presentacion as Presentacion,sum(cantidad) as Total,tamano as Tamaño, inventario as Inventario ');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)
            UNION ALL (SELECT * FROM v_ingresos_stock) 
            UNION ALL (SELECT * FROM v_egresos_stock)
            UNION ALL (SELECT * FROM v_egresosx_stock)
            UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        //$this->db->group_by('concat(id_producto, tamano, inventario)',false);
        $this->db->where('producto',$nombre);
        $this->db->where('activo','1');
        $this->db->having('total >',false);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
      }



//     $this->db->select('u.id_producto, u.producto, u.presentacion, sum(u.cantidad) as total,u.tamano as tamaño,u.inventario as inventario, u.stock_minimo as stockMin,mb.activo bloqueado');
//     $this->db->from('v_stock as u');
//     $this->db->join('producto_bloqueo pb', 'concat(u.id_producto, u.inventario) = concat(pb.id_producto, pb.inventario)', 'left');
//     $this->db->group_by('concat(u.id_producto,u.tamano,u.inventario)',false);
//     $this->db->where('u.producto',$nombre);
//     $this->db->where('u.activo','1');
//     $this->db->having('total >', false);
//     $query=$this->db->get();
//     $data=$query->result();
//     return $data;
// }
      

    function getNombresArtConStock()   //ok muestra el producto en grilla
    {
        $this->db->select('id_producto, producto, presentacion, sum(cantidad) as total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->where('activo','1');
        $this->db->group_by('producto');
        $this->db->having('total >',false);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }

 //funcion para obtener stock por id_medicamento concat(id_producto,tamano,inventario) as med_lote_fec,
  function getProductosById($id)
  {
    $this->db->select('id_producto, producto, presentacion, sum(cantidad) as total, tamano as tamaño,inventario as inventario');
    $this->db->from('((SELECT * FROM v_ingresos_nota_stock)
        UNION ALL (SELECT * FROM v_ingresos_stock) 
        UNION ALL (SELECT * FROM v_egresos_stock)
        UNION ALL (SELECT * FROM v_egresosx_stock)
        UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
    $this->db->group_by('concat(id_producto,tamano,inventario)',false);
    $this->db->where('id_producto',$id);
    //$this->db->where('activo','1');
    $this->db->having('total >',false);
    $query=$this->db->get();
    $data=$query->result();
    return $data;
  }

//funcion para obtener el stock de todos los articulos
  function getAllStock()
  {
    $this->db->select('id_producto , producto, presentacion, sum(cantidad) as total, tamano as tamaño,inventario as inventario');
    $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
    $this->db->group_by('concat(id_producto,tamano,inventario)',false);
    $this->db->order_by('id_producto');
    $this->db->where('activo','1');
    $this->db->having('total >',false);
    $query = $this->db->get();
    $data=$query->result();
    return $data;
  }





    //obtiene todo el stock de una unidad en particular
    function getAllStockUnidades($id_destino){
       
        return 1;
    }

    //funcion para obtener el stock de todos los productos restando los pendientes
    function getAllStockGestion()
    {
        $this->db->select('id_producto as Codigo, producto as Producto, presentacion as Presentacion, sum(cantidad) as Total');
         $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
         

        //$this->db->group_by('concat(id_producto)',false);
        $this->db->group_by('id_producto');
        $this->db->order_by('id_producto');
        $this->db->having('total >',false);
        $this->db->where('activo','1');
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    //funcion para obtener el stock de todos los productos
    function getAllStockId() //////okkkkk
    {
        $this->db->select('id_producto as Codigo, producto as Producto, presentacion as Presentacion, sum(cantidad) as Total, stock_minimo as Stock_Minimo');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->where('activo','1');
        $this->db->group_by('concat(id_producto, tamano, inventario)',false);
        $this->db->order_by('id_producto');
        $this->db->having('total >',false);
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    //funcion para obtener el stock de todos los productos con temps
    function getAllStockIdGestion()
    {
        $this->db->select('id_producto as Codigo, producto as Producto, presentacion as Presentacion, sum(cantidad) as Total, stock_minimo as Stock_Minimo');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock) UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        $this->db->order_by('id_producto');
        $this->db->having('total >',false);
        $this->db->where('activo','1');
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }


    function getProductoByPre($pre){

        $this->db->select('id_producto as Codigo, producto as Producto, presentacion as Presentación, sum(cantidad) as Total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto',false);
        $this->db->order_by('id_producto');
        $this->db->where('activo','1');
        $this->db->where('presentacion',$pre);
        $this->db->having('total >',false);
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    function getProductosPre($pre) //okkkkk
    {
        $this->db->select('id_producto, producto');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        $this->db->order_by('id_producto');
        $this->db->where('activo','1');
        $this->db->where('presentacion',$pre);
        $this->db->having('sum(cantidad) >',false);
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    function getproductoByPreGestion($pre){ //ok

        $this->db->select('id_producto as Codigo, producto as Producto, presentacion as Presentacion, sum(cantidad) as Total');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)
            UNION ALL (SELECT * FROM v_ingresos_stock)
            UNION ALL (SELECT * FROM v_egresos_stock)
            UNION ALL (SELECT * FROM v_egresos_temp_stock)
            UNION ALL (SELECT * FROM v_egresosx_stock)
            UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        //$this->db->group_by('concat(id_producto)',false);
        $this->db->group_by('id_producto',false);
        $this->db->order_by('id_producto');
        $this->db->where('activo','1');
        $this->db->where('presentacion',$pre);
        $this->db->having('total >',false);
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

    function getproductosPreGestion($pre)
    {
        $this->db->select('id_producto, producto ');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock)UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('id_producto');
        $this->db->order_by('id_producto');
        $this->db->where('activo','1');
        $this->db->where('presentacion',$pre);
        $this->db->having('sum(cantidad) >',false);
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }

   
    
    //no funciona VER

    function getSinStockGestion()
    {
        $this->db->select("id_producto as Id_Producto,producto as Producto,presentacion as Presentacion,'0' as Total");
        $this->db->from("producto");
        $this->db->where("id_producto!=","(
        SELECT id_producto FROM ((SELECT * FROM v_ingresos_nota_stock)UNION ALL (SELECT * FROM v_ingresos_stock) UNION ALL (SELECT * FROM v_egresos_stock)UNION ALL (SELECT * FROM v_egresos_temp_stock)UNION ALL (SELECT * FROM v_egresosx_stock)UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux
        WHERE activo=1
        HAVING sum(cantidad)>0
        )",false);
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }
  
//funcion para obtener stock por id_producto ******
    function getProductoById($id){

        $this->db->select('id_producto as ID, producto as Producto, presentacion as Presentacion,concat(id_producto,tamano,inventario) as TamInv, sum(cantidad) as Total,tamano as Tamaño, inventario as Inventario');
        $this->db->from('((SELECT * FROM v_ingresos_nota_stock) 
            UNION ALL (SELECT * FROM v_ingresos_stock) 
            UNION ALL (SELECT * FROM v_egresos_stock)
            UNION ALL (SELECT * FROM v_egresosx_stock)
            UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
        $this->db->group_by('concat(id_producto, tamano, inventario)',false);
        $this->db->where('id_producto',$id);
       // $this->db->where('activo','1');
        $this->db->having('total >',false);
        $query=$this->db->get();
        $data=$query->result();
        return $data;
    }



 function getDatosInv($camTamInv)
  {
    $this->db->select('id_producto, producto, presentacion, concat(id_producto, tamano, inventario) as TamInv ,sum(cantidad) as total, tamano, inventario');
    $this->db->from('((SELECT * FROM v_ingresos_nota_stock)
        UNION ALL (SELECT * FROM v_ingresos_stock) 
        UNION ALL (SELECT * FROM v_egresos_stock) 
        UNION ALL (SELECT * FROM v_egresos_temp_stock)
        UNION ALL (SELECT * FROM v_egresosx_stock)
        UNION ALL (SELECT * FROM v_ingresosx_stock)) as aux');
    $this->db->group_by('concat(id_producto,tamano ,inventario)',false);
   //$this->db->where('concat(id_producto,inventario)', $camTamInv);
    $this->db->where('id_producto',$camTamInv);
   // $this->db->where('activo','1');
    $this->db->having('total >',false);
    $query=$this->db->get();
    $data=$query->result();
    return $data;
  }

  function actualizarInv($camTamInv,$inventario)
  {
     $data = array(
    'inventario' => $inventario
     );
 // $this->db->trans_start();

  $this->db->where('id_producto', $camTamInv);
  $this->db->update('ingreso_producto', $data);
    //$data['1']=$this->db->affected_rows();

  $this->db->where('id_producto', $camTamInv);
  $this->db->update('ingresox_producto', $data);
   // //$data['2']=$this->db->affected_rows();

  $this->db->where('id_producto', $camTamInv);
  $this->db->update('egreso_producto', $data);
  
  $this->db->where('id_producto', $camTamInv);
  $this->db->update('egresox_producto', $data);
 
  $this->db->where('id_producto', $camTamInv);
  $this->db->update('egreso_temp', $data);
   
  $this->db->where('id_producto,', $camTamInv);
  $this->db->update('devolucion_producto', $data);
 
  // $this->db->trans_complete();//esto hace un rollback o un commit dependiendo el result
   return ($this->db->trans_status() === FALSE) ? false: true;

   
  }


   function actualizarStockMin($id,$stock_minimo){

        $data = array(
               'stock_minimo' => $stock_minimo
            );

        $this->db->where('id_producto',$id);
        $this->db->update('producto',$data);
        return $id.$stock_minimo;

    }


    function getproductosDia(){
        $this->db->select('sum(cantidad)*-1 as total, date_format(fec_mov, "%Y-%m-%d") as fecha');
        $this->db->from('egreso_producto');
        $this->db->group_by('concat(year(egreso_producto.fec_mov),month(egreso_producto.fec_mov), day(egreso_producto.fec_mov))',false);
        $this->db->where('activo','1');
        $this->db->order_by('fecha');
        $query=$this->db->get();
        $data=$query->result();

        $this->db->select('count(id_egreso) as total2');
        $this->db->from('egreso_remito');
        $this->db->group_by('concat(year(egreso_remito.fec_mov),month(egreso_remito.fec_mov), day(egreso_remito.fec_mov))',false);
        $this->db->where('activo','1');
        $this->db->order_by('date_format(fec_mov, "%Y-%m-%d")');
        $query2=$this->db->get();
        $data2=$query2->result();
        $i=0;
        $j=0;
        foreach( $data as &$row) {
            foreach ($data2 as &$key) {
                 $total2[$i]= $key->total2;
                 $i++;
            }
            $row->total2=$total2[$j];
            $j++;
        }
        return $data;
    }

    function getConsumos(){
        $this->db->select('sum(em.cantidad)*-1 as total,d.nombre as destino');
        $this->db->from('egreso_producto em');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=em.id_autorizacion');
        $this->db->join('egreso_remito er','er.id_autorizacion=em.id_autorizacion');
        $this->db->join('destino d','d.id_destino=ar.id_destino');
        $this->db->join('producto m','m.id_producto=em.id_producto');
        $this->db->where('em.activo','1');
        $this->db->where('em.id_producto>','0');
        $this->db->group_by('concat(ar.id_destino)',false);
        $this->db->order_by('sum(em.cantidad)');
        $this->db->limit('10');
        $query=$this->db->get();
        $data=$query->result();

        //$datos['cols']=array("total","destino");
       // $datos['rows']=$data;
        ///var_dump($data);
//
        return $data;
    }


    function getproductosMasConsumos(){
        $this->db->select('m.producto as producto,sum(em.cantidad)*-1 as total');
        $this->db->from('egreso_producto em');
        $this->db->join('autorizacion_remito ar','ar.id_autorizacion=em.id_autorizacion');
        $this->db->join('egreso_remito er','er.id_autorizacion=em.id_autorizacion');
        $this->db->join('destino d','d.id_destino=ar.id_destino');
        $this->db->join('producto m','m.id_producto=em.id_producto');
        $this->db->where('em.activo','1');
        $this->db->where('em.id_producto>','0');
        $this->db->group_by('concat(em.id_producto)',false);
        $this->db->order_by('sum(em.cantidad)');
        $this->db->limit('10');

        $query=$this->db->get();
        $data=$query->result();

        return $data;
    }


 // (SELECT * FROM v_ingresos_nota_stock)
        // UNION ALL 
    function getStockMin(){
        $this->db->select('id_producto as Id_Producto, producto as Producto, presentacion as Presentacion, sum(cantidad) as Total, stock_minimo as Stock_Minimo');
        $this->db->from('(
       (SELECT * FROM v_ingresos_nota_stock)
        UNION ALL 
        (SELECT * FROM v_ingresos_stock) 
        UNION ALL 
        (SELECT * FROM v_egresos_stock)
        UNION ALL 
        (SELECT * FROM v_egresosx_stock)
        UNION ALL 
        (SELECT * FROM v_ingresosx_stock)
    ) as aux');
        $this->db->where('activo','1');
        $this->db->group_by('id_producto');
        $this->db->having('total>',false);
        //$this->db->having('(sum(cantidad) - stock_minimo)<',true);
        $this->db->having('(sum(cantidad) - stock_minimo)');
        $this->db->order_by('id_producto');
        $query=$this->db->get();
        $data=$query->result();

        return $data;
    }



    function getSinStock()
    {
        $this->db->select("DISTINCT(pr.id_producto) as Id_Producto, producto as Producto, presentacion as Presentacion, '0' as Total ");
        $this->db->from("(
        (select * from ingresos_egresos_stock)
        union all
        (select * from productos_sin_ingresos)
     ) aux1");
        $this->db->join("producto pr","aux1.id_producto=pr.id_producto","left");
        $this->db->order_by("id_producto");
        $query = $this->db->get();
        $data=$query->result();
        return $data;
    }


    function getPresentacionConsumo(){
        /*SELECT m.presentacion,sum(em.cantidad)*-1 as total
    FROM egreso_producto em
    JOIN autorizacion_remito ar ON ar.id_autorizacion=em.id_autorizacion
    JOIN egreso_remito er ON er.id_autorizacion=em.id_autorizacion
    JOIN destino d ON d.id_destino=ar.id_destino
    JOIN producto m ON m.id_producto=em.id_producto
    WHERE em.activo=1 AND em.id_producto>0 
    GROUP BY m.presentacion
    ORDER BY sum(em.cantidad)*/

    $this->db->select("p.presentacion as label,sum(em.cantidad)*-1 as value");
    $this->db->from("egreso_producto em");
    $this->db->join("autorizacion_remito ar","ar.id_autorizacion=em.id_autorizacion");
    $this->db->join("egreso_remito er","er.id_autorizacion=em.id_autorizacion");
    $this->db->join("destino d","d.id_destino=ar.id_destino");
    $this->db->join("producto p","p.id_producto=em.id_producto");
    $this->db->where("em.activo=1");
    $this->db->where("em.id_producto>0");
    $this->db->group_by("p.presentacion");
    $query = $this->db->get();
    $data=$query->result();
    return $data;

    }

    function getProducto($id)
    {
        $this->db->select('id_producto as ID, producto as Producto, cantidad as Cantidad, num_rem as Remito, num_aut as Autorizacion, fec_mov as Fecha , destino as Destino, proveedor as Proveedor');
        $this->db->from('((select * from v_egresosx_consultas)UNION ALL(select * from v_egresos_consultas) UNION ALL (select * from v_ingresos_consultas)UNION ALL(select * from v_ingresosx_consultas)UNION ALL(select * from v_devolucion_consultas)) as aux');

        // $this->db->select('id_producto as ID, producto as Producto, cantidad as Cantidad, num_rem as Remito, num_aut as Autorizacion, fec_mov as Fecha , destino as Destino, proveedor as Proveedor');
        // $this->db->from('((select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresosx_consultas)UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresos_consultas) UNION ALL (select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresos_consultas)UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresosx_consultas)UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_devolucion_consultas)) as aux');
        $this->db->order_by('fec_mov');
        $this->db->where('id_producto',$id);
        //$this->db->where('activo=1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;

    }

function getProductosSeguimiento($id,$tamano,$inventario)
  {
    $this->db->select('id_producto as id, producto, cantidad, tamano, inventario, num_rem, num_aut, fec_mov, destino, proveedor');
    $this->db->from('((select * from v_egresosx_consultas)UNION ALL(select * from v_egresos_consultas) UNION ALL (select * from v_ingresos_consultas)UNION ALL(select * from v_ingresosx_consultas)UNION ALL(select * from v_devolucion_consultas)) as aux');
    $this->db->order_by('fec_mov');
    $this->db->where('id_producto',$id);
    $this->db->where('tamano',$tamano);
    $this->db->where('inventario',$inventario);
    $this->db->where('activo=1');
    $query=$this->db->get();
    $data=$query->result();
    return $data;
  }


    // function getProducto($id)
    // {
    //     $this->db->select('id_producto as ID, producto as Producto, cantidad as Cantidad, num_rem as Remito, num_aut as Autorizacion, fec_mov as Fecha , destino as Destino, proveedor as Proveedor');
    //     $this->db->from('((select * from v_egresosx_consultas)UNION ALL(select * from v_egresos_consultas) UNION ALL (select * from v_ingresos_consultas)UNION ALL(select * from v_ingresosx_consultas)UNION ALL(select * from v_devolucion_consultas)) as aux');

        // $this->db->select('id_producto as ID, producto as Producto, cantidad as Cantidad, num_rem as Remito, num_aut as Autorizacion, fec_mov as Fecha , destino as Destino, proveedor as Proveedor');
        // $this->db->from('((select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresosx_consultas)UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresos_consultas) UNION ALL (select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresos_consultas)UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresosx_consultas)UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_devolucion_consultas)) as aux');
    //     $this->db->order_by('fec_mov');
    //     $this->db->where('id_producto',$id);
    //     //$this->db->where('activo=1');
    //     $query=$this->db->get();
    //     $data=$query->result();
    //     return $data;

    // }

    // function getproductosSeguimiento($id)
   
    // {
    //     $this->db->select('id_producto as id, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor');
    //     $this->db->from('((select * from v_egresosx_consultas)UNION ALL(select * from v_egresos_consultas) UNION ALL (select * from v_ingresos_consultas)UNION ALL(select * from v_ingresosx_consultas)UNION ALL(select * from v_devolucion_consultas)) as aux');
    //     $this->db->order_by('fec_mov');
    //     $this->db->where('id_producto',$id);
    //     $this->db->where('activo=1');
    //     $query=$this->db->get();
    //     $data=$query->result();
    //     return $data;

    // }

 function getProductosDestino($id)  //obtenerProductosByDestino
{
$this->db->select('id_producto as ID, producto as Producto, cantidad as Cantidad, num_rem as Remito, num_aut as Autorización, fec_mov as Fecha, destino as Destino, proveedor as Proveedor');
$this->db->from('((select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresosx_consultas)
    UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresos_consultas) 
    UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresos_consultas)
    UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresosx_consultas)
    UNION ALL(select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_devolucion_consultas)) as aux');
  $this->db->order_by('fec_mov');
    $this->db->where('destino',$id);
   // $this->db->where('activo=1');
    $query=$this->db->get();
    $data=$query->result();
    return $data;
 }


    function getProductosByFecha($fechaIn,$fechaFin)
    {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
    $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
    $fechaIn = $fechaIn->setTime(00,00);
    $fechaFin = $fechaFin->setTime(23,59);

    $this->db->select('id_producto as ID, producto as Producto, cantidad as Cantidad, num_rem as Remito, num_aut as Autorización, fec_mov as Fecha, destino as Destino, proveedor as Proveedor');
    $this->db->from('((select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresos_consultas) UNION ALL (select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresos_consultas)UNION ALL (select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_ingresosx_consultas)UNION ALL (select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_devolucion_consultas)UNION ALL (select id_producto, producto, cantidad, num_rem, num_aut, fec_mov, destino, proveedor from v_egresosx_consultas)) as aux');
        $this->db->order_by('fec_mov desc');
        $this->db->where('fec_mov >=', $fechaIn->format('Y-m-d H:i:s'));
        $this->db->where('fec_mov <=', $fechaFin->format('Y-m-d H:i:s'));
       // $this->db->where('activo=1');
        $query=$this->db->get();
        $data=$query->result();
        return $data;

    }
  
    function setSeguimiento($id_producto){
        
//, $tamano, $inventario
        $this->db->from('producto_seguimiento');
        $this->db->where('id_producto',$id_producto);
        //$this->db->where('tamano',$tamano);
        //$this->db->where('inventario',$inventario);
        $rs=$this->db->get();
        $producto=$rs->row_array();
        //echo $rs->num_rows();
        if ($rs->num_rows()==0){

             //date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha=date("Y-m-d H:i:s"); 
            $data=array(
                'id_producto' => $id_producto,
                 'activo' => 1,
                'fec_mov' =>  $fecha
                );
            $this->db->insert('producto_seguimiento',$data);
            return true;

        }else{
            return false;
        }
    }


    function dobleEntrada($fechaIn,$fechaFin){

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIn = DateTime::createFromFormat('d/m/Y', $fechaIn);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin);
        
        $fechaIn=$fechaIn->setTime(00,00);
        
        $fechaFin=$fechaFin->setTime(23,59);


$this->db->select('id_producto,producto,
    tabla.`UNIDAD Nº 1 - L. OLMOS`,
    tabla.`UNIDAD Nº 2 - SIERRA CHICA`,
    tabla.`UNIDAD Nº 3 - SAN NICOLAS`,
    tabla.`UNIDAD Nº 4 - BAHIA BLANCA`,
    tabla.`UNIDAD Nº 5 MERCEDES`,
    tabla.`UNIDAD Nº 6 - DOLORES`,
    tabla.`UNIDAD Nº 27 - SIERRA CHICA`,
    tabla.`UNIDAD Nº 7 - AZUL`,
    tabla.`UNIDAD Nº 8 - LOS HORNOS`,
    tabla.`UNIDAD Nº 9 - LA PLATA`,
    tabla.`UNIDAD Nº 10 - M. ROMERO`,
    tabla.`UNIDAD Nº 11 - BARADERO`,
    tabla.`UNIDAD Nº 12 - GORINA`,
    tabla.`UNIDAD Nº 13 - JUNIN`,
    tabla.`UNIDAD Nº 14 - GRAL. ALVEAR`,
    tabla.`UNIDAD Nº 15 - BATAN`,
    tabla.`UNIDAD Nº 16 - JUNIN`,
    tabla.`UNIDAD Nº 17 - URDAMPILLETA`,
    tabla.`UNIDAD Nº 18 - GORINA`,
    tabla.`UNIDAD Nº 19 - SAAVEDRA`,
    tabla.`UNIDAD Nº 20 - TRENQUE LAUQUEN`,
    tabla.`UNIDAD Nº 21 - CAMPANA`,
    tabla.`UNIDAD Nº 22 - Ho.G.A.M - OLMOS`,
    tabla.`UNIDAD Nº 23 - F. VARELA`,
    tabla.`UNIDAD Nº 24 - F. VARELA`,
    tabla.`UNIDAD Nº 25 - OLMOS`,
    tabla.`UNIDAD Nº 26 - OLMOS`,
    tabla.`UNIDAD Nº 28 - MAGDALENA`,
    tabla.`UNIDAD Nº 30 - GRAL. ALVEAR`,
    tabla.`UNIDAD Nº 31 - F. VARELA`,
    tabla.`UNIDAD Nº 32 - F. VARELA`,
    tabla.`UNIDAD Nº 33 - LOS HORNOS`,
    tabla.`UNIDAD Nº 34 - M. ROMERO`,
    tabla.`UNIDAD Nº 35 - MAGDALENA`,
    tabla.`UNIDAD Nº 36 - MAGDALENA`,
    tabla.`UNIDAD Nº 37 - BARKER`,
    tabla.`UNIDAD Nº 38 - SIERRA CHICA`,
    tabla.`UNIDAD Nº 39 - ITUZAINGO`,
    tabla.`UNIDAD Nº 40 - LOMAS DE ZAMORA`,
    tabla.`UNIDAD Nº 41 - CAMPANA`,
    tabla.`UNIDAD Nº 42 - F. VARELA`,
    tabla.`UNIDAD Nº 43 - LA MATANZA`,
    tabla.`UNIDAD Nº 44- BATAN (ALCAIDIA)`,
    tabla.`UNIDAD Nº 45 - M. ROMERO`,
    tabla.`UNIDAD Nº 46 - GRAL. SAN MARTIN`,
    tabla.`UNIDAD Nº 47 - SAN MARTIN (SAN ISIDRO)`,
    tabla.`UNIDAD Nº 48 - SAN MARTIN`,
    tabla.`UNIDAD Nº 49 - JUNIN (ALCAIDIA)`,
    tabla.`UNIDAD Nº 50 - MAR DEL PLATA`,
    tabla.`UNIDAD Nº 51 - MAGDALENA`,
    tabla.`UNIDAD Nº 52 - AZUL`,
    tabla.`UNIDAD Nº 54 - F. VARELA`,
    tabla.`ALCAIDIA 53/55 JOSE C. PAZ - MALV. ARG`,
    tabla.`ALCAIDIA I. CASANOVA`,
    tabla.`ALCAIDIA SAN MARTIN`,
    tabla.`ALCAIDIA PETTINATO`,
    tabla.`ALCAIDIA II - LA PLATA`,
    tabla.`ALCAIDIA LOMAS DE ZAMORA`,
    tabla.`COMPLEJO ROMERO (U10 - U34 - U45)`,
    tabla.`COMPLEJO SAN MARTIN (U46 - U47 - U48)`,
    tabla.`COMPLEJO F. VARELA (U23-U24-U31-U32-U42-U54)`,
    tabla.`COMPLEJO CAMPANA (U21 - U41)`,
    tabla.`COMPLEJO MAGDALENA (U28-U35-U36-U51)`,
    tabla.`COMPLEJO MAR DEL PLATA (U15-U44-U50)`,
    tabla.`ALCAIDIA III ROMERO`,
    tabla.`ALCAIDIA AVELLANEDA`,
    tabla.`ESCUELA DE CADETES`,
    tabla.`ALCAIDIA VIRREY DEL PINO`,
    tabla.`PLAN PREVENCION HIV - MEDICINA ASISTENCIAL`,
    tabla.`N TBC - MEDICINA ASISTENCIAL`,
    tabla.`LIBRERIA`,
    tabla.`BOTIQUIN DPSP`,
    tabla.`PLAN PREVENCION GENITO MAMARIO - MED. ASIST.`',false);
$this->db->from('(
    select id_producto,producto,
    sum(IF(id_destino=2,(cantidad*-1),0)) as `UNIDAD Nº 1 - L. OLMOS`, 
    sum(IF(id_destino=3,(cantidad*-1),0)) as `UNIDAD Nº 2 - SIERRA CHICA`,
    sum(IF(id_destino=4,(cantidad*-1),0)) as `UNIDAD Nº 3 - SAN NICOLAS`,
    sum(IF(id_destino=5,(cantidad*-1),0)) as `UNIDAD Nº 4 - BAHIA BLANCA`,
sum(IF(id_destino=6,(cantidad*-1),0)) as `UNIDAD Nº 5 MERCEDES`,
sum(IF(id_destino=7,(cantidad*-1),0)) as `UNIDAD Nº 6 - DOLORES`,
sum(IF(id_destino=9,(cantidad*-1),0)) as `UNIDAD Nº 27 - SIERRA CHICA`,
sum(IF(id_destino=10,(cantidad*-1),0)) as `UNIDAD Nº 7 - AZUL`,
sum(IF(id_destino=11,(cantidad*-1),0)) as `UNIDAD Nº 8 - LOS HORNOS`,
sum(IF(id_destino=12,(cantidad*-1),0)) as `UNIDAD Nº 9 - LA PLATA`,
sum(IF(id_destino=13,(cantidad*-1),0)) as `UNIDAD Nº 10 - M. ROMERO`,
sum(IF(id_destino=14,(cantidad*-1),0)) as `UNIDAD Nº 11 - BARADERO`,
sum(IF(id_destino=15,(cantidad*-1),0)) as `UNIDAD Nº 12 - GORINA`,
sum(IF(id_destino=16,(cantidad*-1),0)) as `UNIDAD Nº 13 - JUNIN`,
sum(IF(id_destino=17,(cantidad*-1),0)) as `UNIDAD Nº 14 - GRAL. ALVEAR`,
sum(IF(id_destino=18,(cantidad*-1),0)) as `UNIDAD Nº 15 - BATAN`,
sum(IF(id_destino=19,(cantidad*-1),0)) as `UNIDAD Nº 16 - JUNIN`,
sum(IF(id_destino=20,(cantidad*-1),0)) as `UNIDAD Nº 17 - URDAMPILLETA`,
sum(IF(id_destino=21,(cantidad*-1),0)) as `UNIDAD Nº 18 - GORINA`,
sum(IF(id_destino=22,(cantidad*-1),0)) as `UNIDAD Nº 19 - SAAVEDRA`,
sum(IF(id_destino=23,(cantidad*-1),0)) as `UNIDAD Nº 20 - TRENQUE LAUQUEN`,
sum(IF(id_destino=24,(cantidad*-1),0)) as `UNIDAD Nº 21 - CAMPANA`,
sum(IF(id_destino=25,(cantidad*-1),0)) as `UNIDAD Nº 22 - Ho.G.A.M - OLMOS`,
sum(IF(id_destino=26,(cantidad*-1),0)) as `UNIDAD Nº 23 - F. VARELA`,
sum(IF(id_destino=27,(cantidad*-1),0)) as `UNIDAD Nº 24 - F. VARELA`,
sum(IF(id_destino=28,(cantidad*-1),0)) as `UNIDAD Nº 25 - OLMOS`,
sum(IF(id_destino=29,(cantidad*-1),0)) as `UNIDAD Nº 26 - OLMOS`,
sum(IF(id_destino=30,(cantidad*-1),0)) as `UNIDAD Nº 28 - MAGDALENA`,
sum(IF(id_destino=31,(cantidad*-1),0)) as `UNIDAD Nº 30 - GRAL. ALVEAR`,
sum(IF(id_destino=32,(cantidad*-1),0)) as `UNIDAD Nº 31 - F. VARELA`,
sum(IF(id_destino=33,(cantidad*-1),0)) as `UNIDAD Nº 32 - F. VARELA`,
sum(IF(id_destino=34,(cantidad*-1),0)) as `UNIDAD Nº 33 - LOS HORNOS`,
sum(IF(id_destino=35,(cantidad*-1),0)) as `UNIDAD Nº 34 - M. ROMERO`,
sum(IF(id_destino=36,(cantidad*-1),0)) as `UNIDAD Nº 35 - MAGDALENA`,
sum(IF(id_destino=37,(cantidad*-1),0)) as `UNIDAD Nº 36 - MAGDALENA`,
sum(IF(id_destino=38,(cantidad*-1),0)) as `UNIDAD Nº 37 - BARKER`,
sum(IF(id_destino=39,(cantidad*-1),0)) as `UNIDAD Nº 38 - SIERRA CHICA`,
sum(IF(id_destino=40,(cantidad*-1),0)) as `UNIDAD Nº 39 - ITUZAINGO`,
sum(IF(id_destino=41,(cantidad*-1),0)) as `UNIDAD Nº 40 - LOMAS DE ZAMORA`,
sum(IF(id_destino=42,(cantidad*-1),0)) as `UNIDAD Nº 41 - CAMPANA`,
sum(IF(id_destino=43,(cantidad*-1),0)) as `UNIDAD Nº 42 - F. VARELA`,
sum(IF(id_destino=44,(cantidad*-1),0)) as `UNIDAD Nº 43 - LA MATANZA`,
sum(IF(id_destino=45,(cantidad*-1),0)) as `UNIDAD Nº 44- BATAN (ALCAIDIA)`,
sum(IF(id_destino=46,(cantidad*-1),0)) as `UNIDAD Nº 45 - M. ROMERO`,
sum(IF(id_destino=47,(cantidad*-1),0)) as `UNIDAD Nº 46 - GRAL. SAN MARTIN`,
sum(IF(id_destino=48,(cantidad*-1),0)) as `UNIDAD Nº 47 - SAN MARTIN (SAN ISIDRO)`,
sum(IF(id_destino=49,(cantidad*-1),0)) as `UNIDAD Nº 48 - SAN MARTIN`,
sum(IF(id_destino=50,(cantidad*-1),0)) as `UNIDAD Nº 49 - JUNIN (ALCAIDIA)`,
sum(IF(id_destino=51,(cantidad*-1),0)) as `UNIDAD Nº 50 - MAR DEL PLATA`,
sum(IF(id_destino=52,(cantidad*-1),0)) as `UNIDAD Nº 51 - MAGDALENA`,
sum(IF(id_destino=53,(cantidad*-1),0)) as `UNIDAD Nº 52 - AZUL`,
sum(IF(id_destino=54,(cantidad*-1),0)) as `UNIDAD Nº 54 - F. VARELA`,
sum(IF(id_destino=55,(cantidad*-1),0)) as `ALCAIDIA 53/55 JOSE C. PAZ - MALV. ARG`,
sum(IF(id_destino=56,(cantidad*-1),0)) as `ALCAIDIA I. CASANOVA`,
sum(IF(id_destino=57,(cantidad*-1),0)) as `ALCAIDIA SAN MARTIN`,
sum(IF(id_destino=58,(cantidad*-1),0)) as `ALCAIDIA PETTINATO`,
sum(IF(id_destino=59,(cantidad*-1),0)) as `ALCAIDIA II - LA PLATA`,
sum(IF(id_destino=60,(cantidad*-1),0)) as `ALCAIDIA LOMAS DE ZAMORA`,
sum(IF(id_destino=63,(cantidad*-1),0)) as `COMPLEJO ROMERO (U10 - U34 - U45)`,
sum(IF(id_destino=65,(cantidad*-1),0)) as `COMPLEJO SAN MARTIN (U46 - U47 - U48)`,
sum(IF(id_destino=66,(cantidad*-1),0)) as `COMPLEJO F. VARELA (U23-U24-U31-U32-U42-U54)`,
sum(IF(id_destino=67,(cantidad*-1),0)) as `COMPLEJO CAMPANA (U21 - U41)`,
sum(IF(id_destino=68,(cantidad*-1),0)) as `COMPLEJO MAGDALENA (U28-U35-U36-U51)`,
sum(IF(id_destino=69,(cantidad*-1),0)) as `COMPLEJO MAR DEL PLATA (U15-U44-U50)`,
sum(IF(id_destino=70,(cantidad*-1),0)) as `ALCAIDIA III ROMERO`,
sum(IF(id_destino=71,(cantidad*-1),0)) as `ALCAIDIA AVELLANEDA`,
sum(IF(id_destino=72,(cantidad*-1),0)) as `ESCUELA DE CADETES`,
sum(IF(id_destino=73,(cantidad*-1),0)) as `ALCAIDIA VIRREY DEL PINO`,
sum(IF(id_destino=74,(cantidad*-1),0)) as `PLAN PREVENCION HIV - MEDICINA ASISTENCIAL`,
sum(IF(id_destino=75,(cantidad*-1),0)) as `N TBC - MEDICINA ASISTENCIAL`,
sum(IF(id_destino=76,(cantidad*-1),0)) as `LIBRERIA`,
sum(IF(id_destino=77,(cantidad*-1),0)) as `BOTIQUIN DPSP`,
sum(IF(id_destino=78,(cantidad*-1),0)) as `PLAN PREVENCION GENITO MAMARIO - MED. ASIST.`




    from v_egresos_consultas_doble WHERE fec_mov BETWEEN "'.$fechaIn->format('Y-m-d H:i:s').'" AND "'.$fechaFin->format('Y-m-d H:i:s').'" GROUP BY id_producto 
)
as tabla',false);

        $query=$this->db->get();
        $data=$query->result();
        return $data;

    }


}