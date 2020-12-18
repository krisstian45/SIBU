-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2016 at 03:22 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.6.27-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grupo46`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Golosina'),
(2, 'Bebida'),
(3, 'Almacen');

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(100) NOT NULL,
  `proveedor_cuit` varchar(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `nombreFactura` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id`, `proveedor`, `proveedor_cuit`, `fecha`, `nombreFactura`) VALUES
(25, 'asdfadsf', '12345678999', '2016-10-24 07:25:46', '4K-Wallpaper-RW.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `compra_detalle`
--

CREATE TABLE IF NOT EXISTS `compra_detalle` (
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  PRIMARY KEY (`compra_id`,`producto_id`),
  KEY `egreso_detalle-compra` (`compra_id`),
  KEY `egreso_detalle-producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `compra_detalle`
--

INSERT INTO `compra_detalle` (`compra_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(25, 7, 4, 0.01);

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `elementos` int(10) unsigned NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`id`, `titulo`, `descripcion`, `email`, `elementos`, `habilitado`, `mensaje`) VALUES
(1, 'Buffet 2016', 'En el buffet hay comida, golosinas y cafe', 'informatica_unlp@gmail.com', 5, 1, 'No hay que poner malas palabras, sino comida.');

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `fecha` date NOT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`fecha`,`producto_id`),
  KEY `menu_del_dia-producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `observacion` varchar(255) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`usuario_id`,`estado_id`),
  KEY `pedido-usuario` (`usuario_id`),
  KEY `pedido-estado` (`estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pedido_detalle`
--

CREATE TABLE IF NOT EXISTS `pedido_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`pedido_id`,`producto_id`),
  KEY `pedido_detalle-pedido` (`pedido_id`),
  KEY `pedido_detalle-producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `codigo_barra` int(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_minimo` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `proveedor` varchar(45) NOT NULL,
  `precio_venta_unitario` float NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`categoria_id`),
  KEY `producto-categoria` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `marca`, `codigo_barra`, `stock`, `stock_minimo`, `fecha_alta`, `proveedor`, `precio_venta_unitario`, `descripcion`, `categoria_id`) VALUES
(7, 'Milanesa', 'papapap', 2147483647, 27, 1, '2016-10-24 01:40:56', '123456789', 0.01, 'asdfdsaf\r\n', 2),
(8, 'Papas Fritas', 'Bagley', 1234567899, 20, 10, '2016-10-27 00:00:00', 'Bagley', 12.5, 'Son muy ricas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'gestion'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Table structure for table `ubicacion`
--

CREATE TABLE IF NOT EXISTS `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `nombre`, `descripcion`) VALUES
(1, 'linti', '3er piso'),
(2, 'lifia', '2do piso'),
(3, 'oficina alumnos', '1er piso');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `habilitado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`usuario`),
  UNIQUE KEY `idUsuario` (`id`),
  KEY `idUsuario_2` (`id`),
  KEY `idUsuario_3` (`id`),
  KEY `usuario-rol` (`rol_id`),
  KEY `usuario-ubicacion` (`ubicacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `tipoDocumento`, `numeroDocumento`, `email`, `telefono`, `rol_id`, `ubicacion_id`, `habilitado`) VALUES
(6, 'admin', '123456', 'administrador', 'null', '', '123456789', 'a@a', '22157563512', 1, 1, 1),
(9, 'gestion', '123456Aa', 'ratata', 'qwer', 'DNI', '12345678', 'a@a', '12345678', 2, 3, 1),
(10, 'retamar', '123456Aa', 'asdfasfd', 'asdfasdf', 'DNI', '12345678', 'a@a', '12345678', 3, 3, 1),
(11, 'pepea', '123456Aa', 'asdf', 'asdf', 'DNI', '10000001', 'a@a', '12345678', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `venta_detalle`
--

CREATE TABLE IF NOT EXISTS `venta_detalle` (
  `fecha` datetime NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`fecha`,`producto_id`),
  KEY `ingreso_detalle-producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD CONSTRAINT `egreso_detalle-compra` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `egreso_detalle-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_del_dia-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido-estado` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido-usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD CONSTRAINT `pedido_detalle-pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_detalle-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto-categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario-rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario-ubicacion` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicacion` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD CONSTRAINT `ingreso_detalle-producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_detalle_ibfk_1` FOREIGN KEY (`fecha`) REFERENCES `venta` (`fecha`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
