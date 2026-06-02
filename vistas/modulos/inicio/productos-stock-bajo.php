<style>
.dash-box {
  background: var(--dash-card-bg);
  border-radius: var(--dash-radius);
  box-shadow: var(--dash-shadow);
  overflow: hidden;
}
.dash-box-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 18px;
  border-bottom: 1px solid var(--dash-border);
}
.dash-box-title {
  font-size: 14px;
  font-weight: 700;
  color: #2d3748;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 8px;
}
.dash-box-title i { color: var(--dash-danger); }
.dash-box-toggle {
  background: none;
  border: none;
  color: var(--dash-text-muted);
  cursor: pointer;
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 13px;
  transition: background 0.15s;
}
.dash-box-toggle:hover { background: #f0f0f0; }
.dash-box-body { padding: 0; }

.dash-list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.dash-list-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 18px;
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.15s;
}
.dash-list-item:last-child { border-bottom: none; }
.dash-list-item:hover { background: #f8f9fc; }
.dash-list-img {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  object-fit: cover;
  flex-shrink: 0;
  background: #f0f0f0;
}
.dash-list-info { flex: 1; min-width: 0; }
.dash-list-name {
  font-size: 13px;
  font-weight: 600;
  color: #2d3748;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.dash-list-code {
  font-size: 11px;
  color: var(--dash-text-muted);
  margin-top: 1px;
}

.dash-pill {
  display: inline-flex;
  align-items: center;
  padding: 3px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.2px;
  white-space: nowrap;
  flex-shrink: 0;
}
.dash-pill-rojo { background: #fde8e8; color: #c0392b; }
.dash-pill-amarillo { background: #fef9e7; color: #d68910; }
.dash-pill-verde { background: #e8f8f0; color: #1d8348; }

.dash-empty {
  text-align: center;
  padding: 24px;
  color: var(--dash-text-muted);
  font-size: 13px;
}
</style>

<div class="dash-box">
  <div class="dash-box-header">
    <h3 class="dash-box-title"><i class="fa fa-exclamation-triangle"></i> Productos con stock bajo</h3>
    <button class="dash-box-toggle" data-toggle="collapse" data-target="#collapse-stock"><i class="fa fa-minus"></i></button>
  </div>
  <div class="dash-box-body collapse in" id="collapse-stock">
    <ul class="dash-list">

      <?php

      $productosBajoStock = ControladorProductos::ctrMostrarProductosBajoStock();

      if (count($productosBajoStock) > 0):

        foreach ($productosBajoStock as $key => $value):

          $stock = (int) $value["stock"];
          $stockMinimo = isset($value["stock_minimo"]) ? (int) $value["stock_minimo"] : 10;

          if ($stock <= 0) {
            $pillClass = "dash-pill dash-pill-rojo";
          } elseif ($stock <= $stockMinimo / 2) {
            $pillClass = "dash-pill dash-pill-rojo";
          } elseif ($stock <= $stockMinimo) {
            $pillClass = "dash-pill dash-pill-amarillo";
          } else {
            $pillClass = "dash-pill dash-pill-verde";
          }

          $imagen = !empty($value["imagen"]) ? $value["imagen"] : "vistas/img/productos/default/anonymous.png";

          echo '<li class="dash-list-item">
                  <img class="dash-list-img" src="'.$imagen.'" alt="'.$value["descripcion"].'">
                  <div class="dash-list-info">
                    <div class="dash-list-name">'.$value["descripcion"].'</div>
                    <div class="dash-list-code">Código: '.$value["codigo"].'</div>
                  </div>
                  <span class="'.$pillClass.'">'.$stock.' unidades</span>
                </li>';

        endforeach;

      else:

        echo '<div class="dash-empty">No hay productos con stock bajo</div>';

      endif;

      ?>

    </ul>
  </div>
</div>
