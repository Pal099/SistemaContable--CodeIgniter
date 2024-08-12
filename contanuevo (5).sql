-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2023 a las 09:13:57
-- Versión del servidor: 8.0.33
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
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `ban_id` int NOT NULL,
  `ban_descri` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ban_agente` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ban_telefono` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int NOT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheques`
--

CREATE TABLE `cheques` (
  `che_id` int NOT NULL,
  `che_ctacte` int DEFAULT NULL,
  `Che_fecpago` date DEFAULT NULL,
  `Che_feccobro` date DEFAULT NULL,
  `che_numero` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Che_serie` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Che_monto` int DEFAULT NULL,
  `Che_tipo` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Che_obs` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `che_anulado` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cta_cte_Cta_id` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cta_cte`
--

CREATE TABLE `cta_cte` (
  `Cta_id` int NOT NULL,
  `Cta_banco` int DEFAULT NULL,
  `Cta_descri` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cta_moneda` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Cta_numero` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cta_fecini` date DEFAULT NULL,
  `Cta_feccie` date DEFAULT NULL,
  `bancos_ban_id` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentacontable`
--

CREATE TABLE `cuentacontable` (
  `IDCuentaContable` int NOT NULL,
  `Codigo_CC` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Descripcion_CC` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` enum('Título','Grupo','Subgrupo','Cuenta','Subcuenta','Analítico 1','Analítico 2') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `imputable` tinyint(1) DEFAULT NULL,
  `padre_id` int DEFAULT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentacontable`
--

INSERT INTO `cuentacontable` (`IDCuentaContable`, `Codigo_CC`, `Descripcion_CC`, `tipo`, `imputable`, `padre_id`, `estado`) VALUES
(1, '0', 'asd', 'Grupo', 0, NULL, 1),
(2, '0', 'asdf', 'Subcuenta', 0, NULL, 1),
(3, '0', 'asdxzc', '', 0, NULL, 1),
(4, '12345', 'qwerty', 'Subgrupo', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentacontable_antigua`
--

CREATE TABLE `cuentacontable_antigua` (
  `IDCuentaContable` int NOT NULL,
  `CodigoCuentaContable` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DescripcionCuentaContable` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `plandecuentas_IDCuenta` int NOT NULL,
  `id_user` int NOT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucionpresupuestaria`
--

CREATE TABLE `ejecucionpresupuestaria` (
  `ID_EjecucionPresupuestaria` int NOT NULL,
  `IDCuentaContable` int DEFAULT NULL,
  `MontoEjecutado` int DEFAULT NULL,
  `presupuesto_ID_Presupuesto` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuente_de_financiamiento`
--

CREATE TABLE `fuente_de_financiamiento` (
  `id_ff` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `presupuesto_ID_Presupuesto` int NOT NULL,
  `presupuesto_origen_de_financiamiento_id_of` int NOT NULL,
  `presupuesto_programa_id_pro` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fuente_de_financiamiento`
--

INSERT INTO `fuente_de_financiamiento` (`id_ff`, `nombre`, `codigo`, `estado`, `presupuesto_ID_Presupuesto`, `presupuesto_origen_de_financiamiento_id_of`, `presupuesto_programa_id_pro`, `id_user`) VALUES
(1, 'Intendencia', '150', '1', 0, 0, 0, 0);

--
-- Disparadores `fuente_de_financiamiento`
--
DELIMITER $$
CREATE TRIGGER `fuente_after_insert` AFTER INSERT ON `fuente_de_financiamiento` FOR EACH ROW BEGIN
INSERT INTO num_asi_deta (id_ff) VALUES (NEW.id_ff);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_user`
--

CREATE TABLE `login_user` (
  `id_login_user` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `login_user`
--
DELIMITER $$
CREATE TRIGGER `after_login_trigger` AFTER INSERT ON `login_user` FOR EACH ROW BEGIN
    DECLARE user_count INT;
    
    -- Verificar si el usuario ya tiene registros en la tabla login_user
    SELECT COUNT(*) INTO user_count FROM login_user WHERE id_user = NEW.id_user;
    
    -- Si no hay registros, insertar uno nuevo
    IF user_count = 0 THEN
        INSERT INTO login_user (id_user) VALUES (NEW.id_user);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `num_asi`
--

CREATE TABLE `num_asi` (
  `IDNum_Asi` int NOT NULL,
  `FechaEmision` date DEFAULT NULL,
  `ped_mat` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `modalidad` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_presu` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `unidad_resp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `proyecto` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nro_pac` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nro_exp` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `MontoPagado` int NOT NULL,
  `estado` int NOT NULL,
  `MontoTotal` int DEFAULT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `num_asi_deta`
--

CREATE TABLE `num_asi_deta` (
  `IDNum_Asi_Deta` int NOT NULL,
  `IDCuentaContable` int DEFAULT NULL,
  `MontoPago` int DEFAULT NULL,
  `Debe` int DEFAULT NULL,
  `Haber` int DEFAULT NULL,
  `comprobante` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_of` int NOT NULL,
  `id_pro` int NOT NULL,
  `Num_Asi_IDNum_Asi` int NOT NULL,
  `id_ff` int NOT NULL,
  `cheques_che_id` int NOT NULL,
  `proveedores_id` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `num_asi_deta`
--

INSERT INTO `num_asi_deta` (`IDNum_Asi_Deta`, `IDCuentaContable`, `MontoPago`, `Debe`, `Haber`, `comprobante`, `id_of`, `id_pro`, `Num_Asi_IDNum_Asi`, `id_ff`, `cheques_che_id`, `proveedores_id`, `id_user`) VALUES
(0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 0),
(0, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origen_de_financiamiento`
--

CREATE TABLE `origen_de_financiamiento` (
  `id_of` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `origen_de_financiamiento`
--
DELIMITER $$
CREATE TRIGGER `origen_after_insert` AFTER INSERT ON `origen_de_financiamiento` FOR EACH ROW BEGIN
INSERT INTO num_asi_deta (id_of) VALUES (NEW.id_of);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plandecuentas`
--

CREATE TABLE `plandecuentas` (
  `IDCuenta` int NOT NULL,
  `Nivel1` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Nivel2` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Nivel3` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Nivel4` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Nivel5` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Nivel6` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_caja`
--

CREATE TABLE `plan_caja` (
  `ID_PlanCaja` int NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Entrada` int DEFAULT NULL,
  `Salida` int DEFAULT NULL,
  `plan_financiero_ID_PlanFinanciero` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_financiero`
--

CREATE TABLE `plan_financiero` (
  `ID_PlanFinanciero` int NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Monto` int DEFAULT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE `presupuesto` (
  `ID_Presupuesto` int NOT NULL,
  `Anio` int DEFAULT NULL,
  `Descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TotalPresupuestado` int DEFAULT NULL,
  `origen_de_financiamiento_id_of` int NOT NULL,
  `programa_id_pro` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `ID_Presupuesto` int NOT NULL,
  `Año` int DEFAULT NULL,
  `Descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TotalPresupuestado` int DEFAULT NULL,
  `origen_de_financiamiento_id_of` int NOT NULL,
  `programa_id_pro` int NOT NULL,
  `fuente_de_financiamiento_id_ff` int NOT NULL,
  `TotalModificado` int DEFAULT NULL,
  `mes` date NOT NULL,
  `monto_mes` int NOT NULL,
  `estado` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`ID_Presupuesto`, `Año`, `Descripcion`, `TotalPresupuestado`, `origen_de_financiamiento_id_of`, `programa_id_pro`, `fuente_de_financiamiento_id_ff`, `TotalModificado`, `mes`, `monto_mes`, `estado`) VALUES
(1, NULL, 'Presupuesto prueba', 5000000, 1, 1, 3, 140000000, '0000-00-00', 2147483647, '1'),
(2, NULL, 'Presupuesto prueba', 5000000, 1, 1, 3, 140000000, '0000-00-00', 2147483647, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `id_pro` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int NOT NULL,
  `estado` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_pro`, `nombre`, `codigo`, `id_user`, `estado`) VALUES
(1, 'Recursos Institucionales', '150', 0, '1');

--
-- Disparadores `programa`
--
DELIMITER $$
CREATE TRIGGER `programa_after_insert` AFTER INSERT ON `programa` FOR EACH ROW BEGIN
INSERT INTO num_asi_deta (id_pro) VALUES (NEW.id_pro);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int NOT NULL,
  `ruc` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `razon_social` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacion` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int NOT NULL,
  `estado` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `proveedores`
--
DELIMITER $$
CREATE TRIGGER `id_user_to_proveedores` BEFORE INSERT ON `proveedores` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    SET user_id = (SELECT id_user FROM usuarios WHERE Nombre_usuario = CURRENT_USER());
    SET NEW.id_user = user_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_academica`
--

CREATE TABLE `unidad_academica` (
  `id_unidad` int NOT NULL,
  `unidad` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int NOT NULL,
  `estado` varchar(35) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidad_academica`
--

INSERT INTO `unidad_academica` (`id_unidad`, `unidad`, `id_user`, `estado`) VALUES
(1, 'Derecho', 2, '1'),
(2, 'Politécnica', 1, '1'),
(3, 'Economia', 0, '1'),
(4, 'Fafi', 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int NOT NULL,
  `Nombre_usuario` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `contraseña` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `id_unidad` int NOT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `Nombre_usuario`, `contraseña`, `id_unidad`, `estado`) VALUES
(1, 'palo_99', 'palo123', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`ban_id`);

--
-- Indices de la tabla `cheques`
--
ALTER TABLE `cheques`
  ADD PRIMARY KEY (`che_id`,`cta_cte_Cta_id`),
  ADD KEY `fk_cheques_cta_cte1_idx` (`cta_cte_Cta_id`);

--
-- Indices de la tabla `cta_cte`
--
ALTER TABLE `cta_cte`
  ADD PRIMARY KEY (`Cta_id`,`bancos_ban_id`),
  ADD KEY `fk_cta_cte_bancos1_idx` (`bancos_ban_id`);

--
-- Indices de la tabla `cuentacontable`
--
ALTER TABLE `cuentacontable`
  ADD PRIMARY KEY (`IDCuentaContable`);

--
-- Indices de la tabla `cuentacontable_antigua`
--
ALTER TABLE `cuentacontable_antigua`
  ADD PRIMARY KEY (`IDCuentaContable`),
  ADD KEY `fk_cuentacontable_plandecuentas1_idx` (`plandecuentas_IDCuenta`);

--
-- Indices de la tabla `ejecucionpresupuestaria`
--
ALTER TABLE `ejecucionpresupuestaria`
  ADD PRIMARY KEY (`ID_EjecucionPresupuestaria`),
  ADD KEY `IDCuentaContable` (`IDCuentaContable`),
  ADD KEY `fk_ejecucionpresupuestaria_presupuesto1_idx` (`presupuesto_ID_Presupuesto`);

--
-- Indices de la tabla `fuente_de_financiamiento`
--
ALTER TABLE `fuente_de_financiamiento`
  ADD PRIMARY KEY (`id_ff`,`presupuesto_ID_Presupuesto`,`presupuesto_origen_de_financiamiento_id_of`,`presupuesto_programa_id_pro`),
  ADD KEY `fk_fuente_de_financiamiento_presupuesto1_idx` (`presupuesto_ID_Presupuesto`,`presupuesto_origen_de_financiamiento_id_of`,`presupuesto_programa_id_pro`);

--
-- Indices de la tabla `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`id_login_user`);

--
-- Indices de la tabla `num_asi`
--
ALTER TABLE `num_asi`
  ADD PRIMARY KEY (`IDNum_Asi`);

--
-- Indices de la tabla `num_asi_deta`
--
ALTER TABLE `num_asi_deta`
  ADD PRIMARY KEY (`IDNum_Asi_Deta`,`id_of`,`id_pro`,`Num_Asi_IDNum_Asi`,`id_ff`),
  ADD KEY `IDCuentaContable` (`IDCuentaContable`),
  ADD KEY `fk_Num_Asi_Deta_origen_de_financiamiento1_idx` (`id_of`),
  ADD KEY `fk_Num_Asi_Deta_programa1_idx` (`id_pro`),
  ADD KEY `fk_Num_Asi_Deta_Num_Asi1_idx` (`Num_Asi_IDNum_Asi`),
  ADD KEY `fk_Num_Asi_Deta_fuente_de_financiamiento1_idx` (`id_ff`),
  ADD KEY `fk_Num_Asi_Deta_cheques1_idx` (`cheques_che_id`),
  ADD KEY `fk_Num_Asi_Deta_proveedores1_idx` (`proveedores_id`);

--
-- Indices de la tabla `origen_de_financiamiento`
--
ALTER TABLE `origen_de_financiamiento`
  ADD PRIMARY KEY (`id_of`);

--
-- Indices de la tabla `plandecuentas`
--
ALTER TABLE `plandecuentas`
  ADD PRIMARY KEY (`IDCuenta`);

--
-- Indices de la tabla `plan_caja`
--
ALTER TABLE `plan_caja`
  ADD PRIMARY KEY (`ID_PlanCaja`),
  ADD KEY `fk_plan_caja_plan_financiero1_idx` (`plan_financiero_ID_PlanFinanciero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentacontable`
--
ALTER TABLE `cuentacontable`
  MODIFY `IDCuentaContable` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
