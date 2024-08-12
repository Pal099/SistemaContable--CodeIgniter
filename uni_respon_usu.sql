-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2023 a las 20:22:55
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `contanuevo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uni_respon_usu`
--

CREATE TABLE `uni_respon_usu` (
  `id_uni_respon_usu` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `uni_respon_usu`
--

INSERT INTO `uni_respon_usu` (`id_uni_respon_usu`, `id_unidad`, `id_user`) VALUES
(1, 2, 1),
(2, 3, 2),
(3, 2, 3),
(4, 1, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `uni_respon_usu`
--
ALTER TABLE `uni_respon_usu`
  ADD PRIMARY KEY (`id_uni_respon_usu`),
  ADD KEY `id_unidad` (`id_unidad`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `uni_respon_usu`
--
ALTER TABLE `uni_respon_usu`
  MODIFY `id_uni_respon_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `uni_respon_usu`
--
ALTER TABLE `uni_respon_usu`
  ADD CONSTRAINT `fk_unidad_academica_uni_respon_usu` FOREIGN KEY (`id_unidad`) REFERENCES `unidad_academica` (`id_unidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_uni_respon_usu_id` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
