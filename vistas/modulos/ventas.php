<style>
  .ventas-panel {
    --vt-bg: #f8fafc;
    --vt-card: #ffffff;
    --vt-border: #e2e8f0;
    --vt-text: #1e293b;
    --vt-muted: #64748b;
    --vt-accent: #3b82f6;
    --vt-radius: 10px;
    --vt-shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
    background: var(--vt-bg);
    min-height: 100%;
  }
  .ventas-panel .vt-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 20px 24px 0;
  }
  .ventas-panel .vt-header .vt-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
  }
  .ventas-panel .vt-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--vt-accent);
    color: #fff;
    border: none;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, transform .1s;
    text-decoration: none;
  }
  .ventas-panel .vt-btn-primary:hover { background: #2563eb; transform: translateY(-1px); }
  .ventas-panel .vt-btn-primary:active { transform: translateY(0); }
  .ventas-panel .vt-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--vt-card);
    color: var(--vt-text);
    border: 1px solid var(--vt-border);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
  }
  .ventas-panel .vt-btn-outline:hover { border-color: var(--vt-accent); box-shadow: 0 0 0 3px rgba(59,130,246,.12); }
  .ventas-panel .vt-btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1px solid var(--vt-border);
    background: var(--vt-card);
    color: var(--vt-text);
    cursor: pointer;
    font-size: 14px;
    transition: all .2s;
    text-decoration: none;
  }
  .ventas-panel .vt-btn-icon:hover { border-color: var(--vt-accent); color: var(--vt-accent); }
  .ventas-panel .vt-btn-icon.vt-green { color: #16a34a; border-color: #bbf7d0; }
  .ventas-panel .vt-btn-icon.vt-green:hover { background: #f0fdf4; border-color: #16a34a; }
  .ventas-panel .vt-btn-icon.vt-blue { color: var(--vt-accent); border-color: #bfdbfe; }
  .ventas-panel .vt-btn-icon.vt-blue:hover { background: #eff6ff; border-color: var(--vt-accent); }
  .ventas-panel .vt-btn-icon.vt-orange { color: #ea580c; border-color: #fed7aa; }
  .ventas-panel .vt-btn-icon.vt-orange:hover { background: #fff7ed; border-color: #ea580c; }
  .ventas-panel .vt-card {
    background: var(--vt-card);
    border-radius: var(--vt-radius);
    box-shadow: var(--vt-shadow);
    margin: 16px 24px 24px;
    overflow: hidden;
  }
  .ventas-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
    color: var(--vt-text);
  }
  .ventas-table thead { background: #f1f5f9; }
  .ventas-table thead th {
    padding: 10px 12px;
    text-align: left;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: var(--vt-muted);
    border-bottom: 1px solid var(--vt-border);
    white-space: nowrap;
  }
  .ventas-table tbody tr { transition: background .15s; }
  .ventas-table tbody tr:hover { background: #f8fafc; }
  .ventas-table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--vt-border);
    vertical-align: middle;
  }
  .ventas-table tbody tr:last-child td { border-bottom: none; }
  .ventas-table .vt-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
  }
  .ventas-table .vt-tag {
    display: inline-block;
    background: #f1f5f9;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 11px;
    line-height: 1.5;
    white-space: nowrap;
  }
  .ventas-table .vt-actions {
    display: flex;
    gap: 6px;
  }
  .ventas-panel .vt-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 24px;
    margin: 0;
    list-style: none;
    font-size: 13px;
    color: var(--vt-muted);
  }
  .ventas-panel .vt-breadcrumb a { color: var(--vt-muted); text-decoration: none; }
  .ventas-panel .vt-breadcrumb a:hover { color: var(--vt-accent); }
  .ventas-panel .vt-breadcrumb .sep { color: #cbd5e1; }
  .ventas-panel .vt-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--vt-text);
    margin: 0;
    padding: 0 24px;
    padding-top: 20px;
  }
  @media (max-width: 768px) {
    .ventas-panel .vt-header { flex-direction: column; align-items: stretch; padding: 16px 16px 0; }
    .ventas-panel .vt-card { margin: 12px 16px 16px; }
    .ventas-panel .vt-title { padding: 16px 16px 0; font-size: 18px; }
    .ventas-panel .vt-breadcrumb { padding: 0 16px; }
    .ventas-table { font-size: 12px; }
    .ventas-table thead th, .ventas-table tbody td { padding: 8px; }
    .ventas-table thead { display: none; }
    .ventas-table tbody tr {
      display: block;
      padding: 12px;
      border-bottom: 1px solid var(--vt-border);
    }
    .ventas-table tbody tr:last-child { border-bottom: none; }
    .ventas-table tbody td {
      display: flex;
      align-items: center;
      padding: 4px 0;
      border: none;
      gap: 6px;
    }
    .ventas-table tbody td::before {
      content: attr(data-label);
      font-weight: 600;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .03em;
      color: var(--vt-muted);
      min-width: 90px;
      flex-shrink: 0;
    }
    .ventas-table .vt-tags { justify-content: flex-start; }
  }
</style>
<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper ventas-panel">

  <section class="content-header">

    <h1 class="vt-title">

      Administrar ventas

    </h1>

    <ol class="vt-breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="sep">/</li>

      <li>Administrar ventas</li>

    </ol>

  </section>

  <section class="content">

    <div class="vt-header">

      <div class="vt-actions">

        <a href="crear-venta">

          <button class="vt-btn-primary">

            <i class="fa fa-plus"></i> Agregar venta

          </button>

        </a>

      </div>

      <button type="button" class="vt-btn-outline" id="daterange-btn">

        <i class="fa fa-calendar"></i>

        <span>
          <?php

            if(isset($_GET["fechaInicial"])){

              echo htmlspecialchars($_GET["fechaInicial"], ENT_QUOTES, 'UTF-8')." - ".htmlspecialchars($_GET["fechaFinal"], ENT_QUOTES, 'UTF-8');

            }else{

              echo 'Rango de fecha';

            }

          ?>
        </span>

        <i class="fa fa-caret-down"></i>

      </button>

    </div>

    <div class="vt-card">

      <div style="overflow-x:auto;">

        <table class="ventas-table dt-responsive tablas" width="100%">

          <thead>

            <tr>
              <th style="width:10px">#</th>
              <th>Código factura</th>
              <th>Cliente</th>
              <th>Vendedor</th>
              <th>Forma de pago</th>
              <th>Total</th>
              <th>Fecha</th>
              <th>Detalle compra</th>
              <th>Acciones</th>
            </tr>

          </thead>

          <tbody>

          <?php

            if(isset($_GET["fechaInicial"])){

              $fechaInicial = $_GET["fechaInicial"];
              $fechaFinal = $_GET["fechaFinal"];

            }else{

              $fechaInicial = null;
              $fechaFinal = null;

            }

            $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

            foreach ($respuesta as $key => $value) {

              echo '<tr>

                  <td data-label="#">'.($key+1).'</td>

                  <td data-label="Código factura">'.htmlspecialchars($value["codigo"], ENT_QUOTES, 'UTF-8').'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td data-label="Cliente">'.htmlspecialchars(($respuestaCliente ? $respuestaCliente["nombre"] : "Eliminado"), ENT_QUOTES, 'UTF-8').'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td data-label="Vendedor">'.htmlspecialchars(($respuestaUsuario ? $respuestaUsuario["nombre"] : "Eliminado"), ENT_QUOTES, 'UTF-8').'</td>

                  <td data-label="Forma de pago">'.htmlspecialchars($value["metodo_pago"], ENT_QUOTES, 'UTF-8').'</td>

                  <td data-label="Total">$ '.number_format($value["total"],2).'</td>

                  <td data-label="Fecha">'.htmlspecialchars($value["fecha"], ENT_QUOTES, 'UTF-8').'</td>

                  <td data-label="Detalle compra" style="max-width:280px;">';

                    $productosVenta = json_decode($value["productos"], true);

                    if(is_array($productosVenta)){
                      echo '<div class="vt-tags">';
                      foreach ($productosVenta as $p) {
                        echo '<span class="vt-tag">'.htmlspecialchars($p["descripcion"], ENT_QUOTES, 'UTF-8').' <strong>x'.$p["cantidad"].'</strong></span> ';
                      }
                      echo '</div>';
                    }

                  echo '</td>

                  <td data-label="Acciones">

                    <div class="vt-actions">

                      <a class="vt-btn-icon vt-green" href="vistas/modulos/descargar-reporte.php?reporte=ventas">
                        <i class="fa fa-file-excel-o"></i>
                      </a>

                      <button class="vt-btn-icon vt-blue btnImprimirFactura" codigoVenta="'.$value["codigo"].'">
                        <i class="fa fa-print"></i>
                      </button>

                    </div>

                  </td>

                </tr>';
            }

          ?>

          </tbody>

        </table>

      </div>

      <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>

    </div>

  </section>

</div>
