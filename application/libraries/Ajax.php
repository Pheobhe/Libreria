<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax {

		private $ci;
	    public function __construct() {
	        $this->ci =& get_instance();
	        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
	        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
	    }

        public function resolverCredenciales()
        {	
          //metodos principales
          $metodosPrincipales=array("mostrarDatos","getUnidades","getProveedores", "getProductos", "getNombreUnidades", "getNombreProveedores", "getNombresArt", "getproductosId", "getNombresProdConStock", "getCurrentUser", "getproductosNombre", "getUnidadesNombre", "getProveedoresNombre", "imprimir", "VerificarLogin", "getUltimosIngresos", "getCantidadProductos", "getCantidadIngresos", "getCantidadEgresos");
          $metodosManejoImagen=array("insertarImagen", "obtenerImagenPerfil");
          //ingreso
          $metodosIngreso=array("checkRepetido", "addMovimiento", "addNota"); 
          //egreso         
          $metodosEgreso=array("getProductosStock", "checkStock","getTotal","getAutorizaciones", "getAutorizacionById", "cerrar");
          //stock
          $metodosStock=array("mostrarDatosConsulta", "getPresentacion", "getProductoByPre", "getProductosPre", "getProductoById","obtenerProductosById" , "getAllStock", "getAllStockId", "mostrarDatosConsultaGestion", "getAllStockGestion", "getAllStockIdGestion");
          //consultas
          $metodosConsultas=array("getMovimientos","getMovimientosO", "getMovimientooById", "getMovimientoById", "getNotas", "getNotaById", "mostrarDatosFecha", "getMovimientoByFecha" , "getMovimientoOByFecha", "getRemitos", "getRemitoById", "getRemitoByIdOld", "getRemitoByFecha", "getAutorizacionByFecha" , "getAutorizacionByFechaOld", "mostrarVistaProductos","obtenerProductosById","getProductoByFecha","obtenerProductosByDestino");


          //admin-fichas
          $metodosAdminFichas=array("mostrarDatosNuevoArt", "addProducto", "mostrarDatosEliminarArt", "getNombresArtEliminar", "deleteProducto", "mostrarDatosNuevoUnidad", "addUnidad", "mostrarDatosEliminarUnidad", "deleteUnidad", "mostrarDatosNuevoProv", "addProveedor", "mostrarDatosEliminarProv", "deleteProveedor", "mostrarDatosInventario");
          //admin-ingreso
          $metodosAdminIngreso=array("addIngresoX", "mostrarDatosAnular", "anularMovimiento", "anularNota");
          //admin-Egreso
          $metodosAdminEgreso=array("anularAutorizacion", "anularRemito");
          //admin-consultas
         // $metodosAdminConsultas=array("getNotaByFecha");

///***********************


$metodosAdminConsultas=array("getNotaByFecha","mostrarVistaProductosDestino","dobleEntrada","mostrarVistaProductosSeguimiento","getNombresProdSeguimiento","obtenerProductosByIdSeguimiento", "obtenerProductosById","getProductoByFecha", "mostrarDatosEstadisticas","getProductosDia","getConsumos","getCategoriasConsumo" ,"consultaProducto");
     //admin-dashboard    "mostrarVistaConsultaVencidos","getVencidos","mostrarVistaMedicamentosVencimiento","consultaMedicamentoVencimiento",
      $metodosAdminDashboard=array("getSinStock","getNotificacionVencer","getStockMin");








//*******************




          $uri=$this->ci->uri->segment(0);
          $controlador=$this->ci->uri->segment(1);
          $metodo=$this->ci->uri->segment(2);
          $permitidoConsultas= array_merge($metodosPrincipales, $metodosManejoImagen, $metodosIngreso, $metodosEgreso, $metodosStock, $metodosConsultas, $metodosAdminFichas, $metodosAdminIngreso, $metodosAdminEgreso, $metodosAdminConsultas);
          $permitidoCerrar= array_merge($metodosPrincipales, $metodosManejoImagen, $metodosIngreso, $metodosEgreso, $metodosStock, $metodosConsultas, $metodosAdminFichas, $metodosAdminIngreso, $metodosAdminEgreso, $metodosAdminConsultas);
          $permitidoAutorizar= array_merge($metodosPrincipales, $metodosManejoImagen, $metodosIngreso, $metodosEgreso, $metodosStock, $metodosConsultas, $metodosAdminFichas, $metodosAdminIngreso, $metodosAdminEgreso, $metodosAdminConsultas);
          $permitidoAdministrador= array_merge($metodosPrincipales, $metodosManejoImagen, $metodosIngreso, $metodosEgreso, $metodosStock, $metodosConsultas, $metodosAdminFichas, $metodosAdminIngreso, $metodosAdminEgreso, $metodosAdminConsultas);
          $permitidoUnidades= array_merge($metodosPrincipales, $metodosManejoImagen, $metodosIngreso, $metodosEgreso, $metodosStock, $metodosConsultas, $metodosAdminFichas, $metodosAdminIngreso, $metodosAdminEgreso, $metodosAdminConsultas);

          $boolean=TRUE;//produccion
          //$boolean=TRUE;//desarrollo


           $rol = $this->ci->session->userdata('rol');
         
          switch ($rol) {
            case 'autorizar':
               if (!in_array($metodo, $permitidoAutorizar)){return $boolean;}
              break;
            case 'cierre':
               if (!in_array($metodo, $permitidoCerrar)){return $boolean;}
              break;
            case 'consultas':
               if (!in_array($metodo, $permitidoConsultas)){return $boolean;}
              break;
            case 'administrador':
               if (!in_array($metodo, $permitidoAdministrador)){return $boolean;}
              break;
            case 'unidades':
               if (!in_array($metodo, $permitidoUnidades)){return $boolean;}
              break;  
            default:
              die;
              break;
          }

        	 //echo "requerimiento ajax libreria pasa";
			 return true;
        }
}