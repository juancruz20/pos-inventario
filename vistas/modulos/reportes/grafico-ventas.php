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


<div class="row">

  <div class="col-lg-6 col-md-6 col-xs-12">

    <div class="box box-solid bg-teal-gradient">

    	<div class="box-header">

     		<i class="fa fa-th"></i>

      		<h3 class="box-title">Gráfico de Ventas Mensual</h3>

    	</div>

    	<div class="box-body border-radius-none">

    		<div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

      </div>

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
        lineColors       : ['#FFFFFF'],
        lineWidth        : 4,
        hideHover        : 'auto',
        gridTextColor    : '#fff',
        gridStrokeWidth  : 0.4,
        pointSize        : 0,
        gridLineColor    : 'rgba(255,255,255,0.15)',
        gridTextFamily   : 'Open Sans',
        preUnits         : '$',
        gridTextSize     : 10
      });

    </script>

  </div>

  <div class="col-lg-6 col-md-6 col-xs-12">

    <div class="box box-solid bg-light-blue-gradient">

    	<div class="box-header">

     		<i class="fa fa-calendar"></i>

      		<h3 class="box-title">Gráfico de Ventas Diarias</h3>

    	</div>

    	<div class="box-body border-radius-none">

    		<div class="chart" id="line-chart-ventas-dia" style="height: 250px;"></div>

      </div>

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
        lineColors       : ['#FFFFFF'],
        lineWidth        : 4,
        hideHover        : 'auto',
        gridTextColor    : '#fff',
        gridStrokeWidth  : 0.4,
        pointSize        : 0,
        gridLineColor    : 'rgba(255,255,255,0.15)',
        gridTextFamily   : 'Open Sans',
        preUnits         : '$',
        gridTextSize     : 10
      });

    </script>

  </div>

</div>
