<?php

$item = null;
$valor = null;
$orden = "id";

$ventas = ControladorVentas::ctrSumaTotalVentas();

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias = count($categorias);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$totalClientes = count($clientes);

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);

?>

<style>
.dash-stat {
  background: var(--dash-card-bg);
  border-radius: var(--dash-radius);
  box-shadow: var(--dash-shadow);
  padding: 18px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
  transition: box-shadow 0.2s, transform 0.2s;
  min-height: 90px;
}
.dash-stat:hover {
  box-shadow: var(--dash-shadow-hover);
  transform: translateY(-2px);
}
.dash-stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: #fff;
  flex-shrink: 0;
}
.dash-stat-icon.ventas { background: linear-gradient(135deg,#4e73df,#224abe); }
.dash-stat-icon.categorias { background: linear-gradient(135deg,#1cc88a,#169b6b); }
.dash-stat-icon.productos { background: linear-gradient(135deg,#e74a3b,#c0392b); }
.dash-stat-icon.clientes { background: linear-gradient(135deg,#f6c23e,#dda20a); }
.dash-stat-body { flex: 1; min-width: 0; }
.dash-stat-number {
  font-size: 24px;
  font-weight: 800;
  color: #2d3748;
  line-height: 1.2;
}
.dash-stat-label {
  font-size: 13px;
  color: var(--dash-text-muted);
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}
.dash-stat-link {
  display: block;
  font-size: 12px;
  color: var(--dash-primary);
  text-decoration: none;
  font-weight: 600;
  margin-top: 4px;
}
.dash-stat-link:hover { text-decoration: underline; }
</style>

<div class="dash-stat">
  <div class="dash-stat-icon ventas"><i class="ion ion-social-usd"></i></div>
  <div class="dash-stat-body">
    <div class="dash-stat-number">$<?php echo number_format($ventas["total"],2); ?></div>
    <div class="dash-stat-label">Ventas</div>
    <a href="ventas" class="dash-stat-link">Más info &rarr;</a>
  </div>
</div>

<div class="dash-stat">
  <div class="dash-stat-icon categorias"><i class="ion ion-clipboard"></i></div>
  <div class="dash-stat-body">
    <div class="dash-stat-number"><?php echo number_format($totalCategorias); ?></div>
    <div class="dash-stat-label">Categorías</div>
    <a href="categorias" class="dash-stat-link">Más info &rarr;</a>
  </div>
</div>

<div class="dash-stat">
  <div class="dash-stat-icon productos"><i class="ion ion-ios-cart"></i></div>
  <div class="dash-stat-body">
    <div class="dash-stat-number"><?php echo number_format($totalProductos); ?></div>
    <div class="dash-stat-label">Productos</div>
    <a href="productos" class="dash-stat-link">Más info &rarr;</a>
  </div>
</div>

<div class="dash-stat">
  <div class="dash-stat-icon clientes"><i class="ion ion-person-add"></i></div>
  <div class="dash-stat-body">
    <div class="dash-stat-number"><?php echo number_format($totalClientes); ?></div>
    <div class="dash-stat-label">Clientes</div>
    <a href="clientes" class="dash-stat-link">Más info &rarr;</a>
  </div>
</div>
