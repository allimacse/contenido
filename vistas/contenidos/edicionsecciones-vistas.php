<?php
require_once "./controladores/administradorControlador.php";
$insAdmin = new adminstradorControlador();
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-view-day zmdi-hc-fw mdc-text-green"></i> Listado <small> de secciones</small></h1>
    </div>
</div>
<div class="container-fluid">
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
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <?php
                        $pagina = explode("/", $_GET['vistas']);
                        echo $insAdmin->paginador_administrador_controlador($pagina[1], 10, $_SESSION['cdcuenta_sdo'])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>