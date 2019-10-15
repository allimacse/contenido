<script type="text/javascript">
    function select_tipo() {
        var cdseccion = $('#select_tipo').val();
        $.ajax({
            sync: false,
            type: "POST",
            Type: "html",
            url: '/contenido/ajax/httpushAjax.php?token=' + cdseccion,
            success: function(data) {
                $('#tipo_seccion').html(data);

            }
        });
    }
</script>
<script>
    $(function() {
        function addZero(x, n) {
            while (x.toString().length < n) {
                x = "0" + x;
            }
            return x;
        }
    });
</script>
<script>
    $(function() {
        function addZero(x, n) {
            while (x.toString().length < n) {
                x = "0" + x;
            }
            return x;
        }
        /*Uso de datetimepicker, en el que hacemos el uso de validaciones de fecha, en lo que la fecha inicial no puede ser menor a la fecha actual,
         y la fecha final no puede ser menor a la fecha inicial*/
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker1").datetimepicker({
            format: "Y/M/D H:m",
            defaultDate: new Date(), //Se agrego como fecha
            minDate: new Date()
        });
        $("#datepicker2").datetimepicker({
            format: "Y/M/D H:m",
            useCurrent: false,
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
        <h1 class="text-titles"><i class="zmdi zmdi-file-plus zmdi-hc-fw mdc-text-green"></i> Registro <small> de contenidos</small></h1>
    </div>
</div>
<div class="container-fluid">
    <!--<div class="row">
        <div class="col-xs-12">-->
    <ul class="breadcrumb" style="margin-bottom: 15px;">
        <li>
            <a href="<?php echo SERVERURL; ?>contenidos/" class="btn btn-info"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp; Nuevo Contenido</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>edicionsecciones/" class="btn btn-warning"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp; Editar Contenido del Título</a>
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
                                <h1 class="text-titles"><i class="zmdi zmdi-collection-text zmdi-hc-fw"></i> Contenido <small> del título</small></h1>
                            </div>
                        </div><br><br>
                        <!--                                    <div>
                                        <label style="font-size: 20px;" class="text-info">Selecciona un Título:</label>
                                        <div class="form-group">
                                            <?php
                                            $consulta = mainModel::ejecutar_consulta_simple2("SELECT * FROM secciones");
                                            ?>
                                            <select name="secciones" class="form-control" id="select_tipo"  onchange="select_tipo(this.value)" required>
                                                <option value="">Selecciona un titulo para asignar contenido.</option>
                                                <?php while ($row = $consulta->fetch()) {
                                                    $titulo =  utf8_encode($row['nombre']);
                                                    $tipo = $row['idtiposecciones'];
                                                    $cdseccion = $row['idtiposecciones'];
                                                    $id = $row['idsecciones'];
                                                    //                                                        $cdseccion=  mainModel::encryption($cdseccion);
                                                    ?>
                                                <option value="<?php echo $cdseccion; ?>"><?php echo $titulo ?></option>
                                                <?php   } ?>
                                            </select>
                                        </div>
                                    </div><br><br>
                                    <div>
                                        <label style="font-size: 20px;" class="text-info">Asignado al menú:</label>
                                        <div  id="tipo_seccion">
                                            
                                        </div>
                                    </div><br><br>-->
                        <!--                                    <?php
                                                                $variable = $_POST['cdseccion'];
                                                                //                                        echo $variable;
                                                                //                                        print_r($variable);?cdsecciones=<?ph echo $variable; 
                                                                ?>
                                    ?>-->
                        <form action="<?php echo SERVERURL; ?>ajax/contenidoAjax.php" method="POST" data-form="save" class="formularioajax form-group-lg" autocomplete="off" enctype="multipart/form-data">

                            <!--                                    <div id="codigo">
                                        
                                    </div>-->
                            <div>
                                <label style="font-size: 20px;" class="text-info">Selecciona un Título:<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <?php
                                    $consulta = mainModel::ejecutar_consulta_simple2("SELECT
                                                                                                    secciones.idsecciones,
                                                                                                    secciones.nombre,
                                                                                                    secciones.idtiposecciones,
                                                                                                    tiposecciones.tiposeccion
                                                                                                    FROM
                                                                                                    secciones
                                                                                                    INNER JOIN tiposecciones ON tiposecciones.idtiposecciones = secciones.idtiposecciones");
                                    ?>
                                    <select name="secciones" class="form-control">
                                        <option value="">Selecciona un titulo para asignar contenido.</option>
                                        <?php while ($row = $consulta->fetch()) {
                                            $titulo = utf8_decode($row['nombre']);
                                            $tipo = $row['idtiposecciones'];
                                            $cdseccion = $row['idtiposecciones'];
                                            $id = $row['idsecciones'];
                                            $menu = utf8_decode($row['tiposeccion']);
                                            //                                                        $cdseccion=  mainModel::encryption($cdseccion);
                                            ?>
                                            <option value="<?php echo $id; ?>"><?php echo $titulo . ' - ' . $menu ?></option>
                                        <?php   } ?>
                                    </select>
                                </div>
                            </div><br><br>
                            <div>
                                <!--<label style="font-size: 20px;" class="text-info">Asignado al menú:</label>-->
                                <div id="tipo_seccion">

                                </div>
                            </div><br><br>
                            <div>
                                <label style="font-size: 20px;" class="text-info">Texto:<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <textarea type="text" name="texto" placeholder="texto" class="form-control" rows="3" style="font-family: 'Source Sans Pro', sans-serif; font-size:11pt"></textarea>
                                </div>
                            </div>
                            <div>
                                <label style="font-size: 20px;" class="text-info">Link:</label>
                                <div class="content-row">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <select name="url" class="form-control" style="width : 80px; heigth : 10px">
                                                        <!--<option value="">URL</option>-->
                                                        <option value="https://">https://</option>
                                                        <option value="http://">http://</option>
                                                    </select>
                                                </div>
                                                <div class="input-group-btn">
                                                    <input type="text" class="form-control" style="width : 800px; heigth : 10px" name="link" placeholder="link (www.ejemplo.com)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<label style="font-size: 20px;" class="text-info">URL:</label>-->
                                <!--                                            <div class="form-group">
                                                <select name="prioridad" class="form-control">
                                                   <option value="">URL</option>
                                                   <option value="1">https:</option>
                                                   <option value="2">http:</option>
                                                   <option value="3">Bajo</option>
                                                </select>
                                            </div>
                                            <input class="form-control" type="text" name="link" placeholder="link (https://www.ejemplo.com)">-->
                                <!--</div>-->
                            </div>
                            <br><br>
                            <!--<div id="div2" style="display:none;">-->
                            <div>
                                <div class="form">
                                    <label style="font-size: 20px;" class="text-info">Selecciona el documento o imagen a guardar</label>
                                    <input type="file" name="pdfimg" placeholder="Buscar...">
                                </div>
                            </div>
                            <br>
                            <div>
                                <label style="font-size: 20px;" class="text-info">Fecha inicio de visualización:<span class="text-danger">*</span></label>
                            </div>
                            <div class="form-group">
                                <!--<input class="form-control" type="date" style="width : 125px; heigth : 10px" name="fecha_final">-->
                                <input class="form-control datepicker" type="text" id="datepicker1" style="width : 150px; heigth : 15px" name="fecha_inicio">
                            </div>
                            <div>
                                <label style="font-size: 20px;" class="text-info">Fecha final de visualización:<span class="text-danger">*</span></label>
                            </div>
                            <div class="form-group">
                                <!--<input class="form-control" type="date" style="width : 125px; heigth : 10px" name="fecha_final">-->
                                <input class="form-control datepicker" type="text" id="datepicker2" style="width : 150px; heigth : 15px" name="fecha_final">
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
    <!--</div>
    </div>-->
</div>