<?php

$item = null;
$valor = null;
$orden = "ventas";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

$colores = array("#e74a3b","#1cc88a","#f6c23e","#4e73df","#36b9cc","#6f42c1","#e83e8c","#fd7e14","#20c997","#007bff");

$totalVentas = ControladorProductos::ctrMostrarSumaVentas();
$cantidadProductos = is_array($productos) ? count($productos) : 0;
$limiteGrafico = min(10, $cantidadProductos);
$limiteListado = min(5, $cantidadProductos);
$sumaVentas = (isset($totalVentas["total"]) && $totalVentas["total"] > 0) ? $totalVentas["total"] : 0;

?>

<style>
.dash-top .dash-box-title i { color: var(--dash-warning); }
.dash-top-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}
@media (max-width: 768px) {
  .dash-top-layout { grid-template-columns: 1fr; }
}
.dash-top-chart { padding: 0; }
.dash-top-legend { padding: 0; }
.dash-legend {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.dash-legend li {
  font-size: 12px;
  color: var(--dash-text);
  padding: 5px 10px;
  border-radius: 6px;
  transition: background 0.15s;
  display: flex;
  align-items: center;
  gap: 8px;
}
.dash-legend li:hover { background: #f8f9fc; }
.dash-legend-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  flex-shrink: 0;
}
.dash-legend-text {
  flex: 1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.dash-top-list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.dash-top-list-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 18px;
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.15s;
}
.dash-top-list-item:last-child { border-bottom: none; }
.dash-top-list-item:hover { background: #f8f9fc; }
.dash-top-list-img {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  object-fit: cover;
  flex-shrink: 0;
  background: #f0f0f0;
}
.dash-top-list-info { flex: 1; min-width: 0; }
.dash-top-list-name {
  font-size: 13px;
  font-weight: 600;
  color: #2d3748;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.dash-top-list-pct {
  font-size: 12px;
  font-weight: 700;
  flex-shrink: 0;
}
</style>

<div class="dash-box dash-top">
  <div class="dash-box-header">
    <h3 class="dash-box-title"><i class="fa fa-trophy"></i> Productos más vendidos</h3>
    <button class="dash-box-toggle" data-toggle="collapse" data-target="#collapse-top"><i class="fa fa-minus"></i></button>
  </div>
  <div class="dash-box-body collapse in" id="collapse-top">
    <div class="dash-top-layout">

      <div class="dash-top-chart">
        <div class="chart-responsive">
          <canvas id="pieChart" height="160"></canvas>
        </div>
      </div>

      <div class="dash-top-legend">
        <ul class="dash-legend">

        <?php
          for($i = 0; $i < $limiteGrafico; $i++){
            echo '<li>
                    <span class="dash-legend-dot" style="background:'.$colores[$i].'"></span>
                    <span class="dash-legend-text">'.$productos[$i]["descripcion"].'</span>
                  </li>';
          }
        ?>

        </ul>
      </div>

    </div>
  </div>

  <div class="dash-box-footer" style="padding:0;">
    <ul class="dash-top-list">

       <?php
          for($i = 0; $i < $limiteListado; $i++){

            $porcentajeVentas = ($sumaVentas > 0) ? ceil($productos[$i]["ventas"] * 100 / $sumaVentas) : 0;
            $imagenProducto = !empty($productos[$i]["imagen"]) ? $productos[$i]["imagen"] : "vistas/img/productos/default/anonymous.png";

            echo '<li class="dash-top-list-item">
                   <img class="dash-top-list-img" src="'.$imagenProducto.'" alt="'.$productos[$i]["descripcion"].'">
                   <div class="dash-top-list-info">
                     <div class="dash-top-list-name">'.$productos[$i]["descripcion"].'</div>
                   </div>
                   <span class="dash-top-list-pct" style="color:'.$colores[$i].'">'.$porcentajeVentas.'%</span>
                 </li>';

          }
       ?>

    </ul>
  </div>

</div>

<script>

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [

  <?php

  for($i = 0; $i < $limiteGrafico; $i++){

  	echo "{
      value    : ".$productos[$i]["ventas"].",
      color    : '".$colores[$i]."',
      highlight: '".$colores[$i]."',
      label    : '".$productos[$i]["descripcion"]."'
    },";

  }

   ?>
  ];
  var pieOptions     = {
    segmentShowStroke    : true,
    segmentStrokeColor   : '#fff',
    segmentStrokeWidth   : 2,
    percentageInnerCutout: 55,
    animationSteps       : 80,
    animationEasing      : 'easeOutQuart',
    animateRotate        : true,
    animateScale         : false,
    responsive           : true,
    maintainAspectRatio  : false,
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    tooltipTemplate      : '<%=value %> <%=label%>'
  };
  pieChart.Doughnut(PieData, pieOptions);

</script>
