-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2017 a las 03:47:45
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `masones`
--
CREATE DATABASE IF NOT EXISTS `masones` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `masones`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota`
--

CREATE TABLE `cuota` (
  `fecha` date NOT NULL,
  `monto` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuota`
--

INSERT INTO `cuota` (`fecha`, `monto`) VALUES
('2015-01-06', 100),
('2015-02-17', 110),
('2015-03-24', 120),
('2015-04-22', 130);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE `miembros` (
  `cedula` int(9) NOT NULL,
  `nomb` varchar(50) NOT NULL,
  `apell` varchar(50) NOT NULL,
  `cel` varchar(15) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `f_nac` date NOT NULL,
  `f_ingr` date NOT NULL,
  `grado` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `miembros`
--

INSERT INTO `miembros` (`cedula`, `nomb`, `apell`, `cel`, `correo`, `f_nac`, `f_ingr`, `grado`) VALUES
(2, 'a', 'a', 'a', 'a', '2015-10-07', '2015-10-07', 1),
(1, 'q', 'q', 'q', 'q', '2015-10-06', '2015-10-06', 1),
(1, 'q', 'q', '1', 'q', '2000-01-01', '1970-01-01', 1),
(20262861, 'Marco', 'Velasquez', '04148930664', 'marcovelasquez90@hotmail.com', '1990-05-30', '2015-10-07', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `cedula` int(9) NOT NULL,
  `cuota` int(6) NOT NULL,
  `monto` int(6) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `f_pago` date NOT NULL,
  `f_real` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`cedula`, `cuota`, `monto`, `estado`, `f_pago`, `f_real`) VALUES
(20262861, 100, 100, 'pago', '2014-02-02', '2014-02-02'),
(20262861, 110, 100, 'parcial', '2014-03-05', '2014-03-05'),
(0, 0, 0, 'Pago', '1970-01-01', '2016-02-12'),
(0, 0, 0, 'Pago', '1970-01-01', '2016-02-12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
