-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2023 a las 18:49:26
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
-- Estructura de tabla para la tabla `presupuestos`
--

DROP TABLE IF EXISTS `presupuestos`;
CREATE TABLE `presupuestos` (
  `ID_Presupuesto` int(11) NOT NULL,
  `origen_de_financiamiento_id_of` int(11) NOT NULL,
  `fuente_de_financiamiento_id_ff` int(11) NOT NULL,
  `programa_id_pro` int(11) NOT NULL,
  `Idcuentacontable` int(11) NOT NULL,
  `Año` int(11) NOT NULL,
  `TotalPresupuestado` int(11) NOT NULL,
  `TotalModificado` int(11) DEFAULT NULL,
  `pre_ene` int(11) DEFAULT NULL,
  `pre_feb` int(11) DEFAULT NULL,
  `pre_mar` int(11) DEFAULT NULL,
  `pre_abr` int(11) DEFAULT NULL,
  `pre_may` int(11) DEFAULT NULL,
  `pre_jun` int(11) DEFAULT NULL,
  `pre_jul` int(11) DEFAULT NULL,
  `pre_ago` int(11) DEFAULT NULL,
  `pre_sep` int(11) DEFAULT NULL,
  `pre_oct` int(11) DEFAULT NULL,
  `pre_nov` int(11) DEFAULT NULL,
  `pre_dic` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`ID_Presupuesto`, `origen_de_financiamiento_id_of`, `fuente_de_financiamiento_id_ff`, `programa_id_pro`, `Idcuentacontable`, `Año`, `TotalPresupuestado`, `TotalModificado`, `pre_ene`, `pre_feb`, `pre_mar`, `pre_abr`, `pre_may`, `pre_jun`, `pre_jul`, `pre_ago`, `pre_sep`, `pre_oct`, `pre_nov`, `pre_dic`, `estado`) VALUES
(1, 2, 1, 1, 1, 2023, 1200000, 5000, NULL, NULL, NULL, NULL, NULL, 20000, NULL, NULL, NULL, NULL, NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`ID_Presupuesto`),
  ADD KEY `origen_de_financiamiento_id_of` (`origen_de_financiamiento_id_of`),
  ADD KEY `fuente_de_financiamiento_id_ff` (`fuente_de_financiamiento_id_ff`),
  ADD KEY `programa_id_pro` (`programa_id_pro`),
  ADD KEY `Idcuentacontable` (`Idcuentacontable`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `ID_Presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `fk_cc_presu` FOREIGN KEY (`Idcuentacontable`) REFERENCES `cuentacontable` (`IDCuentaContable`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ff_presu` FOREIGN KEY (`fuente_de_financiamiento_id_ff`) REFERENCES `fuente_de_financiamiento` (`id_ff`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_of_presu` FOREIGN KEY (`origen_de_financiamiento_id_of`) REFERENCES `origen_de_financiamiento` (`id_of`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pro_presu` FOREIGN KEY (`programa_id_pro`) REFERENCES `programa` (`id_pro`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
