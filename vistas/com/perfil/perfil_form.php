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
    $titulo = "Editar Perfil";
else
    $titulo = "Nuevo Perfil";
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Mantenimietno de Perfiles</title>
        <link href="vistas/libs/imagina/assets/modal-effect/css/component.css" rel="stylesheet">

        <script>
            altura();
        </script>     
        <?php
        if ($tipo == 1) {
            ?>
            <script language="javascript">
                cargarMenu(<?php echo $id; ?>);
            </script>
            <?php
        } else {
            ?>
            <script language="javascript">
                cargarMenu(null);
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
                                <form action="javascript:fn_EnvNewRH();"   id="frm_perfilnew"  method="post" class="form" enctype="multipart/form-data;charset=UTF-8">
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id_usuario']; ?>"/>
                                    <input type="hidden" name="id_perfil" id="id_perfil" value="<?php echo $id ?>"/>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>C&oacutedigo</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="codigo" name="codigo" class="form-control" value=""/>
                                            </div>
                                            <span id='msj_codigo' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Descripci&oacute;n</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="descripcion" name="descripcion" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_desc' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div>
                                         
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Comentario:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <textarea type="text" id="comentario" name="comentario" class="form-control" value="" ></textarea>
                                                <!--<input type="text" id="comentario" name="comentario" class="form-control" value=""/>-->
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group col-md-6">
                                            <label>Estado</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <!--<span class="input-group-addon white-bg " data-toggle="tooltip" data-placement="bottom"  title="" data-html='true' data-original-title="<?php echo $alerta; ?>"><i  class="ion-alert"></i></span>-->
                                                <select name="estado" id="estado" class="form-control">
                                                    <option value="1" selected>Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            
                                            <label>Permisos Especiales</label>
                                            <div class="col-xs-12">
                                                <div class="checkbox">
                                                    <label class="cr-styled">
                                                        <input type="checkbox" name="chk_dashboard" id="chk_dashboard" >
                                                        <i class="fa"></i> 
                                                        Visibilidad de dashboard
                                                    </label>
                                                </div>

                                                <div class="checkbox">
                                                    <label class="cr-styled">
                                                        <input type="checkbox" name="chk_monetaria" id="chk_monetaria">
                                                        <i class="fa"></i> 
                                                        Visibilidad monetaria
                                                    </label>
                                                </div>

                                                <div class="checkbox">
                                                    <label class="cr-styled">
                                                        <input type="checkbox" name="chk_email" id="chk_email">
                                                        <i class="fa"></i> 
                                                        Alerta de email
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Modal para las opciones del menu--> 

                                    <div width="400" id="accordion-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body"> 
                                                    <div class="panel-group panel-group-joined" id="accordion-test"> 
                                                        <div id="opcionp">
                                                            <!--modal para las opciones del menu-->
                                                        </div>
                                                    </div>
                                                </div><!-- /.body -->

                                                <div class="modal-footer"> 
                                                    <button type="button" class="btn btn-white" data-dismiss="modal" onclick="cancelarAsignarOpciones('<?php echo $id; ?>')" >Cancelar</button> 
                                                    <button type="button" name="btnOpciones" id="btnOpciones" class="btn btn-info" data-dismiss="modal">Ok</button> 
                                                </div> 
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!--fin del modal--> 

                                    <div class="form-group col-md-12">
                                        <a href="#" class="btn btn-info w-sm m-b-5" id="id" style="border-radius: 0px;" onclick="cargarDiv('#window', 'vistas/com/perfil/perfil_listar.php')" ><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;
                                        <button type="button" onclick="guardarPerfil('<?php echo $tipo; ?>')" value="buscar" name="btnguardarPerfil" id="btnguardarPerfil" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>&nbsp;&nbsp;
                                        <!--<button type="button" onclick="cargarMenu('<?php echo $id ?>')" id="btnCargarOpciones" data-toggle="modal" data-target="#accordion-modal"  name="btnCargarOpciones"  class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="ion-android-add"></i>&ensp;Acceso Opciones</button>-->
                                        <button type="button" id="btnCargarOpciones" data-toggle="modal" data-target="#accordion-modal"  name="btnCargarOpciones"  class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="ion-android-add"></i>&ensp;Acceso Opciones</button>
                                        <!--<button type="button" onclick="mostrar()" data-toggle="modal" data-target="#accordion-modal"  name="btnCargarOpciones"  class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="ion-android-add"></i>&ensp;Prueba</button>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="vistas/com/perfil/perfil.js"></script>
    </body>
</html>
