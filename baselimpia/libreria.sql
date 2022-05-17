-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2020 a las 16:58:03
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizacion_anuladas`
--

CREATE TABLE `autorizacion_anuladas` (
  `id_auto_anuluada` int(11) UNSIGNED NOT NULL,
  `id_autorizacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizacion_listado`
--

CREATE TABLE `autorizacion_listado` (
  `id_autorizacion_listado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizacion_remito`
--

CREATE TABLE `autorizacion_remito` (
  `id_autorizacion` int(11) NOT NULL,
  `fec_autorizado` date DEFAULT NULL,
  `id_destino` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `responsable` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `destinatario` varchar(150) NOT NULL,
  `oficio` varchar(150) NOT NULL,
  `id_listado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destino`
--

CREATE TABLE `destino` (
  `id_destino` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(45) NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `cod_postal` varchar(10) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `destino`
--

INSERT INTO `destino` (`id_destino`, `nombre`, `direccion`, `telefono`, `contacto`, `cod_postal`, `fec_mov`, `activo`) VALUES
(1, 'UNIDAD Nº 1', '197 Y 52', '4964606', '', '', '2017-02-06 18:15:36', 0),
(2, 'UNIDAD Nº 1 - L. OLMOS', '197 Y 52', '(0221) 4964606', '', '1901', '2017-02-06 18:16:11', 1),
(3, 'UNIDAD Nº 2 - SIERRA CHICA', 'AV. PEDRO LEGORBURU Y CENTENARIO S/Nº', '(02284) 424584', '', '7400', '2017-02-06 18:17:28', 1),
(4, 'UNIDAD Nº 3 - SAN NICOLAS', 'AV. GRAL. SALVIO 1072', '(0336) 4452471', '', '2900', '2017-02-06 18:18:50', 1),
(5, 'UNIDAD Nº 4 - BAHIA BLANCA', 'LA FALDA Nº 2300', '(0291) 4884084', '', '8000', '2017-02-06 18:19:31', 1),
(6, 'UNIDAD Nº 5 MERCEDES', '27 Nº 1174 E/ 48 Y 50', '(02324) 425362', '', '6600', '2017-02-06 18:20:36', 1),
(7, 'UNIDAD Nº 6 - DOLORES', 'RIOBAMBA Nª 251', '(02245) 443983', '', '7100', '2017-02-06 18:21:19', 1),
(8, 'COMPLEJO SIERRA CHICA', 'LERGUBURU IRIARTE Y AV CENTENARIO', '(02284) 424584', '', '7400', '2017-02-07 14:27:51', 0),
(9, 'UNIDAD Nº 27 - SIERRA CHICA', 'AV. CENTENARIO S/ Nª', '(02284) 424190', '', '7401', '2017-02-06 18:32:19', 1),
(10, 'UNIDAD Nº 7 - AZUL', 'Comisario Aldaz S/Nº', '(02281) 423655', '', '7300', '2017-02-07 14:31:49', 1),
(11, 'UNIDAD Nº 8 - LOS HORNOS', '149 y 70', '(0221) 4563997', 'us8_dpsp@mjus.gba.gov.ar', '1900', '2017-02-07 14:34:33', 1),
(12, 'UNIDAD Nº 9 - LA PLATA', '76 e/ 9 y 11', '(0221) 4524034', 'us9_dpsp@mjus.gba.gov.ar', '1900', '2017-02-07 14:35:28', 1),
(13, 'UNIDAD Nº 10 - M. ROMERO', '520 Y 176', '(0221) 4780014', 'us10_dpsp@mjus.gba.gov.ar', '1903', '2017-02-07 14:36:26', 1),
(14, 'UNIDAD Nº 11 - BARADERO', 'CUARTEL II', '(03329) 484449', '', '2942', '2017-02-07 14:37:17', 1),
(15, 'UNIDAD Nº 12 - GORINA', '501 Y VIAS DEL FERROCARRIL', '(0221) 4780069', 'us12_dpsp@mjus.gba.gov.ar', '1896', '2017-02-07 14:38:29', 1),
(16, 'UNIDAD Nº 13 - JUNIN', 'RUTA 188 KM. 162', '(02364) 422768', 'us13_dpsp@mjus.gba.gov.ar', '6000', '2017-02-07 14:39:11', 1),
(17, 'UNIDAD Nº 14 - GRAL. ALVEAR', 'CUARTEL 5º', '(02344) 481250', '', '7263', '2017-02-07 14:40:55', 1),
(18, 'UNIDAD Nº 15 - BATAN', 'RUTA 88 KM 8,5', '(0223) 4642353', '', '7601', '2017-02-07 14:42:15', 1),
(19, 'UNIDAD Nº 16 - JUNIN', 'RUTA 188 KM 162', '(0236) 4441417', 'us16_dpsp@mjus.gba.gov.ar', '6000', '2017-02-07 14:43:19', 1),
(20, 'UNIDAD Nº 17 - URDAMPILLETA', 'ACCESO RUTA 65 KM 3,5', '(02314) 491586', '', '6553', '2017-02-07 14:46:49', 1),
(21, 'UNIDAD Nº 18 - GORINA', '501 Y 143', '(0221) 4780679', 'us18_dpsp@mjus.gba.gov.ar', '1896', '2017-02-07 14:48:21', 1),
(22, 'UNIDAD Nº 19 - SAAVEDRA', 'SAN CAYETANO Nº 400', '(02923) 497159', 'us19_dpsp@mjus.gba.gov.ar', '8174', '2017-02-07 14:49:25', 1),
(23, 'UNIDAD Nº 20 - TRENQUE LAUQUEN', 'PARAJE LAS TUNAS - RUTA 5 KM 443', '(02392) 434059', 'us20_dpsp@mjus.gba.gov.ar', '6400', '2017-02-07 14:50:48', 1),
(24, 'UNIDAD Nº 21 - CAMPANA', 'RUTA 6 KM 5.5', '(03489) 422428', '', '2804', '2017-02-07 14:53:06', 1),
(25, 'UNIDAD Nº 22 - Ho.G.A.M - OLMOS', '52 193 Y 194', '(0221) 4964611', 'us22_dpsp@mjus.gba.gov.ar', '1901', '2017-02-07 14:54:36', 1),
(26, 'UNIDAD Nº 23 - F. VARELA', 'CALLE BUENOS AIRES Y RUTA PROV. 53 KM 15.500', '(02225) 498487', 'us23_dpsp@mjus.gba.gov.ar', '1888', '2017-02-07 14:55:41', 1),
(27, 'UNIDAD Nº 24 - F. VALREA', 'RUTA PROV. 53 KM 15.500 Y BS AS -LA CAPILLA-', '(02225) 498665', 'us24_dpsp@mjus.gba.gov.ar', '1888', '2017-02-07 14:57:02', 1),
(28, 'UNIDAD Nº 25 - OLMOS', '47 Y 192', '(0221) 4961151', 'us25_dpsp@mjus.gba.gov.ar', '1901', '2017-02-07 14:57:36', 1),
(29, 'UNIDAD Nº 26 - OLMOS', '197 E/ 47 Y 49', '(0221) 4963285', 'us26_dpsp@mjus.gba.gov.ar', '1901', '2017-02-07 14:58:12', 1),
(30, 'UNIDAD Nº 28 - MAGDALENA', 'RUTA 11 KM. 111', '(02221) 454133', '', '1913', '2017-02-07 14:59:59', 1),
(31, 'UNIDAD Nº 30 - GRAL. ALVEAR', 'SAN MARTIN S/Nº', '(02344) 480302', 'us30_dpsp@mjus.gba.gov.ar', '7263', '2017-02-07 15:01:18', 1),
(32, 'UNIDAD Nº 31 - F. VARELA', 'RUTA PROV 53 KM 15.500', '(02225) 498326', 'us31_dpsp@mjus.gba.gov.ar', '1888', '2017-02-07 15:02:25', 1),
(33, 'UNIDAD Nº 32 - F. VARELA', 'RUTA PROV 53 KM 15.500 Y BS AS -LA CAPILLA-', '(02225) 498453', '', '1888', '2017-02-07 15:04:03', 1),
(34, 'UNIDAD Nº 33 - LOS HORNOS', '149 Y 71', '(0221) 4564277', 'us33_dpsp@mjus.gba.gov.ar', '1900', '2017-02-07 15:05:15', 1),
(35, 'UNIDAD Nº 34 - M. ROMERO', '524 Y 179', '(0221) 4917331', 'us34_dpsp@mjus.gba.gov.ar', '1903', '2017-02-07 15:05:51', 1),
(36, 'UNIDAD Nº 35 - MAGDALENA', 'RUTA 11 KM 111', '(02221) 453387', '', '1913', '2017-02-07 15:27:05', 1),
(37, 'UNIDAD Nº 36 - MAGDALENA', 'RUTA 11 KM 111', '(02221) 453651', '', '1913', '2017-02-07 15:28:01', 1),
(38, 'UNIDAD Nº 37 - BARKER', 'VILLA CACIQUE', '(02292) 498089', 'us37_dpsp@mjus.gba.gov.ar', '', '2017-02-07 15:28:57', 1),
(39, 'UNIDAD Nº 38 - SIERRA CHICA', 'AV. P.I. LERGUBURU Y 17', '(02284) 427674', '', '7401', '2017-02-07 15:29:43', 1),
(40, 'UNIDAD Nº 39 - ITUZAINGO', 'PRINGLES E/ EL SALVADOR Y ACEVEDO', '(011) 44816646  / 7079', 'us39_dpsp@mjus.gba.gov.ar', '1714', '2017-02-07 15:30:35', 1),
(41, 'UNIDAD Nº 40 - LOMAS DE ZAMORA', 'GIACHINO Y PEÑALOSA - SANTA CATALINA', '(011) 46936539', 'us40_dpsp@mjus.gba.gov.ar', '1832', '2017-02-07 15:31:39', 1),
(42, 'UNIDAD Nº 41 - CAMPANA', 'RUTA 6 KM 6', '(03489) 422428 / 447916', '', '2804', '2017-02-07 15:32:36', 1),
(43, 'UNIDAD Nº 42 - F. VARELA', 'RUTA PROV. 53 Y AV. BS AS S/Nº \"LA CAPILLA\"', '(02225) 498591', '', '1888', '2017-02-07 15:33:41', 1),
(44, 'UNIDAD Nº 43 - LA MATANZA', 'SCARLATTI Nº 5100 E/ TUPUNGATO Y JACHAL', '(02202) 434596', 'us43_dpsp@mjus.gba.gov.ar', '7503', '2017-02-07 15:35:01', 1),
(45, 'UNIDAD Nº 44- BATAN (ALCAIDIA)', 'RUTA 88 KM 8,5 BATAN', '(0223) 4641486', '', '7601', '2017-02-07 15:40:39', 1),
(46, 'UNIDAD Nº 45 - M. ROMERO', '520 Y 176', '(0221) 4780014', 'us45_dpsp@mjus.gba.gov.ar', '1903', '2017-02-07 15:41:17', 1),
(47, 'UNIDAD Nº 46 - GRAL. SAN MARTIN', 'CNO. DEL BUEN AYRE Y CNO. DE BENEDETTI', '(011) 47206735', 'us46_dpsp@mjus.gba.gov.ar', '1655', '2017-02-07 15:42:15', 1),
(48, 'UNIDAD Nº 47 - SAN MARTIN (SAN ISIDRO)', 'CNO. DEL BUEN AYRE Y CNO. DE BENEDETTI', '(011) 47204277', 'us47_dpsp@mjus.gba.gov.ar', '1655', '2017-02-07 15:43:29', 1),
(49, 'UNIDAD Nº 48 - SAN MARTIN', 'CNO. DEL BUEN AYRE Y CNO. DE BENEDETTI', '(011) 47299374', 'us48_dpsp@mjus.gba.gov.ar', '1655', '2017-02-07 15:44:20', 1),
(50, 'UNIDAD Nº 49 - JUNIN (ALCAIDIA)', 'RUTA 188 KM. 165', '(0236) 4434650', '', '6000', '2017-02-07 15:46:03', 1),
(51, 'UNIDAD Nº 50 - MAR DEL PLATA', 'RUTA 88 KM. 8,5 - BATAN', '(0223) 4641475', '', '7601', '2017-02-07 15:46:47', 1),
(52, 'UNIDAD Nº 51 - MAGDALENA', 'RUTA 11 KM 111 1/2', '(02221) 453405', '', '1913', '2017-02-07 15:47:29', 1),
(53, 'UNIDAD Nº 52 - AZUL', 'COMISARIO ALDAZ S/Nº', '(02281) 432177', '', '7300', '2017-02-07 15:48:12', 1),
(54, 'UNIDAD Nº 54 - F. VARELA', 'CALLE 1635 Nº 2751 Bº LA CAPILLA', '(02225) 498976', 'us54_dpsp@mjus.gba.gov.ar', '1888', '2017-02-07 15:50:03', 1),
(55, 'ALCAIDIA 53/55 JOSE C. PAZ - MALV. ARG', 'PERITO MORENO Nº 3171 - MALV. ARGENTINAS', '(011) 46603210', '', '1846', '2017-02-07 15:52:59', 1),
(56, 'ALCAIDIA I. CASANOVA', 'CALLE ROMA ESQ LASCANO', '(011) 44660710', '', '1765', '2017-02-07 16:06:53', 1),
(57, 'ALCAIDIA SAN MARTIN', 'CNO DEL BUEN AYRE Y CNO. DE BENEDETTI', '(011) 45898726', '', '1655', '2017-02-07 16:08:07', 1),
(58, 'ALCAIDIA PETTINATO', 'RUTA 36 Y 47', '(0221) 4962225', '', '1901', '2017-02-07 16:09:12', 1),
(59, 'ALCAIDIA II - LA PLATA', '11 Nº 2164 E/ 76 Y 77', '(0221) 4539275', '', '1900', '2017-02-07 16:10:29', 1),
(60, 'ALCAIDIA LOMAS DE ZAMORA', 'CAP DE FRAGATA GUACHINO Y PEÑALOSA', '(011) 46933104', '', '', '2017-02-07 16:12:44', 1),
(61, 'ALCAIDIA II DEPARTAMENTAL LA PLATA', '11 Nº 2164 E/ 76 Y 77', '(0221) 4539275', '', '1900', '2017-02-07 16:15:28', 0),
(62, 'COMPLEJO M. ROMERO', '520 Y 176', '(0221) 4780014', 'us10_dpsp@mjus.gba.gov.ar', '1903', '2017-02-07 16:20:05', 0),
(63, 'COMPLEJO ROMERO (U10 - U34 - U45)', '520 Y 176', '(0221) 4780014', 'us10_dpsp@mjus.gba.gov.ar', '1903', '2017-02-07 16:21:05', 1),
(64, 'COMPLEJO F. VARELA', 'RUTA PROV. 53 KM 15,500 Y CALLE BS AS', '(02225) 498665', 'us24_dpsp@mjus.gba.gov.ar', '1888', '2017-02-07 16:27:09', 0),
(65, 'COMPLEJO SAN MARTIN (U46 - U47 - U48)', 'CNO DEL BUEN AYRE Y CNO DE BENEDETTI', '(011) 47299374', 'us48_dpsp@mjus.gba.gov.ar', '1655', '2017-02-07 16:26:25', 1),
(66, 'COMPLEJO F. VARELA (U23-U24-U31-U32-U42-U54)', 'RUTA PROV 53 KM 15,500 Y CALLE BS AS', '(02225) 498665', 'us24_dpsp@mjus.gba.gov.ar', '1888', '2017-02-07 16:30:06', 1),
(67, 'COMPLEJO CAMPANA (U21 - U41)', 'RUTA 6 KM 5,5', '(03489) 422428', '', '2804', '2017-02-07 16:31:21', 1),
(68, 'COMPLEJO MAGDALENA (U28-U35-U36-U51)', 'RUTA 11 KM. 111', '(02221) 454133', '', '1913', '2017-02-07 16:32:47', 1),
(69, 'COMPLEJO MAR DEL PLATA (U15-U44-U50)', 'RUTA 88 KM 8,5 BATAN', '(0223) 4642353', '', '7601', '2017-02-07 16:35:39', 1),
(70, 'ALCAIDIA III ROMERO', '520 Y 182', '(0221) 4913640', '', '1903', '2017-02-07 16:41:42', 1),
(71, 'ALCAIDIA AVELLANEDA', 'NICARAGUA Y COLECTORA AUTOPISTA BS AS', '(011) 42070039', '', '', '2017-02-07 16:45:14', 1),
(72, 'ESCUELA DE CADETES', 'CALLE 44 N° 2000', '(0221) 470-6242 / 6460', '', '', '2017-02-09 16:32:22', 1),
(73, 'ALCAIDIA VIRREY DEL PINO', 'CAÑUELAS 5300 E/ OCTAVIO MAZZOTI Y PAVON', '02202490622', '', '', '2017-02-10 14:30:54', 1),
(74, 'PLAN PREVENCION HIV - MEDICINA ASISTENCIAL', '3 y 525 LA PLATA', '0221 426 2383', '', '', '2017-02-17 14:15:31', 1),
(75, 'N TBC - MEDICINA ASISTENCIAL', '3 y 525 LA PLATA', '0221 426 2383', '', '', '2017-02-17 14:16:22', 1),
(76, 'BOTIQUIN FARMACIA', '6 ENTRE 34 Y 35', '0221 429 3866', '', '', '2017-03-28 14:52:40', 1),
(77, 'BOTIQUIN DPSP', '3 Y 525 (TOLOSA)', '0221 426 2320', '', '', '2017-03-28 14:54:02', 1),
(78, 'PLAN PREVENCION GENITO MAMARIO - MED. ASIST.', '3 y 525', '0221 426 2383', '', '', '2017-04-03 14:56:29', 1),
(79, 'BOTIQUIN - DIR. DE PRESUP. Y ADM. CONT. (SPB)', '6 Y 34', '0221 12345678', '', '', '2017-04-18 16:32:05', 1),
(80, 'JEFATURA SERVICIO PENITENCIARIO', 'Calle 6', '4293800', '', '1900', '2017-05-26 13:05:04', 1),
(81, 'AREA SANITARIA I', 'US 22 calle 52 e 193 y 194', 'US 22 496-1053', 'US 1, 9, 12, 18, 22, 10, 34, 45', '1901', '2017-05-31 19:31:22', 1),
(82, 'PATRONATO DE LIBERADOS', 'CALLE 72 e 121 y 122 Nº186', '457-8363', 'dec@plb.gba.gov.ar', '1900', '2017-07-07 16:29:23', 1),
(83, 'AREA  SANITARIA VI', 'SAN MARTIN S/Nº', '(02344) 480302', 'Hector Bianchi', '7263', '2017-10-27 16:58:01', 1),
(84, 'DIRECCIÓN DE GESTIÓN', 'CALLE 3 Y 525', '4262312', '', '1900', '2017-11-28 19:21:51', 1),
(85, 'AREA SANITARIA III', '---', '---', '-', '-', '2018-01-03 17:05:12', 1),
(86, 'DIRECCION DE MONITOREO ELECTRONICO', 'Calle 6 Nº 122', '(0221) 429-3800', '', '1900', '2018-01-04 14:00:00', 1),
(87, 'UNIDAD N° 57 - ALCAIDÍA CAMPANA', 'RUTA 6 KM 5,5', '03489 422 428', 'areas5_dpsp@mjus.gba.gov.ar', '2804', '2018-10-22 15:17:31', 1),
(88, 'H.I.G.A HORACIO CESTINO ENSENADA', 'CALLE SAN MARTIN ESQ. ESTADOS UNIDOS', '0221 4691416', 'DR. JORGE GUTIERREZ', '1925', '2019-03-07 14:12:13', 1),
(89, 'DIR. DE MED. ASIST. Y PROMOCION DE LA SALUD', 'CALLE 3 Y 525 TOLOSA', '0221 4262320', 'DR. STELRRICH CLAUS', '1900', '2019-03-15 12:37:49', 1),
(90, 'otra', '508', '221', '', '1900', '2019-04-10 18:51:20', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion_anulados`
--

