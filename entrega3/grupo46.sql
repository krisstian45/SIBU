-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-11-2016 a las 17:48:55
-- Versión del servidor: 10.0.26-MariaDB-0+deb8u1
-- Versión de PHP: 5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `grupo46`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
`id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Golosina'),
(2, 'Bebida'),
(3, 'Almacen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
`id` int(11) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `proveedor_cuit` varchar(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `nombreFactura` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `proveedor`, `proveedor_cuit`, `fecha`, `nombreFactura`) VALUES
(25, 'asdfadsf', '12345678999', '2016-10-24 07:25:46', '4K-Wallpaper-RW.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_detalle`
--

CREATE TABLE IF NOT EXISTS `compra_detalle` (
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra_detalle`
--

INSERT INTO `compra_detalle` (`compra_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(25, 7, 4, 0.01);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
`id` int(10) unsigned NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `elementos` int(10) unsigned NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `mensaje` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `titulo`, `descripcion`, `email`, `elementos`, `habilitado`, `mensaje`) VALUES
(1, 'Buffet 2016', 'En el buffet hay comida, golosinas y cafe', 'informatica_unlp@gmail.com', 5, 1, 'No hay que poner malas palabras, sino comida.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `fecha` date NOT NULL,
  `producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`fecha`, `producto_id`) VALUES
('2016-10-30', 7),
('2016-10-30', 8),
('2016-10-31', 7),
('2016-10-31', 8),
('2016-11-04', 7),
('2016-11-04', 8),
('2016-11-04', 9),
('2016-11-04', 10),
('2016-11-04', 11),
('2016-11-04', 12),
('2016-11-04', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
`id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `fecha` datetime NOT NULL,
  `observacion` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `usuario_id`, `estado`, `fecha`, `observacion`) VALUES
(33, 10, 'Entregado', '2016-10-31 01:01:39', 'Listo'),
(34, 10, 'Cancelado', '2016-10-31 01:06:49', 'No hay mas pati , man'),
(42, 10, 'Entregado', '2016-10-31 03:02:20', 'Listo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE IF NOT EXISTS `pedido_detalle` (
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`pedido_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(33, 7, 5, 0.01),
(33, 8, 4, 12.5),
(34, 7, 4, 0.01),
(34, 8, 7, 12.5),
(42, 7, 6, 0.01),
(42, 8, 8, 12.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
`id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `codigo_barra` bigint(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_minimo` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `proveedor` varchar(45) NOT NULL,
  `precio_venta_unitario` float NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `marca`, `codigo_barra`, `stock`, `stock_minimo`, `fecha_alta`, `proveedor`, `precio_venta_unitario`, `descripcion`, `categoria_id`) VALUES
(7, 'Milanesa', 'papapap', 2147483647, 10, 1, '2016-10-24 01:40:56', '123456789', 0.01, 'nueva modificacion\r\n', 1),
(8, 'Papas Fritas', 'Bagley', 1234567899, 2, 10, '2016-10-27 00:00:00', 'Bagley', 12.5, 'Son muy ricas', 1),
(9, 'mogul', 'arcor', 1254521541, 45, 15, '2016-11-04 11:53:01', 'arcor inc', 15, 'gomitas con forma de osito', 1),
(10, 'Beldent', 'arcor', 1524547514, 45, 14, '2016-11-04 12:04:21', 'arcor inc', 15.4, 'sabor menta', 1),
(11, 'honey', 'arcor ', 5245145215, 45, 12, '2016-11-04 12:22:26', 'arcor des', 1, 'sabor miel', 1),
(12, 'doritos ', 'dorit', 7524547514, 45, 12, '2016-11-04 13:28:09', 'dorit corp', 12, 'queso in chert', 1),
(13, 'cheetos', 'snaks', 8956523654, 45, 15, '2016-11-04 13:43:00', 'tetrasnaks', 25, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
`id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'gestion'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

CREATE TABLE IF NOT EXISTS `suscripciones` (
  `chat_id` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `suscripciones`
--

INSERT INTO `suscripciones` (`chat_id`, `nombre`) VALUES
('249503409', 'cristian');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE IF NOT EXISTS `ubicacion` (
`id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `nombre`, `descripcion`) VALUES
(1, 'linti', '3er piso'),
(2, 'lifia', '2do piso'),
(3, 'oficina alumnos', '1er piso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipoDocumento` varchar(20) NOT NULL,
  `numeroDocumento` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `ubicacion_id` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `email`, `telefono`, `rol_id`, `ubicacion_id`, `habilitado`) VALUES
(6, 'admin', '123456', 'administrador', 'null', '', '123456789', 'a@a', '22157563512', 1, 1, 1),
(9, 'gestion', '123456Aa', 'ratata', 'qwer', 'DNI', '12345678', 'a@a', '12345678', 2, 3, 1),
(10, 'retamar', '123456Aa', 'asdfasfd', 'asdfasdf', 'DNI', '12345678', 'a@a', '12345678', 3, 3, 1),
(11, 'pepea', '123456Aa', 'asdf', 'asdf', 'DNI', '10000001', 'a@a', '12345678', 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`fecha`) VALUES
('2016-10-23 00:00:00'),
('2016-10-29 00:00:00'),
('2016-10-30 23:28:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE IF NOT EXISTS `venta_detalle` (
  `fecha` datetime NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta_detalle`
--

INSERT INTO `venta_detalle` (`fecha`, `producto_id`, `cantidad`, `precio_unitario`, `descripcion`) VALUES
('2016-10-23 00:00:00', 7, 10, 12.5, '123'),
('2016-10-30 23:28:46', 7, 6, 0.01, 'asdfdsaf\r\n'),
('2016-10-30 23:28:46', 8, 3, 12.5, 'Son muy ricas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
 ADD PRIMARY KEY (`compra_id`,`producto_id`), ADD KEY `egreso_detalle-compra` (`compra_id`), ADD KEY `egreso_detalle-producto` (`producto_id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`fecha`,`producto_id`), ADD KEY `menu_del_dia-producto` (`producto_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
 ADD PRIMARY KEY (`id`,`usuario_id`,`estado`), ADD KEY `pedido-usuario` (`usuario_id`), ADD KEY `pedido-estado` (`estado`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
 ADD PRIMARY KEY (`pedido_id`,`producto_id`), ADD KEY `pedido_detalle-pedido` (`pedido_id`), ADD KEY `pedido_detalle-producto` (`producto_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
 ADD PRIMARY KEY (`id`,`codigo_barra`,`categoria_id`), ADD KEY `producto-categoria` (`categoria_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
 ADD PRIMARY KEY (`chat_id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id`,`usuario`), ADD UNIQUE KEY `idUsuario` (`id`), ADD KEY `idUsuario_2` (`id`), ADD KEY `idUsuario_3` (`id`), ADD KEY `usuario-rol` (`rol_id`), ADD KEY `usuario-ubicacion` (`ubicacion_id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
 ADD PRIMARY KEY (`fecha`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
 ADD PRIMARY KEY (`fecha`,`producto_id`), ADD KEY `ingreso_detalle-producto` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
ADD CONSTRAINT `egreso_detalle-compra` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `egreso_detalle-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
ADD CONSTRAINT `menu_del_dia-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
ADD CONSTRAINT `pedido-usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
ADD CONSTRAINT `pedido_detalle-pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `pedido_detalle-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
ADD CONSTRAINT `producto-categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `usuario-rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `usuario-ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
ADD CONSTRAINT `ingreso_detalle-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `venta_detalle_ibfk_1` FOREIGN KEY (`fecha`) REFERENCES `venta` (`fecha`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
