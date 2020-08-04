-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2020 a las 00:15:43
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mensajeria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `fechaHora` timestamp NOT NULL DEFAULT current_timestamp(),
  `texto` varchar(100) NOT NULL,
  `id_usr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`fechaHora`, `texto`, `id_usr`) VALUES
('2020-07-30 18:18:48', 'Hola', 1),
('2020-08-03 06:38:32', 'Hola', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje_pri`
--

CREATE TABLE `mensaje_pri` (
  `id_usr_envia` int(11) NOT NULL,
  `id_usr_recibe` int(11) NOT NULL,
  `fechaHora` timestamp NOT NULL DEFAULT current_timestamp(),
  `texto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensaje_pri`
--

INSERT INTO `mensaje_pri` (`id_usr_envia`, `id_usr_recibe`, `fechaHora`, `texto`) VALUES
(1, 3, '2020-08-03 06:46:24', 'Hola desde arbol'),
(3, 1, '2020-08-03 06:41:48', 'hola arbol'),
(3, 4, '2020-08-03 06:42:20', 'Hola juan'),
(3, 5, '2020-08-03 06:42:03', 'Hola cosmik');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usr` int(11) NOT NULL,
  `nombreU` varchar(35) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usr`, `nombreU`, `email`, `password`) VALUES
(1, 'ArbolB', 'victoranizarmorales@gmail.com', '123'),
(3, 'Rocky', 'rock@croqueta.com', '123'),
(4, 'Juan', 'juan@gmail.com', '123'),
(5, 'Cosmik', 'Cos@mik.com', '123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`fechaHora`,`id_usr`),
  ADD KEY `fkMsjUsr` (`id_usr`);

--
-- Indices de la tabla `mensaje_pri`
--
ALTER TABLE `mensaje_pri`
  ADD UNIQUE KEY `chat_privado` (`id_usr_envia`,`id_usr_recibe`,`fechaHora`),
  ADD KEY `fkMsjUsrR` (`id_usr_recibe`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usr`),
  ADD UNIQUE KEY `nombreU` (`nombreU`,`email`),
  ADD UNIQUE KEY `id_usr` (`id_usr`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `fkMsjUsr` FOREIGN KEY (`id_usr`) REFERENCES `usuario` (`id_usr`);

--
-- Filtros para la tabla `mensaje_pri`
--
ALTER TABLE `mensaje_pri`
  ADD CONSTRAINT `fkMsjUsrE` FOREIGN KEY (`id_usr_envia`) REFERENCES `usuario` (`id_usr`),
  ADD CONSTRAINT `fkMsjUsrR` FOREIGN KEY (`id_usr_recibe`) REFERENCES `usuario` (`id_usr`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
