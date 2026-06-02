<?php

$item = null;
$valor = null;
$orden = "id";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$cantidadProductos = is_array($productos) ? count($productos) : 0;
$limiteProductos = min(10, $cantidadProductos);

 ?>

<style>
.dash-recent .dash-box-title i { color: var(--dash-primary); }
.dash-recent-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 18px;
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.15s;
}
.dash-recent-item:last-child { border-bottom: none; }
.dash-recent-item:hover { background: #f8f9fc; }
.dash-recent-img {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  object-fit: cover;
  flex-shrink: 0;
  background: #f0f0f0;
}
.dash-recent-info { flex: 1; min-width: 0; }
.dash-recent-name {
  font-size: 13px;
  font-weight: 600;
  color: #2d3748;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.dash-recent-price {
  font-size: 12px;
  font-weight: 700;
  color: var(--dash-primary);
  flex-shrink: 0;
}
.dash-box-footer {
  padding: 10px 18px;
  text-align: center;
  border-top: 1px solid var(--dash-border);
}
.dash-box-footer a {
  font-size: 12px;
  font-weight: 600;
  color: var(--dash-primary);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.dash-box-footer a:hover { text-decoration: underline; }
</style>

<div class="dash-box dash-recent">
  <div class="dash-box-header">
    <h3 class="dash-box-title"><i class="fa fa-clock-o"></i> Productos Recientes</h3>
    <button class="dash-box-toggle" data-toggle="collapse" data-target="#collapse-recent"><i class="fa fa-minus"></i></button>
  </div>
  <div class="dash-box-body collapse in" id="collapse-recent">
    <ul class="dash-list">

    <?php

    for($i = 0; $i < $limiteProductos; $i++){

      $imagenProducto = !empty($productos[$i]["imagen"]) ? $productos[$i]["imagen"] : "vistas/img/productos/default/anonymous.png";

      echo '<li class="dash-recent-item">
        <img class="dash-recent-img" src="'.$imagenProducto.'" alt="'.$productos[$i]["descripcion"].'">
        <div class="dash-recent-info">
          <div class="dash-recent-name">'.$productos[$i]["descripcion"].'</div>
        </div>
        <span class="dash-recent-price">$'.number_format($productos[$i]["precio_venta"],2).'</span>
      </li>';

    }

    ?>

    </ul>
  </div>
  <div class="dash-box-footer">
    <a href="productos">Ver todos los productos &rarr;</a>
  </div>
</div>
