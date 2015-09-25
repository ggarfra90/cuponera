<?php
session_start();
$id = null;
$tipo = null;
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
if (isset($f_id)) {
    $id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
}
if (isset($f_tipo)) {
    //si el tipo es 1 se va a editar
    $tipo = (int) filter_var($f_tipo, FILTER_SANITIZE_NUMBER_INT);
}
if ($tipo == 1)
    $titulo = "Nueva Unidad de Medida";
else
    $titulo = "Nueva Unidad de Medida";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Mantenimietno de Tipo de Unidades</title>
        <!--<link href="vistas/libs/imagina/assets/modal-effect/css/component.css" rel="stylesheet">-->
        <link href="vistas/libs/imagina/css/bootstrap-combobox.css" rel="stylesheet">
<!--        <script>
            altura();
        </script> -->
        <?php
        if ($tipo == 1) {
            ?>
            <script language="javascript">
                getUnidad(<?php echo $id; ?>);
            </script>
            <?php
        } else {
            ?>
            <script language="javascript">
                getComboUnidadTipo();
            </script>
            <?php
        }
        ?>
    </head>
    <body>

<!--        <section class="content">-->

        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><b><?php echo $titulo; ?>:</b></h4>
                        <div class="col-md-12 ">
                            <div class="panel-body">
                                <form  id="frm_unidad"  method="post" class="form" enctype="multipart/form-data;charset=UTF-8">
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id_usuario']; ?>"/>
                                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                                    <div class="row">
                                        <div class="form-group col-md-4 ">
                                            <label>C&oacute;digo:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_codigo" name="txt_codigo" class="form-control" value="" maxlength="8"/>
                                            </div>
                                            <span id='msj_codigo' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Descripci&oacute;n:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_descripcion" name="txt_descripcion" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_descripcion' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Simbolo:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_simbolo" name="txt_simbolo" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_simbolo' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div> 
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label>Factor:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_factor" name="txt_factor" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_factor' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div> 

                                        <div class="form-group col-md-4">
                                            <label>Tipo de Unidad:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div id="combo_tipo">

                                                </div>
                                                <i id='msj_tipo'
                                                   style='color:red;font-style: normal;' hidden></i>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Estado:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <!--<span class="input-group-addon white-bg " data-toggle="tooltip" data-placement="bottom"  title="" data-html='true' data-original-title="<?php echo $alerta; ?>"><i  class="ion-alert"></i></span>-->
                                                <select name="cbo_estado" id="cbo_estado" class="form-control">
                                                    <option value="1" selected>Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <a href="#" class="btn btn-info w-sm m-b-5" id="id" style="border-radius: 0px;" onclick="cargarDiv('#window', 'vistas/com/unidad/unidad_listar.php')" ><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;
                                            <button type="button" onclick="guardarUnidad('<?php echo $tipo; ?>')" value="guardar" name="btnguardarPerfil" id="btnguardarPerfil" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="vistas/libs/imagina/js/bootstrap-combobox.js"></script>
        <script type="text/javascript">
                                                $(document).ready(function () {
//                                                    getComboColaborador();
//                                                    getComboPerfil();
                                                });
                                                altura();
        </script>
        <script src="vistas/com/unidad/unidad.js"></script>
    </body>
</html>
