-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2015 at 12:41 PM
-- Server version: 5.5.43-0+deb7u1
-- PHP Version: 5.4.39-0+deb7u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cryptoshare`
--
CREATE DATABASE IF NOT EXISTS `cryptoshare` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cryptoshare`;

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
CREATE TABLE IF NOT EXISTS `contactos` (
  `id_usuario` int(11) NOT NULL,
  `id_contacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `contactos`
--

TRUNCATE TABLE `contactos`;
-- --------------------------------------------------------

--
-- Table structure for table `ficheros`
--

DROP TABLE IF EXISTS `ficheros`;
CREATE TABLE IF NOT EXISTS `ficheros` (
  `id` int(11) NOT NULL,
  `id_origen` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `fechahora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `ficheros`
--

TRUNCATE TABLE `ficheros`;
--
-- Triggers `ficheros`
--
DROP TRIGGER IF EXISTS `borrados`;
DELIMITER $$
CREATE TRIGGER `borrados` BEFORE DELETE ON `ficheros`
 FOR EACH ROW insert into ficheros_borrados (id_origen,id_destino,nombre,ruta,fechahora,fechahora_borrado) values (old.id_origen,old.id_destino,old.nombre,old.ruta,old.fechahora,now())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ficheros_borrados`
--

DROP TABLE IF EXISTS `ficheros_borrados`;
CREATE TABLE IF NOT EXISTS `ficheros_borrados` (
  `id` int(11) NOT NULL,
  `id_origen` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `fechahora` datetime NOT NULL,
  `fechahora_borrado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `ficheros_borrados`
--

TRUNCATE TABLE `ficheros_borrados`;
-- --------------------------------------------------------

--
-- Table structure for table `ficheros_borrados_grupos`
--

DROP TABLE IF EXISTS `ficheros_borrados_grupos`;
CREATE TABLE IF NOT EXISTS `ficheros_borrados_grupos` (
  `id` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `fechahora` datetime NOT NULL,
  `fechahora_borrado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `ficheros_borrados_grupos`
--

TRUNCATE TABLE `ficheros_borrados_grupos`;
-- --------------------------------------------------------

--
-- Table structure for table `ficheros_grupos`
--

DROP TABLE IF EXISTS `ficheros_grupos`;
CREATE TABLE IF NOT EXISTS `ficheros_grupos` (
  `id` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `fechahora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `ficheros_grupos`
--

TRUNCATE TABLE `ficheros_grupos`;
--
-- Triggers `ficheros_grupos`
--
DROP TRIGGER IF EXISTS `borrados_grupos`;
DELIMITER $$
CREATE TRIGGER `borrados_grupos` BEFORE DELETE ON `ficheros_grupos`
 FOR EACH ROW insert into ficheros_borrados_grupos (id_grupo,id_usuario,nombre,ruta,fechahora,fechahora_borrado) values (old.id_grupo,old.id_usuario,old.nombre,old.ruta,old.fechahora,now())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL,
  `nombre_grupo` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `grupos`
--

TRUNCATE TABLE `grupos`;
-- --------------------------------------------------------

--
-- Table structure for table `puesto`
--

DROP TABLE IF EXISTS `puesto`;
CREATE TABLE IF NOT EXISTS `puesto` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `puesto`
--

TRUNCATE TABLE `puesto`;
--
-- Dumping data for table `puesto`
--

INSERT INTO `puesto` (`id`, `descripcion`) VALUES
(0, 'Sin definir'),
(1, 'Direccion'),
(2, 'Administracion'),
(3, 'Informatica'),
(4, 'Ventas'),
(5, 'Calidad'),
(6, 'Pruebas');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contrasenia` varchar(64) NOT NULL,
  `nivel` tinyint(4) NOT NULL DEFAULT '0',
  `nombre_completo` varchar(50) NOT NULL,
  `img` varchar(60) NOT NULL DEFAULT 'img/profile/default.png',
  `tlf` int(11) NOT NULL,
  `puesto` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasenia`, `nivel`, `nombre_completo`, `img`, `tlf`, `puesto`) VALUES
(2, 'admin', 'bd94dcda26fccb4e68d6a31f9b5aac0b571ae266d822620e901ef7ebe3a11d4f', 1, 'Administrador', 'img/profile/2.jpg', 999999999, 2);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_grupo`
--

DROP TABLE IF EXISTS `usuarios_grupo`;
CREATE TABLE IF NOT EXISTS `usuarios_grupo` (
  `id_usuario` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `permiso` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `usuarios_grupo`
--

TRUNCATE TABLE `usuarios_grupo`;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id_usuario`,`id_contacto`),
  ADD KEY `usuario` (`id_usuario`),
  ADD KEY `contacto` (`id_contacto`);

--
-- Indexes for table `ficheros`
--
ALTER TABLE `ficheros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_origen` (`id_origen`,`id_destino`),
  ADD KEY `id_destino` (`id_destino`);

--
-- Indexes for table `ficheros_borrados`
--
ALTER TABLE `ficheros_borrados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_origen` (`id_origen`,`id_destino`),
  ADD KEY `id_destino` (`id_destino`);

--
-- Indexes for table `ficheros_borrados_grupos`
--
ALTER TABLE `ficheros_borrados_grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_origen` (`id_grupo`,`id_usuario`),
  ADD KEY `ficheros_borrados_grupos_ibfk_2` (`id_usuario`);

--
-- Indexes for table `ficheros_grupos`
--
ALTER TABLE `ficheros_grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_origen` (`id_grupo`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_grupo` (`nombre_grupo`);

--
-- Indexes for table `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `puesto` (`puesto`);

--
-- Indexes for table `usuarios_grupo`
--
ALTER TABLE `usuarios_grupo`
  ADD PRIMARY KEY (`id_usuario`,`id_grupo`),
  ADD KEY `actualizar_grupos` (`id_grupo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ficheros`
--
ALTER TABLE `ficheros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ficheros_borrados`
--
ALTER TABLE `ficheros_borrados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ficheros_borrados_grupos`
--
ALTER TABLE `ficheros_borrados_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ficheros_grupos`
--
ALTER TABLE `ficheros_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `puesto`
--
ALTER TABLE `puesto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contactos_ibfk_2` FOREIGN KEY (`id_contacto`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ficheros`
--
ALTER TABLE `ficheros`
  ADD CONSTRAINT `ficheros_ibfk_1` FOREIGN KEY (`id_origen`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficheros_ibfk_2` FOREIGN KEY (`id_destino`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ficheros_borrados`
--
ALTER TABLE `ficheros_borrados`
  ADD CONSTRAINT `ficheros_borrados_ibfk_1` FOREIGN KEY (`id_origen`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ficheros_borrados_ibfk_2` FOREIGN KEY (`id_destino`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ficheros_borrados_grupos`
--
ALTER TABLE `ficheros_borrados_grupos`
  ADD CONSTRAINT `ficheros_borrados_grupos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ficheros_borrados_grupos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ficheros_grupos`
--
ALTER TABLE `ficheros_grupos`
  ADD CONSTRAINT `ficheros_grupos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ficheros_grupos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`puesto`) REFERENCES `puesto` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `usuarios_grupo`
--
ALTER TABLE `usuarios_grupo`
  ADD CONSTRAINT `actualizar_grupos` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actualizar_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
