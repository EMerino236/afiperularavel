-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2015 a las 00:48:37
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `afiperularavel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE IF NOT EXISTS `asistencias` (
  `idasistencias` int(11) NOT NULL,
  `asistio` tinyint(1) NOT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idusers` int(11) NOT NULL,
  `ideventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_ninhos`
--

CREATE TABLE IF NOT EXISTS `asistencia_ninhos` (
  `idasistencia_ninhos` int(11) NOT NULL,
  `idninhos` int(11) NOT NULL,
  `ideventos` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_pagos`
--

CREATE TABLE IF NOT EXISTS `calendario_pagos` (
  `idcalendario_pagos` int(11) NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `fecha_pago` date NOT NULL,
  `num_cuota` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `aprobacion` tinyint(1) NOT NULL,
  `num_comprobante` varchar(45) NOT NULL,
  `idpadrinos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colegios`
--

CREATE TABLE IF NOT EXISTS `colegios` (
  `idcolegios` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `nombre_contacto` varchar(100) NOT NULL,
  `email_contacto` varchar(100) NOT NULL,
  `telefono_contacto` varchar(45) NOT NULL,
  `interes` varchar(100) NOT NULL,
  `latitud` varchar(45) NOT NULL,
  `longitud` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `idcomentarios` int(11) NOT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `calificacion` int(11) NOT NULL DEFAULT '0',
  `users_id` int(11) NOT NULL,
  `idasistencia_ninhos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concursos`
--

CREATE TABLE IF NOT EXISTS `concursos` (
  `idconcursos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `titulo` varchar(100) NOT NULL,
  `resenha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_proyectos`
--

CREATE TABLE IF NOT EXISTS `detalle_proyectos` (
  `iddetalle_proyectos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idproyectos` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `presupuesto` double DEFAULT NULL,
  `gasto_real` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE IF NOT EXISTS `documentos` (
  `iddocumentos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idtipo_documentos` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `nombre_archivo` varchar(100) NOT NULL,
  `ruta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_colegios`
--

CREATE TABLE IF NOT EXISTS `documentos_colegios` (
  `iddocumentos_colegios` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `colegios_idcolegios` int(11) NOT NULL,
  `documentos_iddocumentos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_concursos`
--

CREATE TABLE IF NOT EXISTS `documentos_concursos` (
  `iddocumentos_concursos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idconcursos` int(11) NOT NULL,
  `iddocumentos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_eventos`
--

CREATE TABLE IF NOT EXISTS `documentos_eventos` (
  `iddocumentos_eventos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ideventos` int(11) NOT NULL,
  `iddocumentos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_proyectos`
--

CREATE TABLE IF NOT EXISTS `documentos_proyectos` (
  `iddocumentos_proyectos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idproyectos` int(11) NOT NULL,
  `iddocumentos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas` (
  `idempresas` int(11) NOT NULL,
  `nombre_representante` varchar(100) NOT NULL,
  `intereses` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `sector` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `ideventos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_evento` datetime NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `latitud` varchar(45) NOT NULL,
  `longitud` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idperiodos` int(11) NOT NULL,
  `idtipo_eventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fases`
--

CREATE TABLE IF NOT EXISTS `fases` (
  `idfases` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fase_concursos`
--

CREATE TABLE IF NOT EXISTS `fase_concursos` (
  `idfase_concursos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idconcursos` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_limite` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `idLevel` int(10) unsigned NOT NULL,
  `numOrder` tinyint(4) NOT NULL,
  `cost` int(11) NOT NULL,
  `idPredLevel` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `levelstatus`
--

CREATE TABLE IF NOT EXISTS `levelstatus` (
  `idPlayer` int(10) unsigned NOT NULL,
  `idLevel` int(10) unsigned NOT NULL,
  `unlocked` tinyint(1) NOT NULL DEFAULT '0',
  `bought` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `idlogs` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `idtipo_logs` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ninhos`
--

CREATE TABLE IF NOT EXISTS `ninhos` (
  `idninhos` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido_pat` varchar(100) NOT NULL,
  `ap_mat` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` varchar(1) NOT NULL,
  `dni` varchar(45) NOT NULL,
  `nombre_apoderado` varchar(200) NOT NULL,
  `dni_apoderado` varchar(45) NOT NULL,
  `num_familiares` int(11) NOT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idcolegios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padrinos`
--

CREATE TABLE IF NOT EXISTS `padrinos` (
  `idpadrinos` int(11) NOT NULL,
  `como_se_entero` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idusers` int(11) NOT NULL,
  `idperiodo_pagos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE IF NOT EXISTS `perfiles` (
  `idperfiles` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`idperfiles`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'webmaster', 'administrador del sitio', '2015-10-06 09:08:06', '2015-10-06 09:08:06', NULL),
(2, 'afi', 'miembro de afi', '2015-10-06 09:08:06', '2015-10-06 09:08:06', NULL),
(3, 'voluntario', 'voluntario que participa en eventos variados', '2015-10-06 09:08:24', '2015-10-06 09:08:24', NULL),
(4, 'padrino', 'contribuyente de fondos monetarios', '2015-10-06 09:08:24', '2015-10-06 09:08:24', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE IF NOT EXISTS `periodos` (
  `idperiodos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_pagos`
--

CREATE TABLE IF NOT EXISTS `periodo_pagos` (
  `idperiodo_pagos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `numero_pagos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `idpermisos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermisos`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'nav_convocatorias', '2015-10-06 08:59:51', '2015-10-06 08:59:51', NULL),
(2, 'nav_eventos', '2015-10-06 09:01:00', '2015-10-06 09:01:00', NULL),
(3, 'nav_voluntarios', '2015-10-06 09:01:11', '2015-10-06 09:01:11', NULL),
(4, 'nav_padrinos', '2015-10-06 09:01:20', '2015-10-06 09:01:20', NULL),
(5, 'nav_concursos', '2015-10-06 09:01:41', '2015-10-06 09:01:41', NULL),
(6, 'nav_colegios', '2015-10-06 09:01:41', '2015-10-06 09:01:41', NULL),
(7, 'nav_usuarios', '2015-10-06 09:05:52', '2015-10-06 09:05:52', NULL),
(8, 'nav_sistema', '2015-10-06 09:05:52', '2015-10-06 09:05:52', NULL),
(9, 'side_nueva_convocatoria', '2015-10-07 03:19:27', '2015-10-07 03:19:27', NULL),
(10, 'side_listar_convocatorias', '2015-10-07 03:19:27', '2015-10-07 03:19:27', NULL),
(11, 'side_nuevo_evento', '2015-10-07 03:22:04', '2015-10-07 03:22:04', NULL),
(12, 'side_listar_eventos', '2015-10-07 03:22:04', '2015-10-07 03:22:04', NULL),
(13, 'side_nuevo_punto_reunion', '2015-10-07 03:22:31', '2015-10-07 03:22:31', NULL),
(14, 'side_listar_puntos_reunion', '2015-10-07 03:22:31', '2015-10-07 03:22:31', NULL),
(15, 'side_mis_eventos', '2015-10-07 03:23:28', '2015-10-07 03:23:28', NULL),
(16, 'side_listar_voluntarios', '2015-10-07 03:24:27', '2015-10-07 03:24:27', NULL),
(17, 'side_listar_padrinos', '2015-10-07 03:26:36', '2015-10-07 03:26:36', NULL),
(18, 'side_aprobar_padrinos', '2015-10-07 03:26:36', '2015-10-07 03:26:36', NULL),
(19, 'side_nuevo_reporte_padrinos', '2015-10-07 03:27:18', '2015-10-07 03:27:18', NULL),
(20, 'side_listar_reportes_padrinos', '2015-10-07 03:27:18', '2015-10-07 03:27:18', NULL),
(21, 'side_calendario_pagos', '2015-10-07 03:28:21', '2015-10-07 03:28:21', NULL),
(22, 'side_registrar_pago', '2015-10-07 03:28:21', '2015-10-07 03:28:21', NULL),
(23, 'side_nuevo_concurso', '2015-10-07 03:30:03', '2015-10-07 03:30:03', NULL),
(24, 'side_listar_concursos', '2015-10-07 03:30:03', '2015-10-07 03:30:03', NULL),
(25, 'side_nuevo_proyecto', '2015-10-07 03:31:35', '2015-10-07 03:31:35', NULL),
(26, 'side_listar_proyectos', '2015-10-07 03:31:35', '2015-10-07 03:31:35', NULL),
(27, 'side_nuevo_colegio', '2015-10-07 03:32:13', '2015-10-07 03:32:13', NULL),
(28, 'side_listar_colegios', '2015-10-07 03:32:13', '2015-10-07 03:32:13', NULL),
(29, 'side_aprobar_colegios', '2015-10-07 03:32:32', '2015-10-07 03:32:32', NULL),
(30, 'side_nuevo_usuario', '2015-10-07 04:33:10', '2015-10-07 04:33:10', NULL),
(31, 'side_listar_usuarios', '2015-10-07 04:33:10', '2015-10-07 04:33:10', NULL),
(32, 'side_nuevo_perfil', '2015-10-07 09:19:36', '2015-10-07 09:19:36', NULL),
(33, 'side_listar_perfiles', '2015-10-07 09:19:36', '2015-10-07 09:19:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_perfiles`
--

CREATE TABLE IF NOT EXISTS `permisos_perfiles` (
  `idpermisos_perfiles` int(11) NOT NULL,
  `idpermisos` int(11) NOT NULL,
  `idperfiles` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos_perfiles`
--

INSERT INTO `permisos_perfiles` (`idpermisos_perfiles`, `idpermisos`, `idperfiles`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2015-10-06 09:11:20', '2015-10-06 09:11:20', NULL),
(2, 2, 1, '2015-10-06 09:11:20', '2015-10-06 09:11:20', NULL),
(3, 3, 1, '2015-10-06 09:11:36', '2015-10-06 09:11:36', NULL),
(4, 4, 1, '2015-10-06 09:11:36', '2015-10-06 09:11:36', NULL),
(5, 5, 1, '2015-10-06 09:11:56', '2015-10-06 09:11:56', NULL),
(6, 6, 1, '2015-10-06 09:11:56', '2015-10-06 09:11:56', NULL),
(7, 7, 1, '2015-10-06 09:12:08', '2015-10-06 09:12:08', NULL),
(8, 8, 1, '2015-10-06 09:12:08', '2015-10-06 09:12:08', NULL),
(9, 9, 1, '2015-10-07 04:04:19', '2015-10-07 04:04:19', NULL),
(10, 10, 1, '2015-10-07 04:04:19', '2015-10-07 04:04:19', NULL),
(11, 11, 1, '2015-10-07 04:04:28', '2015-10-07 04:04:28', NULL),
(12, 12, 1, '2015-10-07 04:04:28', '2015-10-07 04:04:28', NULL),
(13, 13, 1, '2015-10-07 04:04:38', '2015-10-07 04:04:38', NULL),
(14, 14, 1, '2015-10-07 04:04:38', '2015-10-07 04:04:38', NULL),
(15, 15, 1, '2015-10-07 04:04:47', '2015-10-07 04:04:47', NULL),
(16, 16, 1, '2015-10-07 04:04:47', '2015-10-07 04:04:47', NULL),
(17, 17, 1, '2015-10-07 04:04:55', '2015-10-07 04:04:55', NULL),
(18, 18, 1, '2015-10-07 04:04:55', '2015-10-07 04:04:55', NULL),
(19, 19, 1, '2015-10-07 04:05:05', '2015-10-07 04:05:05', NULL),
(20, 20, 1, '2015-10-07 04:05:05', '2015-10-07 04:05:05', NULL),
(21, 21, 1, '2015-10-07 04:05:17', '2015-10-07 04:05:17', NULL),
(22, 22, 1, '2015-10-07 04:05:17', '2015-10-07 04:05:17', NULL),
(23, 23, 1, '2015-10-07 04:05:29', '2015-10-07 04:05:29', NULL),
(24, 24, 1, '2015-10-07 04:05:29', '2015-10-07 04:05:29', NULL),
(25, 25, 1, '2015-10-07 04:05:42', '2015-10-07 04:05:42', NULL),
(26, 26, 1, '2015-10-07 04:05:42', '2015-10-07 04:05:42', NULL),
(27, 27, 1, '2015-10-07 04:05:53', '2015-10-07 04:05:53', NULL),
(28, 28, 1, '2015-10-07 04:05:53', '2015-10-07 04:05:53', NULL),
(29, 29, 1, '2015-10-07 04:06:01', '2015-10-07 04:06:01', NULL),
(30, 30, 1, '2015-10-07 05:33:17', '2015-10-07 05:33:17', NULL),
(31, 31, 1, '2015-10-07 05:33:17', '2015-10-07 05:33:17', NULL),
(32, 32, 1, '2015-10-07 09:23:33', '2015-10-07 09:23:33', NULL),
(33, 33, 1, '2015-10-07 09:23:33', '2015-10-07 09:23:33', NULL),
(34, 1, 2, '2015-10-16 01:06:28', '2015-10-16 01:06:28', NULL),
(35, 2, 2, '2015-10-16 01:06:28', '2015-10-16 01:06:28', NULL),
(36, 3, 2, '2015-10-16 01:06:41', '2015-10-16 01:06:41', NULL),
(37, 4, 2, '2015-10-16 01:06:41', '2015-10-16 01:06:41', NULL),
(38, 5, 2, '2015-10-16 01:06:54', '2015-10-16 01:06:54', NULL),
(39, 6, 2, '2015-10-16 01:06:54', '2015-10-16 01:06:54', NULL),
(40, 9, 2, '2015-10-16 01:08:21', '2015-10-16 01:08:21', NULL),
(41, 10, 2, '2015-10-16 01:08:21', '2015-10-16 01:08:21', NULL),
(42, 11, 2, '2015-10-16 01:08:42', '2015-10-16 01:08:42', NULL),
(43, 12, 2, '2015-10-16 01:10:48', '2015-10-16 01:10:48', NULL),
(44, 13, 2, '2015-10-16 01:10:48', '2015-10-16 01:10:48', NULL),
(45, 14, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(46, 16, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(47, 17, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(48, 18, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(49, 19, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(50, 20, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(51, 23, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(52, 24, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(53, 25, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(54, 26, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(55, 27, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(56, 28, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(57, 29, 2, '2015-10-16 01:10:49', '2015-10-16 01:10:49', NULL),
(58, 2, 3, '2015-10-16 01:24:00', '2015-10-16 01:24:00', NULL),
(59, 15, 3, '2015-10-16 01:26:45', '2015-10-16 01:26:45', NULL),
(60, 4, 4, '2015-10-16 01:27:03', '2015-10-16 01:27:03', NULL),
(61, 21, 4, '2015-10-16 01:27:03', '2015-10-16 01:27:03', NULL),
(62, 22, 4, '2015-10-16 01:27:11', '2015-10-16 01:27:11', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
  `idpersonas` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido_pat` varchar(100) NOT NULL,
  `apellido_mat` varchar(100) NOT NULL,
  `fecha_nacimiento` timestamp NULL DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idpersonas`, `nombres`, `apellido_pat`, `apellido_mat`, `fecha_nacimiento`, `direccion`, `telefono`, `celular`, `email`, `latitud`, `longitud`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Webmaster', 'AFI', 'PERU', '2015-10-31 05:00:00', NULL, NULL, NULL, 'afiperuwebmaster@gmail.com', NULL, NULL, '2015-10-22 19:48:53', '2015-10-22 19:48:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `idPlayer` int(10) unsigned NOT NULL,
  `childName` varchar(70) NOT NULL,
  `idFacebook` varchar(30) NOT NULL,
  `coins` int(10) unsigned NOT NULL DEFAULT '0',
  `hairVariation` int(11) NOT NULL DEFAULT '0',
  `clothesVariation` int(11) NOT NULL DEFAULT '0',
  `continues` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulantes`
--

CREATE TABLE IF NOT EXISTS `postulantes` (
  `idpostulantes` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `num_documento` varchar(45) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido_pat` varchar(100) NOT NULL,
  `apellido_mat` varchar(100) NOT NULL,
  `fecha_nacimiento` timestamp NULL DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulantes_fases`
--

CREATE TABLE IF NOT EXISTS `postulantes_fases` (
  `idpostulantes_fases` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idpostulantes` int(11) NOT NULL,
  `idfases` int(11) NOT NULL,
  `asistencia` int(11) NOT NULL,
  `aprobacion` int(11) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulantes_periodos`
--

CREATE TABLE IF NOT EXISTS `postulantes_periodos` (
  `idpostulantes_periodos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idpostulantes` int(11) NOT NULL,
  `idperiodos` int(11) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `powerup`
--

CREATE TABLE IF NOT EXISTS `powerup` (
  `idPowerup` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `imgSource` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `powerupxlevel`
--

CREATE TABLE IF NOT EXISTS `powerupxlevel` (
  `idLevel` int(10) unsigned NOT NULL,
  `idPowerup` int(10) unsigned NOT NULL,
  `cost` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precolegios`
--

CREATE TABLE IF NOT EXISTS `precolegios` (
  `idprecolegios` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `nombre_contacto` varchar(100) NOT NULL,
  `email_contacto` varchar(100) NOT NULL,
  `telefono_contacto` varchar(45) NOT NULL,
  `interes` varchar(100) NOT NULL,
  `latitud` varchar(45) NOT NULL,
  `longitud` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prepadrinos`
--

CREATE TABLE IF NOT EXISTS `prepadrinos` (
  `idprepadrinos` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido_pat` varchar(100) NOT NULL,
  `apellido_mat` varchar(100) NOT NULL,
  `dni` varchar(45) NOT NULL,
  `fecha_nacimiento` timestamp NULL DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `como_se_entero` varchar(200) DEFAULT NULL,
  `idperiodo_pagos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `idproyectos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idconcursos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `resenha` varchar(255) NOT NULL,
  `jefe_proyecto` varchar(100) NOT NULL,
  `aprobacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_eventos`
--

CREATE TABLE IF NOT EXISTS `puntos_eventos` (
  `idpuntos_eventos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idpuntos_reunion` int(11) NOT NULL,
  `ideventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_reunion`
--

CREATE TABLE IF NOT EXISTS `puntos_reunion` (
  `idpuntos_reunion` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `latitud` varchar(45) NOT NULL,
  `longitud` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `idPlayer` int(10) unsigned NOT NULL,
  `idLevel` int(10) unsigned NOT NULL,
  `score` int(10) unsigned NOT NULL,
  `defeatPosX` int(11) NOT NULL DEFAULT '-1',
  `defeatPosY` int(11) NOT NULL DEFAULT '-1',
  `defeated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documentos`
--

CREATE TABLE IF NOT EXISTS `tipo_documentos` (
  `idtipo_documentos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documentos`
--

INSERT INTO `tipo_documentos` (`idtipo_documentos`, `created_at`, `updated_at`, `deleted_at`, `nombre`) VALUES
(1, '2015-10-22 08:42:35', '2015-10-22 08:42:35', NULL, 'Guía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_eventos`
--

CREATE TABLE IF NOT EXISTS `tipo_eventos` (
  `idtipo_eventos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_eventos`
--

INSERT INTO `tipo_eventos` (`idtipo_eventos`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sesión de voluntariado', '2015-10-19 00:02:34', '2015-10-19 00:02:34', NULL),
(2, 'Charla informativa', '2015-10-19 00:02:34', '2015-10-19 00:02:34', NULL),
(3, 'Inducción', '2015-10-19 00:04:03', '2015-10-19 00:04:03', NULL),
(4, 'Actividad', '2015-10-19 00:04:03', '2015-10-19 00:04:03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_identificacion`
--

CREATE TABLE IF NOT EXISTS `tipo_identificacion` (
  `idtipo_identificacion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_identificacion`
--

INSERT INTO `tipo_identificacion` (`idtipo_identificacion`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'L.E. / DNI', '2015-10-06 09:19:40', '2015-10-06 09:19:40', NULL),
(2, 'CARNET EXT.', '2015-10-06 09:19:40', '2015-10-06 09:19:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_logs`
--

CREATE TABLE IF NOT EXISTS `tipo_logs` (
  `idtipo_logs` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `num_documento` varchar(45) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `idtipo_identificacion` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `auth_token` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `num_documento`, `password`, `email`, `idtipo_identificacion`, `idpersona`, `auth_token`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'afi_webmaster', '$2y$10$WjPwXuIPioqsgs.rIC2ck.vgdDd9ebavWhSQyD0XbU79FQbOpZGyO', '', 1, 1, NULL, 'XU77ebl9g8Yy0C6YKiOEemdvOKq3h9Y95aQjlGOXn0uLmFPVGkbEiE6mG5Ni', '2015-10-06 09:22:09', '2015-10-08 11:38:55', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_perfiles`
--

CREATE TABLE IF NOT EXISTS `users_perfiles` (
  `idusers_perfiles` int(11) NOT NULL,
  `idperfiles` int(11) NOT NULL,
  `idusers` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users_perfiles`
--

INSERT INTO `users_perfiles` (`idusers_perfiles`, `idperfiles`, `idusers`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2015-10-06 09:29:14', '2015-10-06 09:29:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_periodos`
--

CREATE TABLE IF NOT EXISTS `users_periodos` (
  `idusers_periodos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idusers` int(11) NOT NULL,
  `idperiodos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visualizaciones`
--

CREATE TABLE IF NOT EXISTS `visualizaciones` (
  `idvisualizaciones` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `idusers` int(11) NOT NULL,
  `ideventos` int(11) NOT NULL,
  `iddocumentos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`idasistencias`),
  ADD KEY `fk_asistencias_users1_idx` (`idusers`),
  ADD KEY `fk_asistencias_eventos1_idx` (`ideventos`);

--
-- Indices de la tabla `asistencia_ninhos`
--
ALTER TABLE `asistencia_ninhos`
  ADD PRIMARY KEY (`idasistencia_ninhos`),
  ADD KEY `fk_comentarios_ninhos1_idx` (`idninhos`),
  ADD KEY `fk_comentarios_eventos1_idx` (`ideventos`);

--
-- Indices de la tabla `calendario_pagos`
--
ALTER TABLE `calendario_pagos`
  ADD PRIMARY KEY (`idcalendario_pagos`),
  ADD KEY `fk_calendario_pagos_padrinos1_idx` (`idpadrinos`);

--
-- Indices de la tabla `colegios`
--
ALTER TABLE `colegios`
  ADD PRIMARY KEY (`idcolegios`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idcomentarios`),
  ADD KEY `fk_comentarios_users1_idx` (`users_id`),
  ADD KEY `fk_comentarios_asistencia_ninhos1_idx` (`idasistencia_ninhos`);

--
-- Indices de la tabla `concursos`
--
ALTER TABLE `concursos`
  ADD PRIMARY KEY (`idconcursos`);

--
-- Indices de la tabla `detalle_proyectos`
--
ALTER TABLE `detalle_proyectos`
  ADD PRIMARY KEY (`iddetalle_proyectos`),
  ADD KEY `fk_detalle_proyectos_proyectos1_idx` (`idproyectos`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`iddocumentos`),
  ADD KEY `fk_documentos_tipo_documentos1_idx` (`idtipo_documentos`);

--
-- Indices de la tabla `documentos_colegios`
--
ALTER TABLE `documentos_colegios`
  ADD PRIMARY KEY (`iddocumentos_colegios`),
  ADD KEY `fk_documentos_colegios_colegios1_idx` (`colegios_idcolegios`),
  ADD KEY `fk_documentos_colegios_documentos1_idx` (`documentos_iddocumentos`);

--
-- Indices de la tabla `documentos_concursos`
--
ALTER TABLE `documentos_concursos`
  ADD PRIMARY KEY (`iddocumentos_concursos`),
  ADD KEY `fk_documentos_concursos_concursos1_idx` (`idconcursos`),
  ADD KEY `fk_documentos_concursos_documentos1_idx` (`iddocumentos`);

--
-- Indices de la tabla `documentos_eventos`
--
ALTER TABLE `documentos_eventos`
  ADD PRIMARY KEY (`iddocumentos_eventos`),
  ADD KEY `fk_documentos_eventos_eventos1_idx` (`ideventos`),
  ADD KEY `fk_documentos_eventos_documentos1_idx` (`iddocumentos`);

--
-- Indices de la tabla `documentos_proyectos`
--
ALTER TABLE `documentos_proyectos`
  ADD PRIMARY KEY (`iddocumentos_proyectos`),
  ADD KEY `fk_documentos_proyectos_proyectos1_idx` (`idproyectos`),
  ADD KEY `fk_documentos_proyectos_documentos1_idx` (`iddocumentos`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`idempresas`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ideventos`),
  ADD KEY `fk_eventos_periodos1_idx` (`idperiodos`),
  ADD KEY `fk_eventos_tipo_eventos1_idx` (`idtipo_eventos`);

--
-- Indices de la tabla `fases`
--
ALTER TABLE `fases`
  ADD PRIMARY KEY (`idfases`);

--
-- Indices de la tabla `fase_concursos`
--
ALTER TABLE `fase_concursos`
  ADD PRIMARY KEY (`idfase_concursos`),
  ADD KEY `fk_fechas_limites_concursos1_idx` (`idconcursos`);

--
-- Indices de la tabla `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`idLevel`),
  ADD KEY `fk_Level_Level1_idx` (`idPredLevel`);

--
-- Indices de la tabla `levelstatus`
--
ALTER TABLE `levelstatus`
  ADD PRIMARY KEY (`idPlayer`,`idLevel`),
  ADD KEY `fk_Player_has_Level_Level2_idx` (`idLevel`),
  ADD KEY `fk_Player_has_Level_Player1_idx` (`idPlayer`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`idlogs`),
  ADD KEY `fk_logs_tipo_acciones1_idx` (`idtipo_logs`),
  ADD KEY `fk_logs_users1_idx` (`users_id`);

--
-- Indices de la tabla `ninhos`
--
ALTER TABLE `ninhos`
  ADD PRIMARY KEY (`idninhos`),
  ADD KEY `fk_ninhos_colegios1_idx` (`idcolegios`);

--
-- Indices de la tabla `padrinos`
--
ALTER TABLE `padrinos`
  ADD PRIMARY KEY (`idpadrinos`),
  ADD KEY `fk_padrinos_users1_idx` (`idusers`),
  ADD KEY `fk_padrinos_periodo_pagos1_idx` (`idperiodo_pagos`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`idperfiles`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`idperiodos`);

--
-- Indices de la tabla `periodo_pagos`
--
ALTER TABLE `periodo_pagos`
  ADD PRIMARY KEY (`idperiodo_pagos`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermisos`);

--
-- Indices de la tabla `permisos_perfiles`
--
ALTER TABLE `permisos_perfiles`
  ADD PRIMARY KEY (`idpermisos_perfiles`),
  ADD KEY `fk_permisos_perfiles_permisos_idx` (`idpermisos`),
  ADD KEY `fk_permisos_perfiles_perfiles1_idx` (`idperfiles`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idpersonas`);

--
-- Indices de la tabla `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`idPlayer`);

--
-- Indices de la tabla `postulantes`
--
ALTER TABLE `postulantes`
  ADD PRIMARY KEY (`idpostulantes`);

--
-- Indices de la tabla `postulantes_fases`
--
ALTER TABLE `postulantes_fases`
  ADD PRIMARY KEY (`idpostulantes_fases`),
  ADD KEY `fk_postulantes_fases_postulantes1_idx` (`idpostulantes`),
  ADD KEY `fk_postulantes_fases_fases1_idx` (`idfases`);

--
-- Indices de la tabla `postulantes_periodos`
--
ALTER TABLE `postulantes_periodos`
  ADD PRIMARY KEY (`idpostulantes_periodos`),
  ADD KEY `fk_postulantes_periodos_postulantes1_idx` (`idpostulantes`),
  ADD KEY `fk_postulantes_periodos_periodos1_idx` (`idperiodos`);

--
-- Indices de la tabla `powerup`
--
ALTER TABLE `powerup`
  ADD PRIMARY KEY (`idPowerup`);

--
-- Indices de la tabla `powerupxlevel`
--
ALTER TABLE `powerupxlevel`
  ADD PRIMARY KEY (`idLevel`,`idPowerup`),
  ADD KEY `fk_Level_has_Powerup_Powerup1_idx` (`idPowerup`),
  ADD KEY `fk_Level_has_Powerup_Level1_idx` (`idLevel`);

--
-- Indices de la tabla `precolegios`
--
ALTER TABLE `precolegios`
  ADD PRIMARY KEY (`idprecolegios`);

--
-- Indices de la tabla `prepadrinos`
--
ALTER TABLE `prepadrinos`
  ADD PRIMARY KEY (`idprepadrinos`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`idproyectos`),
  ADD KEY `fk_proyectos_concursos1_idx` (`idconcursos`);

--
-- Indices de la tabla `puntos_eventos`
--
ALTER TABLE `puntos_eventos`
  ADD PRIMARY KEY (`idpuntos_eventos`),
  ADD KEY `fk_puntos_eventos_puntos_reunion1_idx` (`idpuntos_reunion`),
  ADD KEY `fk_puntos_eventos_eventos1_idx` (`ideventos`);

--
-- Indices de la tabla `puntos_reunion`
--
ALTER TABLE `puntos_reunion`
  ADD PRIMARY KEY (`idpuntos_reunion`);

--
-- Indices de la tabla `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`idPlayer`,`idLevel`),
  ADD KEY `fk_Player_has_Level_Level1_idx` (`idLevel`),
  ADD KEY `fk_Player_has_Level_Player_idx` (`idPlayer`);

--
-- Indices de la tabla `tipo_documentos`
--
ALTER TABLE `tipo_documentos`
  ADD PRIMARY KEY (`idtipo_documentos`);

--
-- Indices de la tabla `tipo_eventos`
--
ALTER TABLE `tipo_eventos`
  ADD PRIMARY KEY (`idtipo_eventos`);

--
-- Indices de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  ADD PRIMARY KEY (`idtipo_identificacion`);

--
-- Indices de la tabla `tipo_logs`
--
ALTER TABLE `tipo_logs`
  ADD PRIMARY KEY (`idtipo_logs`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_tipo_documento1_idx` (`idtipo_identificacion`),
  ADD KEY `fk_users_personas1_idx` (`idpersona`);

--
-- Indices de la tabla `users_perfiles`
--
ALTER TABLE `users_perfiles`
  ADD PRIMARY KEY (`idusers_perfiles`),
  ADD KEY `fk_users_perfiles_perfiles1_idx` (`idperfiles`),
  ADD KEY `fk_users_perfiles_users1_idx` (`idusers`);

--
-- Indices de la tabla `users_periodos`
--
ALTER TABLE `users_periodos`
  ADD PRIMARY KEY (`idusers_periodos`),
  ADD KEY `fk_user_periodos_users1_idx` (`idusers`),
  ADD KEY `fk_user_periodos_periodos1_idx` (`idperiodos`);

--
-- Indices de la tabla `visualizaciones`
--
ALTER TABLE `visualizaciones`
  ADD PRIMARY KEY (`idvisualizaciones`),
  ADD KEY `fk_visualizaciones_users1_idx` (`idusers`),
  ADD KEY `fk_visualizaciones_eventos1_idx` (`ideventos`),
  ADD KEY `fk_visualizaciones_documentos1_idx` (`iddocumentos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `idasistencias` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `asistencia_ninhos`
--
ALTER TABLE `asistencia_ninhos`
  MODIFY `idasistencia_ninhos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `calendario_pagos`
--
ALTER TABLE `calendario_pagos`
  MODIFY `idcalendario_pagos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `colegios`
--
ALTER TABLE `colegios`
  MODIFY `idcolegios` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `concursos`
--
ALTER TABLE `concursos`
  MODIFY `idconcursos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_proyectos`
--
ALTER TABLE `detalle_proyectos`
  MODIFY `iddetalle_proyectos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `iddocumentos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documentos_concursos`
--
ALTER TABLE `documentos_concursos`
  MODIFY `iddocumentos_concursos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documentos_eventos`
--
ALTER TABLE `documentos_eventos`
  MODIFY `iddocumentos_eventos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documentos_proyectos`
--
ALTER TABLE `documentos_proyectos`
  MODIFY `iddocumentos_proyectos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ideventos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fases`
--
ALTER TABLE `fases`
  MODIFY `idfases` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fase_concursos`
--
ALTER TABLE `fase_concursos`
  MODIFY `idfase_concursos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `level`
--
ALTER TABLE `level`
  MODIFY `idLevel` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `idlogs` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ninhos`
--
ALTER TABLE `ninhos`
  MODIFY `idninhos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `padrinos`
--
ALTER TABLE `padrinos`
  MODIFY `idpadrinos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `idperfiles` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `idperiodos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `periodo_pagos`
--
ALTER TABLE `periodo_pagos`
  MODIFY `idperiodo_pagos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermisos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `permisos_perfiles`
--
ALTER TABLE `permisos_perfiles`
  MODIFY `idpermisos_perfiles` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idpersonas` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `player`
--
ALTER TABLE `player`
  MODIFY `idPlayer` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `postulantes`
--
ALTER TABLE `postulantes`
  MODIFY `idpostulantes` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `postulantes_fases`
--
ALTER TABLE `postulantes_fases`
  MODIFY `idpostulantes_fases` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `postulantes_periodos`
--
ALTER TABLE `postulantes_periodos`
  MODIFY `idpostulantes_periodos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `powerup`
--
ALTER TABLE `powerup`
  MODIFY `idPowerup` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `idproyectos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `puntos_eventos`
--
ALTER TABLE `puntos_eventos`
  MODIFY `idpuntos_eventos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `puntos_reunion`
--
ALTER TABLE `puntos_reunion`
  MODIFY `idpuntos_reunion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_documentos`
--
ALTER TABLE `tipo_documentos`
  MODIFY `idtipo_documentos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipo_eventos`
--
ALTER TABLE `tipo_eventos`
  MODIFY `idtipo_eventos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  MODIFY `idtipo_identificacion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_logs`
--
ALTER TABLE `tipo_logs`
  MODIFY `idtipo_logs` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users_perfiles`
--
ALTER TABLE `users_perfiles`
  MODIFY `idusers_perfiles` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users_periodos`
--
ALTER TABLE `users_periodos`
  MODIFY `idusers_periodos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `visualizaciones`
--
ALTER TABLE `visualizaciones`
  MODIFY `idvisualizaciones` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `fk_asistencias_eventos1` FOREIGN KEY (`ideventos`) REFERENCES `eventos` (`ideventos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asistencias_users1` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asistencia_ninhos`
--
ALTER TABLE `asistencia_ninhos`
  ADD CONSTRAINT `fk_comentarios_eventos1` FOREIGN KEY (`ideventos`) REFERENCES `eventos` (`ideventos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comentarios_ninhos1` FOREIGN KEY (`idninhos`) REFERENCES `ninhos` (`idninhos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `calendario_pagos`
--
ALTER TABLE `calendario_pagos`
  ADD CONSTRAINT `fk_calendario_pagos_padrinos1` FOREIGN KEY (`idpadrinos`) REFERENCES `padrinos` (`idpadrinos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentarios_asistencia_ninhos1` FOREIGN KEY (`idasistencia_ninhos`) REFERENCES `asistencia_ninhos` (`idasistencia_ninhos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comentarios_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_proyectos`
--
ALTER TABLE `detalle_proyectos`
  ADD CONSTRAINT `fk_detalle_proyectos_proyectos1` FOREIGN KEY (`idproyectos`) REFERENCES `proyectos` (`idproyectos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `fk_documentos_tipo_documentos1` FOREIGN KEY (`idtipo_documentos`) REFERENCES `tipo_documentos` (`idtipo_documentos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documentos_colegios`
--
ALTER TABLE `documentos_colegios`
  ADD CONSTRAINT `fk_documentos_colegios_colegios1` FOREIGN KEY (`colegios_idcolegios`) REFERENCES `colegios` (`idcolegios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentos_colegios_documentos1` FOREIGN KEY (`documentos_iddocumentos`) REFERENCES `documentos` (`iddocumentos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documentos_concursos`
--
ALTER TABLE `documentos_concursos`
  ADD CONSTRAINT `fk_documentos_concursos_concursos1` FOREIGN KEY (`idconcursos`) REFERENCES `concursos` (`idconcursos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentos_concursos_documentos1` FOREIGN KEY (`iddocumentos`) REFERENCES `documentos` (`iddocumentos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documentos_eventos`
--
ALTER TABLE `documentos_eventos`
  ADD CONSTRAINT `fk_documentos_eventos_documentos1` FOREIGN KEY (`iddocumentos`) REFERENCES `documentos` (`iddocumentos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentos_eventos_eventos1` FOREIGN KEY (`ideventos`) REFERENCES `eventos` (`ideventos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documentos_proyectos`
--
ALTER TABLE `documentos_proyectos`
  ADD CONSTRAINT `fk_documentos_proyectos_documentos1` FOREIGN KEY (`iddocumentos`) REFERENCES `documentos` (`iddocumentos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documentos_proyectos_proyectos1` FOREIGN KEY (`idproyectos`) REFERENCES `proyectos` (`idproyectos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_eventos_periodos1` FOREIGN KEY (`idperiodos`) REFERENCES `periodos` (`idperiodos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_eventos_tipo_eventos1` FOREIGN KEY (`idtipo_eventos`) REFERENCES `tipo_eventos` (`idtipo_eventos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fase_concursos`
--
ALTER TABLE `fase_concursos`
  ADD CONSTRAINT `fk_fechas_limites_concursos1` FOREIGN KEY (`idconcursos`) REFERENCES `concursos` (`idconcursos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `level`
--
ALTER TABLE `level`
  ADD CONSTRAINT `fk_Level_Level1` FOREIGN KEY (`idPredLevel`) REFERENCES `level` (`idLevel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `levelstatus`
--
ALTER TABLE `levelstatus`
  ADD CONSTRAINT `fk_Player_has_Level_Level2` FOREIGN KEY (`idLevel`) REFERENCES `level` (`idLevel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Player_has_Level_Player1` FOREIGN KEY (`idPlayer`) REFERENCES `player` (`idPlayer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_tipo_acciones1` FOREIGN KEY (`idtipo_logs`) REFERENCES `tipo_logs` (`idtipo_logs`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_logs_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ninhos`
--
ALTER TABLE `ninhos`
  ADD CONSTRAINT `fk_ninhos_colegios1` FOREIGN KEY (`idcolegios`) REFERENCES `colegios` (`idcolegios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `padrinos`
--
ALTER TABLE `padrinos`
  ADD CONSTRAINT `fk_padrinos_periodo_pagos1` FOREIGN KEY (`idperiodo_pagos`) REFERENCES `periodo_pagos` (`idperiodo_pagos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_padrinos_users1` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permisos_perfiles`
--
ALTER TABLE `permisos_perfiles`
  ADD CONSTRAINT `fk_permisos_perfiles_perfiles1` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permisos_perfiles_permisos` FOREIGN KEY (`idpermisos`) REFERENCES `permisos` (`idpermisos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `postulantes_fases`
--
ALTER TABLE `postulantes_fases`
  ADD CONSTRAINT `fk_postulantes_fases_fases1` FOREIGN KEY (`idfases`) REFERENCES `fases` (`idfases`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_postulantes_fases_postulantes1` FOREIGN KEY (`idpostulantes`) REFERENCES `postulantes` (`idpostulantes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `postulantes_periodos`
--
ALTER TABLE `postulantes_periodos`
  ADD CONSTRAINT `fk_postulantes_periodos_periodos1` FOREIGN KEY (`idperiodos`) REFERENCES `periodos` (`idperiodos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_postulantes_periodos_postulantes1` FOREIGN KEY (`idpostulantes`) REFERENCES `postulantes` (`idpostulantes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `powerupxlevel`
--
ALTER TABLE `powerupxlevel`
  ADD CONSTRAINT `fk_Level_has_Powerup_Level1` FOREIGN KEY (`idLevel`) REFERENCES `level` (`idLevel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Level_has_Powerup_Powerup1` FOREIGN KEY (`idPowerup`) REFERENCES `powerup` (`idPowerup`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_proyectos_concursos1` FOREIGN KEY (`idconcursos`) REFERENCES `concursos` (`idconcursos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `puntos_eventos`
--
ALTER TABLE `puntos_eventos`
  ADD CONSTRAINT `fk_puntos_eventos_eventos1` FOREIGN KEY (`ideventos`) REFERENCES `eventos` (`ideventos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_puntos_eventos_puntos_reunion1` FOREIGN KEY (`idpuntos_reunion`) REFERENCES `puntos_reunion` (`idpuntos_reunion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `fk_Player_has_Level_Level1` FOREIGN KEY (`idLevel`) REFERENCES `level` (`idLevel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Player_has_Level_Player` FOREIGN KEY (`idPlayer`) REFERENCES `player` (`idPlayer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_personas1` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`idpersonas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_tipo_documento1` FOREIGN KEY (`idtipo_identificacion`) REFERENCES `tipo_identificacion` (`idtipo_identificacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_perfiles`
--
ALTER TABLE `users_perfiles`
  ADD CONSTRAINT `fk_users_perfiles_perfiles1` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_perfiles_users1` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_periodos`
--
ALTER TABLE `users_periodos`
  ADD CONSTRAINT `fk_user_periodos_periodos1` FOREIGN KEY (`idperiodos`) REFERENCES `periodos` (`idperiodos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_periodos_users1` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `visualizaciones`
--
ALTER TABLE `visualizaciones`
  ADD CONSTRAINT `fk_visualizaciones_documentos1` FOREIGN KEY (`iddocumentos`) REFERENCES `documentos` (`iddocumentos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visualizaciones_eventos1` FOREIGN KEY (`ideventos`) REFERENCES `eventos` (`ideventos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visualizaciones_users1` FOREIGN KEY (`idusers`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
