-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2024 a las 18:22:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_f`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `cliente_id`, `fecha`, `total`) VALUES
(1, 0, '2024-01-02', 0.00),
(2, 0, '2024-01-02', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_permanentes`
--

CREATE TABLE `facturas_permanentes` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `itbis` decimal(10,0) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas_permanentes`
--

INSERT INTO `facturas_permanentes` (`id`, `factura_id`, `nombre_producto`, `cantidad`, `subtotal`, `itbis`, `fecha`) VALUES
(1, 1, 'Marcador', 22, 1650, 297, '2024-04-23 16:52:28'),
(2, 2, 'Jabón', 11, 715, 129, '2024-04-23 16:53:49'),
(3, 2, 'Jabón', 1, 65, 12, '2024-04-23 16:53:49'),
(4, 2, 'Jabón', 3, 195, 35, '2024-04-23 16:53:49'),
(5, 3, 'Marcador', 3, 225, 41, '2024-04-23 21:47:35'),
(6, 3, 'Cuaderno', 1, 95, 17, '2024-04-23 21:47:35'),
(7, 3, 'Perfume', 2, 1100, 198, '2024-04-23 21:47:35'),
(8, 3, 'Jabón Cocoa', 1, 50, 9, '2024-04-23 21:47:35'),
(9, 3, 'Maíz', 4, 400, 72, '2024-04-23 21:47:35'),
(12, 4, 'Camisa de Algodón', 2, 1000, 180, '2024-04-23 22:09:16'),
(13, 4, 'Zapatos Deportivos', 1, 1000, 180, '2024-04-23 22:09:16'),
(14, 4, 'Bolso de Cuero', 1, 2000, 360, '2024-04-23 22:09:16'),
(15, 4, 'Juego de Sábanas', 2, 2400, 432, '2024-04-23 22:09:16'),
(16, 4, 'Bicicleta de Montaña', 1, 10000, 1800, '2024-04-23 22:09:16'),
(19, 5, 'Zapatos Deportivos', 9, 9000, 1620, '2024-04-24 00:19:13'),
(20, 6, 'Camisa de Algodón', 2, 1000, 180, '2024-04-24 13:47:07'),
(21, 6, 'Zapatos Deportivos', 2, 2000, 360, '2024-04-24 13:47:07'),
(22, 6, 'Zapatos Deportivos', 2, 2000, 360, '2024-04-24 13:47:07'),
(23, 7, 'Zapatos Deportivos', 2, 2000, 360, '2024-04-24 14:02:54'),
(24, 7, 'Zapatos Deportivos', 14, 14000, 2520, '2024-04-24 14:02:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_rapida`
--

