<?php
if ($peticionAjax) {
    require_once "../modelos/edicionseccionesModelo.php";
} else {
    require_once "./modelos/edicionseccionesModelo.php";
}

class edicionseccionesControlador extends actualizarModelo
{
    public function edicion_secciones()
    {
        //Variables extraidas de los campos de ediccionSecciones
        $texto = $_POST['texto'];
        $url = $_POST['url'];
        $link = $_POST['link'];
        $finicio = $_POST['fecha_inicio'];
        $ffinal = $_POST['fecha_final'];
        $idseccion = $_POST['tituloseccion'];
        $idseccionoriginal =  mainModel::decryption($_GET['idseccion']);
        //$extension = end(explode(".", $_FILES['pdfimg']['name'])); //Obtengo la extension del archivo
        $tipo = $_FILES['pdfimg']['type']; //Obtengo la extension del archivo

        if ($texto === "") {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "Oh, No!",
                "Texto" => "El campo texto no puede ir vacio",
                "Tipo" => "info"
            ];
            return mainModel::sweet_alert($alerta);
        }
        //Verificaciones de fechas que no se encuentren vacias
        if ($finicio === "") {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "Oh, No!",
                "Texto" => "La fecha de inicio no debe estar vacío",
                "Tipo" => "info"
            ];
            return mainModel::sweet_alert($alerta);
        }
        if ($ffinal === "") {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "Oh, No!",
                "Texto" => "La fecha de inicio no debe estar vacío",
                "Tipo" => "info"
            ];
            return mainModel::sweet_alert($alerta);
        }
        //Extensiones de archivos permitidas en el sistema
        if ($tipo === "image/jpg" || $tipo === "image/jpeg" || $tipo === "image/jpe" || $tipo === "image/jfif" || $tipo === "image/png" || $tipo === "image/gif" || $tipo === "image/tif" || $tipo === "image/tiff" || $tipo === "application/pdf" || $tipo === "") { } 
        else {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "Oh, No!",
                "Texto" => "El formato de Archivo no es valido",
                "Tipo" => "info"
            ];
            return mainModel::sweet_alert($alerta);
        }
        //Si no tenemos link, no contamos con url
        if ($link == "") {
            $url = "";
        }
        //En caso de que el contenido se cambie a otro titulo lo actualizamos
        if ($idseccion === "") {
            $idseccion = mainModel::decryption($_GET['idseccion']);
        }
        $archivo = $_FILES['pdfimg']['tmp_name'];
        $nombre = $_FILES['pdfimg']['name'];
        $nombre = utf8_encode($nombre);
        $fp = fopen($archivo, "r+b");
        $contenido = fread($fp, filesize($archivo));
        fclose($fp);
        $datoscontenido2 = [
            "texto" =>  utf8_encode($texto),
            "link" => $url . $link,
            "archivo" => $nombre,
            "pdfimg" => $contenido,
            "tipo" => $tipo,
            "finicio" => $finicio,
            "ffinal" => $ffinal,
            "idsecciones" => $idseccion,
            "idseccionesoriginal" => $idseccionoriginal
        ];
        mainModel::actualizar_contenido2($datoscontenido2);
        $alerta = [
            "Alerta" => "edicion",
            "Titulo" => "Registrado",
            "Texto" => "Actualización exitosa en el sistema",
            "Tipo" => "success"
        ];
        return mainModel::sweet_alert($alerta);
    }
}
?>