CREATE TABLE `devolucion_anulados` (
  `id_dev_anulados` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion_producto`
--

CREATE TABLE `devolucion_producto` (
  `id_devolucion_producto` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tamano` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion_remito`
--

CREATE TABLE `devolucion_remito` (
  `id_devolucion` int(11) NOT NULL,
  `fec_devolucion` date DEFAULT NULL,
  `id_destino` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `responsable` varchar(45) DEFAULT NULL,
  `motivo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresox_producto`
--

CREATE TABLE `egresox_producto` (
  `id_egresox_producto` int(11) NOT NULL,
  `id_egresox` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tamano` int(11) NOT NULL,
  `fec_mov` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresox_remito`
--

CREATE TABLE `egresox_remito` (
  `id_egresox` int(11) NOT NULL,
  `fec_mov` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL,
  `responsable` varchar(45) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `fec_egresox` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_producto`
--

CREATE TABLE `egreso_producto` (
  `id_egreso_producto` int(11) NOT NULL,
  `id_autorizacion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tamano` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_productos_unidades`
--

CREATE TABLE `egreso_productos_unidades` (
  `id_egreso_producto` int(11) NOT NULL,
  `id_remito_unidades` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fec_mov` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_remito`
--

CREATE TABLE `egreso_remito` (
  `id_egreso` int(11) NOT NULL,
  `id_autorizacion` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `responsable` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `confirmado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_temp`
--

CREATE TABLE `egreso_temp` (
  `id_egresotemp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_autorizacion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fec_mov` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tamano` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ingresos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ingresos` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(4)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ingresos_egresos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ingresos_egresos` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(4)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ingresos_egresos_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ingresos_egresos_stock` (
`id_producto` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresox_producto`
--

CREATE TABLE `ingresox_producto` (
  `id_ingresox_producto` int(11) NOT NULL,
  `id_ingresox` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tamano` int(11) NOT NULL,
  `fec_mov` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresox_remito`
--

CREATE TABLE `ingresox_remito` (
  `id_ingresox` int(11) NOT NULL,
  `fec_ingresox` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL,
  `responsable` varchar(45) NOT NULL,
  `motivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_anulados`
--

CREATE TABLE `ingreso_anulados` (
  `id_ing_anulado` int(11) NOT NULL,
  `id_ingreso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_producto`
--

CREATE TABLE `ingreso_producto` (
  `id_ingreso_producto` int(11) NOT NULL,
  `id_ingreso` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tamano` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_remito`
--

CREATE TABLE `ingreso_remito` (
  `id_ingreso` int(11) NOT NULL,
  `fec_ingreso` date DEFAULT NULL,
  `id_provedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `responsable` varchar(45) DEFAULT NULL,
  `nro_remito` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_unidades`
--

CREATE TABLE `ingreso_unidades` (
  `id_ingreso` int(11) NOT NULL,
  `id_remito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `responsable` varchar(100) NOT NULL,
  `fec_mov` datetime NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fec_mov` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id_log`, `ip`, `url`, `usuario`, `nombre`, `fec_mov`) VALUES
(1, '170.155.4.131', '/libreria/index.php/VerificarLogin', 1, 'admin@admin.gob.ar', '2017-08-25 15:24:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id_presentacion` int(11) NOT NULL,
  `presentacion` varchar(45) DEFAULT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id_presentacion`, `presentacion`, `fec_mov`, `activo`) VALUES
(1, 'RESMA', '2019-04-09 03:00:00', 1),
(2, 'CAJA', '2019-04-04 03:00:00', 1),
(3, 'UNIDAD', '2019-04-04 03:00:00', 1),
(4, 'BLISTER', '2019-05-17 03:00:00', 1),
(5, 'PAQUETE', '2019-05-17 03:00:00', 1),
(6, 'BOLSA', '2019-05-17 03:00:00', 1),
(7, 'BLOCK', '2019-05-17 03:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `presentacion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `producto`, `stock_minimo`, `fec_mov`, `activo`, `presentacion`) VALUES
(1, 'LAPICERA VERDE', 50, '2018-01-08 13:51:13', 1, 'UNIDAD'),
(2, 'MARCADOR VERDE', 50, '2019-04-11 03:00:00', 1, 'UNIDAD'),
(3, 'HOJAS A4', 100, '2019-04-10 03:00:00', 1, 'RESMA'),
(4, 'LAPIZ NEGRO', 50, '2019-04-11 15:14:39', 1, 'UNIDAD'),
(5, 'SACAPUNTAS METALICO', 50, '2019-04-11 15:15:14', 1, 'UNIDAD'),
(6, 'TIJERAS', 20, '2019-04-11 15:30:01', 1, 'UNIDAD'),
(7, 'HOJAS OFICIO', 100, '2019-04-11 15:31:30', 1, 'RESMA'),
(8, 'LAPICERA AZUL', 50, '2019-04-11 15:32:28', 1, 'UNIDAD'),
(9, 'CORRECTORES', 10, '2019-04-11 15:43:03', 1, 'UNIDAD'),
(10, 'BIBLIORATO A 4', 10, '2019-04-11 15:44:06', 1, 'CAJA'),
(11, 'BANDAS ELÁSTICAS', 10, '2019-04-11 20:06:38', 1, 'BOLSA');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_activos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_activos` (
`id_producto` int(11)
,`nombre` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_ingresos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_ingresos` (
`id_producto` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_sin_ingresos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_sin_ingresos` (
`id_producto` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_bloqueo`
--

CREATE TABLE `producto_bloqueo` (
  `id_bloqueo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `clave` int(4) NOT NULL,
  `fec_mov` datetime NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_seguimiento`
--

CREATE TABLE `producto_seguimiento` (
  `id_seguimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fec_mov` datetime NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_provedor` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `cuit` varchar(30) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contacto` varchar(45) NOT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_provedor`, `nombre`, `cuit`, `direccion`, `telefono`, `email`, `contacto`, `fec_mov`, `activo`) VALUES
(1, 'MINISTERIO DE SALUD DE LA NACION', '30-68307705-0', 'AV. 9 DE JULIO 1925 PISO 8 - CAPITAL FEDERAL', '011 0000 0000', '', '', '2019-07-24 17:18:19', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito_anulados`
--

CREATE TABLE `remito_anulados` (
  `id_rem_anulados` int(11) NOT NULL,
  `id_autorizacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_mov` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `alias` varchar(45) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `fec_mov` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `alias`, `password`, `email`, `rol`, `fec_mov`, `activo`) VALUES
(1, 'administrador', 'administrador', '$2a$12$NoFAg8gmqu2Zv7qv5AO36.FCmUBptqFKRfSS1J/PAHi98PlsmQXdW', 'admin@admin.gob.ar', 'administrador', '2016-12-28 17:00:00', 1 ),
(2, 'LORENA', 'LORENA', '$2y$12$5F61WyEqotaU6JORTpyrY.O9MDSCuXs8z7/gXQFoi1jqbPVRdFK6O', 'lorena@dpsp.gob.ar', 'administrador', '2016-12-28 17:00:00', 1 ),
(3, 'CASSINO LEONARDO', 'CASINO LEONARDO', '$2y$12$tcG7E9sILxipyOgAEY.OuOVtuMOdvipg8WZxakknjnLIXnwp2OGIm', 'l.cassino@spb.gba.gov.ar', 'administrador', '2016-12-28 17:00:00', 1 ),
(4, 'CASTRO LEONARDO', 'CASTRO LEONARDO', '$2y$12$YcYepNgRD6L0X1AzddK45up3qm73QME.cE7dfi2e.3vbY7vdMXT5C', 'lm.castro@spb.gba.gov.ar', 'administrador', '2016-12-28 17:00:00', 1),
(5, 'MASSOLA JORGE', 'MASSOLA JORGE', '$2y$12$.XUf80GLMz5EpWM62Xg1uOs4th5MXjHLIxq8J.5ADEGVCa/KB/Tw6', 'j.massola@spb.gba.gov.ar', 'administrador', '2016-12-28 17:00:00', 1),
(6, 'BRENNA NOELIA', 'BRENA NOELIA', '$2a$12$xvYzaTZ8AaNEA49p0fO.C.ez7FpIj1Sd7eanWPCnMkSu2UE7jaXWS', 'm.brenna@spb.gba.gov.ar', 'administrador', '2016-12-28 17:00:00', 1 ),
(7, 'TORRES EUGENIA', 'TORRES EUGNEIA', '$2a$12$aS3Wbzay5yA9zVmwJC.aCepgJIYtngcV42zDknARnU39GS6gqKTLK', 'en.torres@spb.gba.gov.ar', 'administrador', '2016-12-28 17:00:00', 1 );
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_destino`
--

CREATE TABLE `usuarios_destino` (
  `id_usuario` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_devolucion_consultas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_devolucion_consultas` (
`id_producto` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`tamano` int(11)
,`num_rem` int(11)
,`num_aut` varchar(1)
,`fec_mov` timestamp
,`destino` varchar(45)
,`proveedor` varchar(1)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_egresosx_consultas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_egresosx_consultas` (
`id_producto` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`tamano` int(11)
,`num_rem` int(11)
,`num_aut` text
,`fec_mov` timestamp
,`destino` varchar(1)
,`proveedor` varchar(1)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_egresosx_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_egresosx_stock` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(1)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_egresos_consultas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_egresos_consultas` (
`id_producto` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`num_rem` int(11)
,`num_aut` int(11)
,`fec_mov` timestamp
,`destino` varchar(45)
,`proveedor` varchar(1)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_egresos_consultas_doble`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_egresos_consultas_doble` (
`id_producto` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`tamano` int(11)
,`num_rem` int(11)
,`num_aut` int(11)
,`fec_mov` timestamp
,`id_destino` int(11)
,`destino` varchar(45)
,`proveedor` varchar(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_egresos_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_egresos_stock` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(1)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_egresos_temp_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_egresos_temp_stock` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(1)
,`tamano` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresos` (
`id_ingreso` int(11)
,`fec_ingreso` date
,`id_provedor` int(11)
,`id_usuario` int(11)
,`responsable` varchar(45)
,`nro_remito` varchar(45)
,`id_ingreso_producto` int(11)
,`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresosx_consultas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresosx_consultas` (
`id_producto` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`tamano` int(11)
,`num_rem` text
,`num_aut` text
,`fec_mov` timestamp
,`destino` varchar(1)
,`proveedor` varchar(1)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresosx_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresosx_stock` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(1)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresos_completa`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresos_completa` (
`id_ingreso` int(11)
,`fec_ingreso` date
,`id_provedor` int(11)
,`nombreProv` varchar(45)
,`id_usuario` int(11)
,`alias` varchar(45)
,`responsable` varchar(45)
,`nro_remito` varchar(45)
,`id_ingreso_producto` int(11)
,`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresos_consultas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresos_consultas` (
`id_producto` int(11)
,`producto` varchar(100)
,`cantidad` int(11)
,`tamano` int(11)
,`num_rem` varchar(45)
,`num_aut` varchar(1)
,`fec_mov` timestamp
,`destino` varchar(1)
,`proveedor` varchar(45)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresos_nota_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresos_nota_stock` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(1)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ingresos_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ingresos_stock` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
,`activo` tinyint(1)
,`tamano` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_union_egr_ing`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_union_egr_ing` (
`id_producto` int(11)
,`cantidad` int(11)
,`producto` varchar(100)
,`stock_minimo` int(11)
,`presentacion` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `ingresos`
--
DROP TABLE IF EXISTS `ingresos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ingresos`  AS  (select `v_ingresos_nota_stock`.`id_producto` AS `id_producto`,`v_ingresos_nota_stock`.`cantidad` AS `cantidad`,`v_ingresos_nota_stock`.`producto` AS `producto`,`v_ingresos_nota_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresos_nota_stock`.`presentacion` AS `presentacion`,`v_ingresos_nota_stock`.`activo` AS `activo`,`v_ingresos_nota_stock`.`tamano` AS `tamano` from `v_ingresos_nota_stock`) union all (select `v_ingresos_stock`.`id_producto` AS `id_producto`,`v_ingresos_stock`.`cantidad` AS `cantidad`,`v_ingresos_stock`.`producto` AS `producto`,`v_ingresos_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresos_stock`.`presentacion` AS `presentacion`,`v_ingresos_stock`.`activo` AS `activo`,`v_ingresos_stock`.`tamano` AS `tamano` from `v_ingresos_stock`) union all (select `v_ingresosx_stock`.`id_producto` AS `id_producto`,`v_ingresosx_stock`.`cantidad` AS `cantidad`,`v_ingresosx_stock`.`producto` AS `producto`,`v_ingresosx_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresosx_stock`.`presentacion` AS `presentacion`,`v_ingresosx_stock`.`activo` AS `activo`,`v_ingresosx_stock`.`tamano` AS `tamano` from `v_ingresosx_stock`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ingresos_egresos`
--
DROP TABLE IF EXISTS `ingresos_egresos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ingresos_egresos`  AS  (select `v_ingresos_nota_stock`.`id_producto` AS `id_producto`,`v_ingresos_nota_stock`.`cantidad` AS `cantidad`,`v_ingresos_nota_stock`.`producto` AS `producto`,`v_ingresos_nota_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresos_nota_stock`.`presentacion` AS `presentacion`,`v_ingresos_nota_stock`.`activo` AS `activo`,`v_ingresos_nota_stock`.`tamano` AS `tamano` from `v_ingresos_nota_stock`) union all (select `v_ingresos_stock`.`id_producto` AS `id_producto`,`v_ingresos_stock`.`cantidad` AS `cantidad`,`v_ingresos_stock`.`producto` AS `producto`,`v_ingresos_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresos_stock`.`presentacion` AS `presentacion`,`v_ingresos_stock`.`activo` AS `activo`,`v_ingresos_stock`.`tamano` AS `tamano` from `v_ingresos_stock`) union all (select `v_egresos_stock`.`id_producto` AS `id_producto`,`v_egresos_stock`.`cantidad` AS `cantidad`,`v_egresos_stock`.`producto` AS `producto`,`v_egresos_stock`.`stock_minimo` AS `stock_minimo`,`v_egresos_stock`.`presentacion` AS `presentacion`,`v_egresos_stock`.`activo` AS `activo`,`v_egresos_stock`.`tamano` AS `tamano` from `v_egresos_stock`) union all (select `v_egresosx_stock`.`id_producto` AS `id_producto`,`v_egresosx_stock`.`cantidad` AS `cantidad`,`v_egresosx_stock`.`producto` AS `producto`,`v_egresosx_stock`.`stock_minimo` AS `stock_minimo`,`v_egresosx_stock`.`presentacion` AS `presentacion`,`v_egresosx_stock`.`activo` AS `activo`,`v_egresosx_stock`.`tamano` AS `tamano` from `v_egresosx_stock`) union all (select `v_ingresosx_stock`.`id_producto` AS `id_producto`,`v_ingresosx_stock`.`cantidad` AS `cantidad`,`v_ingresosx_stock`.`producto` AS `producto`,`v_ingresosx_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresosx_stock`.`presentacion` AS `presentacion`,`v_ingresosx_stock`.`activo` AS `activo`,`v_ingresosx_stock`.`tamano` AS `tamano` from `v_ingresosx_stock`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ingresos_egresos_stock`
--
DROP TABLE IF EXISTS `ingresos_egresos_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ingresos_egresos_stock`  AS  (select distinct `ingresos_egresos`.`id_producto` AS `id_producto` from `ingresos_egresos` where (`ingresos_egresos`.`activo` = 1) group by `ingresos_egresos`.`id_producto` having (sum(`ingresos_egresos`.`cantidad`) = 0)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_activos`
--
DROP TABLE IF EXISTS `productos_activos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_activos`  AS  (select `producto`.`id_producto` AS `id_producto`,`producto`.`producto` AS `nombre` from `producto` where (`producto`.`activo` = 1)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_ingresos`
--
DROP TABLE IF EXISTS `productos_ingresos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_ingresos`  AS  (select distinct `ingresos`.`id_producto` AS `id_producto` from `ingresos` where (`ingresos`.`activo` = 1)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_sin_ingresos`
--
DROP TABLE IF EXISTS `productos_sin_ingresos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_sin_ingresos`  AS  (select `pa`.`id_producto` AS `id_producto` from (`productos_activos` `pa` left join `productos_ingresos` `pi` on((`pa`.`id_producto` = `pi`.`id_producto`))) where isnull(`pi`.`id_producto`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_devolucion_consultas`
--
DROP TABLE IF EXISTS `v_devolucion_consultas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_devolucion_consultas`  AS  (select `im`.`id_producto` AS `id_producto`,`p`.`producto` AS `producto`,`im`.`cantidad` AS `cantidad`,`im`.`tamano` AS `tamano`,`ir`.`id_devolucion` AS `num_rem`,'-' AS `num_aut`,`ir`.`fec_mov` AS `fec_mov`,`d`.`nombre` AS `destino`,'-' AS `proveedor`,`im`.`activo` AS `activo` from (((`devolucion_producto` `im` join `devolucion_remito` `ir` on((`ir`.`id_devolucion` = `im`.`id_devolucion`))) join `destino` `d` on((`d`.`id_destino` = `ir`.`id_destino`))) join `producto` `p` on((`p`.`id_producto` = `im`.`id_producto`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_egresosx_consultas`
--
DROP TABLE IF EXISTS `v_egresosx_consultas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_egresosx_consultas`  AS  (select `ex`.`id_producto` AS `id_producto`,`p`.`producto` AS `producto`,`ex`.`cantidad` AS `cantidad`,`ex`.`tamano` AS `tamano`,`er`.`id_egresox` AS `num_rem`,`er`.`motivo` AS `num_aut`,`er`.`fec_mov` AS `fec_mov`,'-' AS `destino`,'-' AS `proveedor`,`ex`.`activo` AS `activo` from ((`egresox_producto` `ex` join `egresox_remito` `er` on((`er`.`id_egresox` = `ex`.`id_egresox`))) join `producto` `p` on((`p`.`id_producto` = `ex`.`id_producto`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_egresosx_stock`
--
DROP TABLE IF EXISTS `v_egresosx_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_egresosx_stock`  AS  select `ep`.`id_producto` AS `id_producto`,`ep`.`cantidad` AS `cantidad`,`p`.`producto` AS `producto`,`p`.`stock_minimo` AS `stock_minimo`,`p`.`presentacion` AS `presentacion`,`ep`.`activo` AS `activo`,`ep`.`tamano` AS `tamano` from ((`egresox_remito` `er` left join `egresox_producto` `ep` on((`er`.`id_egresox` = `ep`.`id_egresox`))) left join `producto` `p` on((`ep`.`id_producto` = `p`.`id_producto`))) where (`p`.`activo` = '1') order by `p`.`id_producto` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_egresos_consultas`
--
DROP TABLE IF EXISTS `v_egresos_consultas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_egresos_consultas`  AS  (select `em`.`id_producto` AS `id_producto`,`m`.`producto` AS `producto`,`em`.`cantidad` AS `cantidad`,`er`.`id_egreso` AS `num_rem`,`er`.`id_autorizacion` AS `num_aut`,`er`.`fec_mov` AS `fec_mov`,`d`.`nombre` AS `destino`,'-' AS `proveedor`,`em`.`activo` AS `activo` from ((((`egreso_producto` `em` join `autorizacion_remito` `ar` on((`em`.`id_autorizacion` = `ar`.`id_autorizacion`))) join `egreso_remito` `er` on((`em`.`id_autorizacion` = `er`.`id_autorizacion`))) join `destino` `d` on((`ar`.`id_destino` = `d`.`id_destino`))) join `producto` `m` on((`m`.`id_producto` = `em`.`id_producto`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_egresos_consultas_doble`
--
DROP TABLE IF EXISTS `v_egresos_consultas_doble`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_egresos_consultas_doble`  AS  (select `em`.`id_producto` AS `id_producto`,`p`.`producto` AS `producto`,`em`.`cantidad` AS `cantidad`,`em`.`tamano` AS `tamano`,`er`.`id_egreso` AS `num_rem`,`er`.`id_autorizacion` AS `num_aut`,`er`.`fec_mov` AS `fec_mov`,`d`.`id_destino` AS `id_destino`,`d`.`nombre` AS `destino`,'-' AS `proveedor` from ((((`egreso_producto` `em` join `autorizacion_remito` `ar` on((`em`.`id_autorizacion` = `ar`.`id_autorizacion`))) join `egreso_remito` `er` on((`em`.`id_autorizacion` = `er`.`id_autorizacion`))) join `destino` `d` on((`ar`.`id_destino` = `d`.`id_destino`))) join `producto` `p` on((`p`.`id_producto` = `em`.`id_producto`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_egresos_stock`
--
DROP TABLE IF EXISTS `v_egresos_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_egresos_stock`  AS  (select `egreso_producto`.`id_producto` AS `id_producto`,`egreso_producto`.`cantidad` AS `cantidad`,`producto`.`producto` AS `producto`,`producto`.`stock_minimo` AS `stock_minimo`,`producto`.`presentacion` AS `presentacion`,`egreso_producto`.`activo` AS `activo`,`egreso_producto`.`tamano` AS `tamano` from (((`autorizacion_remito` left join `egreso_producto` on((`autorizacion_remito`.`id_autorizacion` = `egreso_producto`.`id_autorizacion`))) left join `producto` on((`egreso_producto`.`id_producto` = `producto`.`id_producto`))) left join `egreso_remito` on((`autorizacion_remito`.`id_autorizacion` = `egreso_remito`.`id_autorizacion`))) where ((`autorizacion_remito`.`estado` <> 'ca') and (`producto`.`activo` = 1)) order by `producto`.`id_producto`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_egresos_temp_stock`
--
DROP TABLE IF EXISTS `v_egresos_temp_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_egresos_temp_stock`  AS  (select `egreso_temp`.`id_producto` AS `id_producto`,`egreso_temp`.`cantidad` AS `cantidad`,`producto`.`producto` AS `producto`,`producto`.`stock_minimo` AS `stock_minimo`,`producto`.`presentacion` AS `presentacion`,`egreso_temp`.`activo` AS `activo`,`egreso_temp`.`tamano` AS `tamano` from ((`autorizacion_remito` left join `egreso_temp` on((`autorizacion_remito`.`id_autorizacion` = `egreso_temp`.`id_autorizacion`))) left join `producto` on((`egreso_temp`.`id_producto` = `producto`.`id_producto`))) where (`producto`.`activo` = '1') order by `producto`.`id_producto`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresos`
--
DROP TABLE IF EXISTS `v_ingresos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresos`  AS  (select `ingreso_remito`.`id_ingreso` AS `id_ingreso`,`ingreso_remito`.`fec_ingreso` AS `fec_ingreso`,`ingreso_remito`.`id_provedor` AS `id_provedor`,`ingreso_remito`.`id_usuario` AS `id_usuario`,`ingreso_remito`.`responsable` AS `responsable`,`ingreso_remito`.`nro_remito` AS `nro_remito`,`ingreso_producto`.`id_ingreso_producto` AS `id_ingreso_producto`,`ingreso_producto`.`id_producto` AS `id_producto`,`ingreso_producto`.`cantidad` AS `cantidad`,`producto`.`producto` AS `producto`,`producto`.`stock_minimo` AS `stock_minimo`,`producto`.`presentacion` AS `presentacion` from ((`ingreso_remito` left join `ingreso_producto` on((`ingreso_remito`.`id_ingreso` = `ingreso_producto`.`id_ingreso`))) left join `producto` on((`ingreso_producto`.`id_producto` = `producto`.`id_producto`))) order by `producto`.`id_producto`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresosx_consultas`
--
DROP TABLE IF EXISTS `v_ingresosx_consultas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresosx_consultas`  AS  (select `im`.`id_producto` AS `id_producto`,`p`.`producto` AS `producto`,`im`.`cantidad` AS `cantidad`,`im`.`tamano` AS `tamano`,`ir`.`motivo` AS `num_rem`,`ir`.`motivo` AS `num_aut`,`ir`.`fec_mov` AS `fec_mov`,'-' AS `destino`,'-' AS `proveedor`,`im`.`activo` AS `activo` from ((`ingresox_producto` `im` join `ingresox_remito` `ir` on((`ir`.`id_ingresox` = `im`.`id_ingresox`))) join `producto` `p` on((`p`.`id_producto` = `im`.`id_producto`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresosx_stock`
--
DROP TABLE IF EXISTS `v_ingresosx_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresosx_stock`  AS  select `ingresox_producto`.`id_producto` AS `id_producto`,`ingresox_producto`.`cantidad` AS `cantidad`,`producto`.`producto` AS `producto`,`producto`.`stock_minimo` AS `stock_minimo`,`producto`.`presentacion` AS `presentacion`,`ingresox_producto`.`activo` AS `activo`,`ingresox_producto`.`tamano` AS `tamano` from ((`ingresox_remito` left join `ingresox_producto` on((`ingresox_remito`.`id_ingresox` = `ingresox_producto`.`id_ingresox`))) left join `producto` on((`ingresox_producto`.`id_producto` = `producto`.`id_producto`))) where (`producto`.`activo` = '1') order by `producto`.`id_producto` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresos_completa`
--
DROP TABLE IF EXISTS `v_ingresos_completa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresos_completa`  AS  (select `ir`.`id_ingreso` AS `id_ingreso`,`ir`.`fec_ingreso` AS `fec_ingreso`,`ir`.`id_provedor` AS `id_provedor`,`p`.`nombre` AS `nombreProv`,`ir`.`id_usuario` AS `id_usuario`,`us`.`alias` AS `alias`,`ir`.`responsable` AS `responsable`,`ir`.`nro_remito` AS `nro_remito`,`im`.`id_ingreso_producto` AS `id_ingreso_producto`,`im`.`id_producto` AS `id_producto`,`im`.`cantidad` AS `cantidad`,`m`.`producto` AS `producto`,`m`.`stock_minimo` AS `stock_minimo`,`m`.`presentacion` AS `presentacion` from ((((`ingreso_remito` `ir` join `usuarios` `us` on((`ir`.`id_usuario` = `us`.`id_usuario`))) join `proveedor` `p` on((`ir`.`id_provedor` = `p`.`id_provedor`))) left join `ingreso_producto` `im` on((`ir`.`id_ingreso` = `im`.`id_ingreso`))) left join `producto` `m` on((`im`.`id_producto` = `m`.`id_producto`))) where (`m`.`activo` = '1') order by `ir`.`id_ingreso`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresos_consultas`
--
DROP TABLE IF EXISTS `v_ingresos_consultas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresos_consultas`  AS  (select `im`.`id_producto` AS `id_producto`,`pr`.`producto` AS `producto`,`im`.`cantidad` AS `cantidad`,`im`.`tamano` AS `tamano`,`ir`.`nro_remito` AS `num_rem`,'-' AS `num_aut`,`ir`.`fec_mov` AS `fec_mov`,'-' AS `destino`,`p`.`nombre` AS `proveedor`,`im`.`activo` AS `activo` from (((`ingreso_producto` `im` join `ingreso_remito` `ir` on((`ir`.`id_ingreso` = `im`.`id_ingreso`))) join `proveedor` `p` on((`p`.`id_provedor` = `ir`.`id_provedor`))) join `producto` `pr` on((`pr`.`id_producto` = `im`.`id_producto`)))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresos_nota_stock`
--
DROP TABLE IF EXISTS `v_ingresos_nota_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresos_nota_stock`  AS  (select `devolucion_producto`.`id_producto` AS `id_producto`,`devolucion_producto`.`cantidad` AS `cantidad`,`producto`.`producto` AS `producto`,`producto`.`stock_minimo` AS `stock_minimo`,`producto`.`presentacion` AS `presentacion`,`devolucion_producto`.`activo` AS `activo`,`devolucion_producto`.`tamano` AS `tamano` from ((`devolucion_remito` left join `devolucion_producto` on((`devolucion_remito`.`id_devolucion` = `devolucion_producto`.`id_devolucion`))) left join `producto` on((`devolucion_producto`.`id_producto` = `producto`.`id_producto`))) where (`producto`.`activo` = '1') order by `producto`.`id_producto`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ingresos_stock`
--
DROP TABLE IF EXISTS `v_ingresos_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ingresos_stock`  AS  (select `ingreso_producto`.`id_producto` AS `id_producto`,`ingreso_producto`.`cantidad` AS `cantidad`,`producto`.`producto` AS `producto`,`producto`.`stock_minimo` AS `stock_minimo`,`producto`.`presentacion` AS `presentacion`,`ingreso_producto`.`activo` AS `activo`,`ingreso_producto`.`tamano` AS `tamano` from ((`ingreso_remito` left join `ingreso_producto` on((`ingreso_remito`.`id_ingreso` = `ingreso_producto`.`id_ingreso`))) left join `producto` on((`ingreso_producto`.`id_producto` = `producto`.`id_producto`))) where (`producto`.`activo` = '1') order by `producto`.`id_producto`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_union_egr_ing`
--
DROP TABLE IF EXISTS `v_union_egr_ing`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_union_egr_ing`  AS  (select `v_ingresos_stock`.`id_producto` AS `id_producto`,`v_ingresos_stock`.`cantidad` AS `cantidad`,`v_ingresos_stock`.`producto` AS `producto`,`v_ingresos_stock`.`stock_minimo` AS `stock_minimo`,`v_ingresos_stock`.`presentacion` AS `presentacion` from `v_ingresos_stock`) union (select `v_egresos_stock`.`id_producto` AS `id_producto`,`v_egresos_stock`.`cantidad` AS `cantidad`,`v_egresos_stock`.`producto` AS `producto`,`v_egresos_stock`.`stock_minimo` AS `stock_minimo`,`v_egresos_stock`.`presentacion` AS `presentacion` from `v_egresos_stock`) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autorizacion_anuladas`
--
ALTER TABLE `autorizacion_anuladas`
  ADD PRIMARY KEY (`id_auto_anuluada`),
  ADD KEY `autorizaciones` (`id_autorizacion`),
  ADD KEY `usuarios` (`id_usuario`);

--
-- Indices de la tabla `autorizacion_listado`
--
ALTER TABLE `autorizacion_listado`
  ADD PRIMARY KEY (`id_autorizacion_listado`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `autorizacion_remito`
--
ALTER TABLE `autorizacion_remito`
  ADD PRIMARY KEY (`id_autorizacion`,`id_destino`,`id_usuario`),
  ADD KEY `fk_egreso_destino1_idx` (`id_destino`),
  ADD KEY `fk_egreso_usuario1_idx` (`id_usuario`);

--
-- Indices de la tabla `destino`
--
ALTER TABLE `destino`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indices de la tabla `devolucion_anulados`
--
ALTER TABLE `devolucion_anulados`
  ADD PRIMARY KEY (`id_dev_anulados`),
  ADD KEY `id_devulucion` (`id_devolucion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `devolucion_producto`
--
ALTER TABLE `devolucion_producto`
  ADD PRIMARY KEY (`id_devolucion_producto`,`id_devolucion`,`id_producto`),
  ADD KEY `fk_remito_devolucion_articulo1_idx` (`id_producto`),
  ADD KEY `fk_remito_devolucion_devolucion1_idx` (`id_devolucion`);

--
-- Indices de la tabla `devolucion_remito`
--
ALTER TABLE `devolucion_remito`
  ADD PRIMARY KEY (`id_devolucion`,`id_destino`,`id_usuario`),
  ADD KEY `fk_devolucion_destino1_idx` (`id_destino`),
  ADD KEY `fk_devolucion_usuario1_idx` (`id_usuario`);

--
-- Indices de la tabla `egresox_producto`
--
ALTER TABLE `egresox_producto`
  ADD PRIMARY KEY (`id_egresox_producto`);

--
-- Indices de la tabla `egresox_remito`
--
ALTER TABLE `egresox_remito`
  ADD PRIMARY KEY (`id_egresox`);

--
-- Indices de la tabla `egreso_producto`
--
ALTER TABLE `egreso_producto`
  ADD PRIMARY KEY (`id_egreso_producto`,`id_autorizacion`,`id_producto`),
  ADD KEY `fk_remito_egreso_articulo1_idx` (`id_producto`),
  ADD KEY `fk_remito_egreso_egreso1_idx` (`id_autorizacion`);

--
-- Indices de la tabla `egreso_productos_unidades`
--
ALTER TABLE `egreso_productos_unidades`
  ADD PRIMARY KEY (`id_egreso_producto`);

--
-- Indices de la tabla `egreso_remito`
--
ALTER TABLE `egreso_remito`
  ADD PRIMARY KEY (`id_egreso`,`id_usuario`),
  ADD KEY `fk_egreso_remito_autorizacion1_idx` (`id_autorizacion`),
  ADD KEY `fk_egreso_remito_usuario1_idx` (`id_usuario`);

--
-- Indices de la tabla `egreso_temp`
--
ALTER TABLE `egreso_temp`
  ADD PRIMARY KEY (`id_egresotemp`);

--
-- Indices de la tabla `ingresox_producto`
--
ALTER TABLE `ingresox_producto`
  ADD PRIMARY KEY (`id_ingresox_producto`);

--
-- Indices de la tabla `ingresox_remito`
--
ALTER TABLE `ingresox_remito`
  ADD PRIMARY KEY (`id_ingresox`);

--
-- Indices de la tabla `ingreso_anulados`
--
ALTER TABLE `ingreso_anulados`
  ADD PRIMARY KEY (`id_ing_anulado`),
  ADD KEY `id_ingreso` (`id_ingreso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `ingreso_producto`
--
ALTER TABLE `ingreso_producto`
  ADD PRIMARY KEY (`id_ingreso_producto`,`id_ingreso`,`id_producto`),
  ADD KEY `id_producto_2` (`id_producto`),
  ADD KEY `id_ingreso` (`id_ingreso`);

--
-- Indices de la tabla `ingreso_remito`
--
ALTER TABLE `ingreso_remito`
  ADD PRIMARY KEY (`id_ingreso`,`id_provedor`,`id_usuario`),
  ADD KEY `id_provedor` (`id_provedor`);

--
-- Indices de la tabla `ingreso_unidades`
--
ALTER TABLE `ingreso_unidades`
  ADD PRIMARY KEY (`id_ingreso`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `producto_bloqueo`
--
ALTER TABLE `producto_bloqueo`
  ADD PRIMARY KEY (`id_bloqueo`),
  ADD UNIQUE KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `producto_seguimiento`
--
ALTER TABLE `producto_seguimiento`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD UNIQUE KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_provedor`);

--
-- Indices de la tabla `remito_anulados`
--
ALTER TABLE `remito_anulados`
  ADD PRIMARY KEY (`id_rem_anulados`),
  ADD UNIQUE KEY `id_autorizacion` (`id_autorizacion`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuarios_destino`
--
ALTER TABLE `usuarios_destino`
  ADD PRIMARY KEY (`id_usuario`,`id_destino`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autorizacion_remito`
--
ALTER TABLE `autorizacion_remito`
  MODIFY `id_autorizacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destino`
--
ALTER TABLE `destino`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `devolucion_producto`
--
ALTER TABLE `devolucion_producto`
  MODIFY `id_devolucion_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devolucion_remito`
--
ALTER TABLE `devolucion_remito`
  MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egreso_remito`
--
ALTER TABLE `egreso_remito`
  MODIFY `id_egreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egreso_temp`
--
ALTER TABLE `egreso_temp`
  MODIFY `id_egresotemp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresox_producto`
--
ALTER TABLE `ingresox_producto`
  MODIFY `id_ingresox_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresox_remito`
--
ALTER TABLE `ingresox_remito`
  MODIFY `id_ingresox` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_anulados`
--
ALTER TABLE `ingreso_anulados`
  MODIFY `id_ing_anulado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_producto`
--
ALTER TABLE `ingreso_producto`
  MODIFY `id_ingreso_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_remito`
--
ALTER TABLE `ingreso_remito`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_unidades`
--
ALTER TABLE `ingreso_unidades`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto_bloqueo`
--
ALTER TABLE `producto_bloqueo`
  MODIFY `id_bloqueo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_seguimiento`
--
ALTER TABLE `producto_seguimiento`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_provedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `remito_anulados`
--
ALTER TABLE `remito_anulados`
  MODIFY `id_rem_anulados` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