CREATE TABLE `factura_rapida` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `itbis` decimal(10,0) NOT NULL,
  `factura_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo_producto` varchar(50) NOT NULL,
  `nombre_producto` varchar(250) NOT NULL,
  `descripccion` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `fecha_v` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo_producto`, `nombre_producto`, `descripccion`, `cantidad`, `precio`, `categoria`, `fecha_v`) VALUES
(1, '1234567890123', 'Camisa de Algodón', 'Camisa de algodón de manga larga para hombre.', 46, 500.00, 'Ropa', '2024-04-24 13:46:39'),
(2, '2345678901234', 'Zapatos Deportivos', 'Zapatos deportivos para correr con suela de goma.', 0, 1000.00, 'Calzado', '2024-04-24 13:57:10'),
(3, '3456789012345', 'Laptop HP', 'Laptop HP de última generación con procesador i7.', 15, 25000.00, 'Electrónica', '2024-04-23 22:05:16'),
(4, '4567890123456', 'Mesa de Comedor', 'Mesa de comedor de madera maciza con capacidad para 6 personas.', 10, 8000.00, 'Muebles', '2024-04-23 22:05:16'),
(5, '5678901234567', 'Auriculares Bluetooth', 'Auriculares inalámbricos con cancelación de ruido.', 20, 1500.00, 'Electrónica', '2024-04-23 22:05:16'),
(6, '6789012345678', 'Vestido de Fiesta', 'Vestido largo de fiesta con pedrería.', 25, 3500.00, 'Ropa', '2025-12-31 04:00:00'),
(7, '7890123456789', 'Bolso de Cuero', 'Bolso de cuero genuino para mujer.', 39, 2000.00, 'Accesorios', '2024-04-23 22:07:58'),
(8, '8901234567890', 'Reloj Inteligente', 'Reloj inteligente con monitor de ritmo cardíaco.', 30, 3000.00, 'Electrónica', '2024-04-23 22:05:16'),
(9, '9012345678901', 'Juego de Sábanas', 'Juego de sábanas de algodón egipcio para cama king size.', 48, 1200.00, 'Hogar', '2024-04-23 22:08:27'),
(10, '0123456789012', 'Teléfono Inteligente', 'Teléfono inteligente con cámara de alta resolución.', 20, 15000.00, 'Electrónica', '2024-04-23 22:05:16'),
(11, '1123456789013', 'Cafetera de Capsulas', 'Cafetera de cápsulas con función de espumado de leche.', 15, 3000.00, 'Electrodomésticos', '2024-04-23 22:05:16'),
(12, '2123456789014', 'Maleta de Viaje', 'Maleta de viaje con ruedas giratorias y cerradura TSA.', 35, 2500.00, 'Equipaje', '2024-04-23 22:05:16'),
(13, '3123456789015', 'Teclado Inalámbrico', 'Teclado inalámbrico ultra delgado para computadoras.', 25, 800.00, 'Electrónica', '2024-04-23 22:05:16'),
(14, '4123456789016', 'Set de Herramientas', 'Set de herramientas completo con destornilladores, llaves, y más.', 20, 4000.00, 'Herramientas', '2024-04-23 22:05:16'),
(15, '5123456789017', 'Mochila Escolar', 'Mochila escolar resistente con compartimento acolchado para laptop.', 40, 1500.00, 'Accesorios', '2024-04-23 22:05:16'),
(16, '6123456789018', 'Silla de Oficina', 'Silla ergonómica de oficina con soporte lumbar ajustable.', 30, 3500.00, 'Muebles', '2024-04-23 22:05:16'),
(17, '7123456789019', 'Smart TV', 'Smart TV de 55 pulgadas con resolución 4K y sistema operativo Android.', 10, 25000.00, 'Electrónica', '2024-04-23 22:05:16'),
(18, '8123456789020', 'Plancha de Vapor', 'Plancha de vapor con función de auto apagado y control de temperatura.', 20, 1500.00, 'Electrodomésticos', '2024-04-23 22:05:16'),
(19, '9123456789021', 'Libro de Cocina', 'Libro de cocina con recetas internacionales y fotografías a color.', 50, 700.00, 'Libros', '2024-04-23 22:05:16'),
(20, '1234567890221', 'Bicicleta de Montaña', 'Bicicleta de montaña con cuadro de aluminio y suspensión delantera.', 14, 10000.00, 'Deportes', '2024-04-23 22:09:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(250) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `tipo_user` varchar(50) NOT NULL,
  `numero_tel` int(11) NOT NULL,
  `direccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo`, `contraseña`, `tipo_user`, `numero_tel`, `direccion`) VALUES
(1, 'RANDY DIROCHE DIAZ', 'Diroche Diaz', 'alanelprololo@gmail.com', '123456', 'ADMIN', 849423696, 'Pedro brand,km22,La cuaba'),
(2, 'ELIAN DIROCHE DIAZ', 'Diroche Diaz', 'eliandiroche@gmail.com', '654321', 'USUARIO', 849423696, 'Pedro brand,la cuaba'),
(3, 'usuario', '', '', '123', 'USUARIO', 0, ''),
(4, 'admin', '', '', '321', 'ADMIN', 0, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas_permanentes`
--
ALTER TABLE `facturas_permanentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura_rapida`
--
ALTER TABLE `factura_rapida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `facturas_permanentes`
--
ALTER TABLE `facturas_permanentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `factura_rapida`
--
ALTER TABLE `factura_rapida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
