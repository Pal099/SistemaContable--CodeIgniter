-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2023 a las 00:41:33
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
-- Estructura de tabla para la tabla `cuentacontable`
--

DROP TABLE IF EXISTS `cuentacontable`;
CREATE TABLE `cuentacontable` (
  `IDCuentaContable` int(11) NOT NULL,
  `Codigo_CC` varchar(50) NOT NULL DEFAULT 'NOT NULL',
  `Descripcion_CC` varchar(200) DEFAULT NULL,
  `tipo` enum('Título','Grupo','Subgrupo','Cuenta','Subcuenta','Analítico 1','Analítico 2') NOT NULL,
  `imputable` tinyint(1) DEFAULT NULL,
  `padre_id` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentacontable`
--

INSERT INTO `cuentacontable` (`IDCuentaContable`, `Codigo_CC`, `Descripcion_CC`, `tipo`, `imputable`, `padre_id`, `estado`) VALUES
(30, '2', 'ACTIVO', 'Título', 0, NULL, 1),
(31, '2.1', 'CORRIENTE', 'Título', 0, 30, 1),
(32, '3', 'GASTO DE GESTION', 'Título', 0, NULL, 1),
(33, '3.1', 'GASTO DE GESTION', 'Título', 0, 32, 1),
(34, '5', 'PRUEBA PADRE', 'Título', 0, NULL, 1),
(35, '5.2', 'Prueba hijo', 'Grupo', 0, 34, 1),
(36, '4', 'PASIVO', 'Título', 0, NULL, 1),
(37, '4.1', 'A.P. GASTOS DE GESTION', 'Grupo', 0, 36, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentacontable`
--
ALTER TABLE `cuentacontable`
  ADD PRIMARY KEY (`IDCuentaContable`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentacontable`
--
ALTER TABLE `cuentacontable`
  MODIFY `IDCuentaContable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
