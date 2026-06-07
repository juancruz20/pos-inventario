<?php

require_once "conexion.php";

class ModeloEans{

	/*=============================================
	MOSTRAR EANS
	=============================================*/

	static public function mdlMostrarEans($tabla, $item, $valor){

		if($item != null){
			Conexion::validarColumna($item, $tabla);
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	REGISTRO DE EAN
	=============================================*/

	static public function mdlIngresarEan($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo_ean, descripcion, id_producto) VALUES (:codigo_ean, :descripcion, :id_producto)");

		$stmt->bindParam(":codigo_ean", $datos["codigo_ean"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($datos["id_producto"] === null || $datos["id_producto"] === ""){
			$stmt->bindValue(":id_producto", null, PDO::PARAM_NULL);
		}else{
			$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		}

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

	}

	/*=============================================
	EDITAR EAN
	=============================================*/

	static public function mdlEditarEan($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo_ean = :codigo_ean, descripcion = :descripcion, id_producto = :id_producto WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_ean", $datos["codigo_ean"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($datos["id_producto"] === null || $datos["id_producto"] === ""){
			$stmt->bindValue(":id_producto", null, PDO::PARAM_NULL);
		}else{
			$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
		}

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

	}

	/*=============================================
	BORRAR EAN
	=============================================*/

	static public function mdlEliminarEan($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

	}

}
