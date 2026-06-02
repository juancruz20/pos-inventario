<?php

class Conexion{

    private static $link = null;

    static public function conectar(){

        if(self::$link === null){
            require_once __DIR__ . "/../config.php";

            $dsn = "mysql:host=" . DB_HOST
                 . ";port=" . DB_PORT
                 . ";dbname=" . DB_NAME
                 . ";charset=utf8";

            try {
                self::$link = new PDO($dsn, DB_USER, DB_PASS);
                self::$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                throw new Exception(
                    "No se pudo conectar a la base de datos.\n\n"
                    . "Verifica que:\n"
                    . "  1. MySQL este corriendo en " . DB_HOST . ":" . DB_PORT . "\n"
                    . "  2. La base de datos '" . DB_NAME . "' exista (importar pos.sql)\n"
                    . "  3. El usuario '" . DB_USER . "' tenga permisos\n"
                    . "  4. Los datos en config.php sean correctos\n\n"
                    . "Detalle tecnico: " . $e->getMessage()
                );
            }
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
