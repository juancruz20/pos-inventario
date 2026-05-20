<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">
      <i class="fa fa-exclamation-triangle"></i> Productos con stock bajo
    </h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body" style="padding:0;">
    <ul class="products-list product-list-in-box" style="list-style:none; padding:0; margin:0;">

      <?php

      $productosBajoStock = ControladorProductos::ctrMostrarProductosBajoStock();

      if (count($productosBajoStock) > 0):

        foreach ($productosBajoStock as $key => $value):

          $stock = (int) $value["stock"];
          $stockMinimo = isset($value["stock_minimo"]) ? (int) $value["stock_minimo"] : 10;

          if ($stock <= 0) {
            $labelClass = "stock-label-rojo pulse-alert";
          } elseif ($stock <= $stockMinimo / 2) {
            $labelClass = "stock-label-rojo";
          } elseif ($stock <= $stockMinimo) {
            $labelClass = "stock-label-amarillo";
          } else {
            $labelClass = "stock-label-verde";
          }

          $imagen = !empty($value["imagen"]) ? $value["imagen"] : "vistas/img/productos/default/anonymous.png";

          echo '<li class="product-item-low-stock">
                  <img src="'.$imagen.'" alt="'.$value["descripcion"].'">
                  <div class="product-info">
                    <div class="product-name">'.$value["descripcion"].'</div>
                    <div class="product-code">Código: '.$value["codigo"].'</div>
                  </div>
                  <span class="'.$labelClass.' stock-shake">'.$stock.' unidades</span>
                </li>';

        endforeach;

      else:

        echo '<li style="padding:15px; text-align:center; color:#999;">No hay productos con stock bajo</li>';

      endif;

      ?>

    </ul>
  </div>
</div>

<script>
  setTimeout(function () {
    $(".pulse-alert").removeClass("pulse-alert");
    $(".stock-shake").removeClass("stock-shake");
  }, 30000);
</script>
