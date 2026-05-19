<?php

class Conexion{

    private static $link = null;

    static public function conectar(){

        if(self::$link === null){
            self::$link = new PDO("mysql:host=localhost;dbname=pos",
                                  "root",
                                  "");

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

}