-- ============================================================
-- POS Inventario - Base de datos limpia
-- Listo para importar en cualquier PC / XAMPP
-- ============================================================

DROP DATABASE IF EXISTS `pos`;
CREATE DATABASE `pos` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `pos`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- ============================================================
-- TABLA: categorias
-- ============================================================
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_categorias_categoria` (`categoria`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ============================================================
-- TABLA: clientes
-- ============================================================
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `documento` int(11) NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo_comprobante` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'B',
  `compras` int(11) NOT NULL DEFAULT 0,
  `ultima_compra` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_clientes_documento` (`documento`),
  KEY `idx_clientes_nombre` (`nombre`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ============================================================
-- TABLA: productos
-- ============================================================
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `precio_compra` float NOT NULL DEFAULT 0,
  `precio_venta` float NOT NULL DEFAULT 0,
  `detalle_compra` text COLLATE utf8_spanish_ci NOT NULL,
  `ventas` int(11) NOT NULL DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_productos_id_categoria` (`id_categoria`),
  KEY `idx_productos_codigo` (`codigo`(50)),
  KEY `idx_productos_descripcion` (`descripcion`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ============================================================
-- TABLA: usuarios
-- ============================================================
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuarios_usuario` (`usuario`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ============================================================
-- TABLA: ventas
-- ============================================================
CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL DEFAULT 0,
  `neto` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ventas_codigo` (`codigo`),
  KEY `idx_ventas_id_cliente` (`id_cliente`),
  KEY `idx_ventas_id_vendedor` (`id_vendedor`),
  KEY `idx_ventas_fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ============================================================
-- DATOS INICIALES
-- ============================================================

-- Categoría genérica para empezar
INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'General');

-- Cliente "Venta Rápida" (cliente por defecto del sistema)
INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `tipo_comprobante`) VALUES
(1, 'Venta Rápida', 0, '', '', '', '1900-01-01', 'B');

-- Usuarios por defecto
-- admin / admin
-- vendedor / vendedor
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`) VALUES
(1, 'Administrador', 'admin', '$2y$10$f2HzXjYUJ3XfZU39/iwhku51RoQo4Mf0RoyQ7uKVt54FnIotZ5EEC', 'Administrador', '', 1),
(2, 'Vendedor', 'vendedor', '$2y$10$JBZqeHOXcLQeYV315Y2ApeYcSCXcGBN5zbYSRoVX.Yw5VyPCIXb6S', 'Vendedor', '', 1);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ============================================================
-- Credenciales por defecto
--   Usuario: admin       Contraseña: admin
--   Usuario: vendedor    Contraseña: vendedor
-- ============================================================
