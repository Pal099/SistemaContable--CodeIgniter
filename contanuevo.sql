-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2023 a las 02:01:03
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

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `IsFirstLogin` (`userId` INT) RETURNS TINYINT(1)  BEGIN
    DECLARE firstLogin BOOLEAN;
    
    -- Verificar si el usuario ya tiene registros en la tabla login_user
    SELECT COUNT(*) INTO firstLogin FROM login_user WHERE id_user = userId;
    
    -- Si no hay registros, es la primera vez
    IF firstLogin = 0 THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `obtener_id_usuario` (`username` VARCHAR(255)) RETURNS INT(11)  BEGIN
    DECLARE user_id INT;
    SELECT id_user INTO user_id FROM usuarios WHERE Nombre_usuario = username;
    RETURN user_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `ban_id` int(11) NOT NULL,
  `ban_descri` varchar(100) DEFAULT NULL,
  `ban_agente` varchar(100) DEFAULT NULL,
  `ban_telefono` varchar(50) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheques`
--

CREATE TABLE `cheques` (
  `che_id` int(11) NOT NULL,
  `che_ctacte` int(11) DEFAULT NULL,
  `Che_fecpago` date DEFAULT NULL,
  `Che_feccobro` date DEFAULT NULL,
  `che_numero` varchar(20) DEFAULT NULL,
  `Che_serie` varchar(10) DEFAULT NULL,
  `Che_monto` int(11) DEFAULT NULL,
  `Che_tipo` varchar(20) DEFAULT NULL,
  `Che_obs` varchar(20) DEFAULT NULL,
  `che_anulado` varchar(10) DEFAULT NULL,
  `cta_cte_Cta_id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cta_cte`
--

CREATE TABLE `cta_cte` (
  `Cta_id` int(11) NOT NULL,
  `Cta_banco` int(11) DEFAULT NULL,
  `Cta_descri` varchar(100) DEFAULT NULL,
  `cta_moneda` varchar(20) DEFAULT NULL,
  `Cta_numero` varchar(25) DEFAULT NULL,
  `cta_fecini` date DEFAULT NULL,
  `Cta_feccie` date DEFAULT NULL,
  `bancos_ban_id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentacontable`
--

CREATE TABLE `cuentacontable` (
  `IDCuentaContable` int(11) NOT NULL,
  `CodigoCuentaContable` varchar(50) NOT NULL,
  `DescripcionCuentaContable` varchar(200) NOT NULL,
  `plandecuentas_IDCuenta` int(11) NOT NULL,
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentacontables`
--

