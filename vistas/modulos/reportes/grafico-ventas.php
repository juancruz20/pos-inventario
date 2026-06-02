<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayVentas = array();
$sumaPagosMes = array();

$arrayFechasDia = array();
$sumaPagosDia = array();

$arrayImpuestoMes = array();
$arrayNetoMes = array();

foreach ($respuesta as $key => $value) {

	$fecha = substr($value["fecha"],0,7);
	$fechaDia = substr($value["fecha"],0,10);

	array_push($arrayFechas, $fecha);
	array_push($arrayFechasDia, $fechaDia);

	$arrayVentas = array($fecha => $value["total"]);
	$arrayVentasDia = array($fechaDia => $value["total"]);

	foreach ($arrayVentas as $k => $v) {
		$sumaPagosMes[$k] += $v;
	}

	foreach ($arrayVentasDia as $k => $v) {
		$sumaPagosDia[$k] += $v;
	}

}

$noRepetirFechas = array_unique($arrayFechas);
$noRepetirFechasDia = array_unique($arrayFechasDia);

$sumaImpuestoMes = array();
$sumaNetoMes = array();

foreach ($respuesta as $key => $value) {
	$fecha = substr($value["fecha"],0,7);
	$sumaImpuestoMes[$fecha] += $value["impuesto"];
	$sumaNetoMes[$fecha] += $value["neto"];
}

?>

<style>
.dash-chart-box {
  background: var(--dash-card-bg);
  border-radius: var(--dash-radius);
  box-shadow: var(--dash-shadow);
  overflow: hidden;
}
.dash-chart-header {
  padding: 14px 18px;
  border-bottom: 1px solid var(--dash-border);
  display: flex;
  align-items: center;
  gap: 10px;
}
.dash-chart-header i {
  font-size: 16px;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  color: #fff;
}
.dash-chart-header i.monthly { background: linear-gradient(135deg,#4e73df,#224abe); }
.dash-chart-header i.daily { background: linear-gradient(135deg,#36b9cc,#1a8a9e); }
.dash-chart-title {
  font-size: 14px;
  font-weight: 700;
  color: #2d3748;
  margin: 0;
}
.dash-chart-body {
  padding: 14px;
}
.dash-chart-body .chart {
  height: 220px;
}

.dash-chart-box .morris-hover {
  border-radius: 8px !important;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12) !important;
  border: none !important;
  padding: 8px 12px !important;
  font-family: var(--dash-font) !important;
}
</style>

<div class="dash-chart-box">
  <div class="dash-chart-header">
    <i class="fa fa-chart-line monthly"></i>
    <h3 class="dash-chart-title">Ventas Mensuales</h3>
  </div>
  <div class="dash-chart-body">
    <div class="chart" id="line-chart-ventas" style="height:220px;"></div>
  </div>
  <script>
    var line = new Morris.Line({
      element          : 'line-chart-ventas',
      resize           : true,
      data             : [

      <?php

      if($noRepetirFechas != null){

  	    foreach($noRepetirFechas as $key){

  	    	echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." },";

  	    }

  	    echo "{y: '".$key."', ventas: ".$sumaPagosMes[$key]." }";

      }else{

         echo "{ y: '0', ventas: '0' }";

      }

      ?>

      ],
      xkey             : 'y',
      ykeys            : ['ventas'],
      labels           : ['ventas'],
      lineColors       : ['#4e73df'],
      lineWidth        : 3,
      hideHover        : 'auto',
      gridTextColor    : '#858796',
      gridStrokeWidth  : 0.4,
      pointSize        : 3,
      pointFillColors  : ['#4e73df'],
      pointStrokeColors: ['#fff'],
      gridLineColor    : 'rgba(0,0,0,0.06)',
      gridTextFamily   : 'Inter, system-ui, sans-serif',
      preUnits         : '$',
      gridTextSize     : 11
    });
  </script>
</div>

<div class="dash-chart-box">
  <div class="dash-chart-header">
    <i class="fa fa-calendar-alt daily"></i>
    <h3 class="dash-chart-title">Ventas Diarias</h3>
  </div>
  <div class="dash-chart-body">
    <div class="chart" id="line-chart-ventas-dia" style="height:220px;"></div>
  </div>
  <script>
    var lineDia = new Morris.Line({
      element          : 'line-chart-ventas-dia',
      resize           : true,
      data             : [

      <?php

      if($noRepetirFechasDia != null){

      	$contador = 0;
  	    foreach($noRepetirFechasDia as $key){
  	    	$contador++;
  	    	echo "{ y: '".$key."', ventas: ".$sumaPagosDia[$key]." },";
  	    }

  	    echo "{y: '".$key."', ventas: ".$sumaPagosDia[$key]." }";

      }else{

         echo "{ y: '0', ventas: '0' }";

      }

      ?>

      ],
      xkey             : 'y',
      ykeys            : ['ventas'],
      labels           : ['ventas'],
      lineColors       : ['#36b9cc'],
      lineWidth        : 3,
      hideHover        : 'auto',
      gridTextColor    : '#858796',
      gridStrokeWidth  : 0.4,
      pointSize        : 3,
      pointFillColors  : ['#36b9cc'],
      pointStrokeColors: ['#fff'],
      gridLineColor    : 'rgba(0,0,0,0.06)',
      gridTextFamily   : 'Inter, system-ui, sans-serif',
      preUnits         : '$',
      gridTextSize     : 11
    });
  </script>
</div>
