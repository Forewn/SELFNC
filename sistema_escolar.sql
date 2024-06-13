-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2024 a las 23:57:29
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
-- Estructura de tabla para la tabla `alum_secc`
--

CREATE TABLE `alum_secc` (
  `idaluse` int(11) NOT NULL,
  `idsec` int(11) NOT NULL,
  `idstu` int(11) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asisten_alumn`
--

CREATE TABLE `asisten_alumn` (
  `idasisa` int(11) NOT NULL,
  `idstu` int(11) NOT NULL,
  `idtea` int(11) NOT NULL,
  `idsec` int(11) NOT NULL,
  `presen` varchar(30) NOT NULL,
  `fecha_create` date NOT NULL,
  `fechre` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course`
--

CREATE TABLE `course` (
  `idcur` int(11) NOT NULL,
  `nomcur` varchar(100) NOT NULL,
  `idper` int(11) NOT NULL,
  `iddeg` int(11) NOT NULL,
  `idsub` int(11) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `estado` char(1) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `course`
--

INSERT INTO `course` (`idcur`, `nomcur`, `idper`, `iddeg`, `idsub`, `foto`, `estado`, `fere`) VALUES
(10, 'Matematica I', 8, 9, 13, '170894.jpg', '1', '2024-06-04 22:02:03'),
(11, 'Geologia', 8, 9, 13, '440992.jpg', '1', '2024-06-04 22:59:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `degree`
--

CREATE TABLE `degree` (
  `iddeg` int(11) NOT NULL,
  `idper` int(11) NOT NULL,
  `nomgra` varchar(25) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `degree`
--

INSERT INTO `degree` (`iddeg`, `idper`, `nomgra`, `fere`) VALUES
(9, 8, 'Secundaria', '2024-06-04 18:37:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `idstu` int(11) NOT NULL,
  `dnist` char(8) NOT NULL,
  `nomstu` varchar(25) NOT NULL,
  `edast` varchar(20) NOT NULL,
  `direce` varchar(150) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `nmrotelefono` varchar(12) NOT NULL,
  `sexes` varchar(15) NOT NULL,
  `fenac` date NOT NULL,
  `foto` varchar(150) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `state` char(1) NOT NULL,
  `rol` char(1) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`idstu`, `dnist`, `nomstu`, `edast`, `direce`, `correo`, `nmrotelefono`, `sexes`, `fenac`, `foto`, `usuario`, `clave`, `state`, `rol`, `fere`) VALUES
(17, '39213333', 'Pedro Perez', '23', 'Tilines CA', 'Aga@gmail.com', '0412333', 'Masculino', '2024-06-05', '928333.jpg', '', '', '1', '', '2024-06-04 21:53:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padres`
--

CREATE TABLE `padres` (
  `idfa` int(11) NOT NULL,
  `dnifa` char(8) NOT NULL,
  `nomfa` varchar(30) NOT NULL,
  `profefa` varchar(150) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `telefa` char(9) NOT NULL,
  `direc` varchar(150) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` char(1) NOT NULL,
  `state` char(1) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `padres`
--

INSERT INTO `padres` (`idfa`, `dnifa`, `nomfa`, `profefa`, `correo`, `telefa`, `direc`, `foto`, `usuario`, `clave`, `rol`, `state`, `fere`) VALUES
(5, '34133111', 'Pedro Perez', 'Comerciante', 'adsfa@gmail.com', '0412333', 'Tilines CA', '411848.jpg', '', '', '', '', '2024-06-04 20:38:26'),
(6, '24311333', 'Pedro Pereze', 'Comerciante', 'adsfa@gmail.com', '0412333', 'Tilines CA', '150887.jpg', '', '', '', '1', '2024-06-04 20:39:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `period`
--

CREATE TABLE `period` (
  `idper` int(11) NOT NULL,
  `numperi` char(11) NOT NULL,
  `starperi` date NOT NULL,
  `endperi` date NOT NULL,
  `nomperi` varchar(150) NOT NULL,
  `state` varchar(15) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `period`
--

INSERT INTO `period` (`idper`, `numperi`, `starperi`, `endperi`, `nomperi`, `state`, `fere`) VALUES
(8, '2024-2', '2024-10-16', '2024-07-01', 'Octubre-Julio', 'Activo', '2024-06-04 18:34:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `idsec` int(11) NOT NULL,
  `nomsec` char(1) NOT NULL,
  `idsub` int(11) NOT NULL,
  `idtea` int(11) NOT NULL,
  `idcur` int(11) NOT NULL,
  `capa` char(2) NOT NULL,
  `state` char(1) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subgrade`
--

CREATE TABLE `subgrade` (
  `idsub` int(11) NOT NULL,
  `nomsub` varchar(50) NOT NULL,
  `iddeg` int(11) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `subgrade`
--

INSERT INTO `subgrade` (`idsub`, `nomsub`, `iddeg`, `fere`) VALUES
(13, 'Primer año', 9, '2024-06-04 18:37:27'),
(14, 'Segundo Año', 9, '2024-06-04 18:37:40'),
(15, 'Tercer Año', 9, '2024-06-04 18:37:48'),
(18, 'Cuarto Año', 9, '2024-06-04 18:42:18'),
(19, 'Quinto Año', 9, '2024-06-04 18:42:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teachers`
--

CREATE TABLE `teachers` (
  `idtea` int(11) NOT NULL,
  `dnite` char(8) NOT NULL,
  `nomte` varchar(35) NOT NULL,
  `sexte` varchar(15) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `telet` char(9) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` char(1) NOT NULL,
  `state` char(1) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `teachers`
--

INSERT INTO `teachers` (`idtea`, `dnite`, `nomte`, `sexte`, `correo`, `telet`, `foto`, `usuario`, `clave`, `rol`, `state`, `fere`) VALUES
(4, '20912111', 'Antonio Aguilar', 'Masculino', 'ASDA@gmail.com', '0412333', '67107.jpg', '', '', '', '1', '2024-06-04 22:01:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` char(1) NOT NULL,
  `estado` int(11) NOT NULL,
  `fere` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `correo`, `clave`, `rol`, `estado`, `fere`) VALUES
(1, 'Aga222', 'Angelo', 'admin@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', '1', 1, '2024-06-04 22:40:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alum_secc`
--
ALTER TABLE `alum_secc`
  ADD PRIMARY KEY (`idaluse`),
  ADD KEY `idsec` (`idsec`),
  ADD KEY `idstu` (`idstu`);

--
-- Indices de la tabla `asisten_alumn`
--
ALTER TABLE `asisten_alumn`
  ADD PRIMARY KEY (`idasisa`),
  ADD KEY `idstu` (`idstu`),
  ADD KEY `idtea` (`idtea`),
  ADD KEY `idsec` (`idsec`);

--
-- Indices de la tabla `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`idcur`),
  ADD KEY `idper` (`idper`),
  ADD KEY `iddeg` (`iddeg`),
  ADD KEY `idsub` (`idsub`);

--
-- Indices de la tabla `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`iddeg`),
  ADD KEY `idper` (`idper`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`idstu`);

--
-- Indices de la tabla `padres`
--
ALTER TABLE `padres`
  ADD PRIMARY KEY (`idfa`);

--
-- Indices de la tabla `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`idper`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`idsec`),
  ADD KEY `idsub` (`idsub`),
  ADD KEY `idtea` (`idtea`),
  ADD KEY `idcur` (`idcur`);

--
-- Indices de la tabla `subgrade`
--
ALTER TABLE `subgrade`
  ADD PRIMARY KEY (`idsub`),
  ADD KEY `iddeg` (`iddeg`);

--
-- Indices de la tabla `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`idtea`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alum_secc`
--
ALTER TABLE `alum_secc`
  MODIFY `idaluse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `asisten_alumn`
--
ALTER TABLE `asisten_alumn`
  MODIFY `idasisa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `course`
--
ALTER TABLE `course`
  MODIFY `idcur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `degree`
--
ALTER TABLE `degree`
  MODIFY `iddeg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `idstu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `padres`
--
ALTER TABLE `padres`
  MODIFY `idfa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `idper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `idsec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `subgrade`
--
ALTER TABLE `subgrade`
  MODIFY `idsub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `teachers`
--
ALTER TABLE `teachers`
  MODIFY `idtea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alum_secc`
--
ALTER TABLE `alum_secc`
  ADD CONSTRAINT `alum_secc_ibfk_1` FOREIGN KEY (`idsec`) REFERENCES `seccion` (`idsec`),
  ADD CONSTRAINT `alum_secc_ibfk_2` FOREIGN KEY (`idstu`) REFERENCES `estudiantes` (`idstu`);

--
-- Filtros para la tabla `asisten_alumn`
--
ALTER TABLE `asisten_alumn`
  ADD CONSTRAINT `asisten_alumn_ibfk_1` FOREIGN KEY (`idstu`) REFERENCES `estudiantes` (`idstu`),
  ADD CONSTRAINT `asisten_alumn_ibfk_2` FOREIGN KEY (`idtea`) REFERENCES `teachers` (`idtea`),
  ADD CONSTRAINT `asisten_alumn_ibfk_3` FOREIGN KEY (`idsec`) REFERENCES `seccion` (`idsec`);

--
-- Filtros para la tabla `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`idper`) REFERENCES `period` (`idper`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`iddeg`) REFERENCES `degree` (`iddeg`),
  ADD CONSTRAINT `course_ibfk_3` FOREIGN KEY (`idsub`) REFERENCES `subgrade` (`idsub`);

--
-- Filtros para la tabla `degree`
--
ALTER TABLE `degree`
  ADD CONSTRAINT `degree_ibfk_1` FOREIGN KEY (`idper`) REFERENCES `period` (`idper`);

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`idsub`) REFERENCES `subgrade` (`idsub`),
  ADD CONSTRAINT `seccion_ibfk_2` FOREIGN KEY (`idtea`) REFERENCES `teachers` (`idtea`),
  ADD CONSTRAINT `seccion_ibfk_3` FOREIGN KEY (`idcur`) REFERENCES `course` (`idcur`);

--
-- Filtros para la tabla `subgrade`
--
ALTER TABLE `subgrade`
  ADD CONSTRAINT `subgrade_ibfk_1` FOREIGN KEY (`iddeg`) REFERENCES `degree` (`iddeg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
