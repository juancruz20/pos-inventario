<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";


class TablaProductos{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductos(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);	
		header('Content-Type: application/json; charset=utf-8');

		if(!is_array($productos) || count($productos) == 0){

			echo json_encode(array("data" => array()));

		  	return;
		}
		
		$data = array();

		for($i = 0; $i < count($productos); $i++){

		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 

			$imagenProducto = !empty($productos[$i]["imagen"]) ? $productos[$i]["imagen"] : "vistas/img/productos/default/anonymous.png";
		  	$imagen = "<img src='".$imagenProducto."' width='40px'>";

		  	/*=============================================
 	 		TRAEMOS LA CATEGORIA
  			=============================================*/ 

		  	$item = "id";
		  	$valor = $productos[$i]["id_categoria"];

		  	$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
			$nombreCategoria = (is_array($categorias) && isset($categorias["categoria"])) ? $categorias["categoria"] : "Sin categoría";

		  	/*=============================================
 	 		STOCK
  			=============================================*/ 

  			if($productos[$i]["stock"] <= 10){

  				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

  			}else if($productos[$i]["stock"] > 10 && $productos[$i]["stock"] <= 15){

  				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";

  			}else{

  				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";

  			}

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial"){

  				$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button></div>"; 

  			}else{

  				$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$imagenProducto."'><i class='fa fa-times'></i></button></div>"; 

  			}

			$controlStock = "<div class='input-group input-group-sm' style='width:140px'><input type='number' class='form-control input-actualizar-stock' data-id='".$productos[$i]["id"]."' placeholder='+/- cantidad' step='1' style='height:28px;font-size:12px;'><span class='input-group-btn'><button class='btn btn-success btn-actualizar-stock' data-id='".$productos[$i]["id"]."' type='button'><i class='fa fa-plus'></i></button></span></div>";

			$data[] = array(
				(string) ($i + 1),
				$imagen,
				(string) $productos[$i]["codigo"],
				(string) $productos[$i]["descripcion"],
				(string) $nombreCategoria,
				$stock,
				$controlStock,
				(string) $productos[$i]["precio_compra"],
				(string) $productos[$i]["precio_venta"],
				(string) $productos[$i]["fecha"],
				$botones
			);

		}
		
		echo json_encode(array("data" => $data), JSON_UNESCAPED_UNICODE);


	}



}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductos = new TablaProductos();
$activarProductos -> mostrarTablaProductos();


