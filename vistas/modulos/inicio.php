<style>
:root {
  --dash-bg: #f4f6fb;
  --dash-card-bg: #fff;
  --dash-radius: 12px;
  --dash-shadow: 0 2px 12px rgba(0,0,0,0.06);
  --dash-shadow-hover: 0 4px 20px rgba(0,0,0,0.1);
  --dash-primary: #4e73df;
  --dash-success: #1cc88a;
  --dash-danger: #e74a3b;
  --dash-warning: #f6c23e;
  --dash-info: #36b9cc;
  --dash-text: #5a5c69;
  --dash-text-muted: #858796;
  --dash-border: #e3e6f0;
  --dash-font: 'Inter', system-ui, -apple-system, sans-serif;
}
.dash-moderno * { box-sizing: border-box; }
.dash-moderno {
  font-family: var(--dash-font);
  color: var(--dash-text);
}
.dash-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 8px;
}
.dash-header h1 {
  font-size: 22px;
  font-weight: 700;
  margin: 0;
  color: #2d3748;
}
.dash-header h1 small {
  font-size: 14px;
  font-weight: 400;
  color: var(--dash-text-muted);
  margin-left: 8px;
}
.dash-breadcrumb {
  display: flex;
  gap: 6px;
  list-style: none;
  padding: 0;
  margin: 0;
  font-size: 13px;
}
.dash-breadcrumb li:not(:last-child)::after {
  content: '/';
  margin-left: 6px;
  color: var(--dash-text-muted);
}
.dash-breadcrumb a { color: var(--dash-primary); text-decoration: none; }
.dash-breadcrumb .active { color: var(--dash-text-muted); }

/* Grid */
.dash-stats,
.dash-charts,
.dash-bottom {
  display: grid;
  gap: 16px;
  margin-bottom: 16px;
}
.dash-stats { grid-template-columns: repeat(4, 1fr); }
.dash-charts { grid-template-columns: 1fr 1fr; }
.dash-bottom { grid-template-columns: 1fr 1fr; }

@media (max-width: 992px) {
  .dash-stats { grid-template-columns: repeat(2, 1fr); }
  .dash-charts,
  .dash-bottom { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
  .dash-stats { grid-template-columns: 1fr; }
}
</style>

<div class="dash-moderno">

  <div class="dash-header">
    <h1>Tablero <small>Panel de Control</small></h1>
    <ol class="dash-breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tablero</li>
    </ol>
  </div>

  <div class="dash-stats">
    <?php
    if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor") {
      include "inicio/cajas-superiores.php";
    }
    ?>
  </div>

  <div class="dash-charts">
    <?php
    if ($_SESSION["perfil"] == "Administrador") {
      include "reportes/grafico-ventas.php";
    }
    ?>
    <?php
    if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor") {
      include "inicio/productos-stock-bajo.php";
    }
    ?>
  </div>

  <div class="dash-bottom">
    <?php
    if ($_SESSION["perfil"] == "Administrador") {
      include "reportes/productos-mas-vendidos.php";
    }
    ?>
    <?php
    if ($_SESSION["perfil"] == "Administrador") {
      include "inicio/productos-recientes.php";
    }
    ?>
  </div>

</div>
