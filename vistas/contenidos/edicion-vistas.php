<script>
    $(function() {
        function addZero(x, n) {
            while (x.toString().length < n) {
                x = "0" + x;
            }
            return x;
        }
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker1").datetimepicker({
            format: "Y/M/D H:m",
            minDate: new Date()
        });
        $("#datepicker2").datetimepicker({
            format: "Y/M/D H:m",
            minDate: new Date()
        });
        $("#datepicker1").on("dp.change", function(e) {
            $('#datepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datepicker2").on("dp.change", function(e) {
            $('#datepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-file-plus zmdi-hc-fw mdc-text-green"></i> Actualización <small> de contenido</small></h1>
    </div>
</div>
<div class="container-fluid">
    <?php
    $datos = explode("/", $_GET['vistas']);
    require_once './controladores/administradorControlador.php';
    $clasadmin = new adminstradorControlador();
    $filas = $clasadmin->datos_administrador_controlador("unico", $datos[1], $datos[2]);

    $id = $datos[1];
    $idcon = $datos[2];

    if ($filas->rowCount() == 1) {
        $campos = $filas->fetch();
        $pdf = $campos['pdf_imagen'];
        $nombrepdf = $campos['archivo'];
        $tipo = $campos['tipo'];
        ?>
        <ul class="breadcrumb" style="margin-bottom: 15px;">
            <li>
                <a href="<?php echo SERVERURL; ?>edicionsecciones/" class="btn btn-info">Regresar</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="new">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <label class="text-danger">Campos obligatorios "*"</label>
                            <div class="container-fluid">
                                <div class="page-header">
                                    <h1 class="text-titles"><i class="zmdi zmdi-collection-text zmdi-hc-fw"></i> Contenido <small> a modificar</small></h1>
                                </div>
                            </div><br><br>
                            <form action="<?php echo SERVERURL; ?>ajax/edicionseccionesAjax.php?idseccion=<?php echo $id; ?>" method="POST" data-form="save" class="formularioajax form-group-lg" autocomplete="off" enctype="multipart/form-data">
                                <label style="font-size: 20px;" class="text-info">Titulos:<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <select name="tituloseccion" class="form-control">
                                        <option value="<?php echo "";?>"><?php echo utf8_decode($campos['nombre']). ' - ' . utf8_decode($campos['tiposeccion']) ;?></option>
                                        <?php
                                            $menu_titulo = mainModel::obtener_menu_titulo();
                                            while ($row = $menu_titulo->fetch()) {
                                                $titulo = utf8_decode($row['nombre']);
                                                $id = $row['idsecciones'];
                                                $menu = utf8_decode($row['tiposeccion']);
                                                if(utf8_decode($campos['nombre'])!=$titulo){
                                                ?>
                                            <option value="<?php echo $id; ?>"><?php echo $titulo . ' - ' . $menu ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 20px;" class="text-info">Texto:<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <textarea type="text" name="texto" placeholder="texto" onkeypress="return soloLetras(event)" onkeyup="mayus(this);" class="form-control" rows="3"><?php echo utf8_decode($campos['text']); ?></textarea>
                                    </div>
                                </div>
                                <div>
                                    <label style="font-size: 20px;" class="text-info">Link:</label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="link" value="<?php echo $campos['link']; ?>" placeholder="link (http://www.example.com) ó (https://www.example.com)">
                                        <input class="form-control" type="hidden" name="linkoriginal" value="<?php echo $campos['link']; ?>">
                                    </div>
                                </div>
                                <div>
                                    <label style="font-size: 20px;" class="text-info">Documento o Imagen:</label>
                                    <div class="form-group">
                                        <?php
                                            if ($tipo == 'image/png' || $tipo == 'image/jpg' || $tipo == 'image/jpeg' || $tipo == 'image/tiff' || $tipo == 'image/gif' || $tipo == 'image/gif') {
                                                echo "<img src='data:image/*; base64," . base64_encode($pdf) . "' width='300'>";
                                            } elseif ($tipo == 'application/pdf') {
                                                echo "<div class='form-group'>
                                                        <p>Para visualizar el pdf click en<a target='_blank' href='" . SERVERURL . "documento/ver-vistas.php?id=$id&idcon=$idcon' rel='external nofollow'>&nbsp;Ver más...</a></p>
                                                  </div>";
                                            } elseif ($pdf == '') {
                                                echo "<div class='form-group'>
                                                    <p>No existe un documento o imagen para mostrar.</p>
                                                </div>";
                                            }
                                            ?>
                                    </div>
                                </div>
                                <br><br>
                                <div>
                                    <div class="form">
                                        <label style="font-size: 20px;" class="text-info">Selecciona el documento o imagen a guardar</label>&nbsp;<span class="text-danger">(Nota: se requiere volver a seleccionar el archivo o imagen a guardar)</span>
                                        <input type="file" name="pdfimg" placeholder="Buscar...">
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <label style="font-size: 20px;" class="text-info">Fecha inicio de visualización:<span class="text-danger">*</span></label>
                                </div>
                                <div class="form-group">
                                    <input class="form-control datepicker" type="text" id="datepicker1" style="width : 150px; heigth : 15px" name="fecha_inicio" value="<?php echo $campos['fecha_inicio']; ?>" placeholder="YYYY/MM/DD" title="Coloca la fecha con el siguiente formato YYYY/MM/DD">
                                </div>
                                <div>
                                    <label style="font-size: 20px;" class="text-info">Fecha final de visualización:<span class="text-danger">*</span></label>
                                </div>
                                <div class="form-group">
                                    <input class="form-control datepicker" type="text" id="datepicker2" style="width : 150px; heigth : 15px" name="fecha_final" value="<?php echo $campos['fecha_fin']; ?>" placeholder="YYYY/MM/DD" title="Coloca la fecha con el siguiente formato YYYY/MM/DD">
                                </div>
                                <p class="text-center">
                                    <button type="submit" class="btn btn-info btn-raised btn-lg"><i class="zmdi zmdi-floppy zmdi-hc-lg"></i> Guardar Contenido</button>
                                    <div class="RespuestaAjax"></div>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>