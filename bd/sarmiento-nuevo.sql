-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-02-2019 a las 04:30:36
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sarmiento-nuevo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actualizacion_precio`
--

CREATE TABLE IF NOT EXISTS `actualizacion_precio` (
  `id_actualizacion` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(128) NOT NULL,
  `grupo` varchar(128) NOT NULL,
  `categoria` varchar(128) NOT NULL,
  `subcategoria` varchar(128) NOT NULL,
  `variacion` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_estado` tinyint(4) NOT NULL DEFAULT '1',
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_actualizacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1200 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anulacion`
--

CREATE TABLE IF NOT EXISTS `anulacion` (
  `id_anulacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_presupuesto` int(11) NOT NULL,
  `monto` float NOT NULL,
  `fecha` datetime NOT NULL,
  `nota` text NOT NULL,
  PRIMARY KEY (`id_anulacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
  `id_articulo` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_proveedor` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1',
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `precio_costo` float NOT NULL,
  `costo_descuento` float NOT NULL,
  `iva` float NOT NULL,
  `impuesto` float NOT NULL,
  `margen` float NOT NULL,
  `precio_venta_iva` float NOT NULL,
  `precio_venta_sin_iva_con_imp` float NOT NULL,
  `precio_venta_sin_iva` float NOT NULL,
  `id_proveedor` int(11) NOT NULL DEFAULT '13',
  `id_grupo` int(11) NOT NULL DEFAULT '1',
  `id_categoria` int(11) NOT NULL DEFAULT '1',
  `id_subcategoria` int(11) NOT NULL DEFAULT '1',
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `stock` float NOT NULL DEFAULT '1',
  `stock_min` float NOT NULL,
  PRIMARY KEY (`id_articulo`),
  KEY `grupo` (`id_grupo`),
  KEY `grupo_2` (`id_grupo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=27392 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE IF NOT EXISTS `calendario` (
  `id_calendario` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `id_color` int(11) NOT NULL,
  `id_estado` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_calendario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_nota` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `apellido` varchar(64) NOT NULL,
  `alias` varchar(128) NOT NULL,
  `direccion` varchar(64) NOT NULL,
  `telefono` varchar(32) NOT NULL,
  `celular` varchar(32) NOT NULL,
  `nextel` varchar(32) NOT NULL,
  `cuil` varchar(32) NOT NULL,
  `id_condicion_iva` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE IF NOT EXISTS `color` (
  `id_color` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(128) NOT NULL,
  `backgroundColor` varchar(16) NOT NULL,
  `borderColor` varchar(16) NOT NULL,
  PRIMARY KEY (`id_color`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_iva`
--

CREATE TABLE IF NOT EXISTS `condicion_iva` (
  `id_condicion_iva` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) NOT NULL,
  PRIMARY KEY (`id_condicion_iva`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `dias_pago` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_inicial` float NOT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_backup`
--

CREATE TABLE IF NOT EXISTS `config_backup` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `directorio` varchar(128) NOT NULL,
  `formato_fecha` varchar(16) NOT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_impresion`
--

CREATE TABLE IF NOT EXISTS `config_impresion` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `impresion` varchar(32) NOT NULL,
  `cabecera` text NOT NULL,
  `pie` text NOT NULL,
  `impresion_automatica` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE IF NOT EXISTS `devolucion` (
  `id_devolucion` int(11) NOT NULL AUTO_INCREMENT,
  `id_presupuesto` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `a_cuenta` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_devolucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion_detalle`
--

CREATE TABLE IF NOT EXISTS `devolucion_detalle` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_devolucion` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto` float NOT NULL,
  PRIMARY KEY (`id_detalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=278 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(32) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_devolucion`
--

CREATE TABLE IF NOT EXISTS `estado_devolucion` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(64) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_presupuesto`
--

CREATE TABLE IF NOT EXISTS `estado_presupuesto` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(65) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE IF NOT EXISTS `familias` (
  `codfamilia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codfamilia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_nota` int(11) NOT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=242 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interes`
--

CREATE TABLE IF NOT EXISTS `interes` (
  `id_interes` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `monto` float NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `tabla` varchar(32) NOT NULL,
  `id_tabla` int(11) NOT NULL,
  `id_accion` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2773 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_presupuesto`
--

CREATE TABLE IF NOT EXISTS `log_presupuesto` (
  `id_presupuesto` int(20) NOT NULL,
  `old_fecha` datetime NOT NULL,
  `new_fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `new_monto` float NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `new_id_cliente` int(11) NOT NULL,
  `descuento` float NOT NULL,
  `new_descuento` float NOT NULL,
  `tipo` int(11) NOT NULL,
  `new_tipo` int(11) NOT NULL,
  `a_cuenta` float NOT NULL,
  `new_a_cuenta` float NOT NULL,
  `estado` int(11) NOT NULL,
  `new_estado` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_reglon_presupuesto`
--

CREATE TABLE IF NOT EXISTS `log_reglon_presupuesto` (
  `id_renglon` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `old_cantidad` float NOT NULL,
  `new_cantidad` float NOT NULL,
  `old_precio` float NOT NULL,
  `new_precio` float NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE IF NOT EXISTS `nota` (
  `id_nota` int(11) NOT NULL AUTO_INCREMENT,
  `nota` varchar(255) NOT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) NOT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE IF NOT EXISTS `presupuesto` (
  `id_presupuesto` int(20) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `descuento` float NOT NULL,
  `tipo` int(11) NOT NULL,
  `a_cuenta` float NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci,
  `com_publico` tinyint(4) DEFAULT NULL,
  `id_vendedor` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_presupuesto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=143929 ;

--
-- (Evento) desencadenante `presupuesto`
--
DROP TRIGGER IF EXISTS `presupuesto_AUPD`;
DELIMITER //
CREATE TRIGGER `presupuesto_AUPD` AFTER UPDATE ON `presupuesto`
 FOR EACH ROW BEGIN
  INSERT INTO log_presupuesto
	(
	`id_presupuesto`,
	`old_fecha`,
	`new_fecha`,
	`monto`,
	`new_monto`,
	`id_cliente`,
	`new_id_cliente`,
	`descuento`,
	`new_descuento`,
	`tipo`,
	`new_tipo`,
	`a_cuenta`,
	`new_a_cuenta`,
	`estado`,
	`new_estado`,
	`fecha`
	 )
	VALUES	(
	OLD.id_presupuesto,
	OLD.fecha,
	NEW.fecha,
	OLD.monto,
	NEW.monto,
	OLD.id_cliente,
	NEW.id_cliente,
	OLD.descuento,
	NEW.descuento,
	OLD.tipo,
	NEW.tipo,
	OLD.a_cuenta,
	NEW.a_cuenta,
	OLD.estado,
	NEW.estado,
	 NOW()
	);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `margen` float NOT NULL,
  `impuesto` float NOT NULL,
  `descuento` float NOT NULL,
  `descuento2` float NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reglon_presupuesto`
--

CREATE TABLE IF NOT EXISTS `reglon_presupuesto` (
  `id_renglon` int(11) NOT NULL AUTO_INCREMENT,
  `id_presupuesto` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_renglon`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=342281 ;

--
-- (Evento) desencadenante `reglon_presupuesto`
--
DROP TRIGGER IF EXISTS `reglon_presupuesto_AUPD`;
DELIMITER //
CREATE TRIGGER `reglon_presupuesto_AUPD` AFTER UPDATE ON `reglon_presupuesto`
 FOR EACH ROW BEGIN
  INSERT INTO log_reglon_presupuesto
	(
	  `id_renglon`, 
	  `id_presupuesto`,
	  `id_articulo`, 
	  `old_cantidad`,
	  `new_cantidad`, 
	  `old_precio`,
	  `new_precio` ,
	  `fecha`
	)
	VALUES	(
	 OLD.id_renglon, 
	  OLD.id_presupuesto,
	  OLD.id_articulo, 
	  OLD.cantidad,
	  NEW.cantidad, 
	  OLD.precio,
	  NEW.precio, 
	  NOW()
	);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito`
--

CREATE TABLE IF NOT EXISTS `remito` (
  `id_remito` int(20) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `devolucion` float NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_remito`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1929 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito_detalle`
--

CREATE TABLE IF NOT EXISTS `remito_detalle` (
  `id_remito_detalle` int(20) NOT NULL AUTO_INCREMENT,
  `monto` float NOT NULL,
  `id_remito` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `a_cuenta` float NOT NULL,
  `id_estado_presupuesto` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_remito_detalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11144 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) NOT NULL,
  `permiso_articulo` int(11) NOT NULL,
  `permiso_proveedor` int(11) NOT NULL,
  `permiso_cliente` int(11) NOT NULL,
  `permiso_presupuesto` int(11) NOT NULL,
  `permiso_ctacte` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE IF NOT EXISTS `subcategoria` (
  `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria_padre` int(11) NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_nota` int(11) NOT NULL,
  PRIMARY KEY (`id_subcategoria`),
  UNIQUE KEY `cod_categoria_padre` (`id_categoria_padre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(32) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(64) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE IF NOT EXISTS `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `vendedor` varchar(128) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_vendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
