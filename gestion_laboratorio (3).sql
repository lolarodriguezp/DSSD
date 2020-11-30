-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-11-2020 a las 13:52:07
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_laboratorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_protocolos`
--

CREATE TABLE `actividades_protocolos` (
  `id_actividad` int(11) NOT NULL,
  `id_protocolo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros_proyectos`
--

CREATE TABLE `miembros_proyectos` (
  `id_miembro` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `miembros_proyectos`
--

INSERT INTO `miembros_proyectos` (`id_miembro`, `nombre`) VALUES
(1, 'Pilar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolos`
--

CREATE TABLE `protocolos` (
  `id_protocolo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `es_local` bit(1) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Pendiente',
  `id_proyecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `protocolos`
--

INSERT INTO `protocolos` (`id_protocolo`, `nombre`, `id_responsable`, `fecha_inicio`, `fecha_fin`, `orden`, `es_local`, `puntaje`, `estado`, `id_proyecto`) VALUES
(1, 'Primer protocolo', 1, NULL, '2020-10-21', 1, b'1', 11, 'Pendiente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `nombre`, `fecha_inicio`, `fecha_fin`, `id_responsable`) VALUES
(1, 'Primer proyecto', '2020-10-20', '2020-10-21', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `rol`, `created_at`, `updated_at`) VALUES
(2, 'Pilar Acha', 'pilaracha97@gmail.com', '$2y$10$7zvF56kHyOm31Rd84s4p8uatsOuE7CytHGkhrtq4XPaCLAAYg1zXq', 'Jefe', '2020-11-24 23:52:28', '2020-11-24 23:52:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `actividades_protocolos`
--
ALTER TABLE `actividades_protocolos`
  ADD PRIMARY KEY (`id_protocolo`,`id_actividad`),
  ADD KEY `fk_actividad` (`id_actividad`);

--
-- Indices de la tabla `miembros_proyectos`
--
ALTER TABLE `miembros_proyectos`
  ADD PRIMARY KEY (`id_miembro`);

--
-- Indices de la tabla `protocolos`
--
ALTER TABLE `protocolos`
  ADD PRIMARY KEY (`id_protocolo`),
  ADD KEY `protocolo_responsable` (`id_responsable`),
  ADD KEY `protocolo_proyecto` (`id_proyecto`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `proyecto_responsable` (`id_responsable`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `miembros_proyectos`
--
ALTER TABLE `miembros_proyectos`
  MODIFY `id_miembro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `protocolos`
--
ALTER TABLE `protocolos`
  MODIFY `id_protocolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades_protocolos`
--
ALTER TABLE `actividades_protocolos`
  ADD CONSTRAINT `fk_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`),
  ADD CONSTRAINT `fk_protocolo` FOREIGN KEY (`id_protocolo`) REFERENCES `protocolos` (`id_protocolo`);

--
-- Filtros para la tabla `protocolos`
--
ALTER TABLE `protocolos`
  ADD CONSTRAINT `protocolo_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`),
  ADD CONSTRAINT `protocolo_responsable` FOREIGN KEY (`id_responsable`) REFERENCES `miembros_proyectos` (`id_miembro`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyecto_responsable` FOREIGN KEY (`id_responsable`) REFERENCES `miembros_proyectos` (`id_miembro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