CREATE TABLE `cuentacontables` (
  `IDCuentaContable` int(11) NOT NULL,
  `Codigo_CC` varchar(50) NOT NULL DEFAULT 'NOT NULL',
  `Descripcion_CC` varchar(200) DEFAULT NULL,
  `tipo` enum('Título','Grupo','Subgrupo','Cuenta','Subcuenta','Analítico 1','Analítico 2') NOT NULL,
  `imputable` tinyint(1) DEFAULT NULL,
  `padre_id` int(11) DEFAULT NULL,
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucionpresupuestaria`
--

CREATE TABLE `ejecucionpresupuestaria` (
  `ID_EjecucionPresupuestaria` int(11) NOT NULL,
  `IDCuentaContable` int(11) DEFAULT NULL,
  `MontoEjecutado` int(11) DEFAULT NULL,
  `presupuesto_ID_Presupuesto` int(11) NOT NULL,
  `id_uni_respon_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuente_de_financiamiento`
--

CREATE TABLE `fuente_de_financiamiento` (
  `id_ff` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `presupuesto_ID_Presupuesto` int(11) NOT NULL,
  `presupuesto_origen_de_financiamiento_id_of` int(11) NOT NULL,
  `presupuesto_programa_id_pro` int(11) NOT NULL,
  `id_uni_respon_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fuente_de_financiamiento`
--

INSERT INTO `fuente_de_financiamiento` (`id_ff`, `nombre`, `codigo`, `estado`, `presupuesto_ID_Presupuesto`, `presupuesto_origen_de_financiamiento_id_of`, `presupuesto_programa_id_pro`, `id_uni_respon_usu`) VALUES
(1, 'Fondos Internos', '1/1/5', '1', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_user`
--

CREATE TABLE `login_user` (
  `id_login_user` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
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
  `IDNum_Asi` int(11) NOT NULL,
  `FechaEmision` date NOT NULL DEFAULT current_timestamp(),
  `num_asi` int(100) NOT NULL,
  `op` int(11) NOT NULL,
  `ped_mat` varchar(45) DEFAULT NULL,
  `modalidad` varchar(45) DEFAULT NULL,
  `tipo_presu` varchar(45) DEFAULT NULL,
  `unidad_resp` varchar(50) NOT NULL,
  `proyecto` varchar(50) DEFAULT NULL,
  `nro_pac` varchar(50) DEFAULT NULL,
  `nro_exp` varchar(45) DEFAULT NULL,
  `MontoPagado` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `MontoTotal` int(11) DEFAULT NULL,
  `id_provee` int(11) NOT NULL,
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `num_asi_deta`
--

CREATE TABLE `num_asi_deta` (
  `IDNum_Asi_Deta` int(11) NOT NULL,
  `numero` int(255) NOT NULL,
  `IDCuentaContable` int(11) DEFAULT NULL,
  `MontoPago` int(11) DEFAULT NULL,
  `Debe` int(255) DEFAULT NULL,
  `Haber` int(255) DEFAULT NULL,
  `comprobante` varchar(45) DEFAULT NULL,
  `id_of` int(11) NOT NULL,
  `id_pro` int(11) NOT NULL,
  `Num_Asi_IDNum_Asi` int(11) NOT NULL,
  `id_ff` int(11) NOT NULL,
  `cheques_che_id` int(11) NOT NULL,
  `proveedores_id` int(11) NOT NULL,
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origen_de_financiamiento`
--

CREATE TABLE `origen_de_financiamiento` (
  `id_of` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `id_uni_respon_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `origen_de_financiamiento`
--

INSERT INTO `origen_de_financiamiento` (`id_of`, `nombre`, `codigo`, `estado`, `id_uni_respon_usu`) VALUES
(1, 'Junta Municipal', '1/2', '1', 4),
(2, 'Municipalidad', '1/1', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plandecuentas`
--

CREATE TABLE `plandecuentas` (
  `IDCuenta` int(11) NOT NULL,
  `Nivel1` varchar(100) DEFAULT NULL,
  `Nivel2` varchar(100) DEFAULT NULL,
  `Nivel3` varchar(100) DEFAULT NULL,
  `Nivel4` varchar(100) DEFAULT NULL,
  `Nivel5` varchar(100) DEFAULT NULL,
  `Nivel6` varchar(100) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_caja`
--

CREATE TABLE `plan_caja` (
  `ID_PlanCaja` int(11) NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Entrada` int(11) DEFAULT NULL,
  `Salida` int(11) DEFAULT NULL,
  `plan_financiero_ID_PlanFinanciero` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_financiero`
--

CREATE TABLE `plan_financiero` (
  `ID_PlanFinanciero` int(11) NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Monto` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

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
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `id_pro` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_pro`, `nombre`, `codigo`, `id_uni_respon_usu`, `estado`) VALUES
(1, 'Recursos Institucionales', '111', 2, '1'),
(2, 'Intendencia', '112', 4, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `ruc` varchar(100) DEFAULT NULL,
  `razon_social` varchar(200) DEFAULT NULL,
  `direccion` varchar(20) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `observacion` varchar(45) DEFAULT NULL,
  `id_uni_respon_usu` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `ruc`, `razon_social`, `direccion`, `telefono`, `email`, `observacion`, `id_uni_respon_usu`, `estado`) VALUES
(1, '100', 'Inmobiliaria', 'Avenida siempre viva', '0981 099 101', 'probando123@gmail.com', 'obsss 1', 3, '1'),
(2, '200', 'Bancomer S.A.', 'Avda. Los Caballos', '0589 655 889', 'prueba@gmail-com', 'obsss 12', 2, '1'),
(3, '500', 'Entidad Inmck', 'Avda. Capitan Americ', '85555', 'hola@gmail.com', 'obsss', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_academica`
--

CREATE TABLE `unidad_academica` (
  `id_unidad` int(11) NOT NULL,
  `unidad` varchar(35) NOT NULL,
  `estado` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidad_academica`
--

INSERT INTO `unidad_academica` (`id_unidad`, `unidad`, `estado`) VALUES
(1, 'Derecho', '1'),
(2, 'Politecnica', '1'),
(3, 'Economia', '1'),
(4, 'FAFI', '1');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `Nombre_usuario` varchar(25) NOT NULL,
  `contraseña` varchar(500) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `Nombre_usuario`, `contraseña`, `id_unidad`, `estado`) VALUES
(1, 'palo_99', 'bc8bcf6c670c02e7288ec8fc5f7192483bed586e', 2, 1),
(2, 'adrian', '58e71360c3359fdde64fef0b005892eb85443391', 3, 1),
(3, 'mara', 'ac7d32e3c0f61ebc7dfd1ee010f24537314eec2e', 2, 1),
(4, 'karen', '63a8ecb98554a55cfe55c25b7f3967b931491b7d', 1, 1);

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
  ADD PRIMARY KEY (`IDCuentaContable`),
  ADD KEY `fk_cuentacontable_plandecuentas1_idx` (`plandecuentas_IDCuenta`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

--
-- Indices de la tabla `cuentacontables`
--
ALTER TABLE `cuentacontables`
  ADD PRIMARY KEY (`IDCuentaContable`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

--
-- Indices de la tabla `ejecucionpresupuestaria`
--
ALTER TABLE `ejecucionpresupuestaria`
  ADD PRIMARY KEY (`ID_EjecucionPresupuestaria`),
  ADD KEY `IDCuentaContable` (`IDCuentaContable`),
  ADD KEY `fk_ejecucionpresupuestaria_presupuesto1_idx` (`presupuesto_ID_Presupuesto`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

--
-- Indices de la tabla `fuente_de_financiamiento`
--
ALTER TABLE `fuente_de_financiamiento`
  ADD PRIMARY KEY (`id_ff`,`presupuesto_ID_Presupuesto`,`presupuesto_origen_de_financiamiento_id_of`,`presupuesto_programa_id_pro`),
  ADD KEY `fk_fuente_de_financiamiento_presupuesto1_idx` (`presupuesto_ID_Presupuesto`,`presupuesto_origen_de_financiamiento_id_of`,`presupuesto_programa_id_pro`),
  ADD KEY `fk_uni_respon_usu_ff` (`id_uni_respon_usu`);

--
-- Indices de la tabla `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`id_login_user`);

--
-- Indices de la tabla `num_asi`
--
ALTER TABLE `num_asi`
  ADD PRIMARY KEY (`IDNum_Asi`),
  ADD KEY `id_provee` (`id_provee`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

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
  ADD KEY `fk_Num_Asi_Deta_proveedores1_idx` (`proveedores_id`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

--
-- Indices de la tabla `origen_de_financiamiento`
--
ALTER TABLE `origen_de_financiamiento`
  ADD PRIMARY KEY (`id_of`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

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
-- Indices de la tabla `plan_financiero`
--
ALTER TABLE `plan_financiero`
  ADD PRIMARY KEY (`ID_PlanFinanciero`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`ID_Presupuesto`),
  ADD KEY `origen_de_financiamiento_id_of` (`origen_de_financiamiento_id_of`),
  ADD KEY `fuente_de_financiamiento_id_ff` (`fuente_de_financiamiento_id_ff`),
  ADD KEY `programa_id_pro` (`programa_id_pro`),
  ADD KEY `Idcuentacontable` (`Idcuentacontable`),
  ADD KEY `id_uni_respon_usu` (`id_uni_respon_usu`);

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`id_pro`),
  ADD KEY `fk_uni_respon_usu_programa` (`id_uni_respon_usu`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_uni_respon_usu` (`id_uni_respon_usu`);

--
-- Indices de la tabla `unidad_academica`
--
ALTER TABLE `unidad_academica`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `uni_respon_usu`
--
ALTER TABLE `uni_respon_usu`
  ADD PRIMARY KEY (`id_uni_respon_usu`),
  ADD KEY `id_unidad` (`id_unidad`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user_index` (`id_user`),
  ADD KEY `id_unidad` (`id_unidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `ban_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cheques`
--
ALTER TABLE `cheques`
  MODIFY `che_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cta_cte`
--
ALTER TABLE `cta_cte`
  MODIFY `Cta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentacontable`
--
ALTER TABLE `cuentacontable`
  MODIFY `IDCuentaContable` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentacontables`
--
ALTER TABLE `cuentacontables`
  MODIFY `IDCuentaContable` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejecucionpresupuestaria`
--
ALTER TABLE `ejecucionpresupuestaria`
  MODIFY `ID_EjecucionPresupuestaria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fuente_de_financiamiento`
--
ALTER TABLE `fuente_de_financiamiento`
  MODIFY `id_ff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `login_user`
--
ALTER TABLE `login_user`
  MODIFY `id_login_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `num_asi`
--
ALTER TABLE `num_asi`
  MODIFY `IDNum_Asi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `num_asi_deta`
--
ALTER TABLE `num_asi_deta`
  MODIFY `IDNum_Asi_Deta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `origen_de_financiamiento`
--
ALTER TABLE `origen_de_financiamiento`
  MODIFY `id_of` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `ID_Presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidad_academica`
--
ALTER TABLE `unidad_academica`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `uni_respon_usu`
--
ALTER TABLE `uni_respon_usu`
  MODIFY `id_uni_respon_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cheques`
--
ALTER TABLE `cheques`
  ADD CONSTRAINT `fk_cheques_cta_cte1` FOREIGN KEY (`cta_cte_Cta_id`) REFERENCES `cta_cte` (`Cta_id`);

--
-- Filtros para la tabla `cta_cte`
--
ALTER TABLE `cta_cte`
  ADD CONSTRAINT `fk_cta_cte_bancos1` FOREIGN KEY (`bancos_ban_id`) REFERENCES `bancos` (`ban_id`);

--
-- Filtros para la tabla `cuentacontables`
--
ALTER TABLE `cuentacontables`
  ADD CONSTRAINT `fk_id_uni_respon_usu_cuenctacontables` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ejecucionpresupuestaria`
--
ALTER TABLE `ejecucionpresupuestaria`
  ADD CONSTRAINT `fk_ejecucionpresupuestaria_presupuesto1` FOREIGN KEY (`presupuesto_ID_Presupuesto`) REFERENCES `presupuesto` (`ID_Presupuesto`),
  ADD CONSTRAINT `fk_id_cuentacontable_ejecucionpresu` FOREIGN KEY (`IDCuentaContable`) REFERENCES `cuentacontables` (`IDCuentaContable`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_uni_respon_usu_ejecucionpresupuestaria` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fuente_de_financiamiento`
--
ALTER TABLE `fuente_de_financiamiento`
  ADD CONSTRAINT `fk_uni_respon_usu_ff` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `num_asi`
--
ALTER TABLE `num_asi`
  ADD CONSTRAINT `fk_proveedores_numasi` FOREIGN KEY (`id_provee`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_uni_respon_usu_numasi` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `num_asi_deta`
--
ALTER TABLE `num_asi_deta`
  ADD CONSTRAINT `fk_fuentes_numasideta` FOREIGN KEY (`id_ff`) REFERENCES `fuente_de_financiamiento` (`id_ff`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_cuentacontable_numasideta` FOREIGN KEY (`IDCuentaContable`) REFERENCES `cuentacontables` (`IDCuentaContable`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_numasi_numasideta` FOREIGN KEY (`Num_Asi_IDNum_Asi`) REFERENCES `num_asi` (`IDNum_Asi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_origen_numasideta` FOREIGN KEY (`id_of`) REFERENCES `origen_de_financiamiento` (`id_of`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_programa_numasideta` FOREIGN KEY (`id_pro`) REFERENCES `programa` (`id_pro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_uni_respon_usu_numasideta` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_numasideta` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `origen_de_financiamiento`
--
ALTER TABLE `origen_de_financiamiento`
  ADD CONSTRAINT `fk_id_uni_respon_usu_origen` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `plan_caja`
--
ALTER TABLE `plan_caja`
  ADD CONSTRAINT `fk_plan_caja_plan_financiero1` FOREIGN KEY (`plan_financiero_ID_PlanFinanciero`) REFERENCES `plan_financiero` (`ID_PlanFinanciero`);

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `fk_cuenta_contable_presu` FOREIGN KEY (`Idcuentacontable`) REFERENCES `cuentacontables` (`IDCuentaContable`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fuente_finan_presu` FOREIGN KEY (`fuente_de_financiamiento_id_ff`) REFERENCES `fuente_de_financiamiento` (`id_ff`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_programa_presu` FOREIGN KEY (`programa_id_pro`) REFERENCES `programa` (`id_pro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_uni_respon_usu_presu` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_origen_finan_presu` FOREIGN KEY (`origen_de_financiamiento_id_of`) REFERENCES `origen_de_financiamiento` (`id_of`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `fk_uni_respon_usu_programa` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_id_uni_respon_usu` FOREIGN KEY (`id_uni_respon_usu`) REFERENCES `uni_respon_usu` (`id_uni_respon_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `uni_respon_usu`
--
ALTER TABLE `uni_respon_usu`
  ADD CONSTRAINT `fk_unidad_academica_uni_respon_usu` FOREIGN KEY (`id_unidad`) REFERENCES `unidad_academica` (`id_unidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_uni_respon_usu_id` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_unidad_id` FOREIGN KEY (`id_unidad`) REFERENCES `unidad_academica` (`id_unidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
