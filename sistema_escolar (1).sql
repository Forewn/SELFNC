-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2024 a las 11:24:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_escolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `años`
--

CREATE TABLE `años` (
  `id_año` int(11) NOT NULL,
  `año` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `años`
--

INSERT INTO `años` (`id_año`, `año`) VALUES
(1, '1ro'),
(2, '2do'),
(3, '3ro'),
(4, '4to'),
(5, '5to');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletin`
--

CREATE TABLE `boletin` (
  `id_boletin` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boletin`
--

INSERT INTO `boletin` (`id_boletin`, `id_inscripcion`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `cedula_estudiante` int(11) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `fecha_nac` date NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `genero` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`cedula_estudiante`, `nombres`, `fecha_nac`, `direccion`, `telefono`, `correo`, `genero`) VALUES
(22222222, 'Daniel Parra', '2002-06-03', 'En el monte', '04247500250', 'parra@masters.com', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `estudiantes_cedula_estudiante` int(11) NOT NULL,
  `cedula_representante` int(11) NOT NULL,
  `id_seccion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id_inscripcion`, `estudiantes_cedula_estudiante`, `cedula_representante`, `id_seccion`) VALUES
(1, 22222222, 11111111, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `materia` varchar(45) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_año` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `materia`, `id_tipo`, `id_año`) VALUES
(1, 'Matematica', 1, 1),
(2, 'Cultura', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_notas` int(11) NOT NULL,
  `id_profesor_materia_seccion` varchar(45) NOT NULL,
  `1er_lapso` varchar(5) NOT NULL,
  `2do_lapso` varchar(5) NOT NULL,
  `3er_lapso` varchar(5) NOT NULL,
  `nota_final` varchar(5) NOT NULL,
  `boletin_id_boletin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_notas`, `id_profesor_materia_seccion`, `1er_lapso`, `2do_lapso`, `3er_lapso`, `nota_final`, `boletin_id_boletin`) VALUES
(1, '1', 'A', 'C', 'B', 'B', 1),
(2, '2', '10', '20', '20', '16.6', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentezcos`
--

CREATE TABLE `parentezcos` (
  `id_parentezco` int(11) NOT NULL,
  `parentezco` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parentezcos`
--

INSERT INTO `parentezcos` (`id_parentezco`, `parentezco`) VALUES
(1, 'Mamá'),
(2, 'Papá'),
(3, 'Hermano/a'),
(4, 'Abuelo/a'),
(5, 'Tío/a'),
(6, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_academico`
--

CREATE TABLE `periodo_academico` (
  `id_periodo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodo_academico`
--

INSERT INTO `periodo_academico` (`id_periodo`, `nombre`, `fecha_inicio`, `fecha_fin`, `status`) VALUES
(1, '2024-2025', '2024-09-16', '2025-06-13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `cedula_profesor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` text NOT NULL,
  `correo` text NOT NULL,
  `genero` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`cedula_profesor`, `nombre`, `telefono`, `direccion`, `correo`, `genero`) VALUES
(29545423, 'Angelo Isaac Toscano', '04247500258', 'no tiene casa', 'aga@gmail.com', 'M'),
(29699505, 'Jhosmar Suarez', '04247420767', 'sizarra ieja', 'a@gmail.com', 'M'),
(30110969, 'Eliana Perez', '04147212442', 'Miau', 'notengo@gmail.com', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_materias`
--

CREATE TABLE `profesores_materias` (
  `id_profesor_materia` varchar(45) NOT NULL,
  `profesores_cedula_profesor` int(11) NOT NULL,
  `materias_id_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores_materias`
--

INSERT INTO `profesores_materias` (`id_profesor_materia`, `profesores_cedula_profesor`, `materias_id_materia`) VALUES
('1', 29545423, 2),
('2', 29545423, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_materias_seccion`
--

CREATE TABLE `profesor_materias_seccion` (
  `id_profesor_materia_seccion` varchar(45) NOT NULL,
  `id_seccion` varchar(30) NOT NULL,
  `id_profesor_materia` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor_materias_seccion`
--

INSERT INTO `profesor_materias_seccion` (`id_profesor_materia_seccion`, `id_seccion`, `id_profesor_materia`) VALUES
('1', '1', '1'),
('2', '1', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representante_legal`
--

CREATE TABLE `representante_legal` (
  `cedula_representante_legal` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `direccion` text NOT NULL,
  `fecha_nac` date DEFAULT NULL,
  `sexo` char(2) NOT NULL,
  `id_parentezco` int(11) NOT NULL,
  `profesion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `representante_legal`
--

INSERT INTO `representante_legal` (`cedula_representante_legal`, `nombre`, `telefono`, `correo`, `direccion`, `fecha_nac`, `sexo`, `id_parentezco`, `profesion`) VALUES
(11111111, 'Papa de Parra', '11111111', 'papadeparra@eloriginal.com', 'en el mismo monte que parra', '1985-06-10', 'M', 2, 'No hay profesión como ser papa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'Profesor'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id_seccion` varchar(30) NOT NULL,
  `id_año` int(11) NOT NULL,
  `letra` char(2) NOT NULL,
  `cedula_tutor` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id_seccion`, `id_año`, `letra`, `cedula_tutor`, `id_periodo`) VALUES
('1', 1, 'U', 29545423, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_materia`
--

CREATE TABLE `tipo_materia` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_materia`
--

INSERT INTO `tipo_materia` (`id_tipo`, `tipo`) VALUES
(1, 'Cuantitativa'),
(2, 'Cualitativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(65) NOT NULL,
  `status` char(2) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `cedula_profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `password`, `status`, `id_rol`, `cedula_profesor`) VALUES
(0, 'Elibook', '3d2172418ce305c7d16d4b05597c6a59', '1', 1, 30110969),
(1, 'Aga222', '$2y$10$0yCDCMoInSgsgh1MojTcCOVB.8zdfYd9bqYKy0XxyfHreQkk32LCm', '1', 1, 29545423),
(12, 'Forewn', 'b7bc2a2f5bb6d521e64c8974c143e9a0', '1', 2, 29699505);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `años`
--
ALTER TABLE `años`
  ADD PRIMARY KEY (`id_año`);

--
-- Indices de la tabla `boletin`
--
ALTER TABLE `boletin`
  ADD PRIMARY KEY (`id_boletin`),
  ADD KEY `fk_boletin_inscripcion1_idx` (`id_inscripcion`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`cedula_estudiante`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `fk_inscripcion_estudiantes1_idx` (`estudiantes_cedula_estudiante`),
  ADD KEY `fk_inscripcion_representante_legal1_idx` (`cedula_representante`),
  ADD KEY `fk_inscripcion_seccion1_idx` (`id_seccion`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `fk_materias_tipo_tabla1_idx` (`id_tipo`),
  ADD KEY `id_año` (`id_año`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_notas`) USING BTREE,
  ADD KEY `fk_boletin_profesor_materias_seccion1_idx` (`id_profesor_materia_seccion`),
  ADD KEY `fk_notas_boletin1_idx` (`boletin_id_boletin`);

--
-- Indices de la tabla `parentezcos`
--
ALTER TABLE `parentezcos`
  ADD PRIMARY KEY (`id_parentezco`);

--
-- Indices de la tabla `periodo_academico`
--
ALTER TABLE `periodo_academico`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`cedula_profesor`);

--
-- Indices de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD PRIMARY KEY (`id_profesor_materia`),
  ADD KEY `fk_profesores_has_materias_materias1_idx` (`materias_id_materia`),
  ADD KEY `fk_profesores_has_materias_profesores1_idx` (`profesores_cedula_profesor`);

--
-- Indices de la tabla `profesor_materias_seccion`
--
ALTER TABLE `profesor_materias_seccion`
  ADD PRIMARY KEY (`id_profesor_materia_seccion`),
  ADD KEY `fk_materias_has_seccion_seccion1_idx` (`id_seccion`),
  ADD KEY `fk_materias/seccion_profesores/materias1_idx` (`id_profesor_materia`);

--
-- Indices de la tabla `representante_legal`
--
ALTER TABLE `representante_legal`
  ADD PRIMARY KEY (`cedula_representante_legal`),
  ADD KEY `fk_representante_legal_parentezcos1_idx` (`id_parentezco`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id_seccion`),
  ADD KEY `fk_seccion_años1_idx` (`id_año`),
  ADD KEY `fk_seccion_profesores1_idx` (`cedula_tutor`),
  ADD KEY `fk_seccion_periodo_academico1_idx` (`id_periodo`);

--
-- Indices de la tabla `tipo_materia`
--
ALTER TABLE `tipo_materia`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD KEY `fk_usuarios_roles_idx` (`id_rol`),
  ADD KEY `fk_usuarios_profesores1_idx` (`cedula_profesor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_notas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletin`
--
ALTER TABLE `boletin`
  ADD CONSTRAINT `fk_boletin_inscripcion1` FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripcion` (`id_inscripcion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_inscripcion_estudiantes1` FOREIGN KEY (`estudiantes_cedula_estudiante`) REFERENCES `estudiantes` (`cedula_estudiante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_representante_legal1` FOREIGN KEY (`cedula_representante`) REFERENCES `representante_legal` (`cedula_representante_legal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_seccion1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_materias_tipo_tabla1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_materia` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_año`) REFERENCES `años` (`id_año`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `fk_boletin_profesor_materias_seccion1` FOREIGN KEY (`id_profesor_materia_seccion`) REFERENCES `profesor_materias_seccion` (`id_profesor_materia_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notas_boletin1` FOREIGN KEY (`boletin_id_boletin`) REFERENCES `boletin` (`id_boletin`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD CONSTRAINT `fk_profesores_has_materias_materias1` FOREIGN KEY (`materias_id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profesores_has_materias_profesores1` FOREIGN KEY (`profesores_cedula_profesor`) REFERENCES `profesores` (`cedula_profesor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profesor_materias_seccion`
--
ALTER TABLE `profesor_materias_seccion`
  ADD CONSTRAINT `fk_materias/seccion_profesores/materias1` FOREIGN KEY (`id_profesor_materia`) REFERENCES `profesores_materias` (`id_profesor_materia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materias_has_seccion_seccion1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `representante_legal`
--
ALTER TABLE `representante_legal`
  ADD CONSTRAINT `fk_representante_legal_parentezcos1` FOREIGN KEY (`id_parentezco`) REFERENCES `parentezcos` (`id_parentezco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `fk_seccion_años1` FOREIGN KEY (`id_año`) REFERENCES `años` (`id_año`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seccion_periodo_academico1` FOREIGN KEY (`id_periodo`) REFERENCES `periodo_academico` (`id_periodo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seccion_profesores1` FOREIGN KEY (`cedula_tutor`) REFERENCES `profesores` (`cedula_profesor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
