<?php

require_once __DIR__ . "/../helpers/imagen.helper.php";

class ControladorProductos{

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function ctrMostrarProductos($item, $valor, $orden){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);

		return $respuesta;

	}

	/*=============================================
	PRODUCTOS CON STOCK BAJO
	=============================================*/

	static public function ctrMostrarProductosBajoStock(){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductosBajoStock($tabla);

		return $respuesta;

	}

	/*=============================================
	CREAR PRODUCTO (MODIFICADO: VALIDACIÓN DE IMAGEN)
	=============================================*/

	static public function ctrCrearProducto(){

		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&	
			   preg_match('/^[0-9]+$/', $_POST["nuevoStockMinimo"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoStockMedio"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){

				$detalleCompra = isset($_POST["nuevoDetalleCompra"]) ? $_POST["nuevoDetalleCompra"] : "";
				$precioCompra = isset($_POST["nuevoPrecioCompra"]) ? $_POST["nuevoPrecioCompra"] : 0;

		   		$ruta = "vistas/img/productos/default/anonymous.png";

			   	$nuevaRuta = HelperImagen::subirImagen($_FILES["nuevaImagen"], "vistas/img/productos", $_POST["nuevoCodigo"]);
			   	if($nuevaRuta != ""){
			   		$ruta = $nuevaRuta;
			   	}

				$tabla = "productos";

				$datos = array("id_categoria" => $_POST["nuevaCategoria"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "descripcion" => $_POST["nuevaDescripcion"],
							   "stock" => $_POST["nuevoStock"],
							   "stock_minimo" => $_POST["nuevoStockMinimo"],
							   "stock_medio" => $_POST["nuevoStockMedio"],
							   "precio_compra" => $precioCompra,
							   "precio_venta" => $_POST["nuevoPrecioVenta"],
							   "imagen" => $ruta,
							   "detalle_compra" => $detalleCompra);

				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	EDITAR PRODUCTO (MODIFICADO: VALIDACIÓN DE IMAGEN)
	=============================================*/

	static public function ctrEditarProducto(){

		if(isset($_POST["editarDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&	
			   preg_match('/^[0-9]+$/', $_POST["editarStockMinimo"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarStockMedio"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])){

				$detalleCompra = isset($_POST["editarDetalleCompra"]) ? $_POST["editarDetalleCompra"] : "";
				$precioCompra = isset($_POST["editarPrecioCompra"]) ? $_POST["editarPrecioCompra"] : 0;

		   		$ruta = $_POST["imagenActual"];

			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){
						HelperImagen::eliminarImagen($_POST["imagenActual"]);
					}

					$nuevaRuta = HelperImagen::subirImagen($_FILES["editarImagen"], "vistas/img/productos", $_POST["editarCodigo"]);
					if($nuevaRuta != ""){
						$ruta = $nuevaRuta;
					}

				}

				$tabla = "productos";

				$datos = array("id_categoria" => $_POST["editarCategoria"],
							   "codigo" => $_POST["editarCodigo"],
							   "descripcion" => $_POST["editarDescripcion"],
							   "stock" => $_POST["editarStock"],
							   "stock_minimo" => $_POST["editarStockMinimo"],
							   "stock_medio" => $_POST["editarStockMedio"],
							   "precio_compra" => $precioCompra,
							   "precio_venta" => $_POST["editarPrecioVenta"],
							   "imagen" => $ruta,
							   "detalle_compra" => $detalleCompra);

				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto(){

		if(isset($_GET["idProducto"])){

			$tabla ="productos";
			$datos = $_GET["idProducto"];

			if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){
				HelperImagen::eliminarImagen($_GET["imagen"]);
				HelperImagen::eliminarDirectorio('vistas/img/productos/'.$_GET["codigo"]);
			}

			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "productos";

								}
							})

				</script>';

			}		
		}


	}

	/*=============================================
	ACTUALIZAR STOCK (ajuste positivo/negativo)
	=============================================*/

	static public function ctrActualizarStock(){

		if(isset($_POST["idProducto"]) && isset($_POST["cantidad"])){

			$tabla = "productos";
			$id = $_POST["idProducto"];
			$cantidad = (int) $_POST["cantidad"];

			if($cantidad === 0){
				return "error";
			}

			$item = "id";
			$valor = $id;
			$orden = "id";

			$traerProducto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);

			if(!$traerProducto){
				return "error";
			}

			$nuevoStock = (int) $traerProducto["stock"] + $cantidad;

			if($nuevoStock < 0){
				return "stock_negativo";
			}

			$respuesta = ModeloProductos::mdlActualizarProducto($tabla, "stock", $nuevoStock, $id);

			return $respuesta;

		}

	}

	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	static public function ctrMostrarSumaVentas(){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);

		return $respuesta;

	}

}
?>