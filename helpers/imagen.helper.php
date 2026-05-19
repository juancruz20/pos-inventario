<?php

class HelperImagen{

    public static function subirImagen($archivo, $directorioBase, $nombreSubdirectorio, $ancho = 500, $alto = 500){

        $ruta = "";

        if(!isset($archivo) || $archivo["error"] !== UPLOAD_ERR_OK || empty($archivo["tmp_name"])){
            return $ruta;
        }

        if(!is_uploaded_file($archivo["tmp_name"])){
            return $ruta;
        }

        $datosImagen = getimagesize($archivo["tmp_name"]);
        if($datosImagen === false){
            return $ruta;
        }

        list($anchoOrig, $altoOrig) = $datosImagen;

        $directorio = $directorioBase . "/" . $nombreSubdirectorio;
        if(!is_dir($directorio)){
            mkdir($directorio, 0755, true);
        }

        $aleatorio = mt_rand(100, 999);

        if($datosImagen["mime"] == "image/jpeg"){
            $ruta = $directorio . "/" . $aleatorio . ".jpg";
            $origen = imagecreatefromjpeg($archivo["tmp_name"]);
            $destino = imagecreatetruecolor($ancho, $alto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $anchoOrig, $altoOrig);
            imagejpeg($destino, $ruta);
        }elseif($datosImagen["mime"] == "image/png"){
            $ruta = $directorio . "/" . $aleatorio . ".png";
            $origen = imagecreatefrompng($archivo["tmp_name"]);
            $destino = imagecreatetruecolor($ancho, $alto);
            imagealphablending($destino, false);
            imagesavealpha($destino, true);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $anchoOrig, $altoOrig);
            imagepng($destino, $ruta);
        }

        return $ruta;
    }

    public static function eliminarImagen($ruta){
        if(!empty($ruta) && file_exists($ruta)){
            unlink($ruta);
        }
    }

    public static function eliminarDirectorio($path){
        if(is_dir($path)){
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file){
                $filePath = "$path/$file";
                is_dir($filePath) ? self::eliminarDirectorio($filePath) : unlink($filePath);
            }
            rmdir($path);
        }
    }

}
