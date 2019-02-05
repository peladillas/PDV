-- consultas para hacer funcionar el stock
-- actualizacion de la tabla articulo

ALTER TABLE `articulo` ADD `stock` FLOAT NOT NULL AFTER `descripcion`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
`id_stock` bigint(20) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `id_comprobante` int(11) NOT NULL,
  `id_comprobante_tipo` int(11) NOT NULL,
  `cantidad_entrante` float NOT NULL,
  `cantidad_saliente` float NOT NULL,
  `id_almacen` int(11) NOT NULL,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
 ADD PRIMARY KEY (`id_stock`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
MODIFY `id_stock` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro`
--

CREATE TABLE IF NOT EXISTS `parametro` (
`id_parametro` int(11) NOT NULL,
  `parametro` varchar(64) NOT NULL,
  `id_parametro_tipo` int(11) NOT NULL,
  `user_add` int(11) NOT NULL,
  `user_upd` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`id_parametro`, `parametro`, `id_parametro_tipo`, `user_add`, `user_upd`, `date_add`, `date_upd`) VALUES
(1, 'remito', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'devolucion', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'movimiento manual', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `parametro`
--
ALTER TABLE `parametro`
 ADD PRIMARY KEY (`id_parametro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `parametro`
--
ALTER TABLE `parametro`
MODIFY `id_parametro` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro_tipo`
--

CREATE TABLE IF NOT EXISTS `parametro_tipo` (
`id_parametro_tipo` int(11) NOT NULL,
  `parametro_tipo` varchar(64) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `parametro_tipo`
--

INSERT INTO `parametro_tipo` (`id_parametro_tipo`, `parametro_tipo`) VALUES
(1, 'id_comprobante_tipo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `parametro_tipo`
--
ALTER TABLE `parametro_tipo`
 ADD PRIMARY KEY (`id_parametro_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `parametro_tipo`
--
ALTER TABLE `parametro_tipo`
MODIFY `id_parametro_tipo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
