<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxActualizarStock{

	public $idProducto;
	public $cantidad;

	public function ajaxActualizarStock(){

		$respuesta = ControladorProductos::ctrActualizarStock();

		echo json_encode($respuesta);

	}

}

if(isset($_POST["idProducto"])){

	$actualizar = new AjaxActualizarStock();
	$actualizar -> idProducto = $_POST["idProducto"];
	$actualizar -> cantidad = $_POST["cantidad"];
	$actualizar -> ajaxActualizarStock();

}
