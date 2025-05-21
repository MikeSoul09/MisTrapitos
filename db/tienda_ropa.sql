-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 22:27:50
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
-- Base de datos: `tienda_ropa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `direccion`, `correo`, `telefono`, `ciudad`) VALUES
(101, 'Carlos Mendoza', 'Av. Libertad 500', 'carlos.mendoza@gmail.com', '3311112222', 'Guadalajara'),
(102, 'Ana López', 'Calle Rosa 89', 'ana.lopez@yahoo.com', '3322223333', 'Zapopan'),
(103, 'Laura Torres', 'Calle Lago 22', 'laura.torres@hotmail.com', '3333334444', 'Guadalajara'),
(105, 'Jose', 'Malecon', 'test@gmail.com', '3322556698', 'Tlaquepaque'),
(106, 'Bastian', 'Flores Magon 34', 'bastian34@gmail.dom', '3355668899', 'Tonala');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detalle`, `id_venta`, `id_producto`, `cantidad`) VALUES
(1, 7, 1, 10),
(2, 8, 1, 10),
(3, 9, 2, 15),
(5, 11, 3, 20),
(7, 15, 1, 10),
(19, 27, 12, 150),
(20, 28, 3, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `talla_color` varchar(100) NOT NULL,
  `descuento` decimal(5,2) DEFAULT 0.00,
  `inicio_oferta` date DEFAULT NULL,
  `fin_oferta` date DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `categoria`, `descripcion`, `precio`, `stock`, `talla_color`, `descuento`, `inicio_oferta`, `fin_oferta`, `id_proveedor`) VALUES
(1, 'Camiseta Blanca', 'Camisetas', 'Camiseta de algodón blanca', 199.99, 90, 'S,M,L,XL', 20.00, '2025-05-01', '2025-05-31', 1),
(2, 'Camiseta Negra', 'Camisetas', 'Camiseta casual negra', 219.99, 100, 'S,M,L,XL', 0.00, '0000-00-00', '0000-00-00', 1),
(3, 'Pantalón Azul', 'Pantalones', 'Pantalón de mezclilla azul', 399.00, 140, '30,31,32', 30.00, '2025-05-10', '2025-05-25', 2),
(4, 'Gorra Estilo', 'Accesorios', 'Gorra con diseño urbano', 150.50, 200, 'Unitalla', 0.00, '0000-00-00', '0000-00-00', 3),
(5, 'Cinturón Cuero', 'Accesorios', 'Cinturón de cuero genuino', 299.90, 150, '28,30,32', 15.00, '2025-05-05', '2025-06-01', 3),
(12, 'Pantalón Negro', 'Pantalones', 'Mezclilla negra', 399.00, 0, '30,32,36,38', 10.00, '2025-05-18', '2025-05-25', 2),
(13, 'Camiseta Gris', 'Camisetas', 'Camiseta de algodón gris', 200.00, 150, 'S,M,L', 10.00, '2025-05-17', '2025-05-24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `direccion`, `correo`, `telefono`) VALUES
(1, 'Proveedora Moda SA', 'Av. Central 123', 'contacto@modasa.com', '3312345678'),
(2, 'Textiles MX', 'Calle Diseño 456', 'ventas@textilesmx.com', '3322334455'),
(3, 'Accesorios Fashion', 'Plaza Ropa Local 9', 'info@accesfashion.com', '3344556677'),
(4, 'Jose', 'MAlecon', 'test@gmail.com', '3322556688'),
(5, 'Marco García', 'Donato Guerra 200', 'MGarcia@hotmail.com', '344778899'),
(6, 'Pedro Picapiedra', 'Valle del dino', 'picapiedra2000@gmail.com', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','vendedor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`) VALUES
(7, 'MIguel Isaac', 'Migueles1009', '$2y$10$P.XtY9YDcsHb9mfs.RInlurrgZjeSa9Y0Il.gr2jWSI4JK/OgkCUm', 'vendedor'),
(8, 'Admin', 'Admin', '$2y$10$psFa2Sfk0rkMWUov9piGR./BeFw6NgEOsJeqzpe0ybMcr9aF4vJsO', 'admin'),
(9, 'User1', 'User1', '$2y$10$ZwzXloQj7ualGugv.e/y6eAKxY4GtoYebljd510qhk1LbXBmOghVK', 'vendedor'),
(10, 'Isaac', 'Isaquesedeaqui', '$2y$10$IpF3C8l4DFVrZlZlNQmsb.yjfNXPZ.Ld7/YtOnMqis6GzeCkrjHym', 'admin'),
(11, 'Vendedor14', 'Vend14', '$2y$10$v6pGM1a/ir.gCRjvBIUN9e1vSMlBZiigLJRh0Z6Y0lrG024XMFV36', 'vendedor'),
(13, 'Vendedor14', 'Vend15', '$2y$10$va81ndODWurHf9hDpRsdXOv.IsqJMEQ2Lh6zVGJUNvhIKxHSvhRb2', 'vendedor'),
(14, 'Pepe', 'vend16', '$2y$10$NiE41NF5utsTCGANErHSPO6FD8X14oM83WJcPyiOYqAQgtKmXGpJi', 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` enum('Efectivo','Tarjeta','Transferencia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `fecha`, `metodo_pago`) VALUES
(1, 101, '2025-05-10 14:30:00', 'Tarjeta'),
(2, 102, '2025-05-11 16:00:00', 'Efectivo'),
(3, 103, '2025-05-12 12:00:00', 'Transferencia'),
(4, 101, '2025-05-13 19:19:16', 'Efectivo'),
(5, 101, '2025-05-13 19:29:26', 'Efectivo'),
(6, 101, '2025-05-13 20:49:12', 'Efectivo'),
(7, 101, '2025-05-13 20:50:58', 'Efectivo'),
(8, 101, '2025-05-16 16:13:08', 'Transferencia'),
(9, 102, '2025-05-19 15:09:50', 'Efectivo'),
(11, 103, '2025-05-19 15:10:56', 'Efectivo'),
(13, 103, '2025-05-19 22:17:50', 'Efectivo'),
(15, 103, '2025-05-19 22:19:11', 'Efectivo'),
(24, 102, '2025-05-19 22:47:49', 'Efectivo'),
(25, 101, '2025-05-19 23:04:42', 'Tarjeta'),
(26, 101, '2025-05-20 21:29:48', 'Efectivo'),
(27, 101, '2025-05-20 22:08:11', 'Transferencia'),
(28, 106, '2025-05-20 22:20:24', 'Tarjeta');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `idx_cliente_ciudad` (`ciudad`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `idx_producto_categoria` (`categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `idx_venta_fecha` (`fecha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
