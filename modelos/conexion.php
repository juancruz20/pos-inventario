<?php

class Conexion{

    private static $link = null;

    static public function conectar(){

        if(self::$link === null){
            require_once __DIR__ . "/../config.php";
            self::$link = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                                  DB_USER,
                                  DB_PASS);

            self::$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$link->exec("set names utf8");
        }

        return self::$link;

    }

    static public function iniciarTransaccion(){
        $db = self::conectar();
        if(!$db->inTransaction()){
            $db->beginTransaction();
        }
    }

    static public function confirmarTransaccion(){
        $db = self::conectar();
        if($db->inTransaction()){
            $db->commit();
        }
    }

    static public function revertirTransaccion(){
        $db = self::conectar();
        if($db->inTransaction()){
            $db->rollBack();
        }
    }

    static public function validarColumna($columna, $tabla){
        $columnasPermitidas = [
            "productos" => ["id", "id_categoria", "codigo", "descripcion", "imagen", "stock", "precio_compra", "precio_venta", "detalle_compra", "ventas", "fecha"],
            "categorias" => ["id", "categoria", "fecha"],
            "clientes" => ["id", "nombre", "documento", "email", "telefono", "direccion", "fecha_nacimiento", "tipo_comprobante", "compras", "ultima_compra", "fecha"],
            "usuarios" => ["id", "nombre", "usuario", "password", "perfil", "foto", "estado", "ultimo_login", "fecha"],
            "ventas" => ["id", "codigo", "id_cliente", "id_vendedor", "productos", "impuesto", "neto", "total", "metodo_pago", "fecha"],
        ];
        if(!isset($columnasPermitidas[$tabla])){
            throw new Exception("Tabla no permitida: " . $tabla);
        }
        if(!in_array($columna, $columnasPermitidas[$tabla])){
            throw new Exception("Columna no permitida: " . $columna . " en tabla " . $tabla);
        }
        return true;
    }

}