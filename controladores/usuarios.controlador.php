<?php

require_once __DIR__ . "/../helpers/imagen.helper.php";

class ControladorUsuarios{

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/

	static public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])){

			   	$encriptar = password_hash($_POST["ingPassword"], PASSWORD_BCRYPT);

				$tabla = "usuarios";

				$item = "usuario";
				$valor = $_POST["ingUsuario"];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				if(is_array($respuesta) && $respuesta["usuario"] == $_POST["ingUsuario"] && password_verify($_POST["ingPassword"], $respuesta["password"])){

					if($respuesta["estado"] == 1){

						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["usuario"] = $respuesta["usuario"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["perfil"] = $respuesta["perfil"];

						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/

						date_default_timezone_set('America/Bogota');

						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$fechaActual = $fecha.' '.$hora;

						$item1 = "ultimo_login";
						$valor1 = $fechaActual;

						$item2 = "id";
						$valor2 = $respuesta["id"];

						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

						if($ultimoLogin == "ok"){

							echo '<script>

								window.location = "inicio";

							</script>';

						}				
						
					}else{

						echo '<br>
							<div class="alert alert-danger">El usuario aún no está activado</div>';

					}		

				}else{

					echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

				}

			}	

		}

	}

	/*=============================================
	REGISTRO DE USUARIO (MODIFICADO: SIN PERFIL ESPECIAL)
	=============================================*/

	static public function ctrCrearUsuario(){

    if(isset($_POST["nuevoUsuario"])){

        if(
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])
        ){

            /*=============================================
            VALIDAR IMAGEN
            =============================================*/

            $ruta = HelperImagen::subirImagen($_FILES["nuevaFoto"], "vistas/img/usuarios", $_POST["nuevoUsuario"]);

            $tabla = "usuarios";

            $encriptar = password_hash($_POST["nuevoPassword"], PASSWORD_BCRYPT);

            // ========== NUEVA VALIDACIÓN: ELIMINAR PERFIL "ESPECIAL" ==========
            $permitidos = ["Administrador", "Vendedor"];
            $perfil = $_POST["nuevoPerfil"];
            if (!in_array($perfil, $permitidos)) {
                $perfil = "Vendedor"; // por defecto, si no es válido
            }
            // =================================================================

            $datos = array(
                "nombre" => $_POST["nuevoNombre"],
                "usuario" => $_POST["nuevoUsuario"],
                "password" => $encriptar,
                "perfil" => $perfil,
                "foto" => $ruta
            );

            $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

            if($respuesta == "ok"){

                echo '<script>

                    swal({
                        type: "success",
                        title: "¡El usuario ha sido guardado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location = "usuarios";
                        }
                    });

                </script>';

            }

        }else{

            echo '<script>

                swal({
                    type: "error",
                    title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location = "usuarios";
                    }
                });

            </script>';

        }

    }

}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO (MODIFICADO: SIN PERFIL ESPECIAL)
	=============================================*/

	static public function ctrEditarUsuario(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					if(!empty($_POST["fotoActual"])){
						HelperImagen::eliminarImagen($_POST["fotoActual"]);
					}

					$ruta = HelperImagen::subirImagen($_FILES["editarFoto"], "vistas/img/usuarios", $_POST["editarUsuario"]);

				}

				$tabla = "usuarios";

				if($_POST["editarPassword"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

						$encriptar = password_hash($_POST["editarPassword"], PASSWORD_BCRYPT);

					}else{

						echo'<script>

								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result) {
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

						  	return;

					}

				}else{

					$encriptar = $_POST["passwordActual"];

				}

				// ========== NUEVA VALIDACIÓN: ELIMINAR PERFIL "ESPECIAL" ==========
				$permitidos = ["Administrador", "Vendedor"];
				$perfil = $_POST["editarPerfil"];
				if (!in_array($perfil, $permitidos)) {
					$perfil = "Vendedor";
				}
				// =================================================================

				$datos = array("nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "perfil" => $perfil,
							   "foto" => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "usuarios";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];

			if($_GET["fotoUsuario"] != ""){
				HelperImagen::eliminarImagen($_GET["fotoUsuario"]);
				HelperImagen::eliminarDirectorio('vistas/img/usuarios/'.$_GET["usuario"]);
			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';

			}		

		}

	}

}
?>