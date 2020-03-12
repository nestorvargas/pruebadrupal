-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-03-2020 a las 01:55:19
-- Versión del servidor: 8.0.19
-- Versión de PHP: 7.3.15-4+0~20200224.55+debian10~1.gbpbea824

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drupal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `myusers`
--

CREATE TABLE `myusers` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `myusers`
--

INSERT INTO `myusers` (`id`, `nombre`, `correo`) VALUES
(1, 'admin', 'nestorfabian.92@gmail.com'),
(2, 'nvargasf', 'nvargasf@invima.gov.co'),
(3, 'nestor2131', 'nestorfabian.92@gmail.com'),
(4, 'nvargasf', 'nestorfabian.92@gmail.com'),
(5, 'nvargasf', 'nestorfabian.92@gmail.com'),
(6, 'admin2', 'nestorfabian.92@gmail.com'),
(7, 'prueba admin', 'nestorfabian@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `myusers`
--
ALTER TABLE `myusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `myusers`
--
ALTER TABLE `myusers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
