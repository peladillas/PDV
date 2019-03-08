-- consultas para hacer funcionar el stock
-- actualizacion de la tabla articulo

ALTER TABLE `articulo` ADD `stock` FLOAT NOT NULL AFTER `descripcion`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE IF NOT EXISTS `stock_detail` (
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
ALTER TABLE `stock_detail`
 ADD PRIMARY KEY (`id_stock`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock_detail`
MODIFY `id_stock` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
 ADD PRIMARY KEY (`id_nota_credito`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
MODIFY `id_nota_credito` int(11) NOT NULL AUTO_INCREMENT;
