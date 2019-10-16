<?php
//$codigo=$_SESSION['cdcuenta_ssc'];
if ($peticionAjax) {
    require_once "../modelos/seccionesModelo.php";
} else {
    require_once "./modelos/seccionesModelo.php";
}

//contralador para agregar administrador
class seccionesControlador extends seccionesModelo
{
    public function agregar_secciones_controlador($codigo)
    {
        $seccion = mainModel::limpiar_cadena($_POST['seccion']);
        $tiposeccion = mainModel::limpiar_cadena($_POST['tipo_seccion']);
        $prioridad = "";

        if ($tiposeccion === "") {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "Oh, No!",
                "Texto" => "Debes asignar un menú al título",
                "Tipo" => "info"
            ];
        } else {
            if ($seccion === "") {
                $alerta = [
                    "Alerta" => "simple2",
                    "Titulo" => "Oh, No!",
                    "Texto" => "El campo título no debe ir  vacío",
                    "Tipo" => "info"
                ];
            } else {
                $consulta = mainModel::ejecutar_consulta_simple("SELECT nombre FROM secciones WHERE "
                    . "nombre='$seccion'");

                if ($consulta->rowCount() >= 1) {
                    $alerta = [
                        "Alerta" => "simple2",
                        "Titulo" => "Oh, No!",
                        "Texto" => "el titulo que acabas de asignar al menú, ya se encuentra registrado en el sistema",
                        "Tipo" => "info"
                    ];
                } else {
                    $consulta2 = mainModel::ejecutar_consulta_simple("SELECT idsecciones FROM secciones");
                    $numero = ($consulta2->rowCount()) + 1;

                    $fechaactual = date("d/m/Y");
                    $horaactual = date("h:i:s a");

                    $seccion = [
                        "seccion" => utf8_encode($seccion),
                        "tipo" => $tiposeccion,
                        "prioridad" => $prioridad,
                        "cdcuenta" => $codigo,
                        "fecha" => $fechaactual,
                        "hora" => $horaactual,
                        "estatus" => 1
                    ];

                    $guardarseccion = mainModel::agregar_secciones($seccion);
                    if ($guardarseccion->rowCount() >= 1) {

                        $alerta = [
                            "Alerta" => "limpiar",
                            "Titulo" => "Registrado",
                            "Texto" => "Se registro con exito en el sistema",
                            "Tipo" => "success"
                        ];
                    } else {
                        mainModel::eliminar_seccion($volante);
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrio un error inesperado",
                            "Texto" => "No se registro el menú y el título seleccionados",
                            "Tipo" => "error"
                        ];
                    }
                }
            }
        }
        return mainModel::sweet_alert($alerta);
    }

    public function agregar_contenido_controlador()
    {

        $finicio = $_POST['fecha_inicio'];
        $idsecciones = $_POST['secciones'];
        $texto = mainModel::limpiar_cadena($_POST['texto']);
        $link = mainModel::limpiar_cadena($_POST['link']);
        $url = mainModel::limpiar_cadena($_POST['url']);

        $f_final = $_POST['fecha_final'];
        $pdfimg = ($_FILES['pdfimg']);

        $fechaactual = date("Y-m-d H:i");
        if ($idsecciones === "") {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "Oh, No!",
                "Texto" => "Debes seleccionar un título para asignarle contenido",
                "Tipo" => "info"
            ];
        } else {
            if ($texto === "") {
                $alerta = [
                    "Alerta" => "simple2",
                    "Titulo" => "Oh, No!",
                    "Texto" => "El campo texto no debe estar vacío",
                    "Tipo" => "info"
                ];
            } else {
                if ($finicio === "") {
                    $alerta = [
                        "Alerta" => "simple2",
                        "Titulo" => "Oh, No!",
                        "Texto" => "La fecha de inicio no debe estar vacío",
                        "Tipo" => "info"
                    ];
                } else {
                    if ($finicio < $fechaactual) {
                        $alerta = [
                            "Alerta" => "simple2",
                            "Titulo" => "Oh, No!",
                            "Texto" => "La fecha inicial debe ser mayor a la actual",
                            "Tipo" => "info"
                        ];
                    } else {
                        if ($f_final === "") {
                            $alerta = [
                                "Alerta" => "simple2",
                                "Titulo" => "Oh, No!",
                                "Texto" => "La fecha final no debe estar vacío",
                                "Tipo" => "info"
                            ];
                        } else {
                            if ($f_final < $fechaactual) {
                                $alerta = [
                                    "Alerta" => "simple2",
                                    "Titulo" => "Oh, No!",
                                    "Texto" => "La fecha de termino debe ser mayor a la actual",
                                    "Tipo" => "info"
                                ];
                            } else {

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT idsecciones FROM contenidos WHERE "
                                    . "idsecciones='$idsecciones'");

                                if ($consulta->rowCount() >= 1) {
                                    $alerta = [
                                        "Alerta" => "simple",
                                        "Titulo" => "Ocurrio un error inisperado",
                                        "Texto" => "El título que acabas de ingresar ya cuenta con un contenido",
                                        "Tipo" => "error"
                                    ];
                                } else {
                                    $archivo = $_FILES['pdfimg']['tmp_name'];
                                    $tamanio = $_FILES['pdfimg']['size'];
                                    $tipo = $_FILES['pdfimg']['type'];
                                    $nombre = $_FILES['pdfimg']['name'];

                                    $nombre = utf8_encode($nombre);

                                    $fp = fopen($archivo, "r+b");
                                    $contenido = fread($fp, filesize($archivo));
                                    fclose($fp);

                                    if ($link == "") {
                                        $url = "";
                                    }

                                    $contenidosecciones = [
                                        "texto" =>  utf8_encode($texto),
                                        "link" => $url . $link,
                                        "archivo" => $nombre,
                                        "pdfimg" => $contenido,
                                        "tipo" => $tipo,
                                        "finicio" => $finicio,
                                        "ffinal" => $f_final,
                                        "idsecciones" => $idsecciones
                                    ];
                                    $guardarcontenido = seccionesModelo::agregar_contenido_modelo($contenidosecciones);

                                    if ($guardarcontenido->rowCount() >= 1) {
                                        $alerta = [
                                            "Alerta" => "limpiar",
                                            "Titulo" => "Registrado" . $tipo,
                                            "Texto" => "Contenido guardado con exito en el sistema",
                                            "Tipo" => "success"
                                        ];
                                    } else {
                                        $alerta = [
                                            "Alerta" => "simple",
                                            "Titulo" => "Ocurrio un error",
                                            "Texto" => "No se registro el contenido",
                                            "Tipo" => "error"
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return mainModel::sweet_alert($alerta);
    }

    public function agregar_tiposecciones_controlador()
    {

        $seccion = mainModel::limpiar_cadena($_POST['tipo_seccion']);

        if ($seccion === "") {
            $alerta = [
                "Alerta" => "simple2",
                "Titulo" => "¡Oh, No!",
                "Texto" => "El campo menú a ingresar no debe estar vacío",
                "Tipo" => "info"
            ];
        } else {
            $consulta = mainModel::ejecutar_consulta_simple("SELECT
                                                                        tiposecciones.tiposeccion
                                                                        FROM
                                                                        tiposecciones
                                                                        WHERE
                                                                        tiposecciones.tiposeccion = '$seccion'");

            if ($consulta->rowCount() >= 1) {
                $alerta = [
                    "Alerta" => "simple2",
                    "Titulo" => "¡Oh, No!",
                    "Texto" => "El menú que acabas de ingresar ya se encuentra registrado en el sistema",
                    "Tipo" => "info"
                ];
            } else {

                $seccion = [
                    "seccion" => utf8_encode($seccion),
                    "estatus" => '1'
                ];

                $guardarseccion = mainModel::agregar_tiposecciones($seccion);
                if ($guardarseccion->rowCount() >= 1) {
                    $alerta = [
                        "Alerta" => "limpiar",
                        "Titulo" => "Registrado",
                        "Texto" => "El nuevo menú se guardado con exito en el sistema",
                        "Tipo" => "success"
                    ];
                } else {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio algo inesperado",
                        "Texto" => "No se registro el menú",
                        "Tipo" => "error"
                    ];
                }
            }
        }
        return mainModel::sweet_alert($alerta);
    }
}
