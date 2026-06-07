<?php

require_once "../controladores/eans.controlador.php";
require_once "../modelos/eans.modelo.php";

class AjaxEans{

	public $idEan;

	public function ajaxEditarEan(){

		$item = "id";
		$valor = $this->idEan;

		$respuesta = ControladorEans::ctrMostrarEans($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR EAN
=============================================*/

if(isset($_POST["idEan"])){

	$editarEan = new AjaxEans();
	$editarEan -> idEan = $_POST["idEan"];
	$editarEan -> ajaxEditarEan();

}
