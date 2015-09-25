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
    $titulo = "Editar Equivalencia";
else
    $titulo = "Nuevo Equivalencia";
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Mantenimietno de Perfiles</title>
        <!--<link href="vistas/libs/imagina/assets/modal-effect/css/component.css" rel="stylesheet">-->
        <link href="vistas/libs/imagina/css/bootstrap-combobox.css" rel="stylesheet">
        <!--<link href="vistas/libs/imagina/css/bootstrap-combobox.css" rel="stylesheet" type="text/css"/>-->

        <?php
        if ($tipo == 1) {
            ?>
            <script language="javascript">
                getEquivalencia(<?php echo $id; ?>);
            </script>
            <?php
        } else {
            ?>
            <script language="javascript">
                getComboAlternativa();
                getComboUnidad();
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

                                <form  id="frm_equivalencia"  method="post" class="form" enctype="multipart/form-data;charset=UTF-8">
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id_usuario']; ?>"/>
                                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label>Factor:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_factor1" name="txt_factor1" class="form-control" required="" aria-required="true" value="1" />
                                            </div>
                                            <i id='msj_factor1'
                                               style='color:red;font-style: normal;' hidden></i>
                                        </div> 
                                        <div class="form-group col-md-3">
                                            <label>Unidad Alternativa:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div id="combo_unidad">

                                                </div>
                                                <i id='msj_alternativa'
                                                   style='color:red;font-style: normal;' hidden></i>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-1" align="center">
                                            <label></label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <i align='center' class="ion-arrow-right-a" style="color:#1C1C1C;font-size: 25px"></i>
                                            </div>
                                            <i id='msj_usuario'
                                               style='color:red;font-style: normal;' hidden></i>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Factor:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_factor2" name="txt_factor2" class="form-control" required="" aria-required="true" value="1"/>
                                            </div>
                                            <i id='msj_factor2'
                                               style='color:red;font-style: normal;' hidden></i>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Unidad Base:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div id="combo_unidades">
                                                </div>
                                                <i id='msj_unidad'
                                                   style='color:red;font-style: normal;' hidden></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <a href="#" class="btn btn-info w-sm m-b-5" id="id" style="border-radius: 0px;" onclick="cargarDiv('#window', 'vistas/com/unidad/equivalencia_listar.php')" ><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;
                                            <button type="button" onclick="guardarEquivalencia('<?php echo $tipo; ?>')" value="buscar" name="btnguardarPerfil" id="btnguardarPerfil" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>&nbsp;&nbsp;
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
//                                                    getCombounidad();
//                                                    getComboPerfil();
                                                });
                                                altura();
        </script>

        <script src="vistas/com/unidad/equivalencia.js"></script>
    </body>
</html>
