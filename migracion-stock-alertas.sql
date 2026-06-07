-- ============================================================
-- Migración: alertas de stock por producto
-- Agrega los umbrales personalizables stock_minimo y stock_medio
-- Defaults preservan el comportamiento anterior (10 / 15)
-- ============================================================

ALTER TABLE `productos`
  ADD COLUMN `stock_minimo` INT(11) NOT NULL DEFAULT 10 AFTER `stock`,
  ADD COLUMN `stock_medio`  INT(11) NOT NULL DEFAULT 15 AFTER `stock_minimo`;
