<?php

class ControladorEans{

	/*=============================================
	MOSTRAR EANS
	=============================================*/

	static public function ctrMostrarEans($item, $valor){

		$tabla = "eans";

		$respuesta = ModeloEans::mdlMostrarEans($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR EAN
	=============================================*/

	static public function ctrCrearEan(){

		if(isset($_POST["nuevoCodigoEan"])){

			if(preg_match('/^[0-9]+$/', $_POST["nuevoCodigoEan"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .,()\-_/]+$/u', $_POST["nuevaDescripcionEan"])){

				$idProducto = (isset($_POST["nuevoIdProductoEan"]) && $_POST["nuevoIdProductoEan"] !== "") ? $_POST["nuevoIdProductoEan"] : null;

				$tabla = "eans";

				$datos = array(
					"codigo_ean"  => $_POST["nuevoCodigoEan"],
					"descripcion" => $_POST["nuevaDescripcionEan"],
					"id_producto" => $idProducto
				);

				$respuesta = ModeloEans::mdlIngresarEan($tabla, $datos);

				if($respuesta == "ok"){

					echo '<script>
						swal({
							type: "success",
							title: "El EAN ha sido guardado correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "eans";
							}
						})
					</script>';

				}else{

					echo '<script>
						swal({
							type: "error",
							title: "No se pudo guardar el EAN (es posible que el código ya exista)",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "eans";
							}
						})
					</script>';

				}

			}else{

				echo '<script>
					swal({
						type: "error",
						title: "¡El EAN o la descripción no pueden estar vacíos o llevar caracteres no permitidos!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if (result.value) {
							window.location = "eans";
						}
					})
				</script>';

			}

		}

	}

	/*=============================================
	EDITAR EAN
	=============================================*/

	static public function ctrEditarEan(){

		if(isset($_POST["editarCodigoEan"])){

			if(preg_match('/^[0-9]+$/', $_POST["editarCodigoEan"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .,()\-_/]+$/u', $_POST["editarDescripcionEan"])){

				$idProducto = (isset($_POST["editarIdProductoEan"]) && $_POST["editarIdProductoEan"] !== "") ? $_POST["editarIdProductoEan"] : null;

				$tabla = "eans";

				$datos = array(
					"id"          => $_POST["editarIdEan"],
					"codigo_ean"  => $_POST["editarCodigoEan"],
					"descripcion" => $_POST["editarDescripcionEan"],
					"id_producto" => $idProducto
				);

				$respuesta = ModeloEans::mdlEditarEan($tabla, $datos);

				if($respuesta == "ok"){

					echo '<script>
						swal({
							type: "success",
							title: "El EAN ha sido editado correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "eans";
							}
						})
					</script>';

				}else{

					echo '<script>
						swal({
							type: "error",
							title: "No se pudo editar el EAN (es posible que el código ya exista)",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "eans";
							}
						})
					</script>';

				}

			}else{

				echo '<script>
					swal({
						type: "error",
						title: "¡El EAN o la descripción no pueden estar vacíos o llevar caracteres no permitidos!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if (result.value) {
							window.location = "eans";
						}
					})
				</script>';

			}

		}

	}

	/*=============================================
	ELIMINAR EAN
	=============================================*/

	static public function ctrEliminarEan(){

		if(isset($_GET["idEan"])){

			$tabla = "eans";
			$datos = $_GET["idEan"];

			$respuesta = ModeloEans::mdlEliminarEan($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>
					swal({
						type: "success",
						title: "El EAN ha sido borrado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if (result.value) {
							window.location = "eans";
						}
					})
				</script>';

			}

		}

	}

}
?>
