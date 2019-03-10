-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2019 a las 00:49:55
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
`id_actualizacion` int(11) NOT NULL,
  `proveedor` varchar(128) NOT NULL,
  `grupo` varchar(128) NOT NULL,
  `categoria` varchar(128) NOT NULL,
  `subcategoria` varchar(128) NOT NULL,
  `variacion` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_estado` tinyint(4) NOT NULL DEFAULT '1',
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anulacion`
--

CREATE TABLE IF NOT EXISTS `anulacion` (
`id_anulacion` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `monto` float NOT NULL,
  `fecha` datetime NOT NULL,
  `nota` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
`id_articulo` bigint(20) NOT NULL,
  `cod_proveedor` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1',
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `stock` float NOT NULL,
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
  `id_estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`id_articulo`, `cod_proveedor`, `descripcion`, `stock`, `precio_costo`, `costo_descuento`, `iva`, `impuesto`, `margen`, `precio_venta_iva`, `precio_venta_sin_iva_con_imp`, `precio_venta_sin_iva`, `id_proveedor`, `id_grupo`, `id_categoria`, `id_subcategoria`, `id_estado`) VALUES
(1, '123', 'Nuevo producto', -26, 0, 0, 0, 0, 0, 50, 50, 0, 13, 1, 1, 1, 1),
(2, '456', 'Segundo producto', -24, 0, 0, 0, 0, 0, 60, 60, 0, 13, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE IF NOT EXISTS `calendario` (
`id_calendario` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `id_color` int(11) NOT NULL,
  `id_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
`id_categoria` int(11) NOT NULL,
  `descripcion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_nota` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
`id_cliente` int(11) NOT NULL,
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
  `id_estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `apellido`, `alias`, `direccion`, `telefono`, `celular`, `nextel`, `cuil`, `id_condicion_iva`, `id_tipo`, `comentario`, `id_estado`) VALUES
(1, 'Diego', 'Nieto', '', '', '', '', '', '', 0, 0, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE IF NOT EXISTS `color` (
`id_color` int(11) NOT NULL,
  `color` varchar(128) NOT NULL,
  `backgroundColor` varchar(16) NOT NULL,
  `borderColor` varchar(16) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `color`, `backgroundColor`, `borderColor`) VALUES
(1, 'Rojo', 'f56954', 'f56954'),
(2, 'Amarillo', 'f39c12', 'f39c12'),
(3, 'Azul', '0073b7', '0073b7'),
(4, 'Celeste', '00c0ef', '00c0ef'),
(5, 'Verde', '00a65a', '00a65a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_iva`
--

CREATE TABLE IF NOT EXISTS `condicion_iva` (
`id_condicion_iva` int(11) NOT NULL,
  `descripcion` varchar(32) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `condicion_iva`
--

INSERT INTO `condicion_iva` (`id_condicion_iva`, `descripcion`) VALUES
(1, 'Monotributista'),
(2, 'Responsable inscripto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE IF NOT EXISTS `config` (
`id_config` int(11) NOT NULL,
  `dias_pago` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_inicial` float NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id_config`, `dias_pago`, `cantidad`, `cantidad_inicial`) VALUES
(1, 30, 2500, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_backup`
--

CREATE TABLE IF NOT EXISTS `config_backup` (
`id_config` int(11) NOT NULL,
  `directorio` varchar(128) NOT NULL,
  `formato_fecha` varchar(16) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `config_backup`
--

INSERT INTO `config_backup` (`id_config`, `directorio`, `formato_fecha`) VALUES
(1, 'C:/Users/Martin/Documents/Backups/', 'Y-m-d H i s');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_impresion`
--

CREATE TABLE IF NOT EXISTS `config_impresion` (
`id_config` int(11) NOT NULL,
  `impresion` varchar(32) NOT NULL,
  `cabecera` text NOT NULL,
  `pie` text NOT NULL,
  `impresion_automatica` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `config_impresion`
--

INSERT INTO `config_impresion` (`id_config`, `impresion`, `cabecera`, `pie`, `impresion_automatica`) VALUES
(1, 'remito', '<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<h3>\r\n					&nbsp;</h3>\r\n			</td>\r\n			<td>\r\n				<h3 style="text-align: center;">\r\n					<span style="font-size:22px;"><strong><u>BULONES SARMIENTO</u></strong></span></h3>\r\n				<p>\r\n					<span style="font-size:12px;">Tel:0260-4437750</span></p>\r\n				<p>\r\n					<span style="font-size:12px;">Mail:bulonesarmiento@gmail.com</span></p>\r\n			</td>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:12px;">Nro:&nbsp;<strong>#remito_nro# &nbsp;- &nbsp;</strong>Fecha:&nbsp;<strong>#remito_fecha#&nbsp;</strong></span></h3>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:12px;">Cliente:</span></h3>\r\n			</td>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:12px;"><strong>#cliente_nombre#&nbsp;</strong></span></h3>\r\n			</td>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:12px;">Entrega: $&nbsp;<strong>#remito_monto#</strong></span></h3>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>\r\n', '', 1),
(2, 'presupuesto', '<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<h3>\r\n					&nbsp;</h3>\r\n			</td>\r\n			<td>\r\n				<h3 style="text-align: center;">\r\n					<strong><u><span style="font-size:20px;">BULONES&nbsp;SARMIENTO</span></u></strong></h3>\r\n				<p>\r\n					<span style="font-size:11px;">Tel:0260-4437750</span></p>\r\n				<p>\r\n					<span style="font-size:11px;">Mail:bulonesarmiento@gmail.com</span></p>\r\n			</td>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:11px;">Nro:&nbsp;<strong>#presupuesto_nro# &nbsp;- &nbsp;</strong>Fecha:&nbsp;<strong>#presupuesto_fecha#&nbsp;&nbsp;</strong>Descuento:&nbsp;<strong style="font-size: 12px;">#presupuesto_descuento#&nbsp;</strong></span></h3>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:11px;">Cliente:</span></h3>\r\n			</td>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:11px;"><strong>#cliente_nombre#&nbsp;</strong></span></h3>\r\n			</td>\r\n			<td>\r\n				<h3>\r\n					<span style="font-size:11px;"><span style="font-size:16px;"><strong><em><u>&nbsp;Total:</u></em></strong> </span>$<span style="font-size:18px;">&nbsp;<strong>#presupuesto_monto#</strong></span></span></h3>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>\r\n', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE IF NOT EXISTS `devolucion` (
`id_devolucion` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `a_cuenta` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion_detalle`
--

CREATE TABLE IF NOT EXISTS `devolucion_detalle` (
`id_detalle` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE IF NOT EXISTS `familias` (
`codfamilia` int(11) NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
`id_grupo` int(11) NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_nota` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

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
`id_log` int(11) NOT NULL,
  `tabla` varchar(32) NOT NULL,
  `id_tabla` int(11) NOT NULL,
  `id_accion` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
`id_nota` int(11) NOT NULL,
  `nota` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE IF NOT EXISTS `nota_credito` (
`id_nota_credito` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `comentario` text NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `user_add` int(11) NOT NULL,
  `user_upd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
`id_permiso` int(11) NOT NULL,
  `descripcion` varchar(32) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `descripcion`) VALUES
(1, 'Ver'),
(2, 'Ver, añadir'),
(3, 'Ver, modificar'),
(4, 'Ver, añadir, modificar'),
(5, 'Ver, añadir, modificar, eliminar'),
(6, 'Ninguno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE IF NOT EXISTS `presupuesto` (
`id_presupuesto` int(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `descuento` float NOT NULL,
  `tipo` int(11) NOT NULL,
  `a_cuenta` float NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci NOT NULL,
  `com_publico` tinyint(4) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Disparadores `presupuesto`
--
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
`id_proveedor` int(11) NOT NULL,
  `descripcion` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `margen` float NOT NULL,
  `impuesto` float NOT NULL,
  `descuento` float NOT NULL,
  `descuento2` float NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito`
--

CREATE TABLE IF NOT EXISTS `remito` (
`id_remito` int(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL,
  `devolucion` float NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito_detalle`
--

CREATE TABLE IF NOT EXISTS `remito_detalle` (
`id_remito_detalle` int(20) NOT NULL,
  `monto` float NOT NULL,
  `id_remito` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `a_cuenta` float NOT NULL,
  `id_estado_presupuesto` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renglon_nota_credito`
--

CREATE TABLE IF NOT EXISTS `renglon_nota_credito` (
`id_renglon` int(11) NOT NULL,
  `id_nota_credito` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renglon_presupuesto`
--

CREATE TABLE IF NOT EXISTS `renglon_presupuesto` (
`id_renglon` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Disparadores `renglon_presupuesto`
--
DELIMITER //
CREATE TRIGGER `reglon_presupuesto_AUPD` AFTER UPDATE ON `renglon_presupuesto`
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
-- Estructura de tabla para la tabla `renglon_stock`
--

CREATE TABLE IF NOT EXISTS `renglon_stock` (
`id_stock` bigint(20) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `id_comprobante` int(11) NOT NULL,
  `id_comprobante_tipo` int(11) NOT NULL,
  `cantidad_entrante` float NOT NULL,
  `cantidad_saliente` float NOT NULL,
  `id_almacen` int(11) NOT NULL,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
`id_rol` int(11) NOT NULL,
  `descripcion` varchar(32) NOT NULL,
  `permiso_articulo` int(11) NOT NULL,
  `permiso_proveedor` int(11) NOT NULL,
  `permiso_cliente` int(11) NOT NULL,
  `permiso_presupuesto` int(11) NOT NULL,
  `permiso_ctacte` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `descripcion`, `permiso_articulo`, `permiso_proveedor`, `permiso_cliente`, `permiso_presupuesto`, `permiso_ctacte`, `id_estado`) VALUES
(3, 'Administrativo', 5, 5, 5, 5, 5, 2),
(4, 'vendedor', 2, 6, 1, 1, 1, 1),
(5, 'Martin', 5, 5, 5, 5, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE IF NOT EXISTS `subcategoria` (
`id_subcategoria` int(11) NOT NULL,
  `id_categoria_padre` int(11) NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_nota` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE IF NOT EXISTS `tipo_cliente` (
`id_tipo` int(11) NOT NULL,
  `tipo` varchar(64) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tipo_cliente`
--

INSERT INTO `tipo_cliente` (`id_tipo`, `tipo`) VALUES
(1, 'Nuevo'),
(2, 'Normal'),
(3, 'Potencial'),
(4, 'Malo'),
(5, 'Excelente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id_usuario` int(11) NOT NULL,
  `descripcion` varchar(32) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `descripcion`, `pass`, `id_rol`, `id_estado`) VALUES
(1, 'martin', '5bf5cd239b46533ca36853f611b323d8', 5, 1),
(2, 'admin', '405e28906322882c5be9b4b27f4c35fd', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE IF NOT EXISTS `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `vendedor` varchar(128) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`id_vendedor`, `vendedor`, `id_estado`) VALUES
(0, 'LUCIANO ', 1),
(1, 'MARTIN P', 1),
(2, 'HUGO M', 1),
(3, 'SEBASTIAN', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actualizacion_precio`
--
ALTER TABLE `actualizacion_precio`
 ADD PRIMARY KEY (`id_actualizacion`);

--
-- Indices de la tabla `anulacion`
--
ALTER TABLE `anulacion`
 ADD PRIMARY KEY (`id_anulacion`);

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
 ADD PRIMARY KEY (`id_articulo`), ADD KEY `grupo` (`id_grupo`), ADD KEY `grupo_2` (`id_grupo`);

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
 ADD PRIMARY KEY (`id_calendario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
 ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
 ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
 ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `condicion_iva`
--
ALTER TABLE `condicion_iva`
 ADD PRIMARY KEY (`id_condicion_iva`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
 ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `config_backup`
--
ALTER TABLE `config_backup`
 ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `config_impresion`
--
ALTER TABLE `config_impresion`
 ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `devolucion`
--
ALTER TABLE `devolucion`
 ADD PRIMARY KEY (`id_devolucion`);

--
-- Indices de la tabla `devolucion_detalle`
--
ALTER TABLE `devolucion_detalle`
 ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
 ADD PRIMARY KEY (`codfamilia`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
 ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `interes`
--
ALTER TABLE `interes`
 ADD PRIMARY KEY (`id_interes`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
 ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `nota`
--
ALTER TABLE `nota`
 ADD PRIMARY KEY (`id_nota`);

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
 ADD PRIMARY KEY (`id_nota_credito`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
 ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
 ADD PRIMARY KEY (`id_presupuesto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
 ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `remito`
--
ALTER TABLE `remito`
 ADD PRIMARY KEY (`id_remito`);

--
-- Indices de la tabla `remito_detalle`
--
ALTER TABLE `remito_detalle`
 ADD PRIMARY KEY (`id_remito_detalle`);

--
-- Indices de la tabla `renglon_nota_credito`
--
ALTER TABLE `renglon_nota_credito`
 ADD PRIMARY KEY (`id_renglon`);

--
-- Indices de la tabla `renglon_presupuesto`
--
ALTER TABLE `renglon_presupuesto`
 ADD PRIMARY KEY (`id_renglon`);

--
-- Indices de la tabla `renglon_stock`
--
ALTER TABLE `renglon_stock`
 ADD PRIMARY KEY (`id_stock`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
 ADD PRIMARY KEY (`id_subcategoria`), ADD UNIQUE KEY `cod_categoria_padre` (`id_categoria_padre`);

--
-- Indices de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
 ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
 ADD PRIMARY KEY (`id_vendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actualizacion_precio`
--
ALTER TABLE `actualizacion_precio`
MODIFY `id_actualizacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `anulacion`
--
ALTER TABLE `anulacion`
MODIFY `id_anulacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
MODIFY `id_articulo` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
MODIFY `id_calendario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `condicion_iva`
--
ALTER TABLE `condicion_iva`
MODIFY `id_condicion_iva` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `config_backup`
--
ALTER TABLE `config_backup`
MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `config_impresion`
--
ALTER TABLE `config_impresion`
MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `devolucion`
--
ALTER TABLE `devolucion`
MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `devolucion_detalle`
--
ALTER TABLE `devolucion_detalle`
MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
MODIFY `codfamilia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
MODIFY `id_nota_credito` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
MODIFY `id_presupuesto` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `remito`
--
ALTER TABLE `remito`
MODIFY `id_remito` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `remito_detalle`
--
ALTER TABLE `remito_detalle`
MODIFY `id_remito_detalle` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `renglon_nota_credito`
--
ALTER TABLE `renglon_nota_credito`
MODIFY `id_renglon` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `renglon_presupuesto`
--
ALTER TABLE `renglon_presupuesto`
MODIFY `id_renglon` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `renglon_stock`
--
ALTER TABLE `renglon_stock`
MODIFY `id_stock` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
