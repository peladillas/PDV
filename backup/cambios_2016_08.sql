CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `vendedor` varchar(128) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vendedor` (`id_vendedor`, `vendedor`, `id_estado`) VALUES
(1, 'Pablo', 1),
(2, 'Juan', 1),
(3, 'Martin', 1);


CREATE TABLE `interes` (
  `id_interes` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `monto` float NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `presupuesto` ADD `id_vendedor` INT NOT NULL AFTER `a_cuenta`;
