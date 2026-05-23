<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class TablaProductosVentas{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductosVentas(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

  		if(!is_array($productos) || count($productos) == 0){

  			echo json_encode(array("data" => array()));

		  	return;
  		}

  		$data = array();

  		for($i = 0; $i < count($productos); $i++){

		  	$imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

  			if($productos[$i]["stock"] <= 10){

  				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

  			}else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){

  				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";

  			}else{

  				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";

  			}

		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' style='height:34px;' idProducto='".$productos[$i]["id"]."'>Agregar</button></div>";

			$data[] = array(
				(string) ($i + 1),
				$imagen,
				(string) $productos[$i]["codigo"],
				(string) $productos[$i]["descripcion"],
				$stock,
				$botones
			);

  		}

  		echo json_encode(array("data" => $data), JSON_UNESCAPED_UNICODE);

	}


}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductosVentas = new TablaProductosVentas();
$activarProductosVentas -> mostrarTablaProductosVentas();

