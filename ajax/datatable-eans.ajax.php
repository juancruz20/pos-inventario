<?php

require_once "../controladores/eans.controlador.php";
require_once "../modelos/eans.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaEans{

	public function mostrarTablaEans(){

		$item = null;
		$valor = null;

		$eans = ControladorEans::ctrMostrarEans($item, $valor);

		header('Content-Type: application/json; charset=utf-8');

		if(!is_array($eans) || count($eans) == 0){

			echo json_encode(array("data" => array()));

			return;
		}

		$data = array();

		for($i = 0; $i < count($eans); $i++){

			$codigoBadge = "<span class='ean-code'>".htmlspecialchars($eans[$i]["codigo_ean"], ENT_QUOTES, 'UTF-8')."</span>";

			/*=============================================
			PRODUCTO ASOCIADO
			=============================================*/

			if(!empty($eans[$i]["id_producto"])){

				$item = "id";
				$valor = $eans[$i]["id_producto"];
				$orden = "id";

				$prod = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

				if(is_array($prod) && isset($prod["descripcion"])){
					$producto = "<span class='ean-producto-badge'>".htmlspecialchars($prod["codigo"], ENT_QUOTES, 'UTF-8')." — ".htmlspecialchars($prod["descripcion"], ENT_QUOTES, 'UTF-8')."</span>";
				}else{
					$producto = "<span class='ean-producto-vacio'>Producto eliminado</span>";
				}

			}else{

				$producto = "<span class='ean-producto-vacio'>— sin asociar —</span>";

			}

			/*=============================================
			ACCIONES
			=============================================*/

			$botones = "<div class='btn-group'>"
				. "<button class='btn btn-warning btnEditarEan' idEan='".$eans[$i]["id"]."' data-toggle='modal' data-target='#modalEditarEan'><i class='fa fa-pencil'></i></button>"
				. "<button class='btn btn-danger btnEliminarEan' idEan='".$eans[$i]["id"]."'><i class='fa fa-times'></i></button>"
				. "</div>";

			$data[] = array(
				(string) ($i + 1),
				$codigoBadge,
				(string) $eans[$i]["descripcion"],
				$producto,
				(string) $eans[$i]["fecha"],
				$botones
			);

		}

		echo json_encode(array("data" => $data), JSON_UNESCAPED_UNICODE);

	}

}

$activarEans = new TablaEans();
$activarEans -> mostrarTablaEans();
