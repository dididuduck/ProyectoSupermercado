-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2026 a las 11:04:32
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
-- Base de datos: `supermercado`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_filtrar_productos` (IN `pa_nombre` VARCHAR(100), IN `pa_categoria` VARCHAR(50), IN `pa_precio_max` DECIMAL(10,2))   begin 
	WITH ProductosFiltrados AS (
	-- acá es el cte (cargar tabla temp memoria solo dura la consulta)
        SELECT 
            p.id_producto,
            p.nombre AS producto,
            p.precio,
            p.imagen,
            c.nombre AS categoria
        FROM productos as p 
        -- la tabla productos tmb se ubica como p 
        INNER JOIN categorias as c ON p.id_categoria = c.id_categoria
        WHERE (p_nombre = '' OR p.nombre LIKE CONCAT('%', p_nombre, '%'))
          AND (p_categoria = '' OR c.nombre = p_categoria)
          AND (p_precio_max = 0 OR p.precio <= p_precio_max)
    )
    SELECT * FROM ProductosFiltrados;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_filtrar_productos` (IN `p_nombre` VARCHAR(100), IN `p_categoria` VARCHAR(50), IN `p_precio_max` DECIMAL(10,2))   BEGIN 
    -- CTE: tabla temporal en memoria solo durante la consulta
    WITH ProductosFiltrados AS (
        SELECT 
            p.id_producto,
            p.nombre AS producto,
            p.precio,
            p.imagen,
            c.nombre AS categoria
        FROM productos AS p 
        INNER JOIN categorias AS c ON p.id_categoria = c.id_categoria
        WHERE (p_nombre = '' OR p.nombre LIKE CONCAT('%', p_nombre, '%'))
          AND (p_categoria = '' OR c.nombre = p_categoria)
          AND (p_precio_max = 0 OR p.precio <= p_precio_max)
    )
    SELECT * FROM ProductosFiltrados;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'Computación'),
(2, 'Moda'),
(3, 'Hogar'),
(4, 'Computación'),
(5, 'Moda'),
(6, 'Hogar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `imagen`, `id_categoria`) VALUES
(1, 'Laptop Estudiantil', 450.00, 'laptop.png', 1),
(2, 'Vestido Casual', 299.00, 'vestido.png', 2),
(3, 'Lámpara de Escritorio', 180.00, 'hogar.png', 3),
(4, 'Laptop Estudiantil', 450.00, 'laptop.png', 1),
(5, 'Vestido Casual', 299.00, 'vestido.png', 2),
(6, 'Lámpara de Escritorio', 180.00, 'hogar.png', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
