-- ============================================================
-- Migración: tabla eans (catálogo de códigos EAN del usuario)
-- ============================================================

CREATE TABLE IF NOT EXISTS `eans` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `codigo_ean` VARCHAR(20) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` TEXT COLLATE utf8_spanish_ci NOT NULL,
  `id_producto` INT(11) DEFAULT NULL,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_eans_codigo` (`codigo_ean`),
  KEY `idx_eans_id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
