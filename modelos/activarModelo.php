<?php

if($peticionAjax){
     require_once "../nucleo/mainModel.php";
    }else {
    require_once "./nucleo/mainModel.php";
}
class activarModelo extends mainModel{    
    protected function activar_modelo($nomtitulo,$idtiposeccion){
        
        $nomtitulo=mainModel::decryption($nomtitulo);
        $idtiposeccion=mainModel::decryption($idtiposeccion);
        
        $datos=[
           "titulo"=>utf8_encode($nomtitulo),
            "idtiposeccion"=>$idtiposeccion
        ];
        
        $desactivar=mainModel::activar_estatus($datos);
        
//        print_r($nomtitulo);
//        print_r($idtiposeccion);
//        print_r($nomtitulo);
        if($desactivar->rowCount()>=1){
            $respuesta="TRUE";
        }else{
            $respuesta="FALSE";
        }
        return $respuesta;
    }
}