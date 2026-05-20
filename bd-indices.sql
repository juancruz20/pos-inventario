-- =============================================
-- MIGRACIONES DE BASE DE DATOS
-- =============================================

ALTER TABLE productos ADD detalle_compra TEXT NOT NULL AFTER precio_venta;
ALTER TABLE clientes ADD tipo_comprobante VARCHAR(1) NOT NULL DEFAULT 'B' AFTER fecha_nacimiento;

-- =============================================
-- ÍNDICES FALTANTES PARA MEJORAR RENDIMIENTO
-- =============================================

ALTER TABLE `productos` ADD INDEX `idx_productos_id_categoria` (`id_categoria`);
ALTER TABLE `productos` ADD INDEX `idx_productos_codigo` (`codigo`);
ALTER TABLE `productos` ADD INDEX `idx_productos_descripcion` (`descripcion`(100));

ALTER TABLE `clientes` ADD INDEX `idx_clientes_documento` (`documento`);
ALTER TABLE `clientes` ADD INDEX `idx_clientes_nombre` (`nombre`(100));

ALTER TABLE `usuarios` ADD INDEX `idx_usuarios_usuario` (`usuario`(100));

ALTER TABLE `ventas` ADD INDEX `idx_ventas_codigo` (`codigo`);
ALTER TABLE `ventas` ADD INDEX `idx_ventas_id_cliente` (`id_cliente`);
ALTER TABLE `ventas` ADD INDEX `idx_ventas_id_vendedor` (`id_vendedor`);
ALTER TABLE `ventas` ADD INDEX `idx_ventas_fecha` (`fecha`);
