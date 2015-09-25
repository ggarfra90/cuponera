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
    $titulo = "Editar Colaborador";
else
    $titulo = "Nuevo Colaborador";
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
                getColaborador(<?php echo $id; ?>);
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
                                <form  id="frm_colaborador"  method="post" class="form" enctype="multipart/form-data;charset=UTF-8">
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id_usuario']; ?>"/>
                                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                                    <div class="row">
                                        <div class="form-group col-md-6 ">
                                            <label>DNI:   </label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_dni" name="txt_dni" class="form-control" value="" maxlength="8"/>
                                            </div>
                                            <span id='msj_dni' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Nombres:   </label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_nombre" name="txt_nombre" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_nombre' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Apellido Paterno:  </label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_apepaterno" name="txt_apepaterno" class="form-control" required="" aria-required="true" value=""/>
                                                <!--<input type="text" id="comentario" name="comentario" class="form-control" value=""/>-->
                                            </div>
                                            <span id='msj_paterno' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div> 
                                        <div class="form-group col-md-6">
                                            <label>Apellido Materno:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_apematerno" name="txt_apematerno" class="form-control" required="" aria-required="true" value=""/>
                                                <!--<input type="text" id="comentario" name="comentario" class="form-control" value=""/>-->
                                            </div>
                                            <span id='msj_materno' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Telefono:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_telefono" name="txt_telefono" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_telefono' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
                                        </div> 

                                        <div class="form-group col-md-6">
                                            <label>Celular:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_celular" name="txt_celular" class="form-control" required="" aria-required="true" value=""/>
                                            </div>
                                            <span id='msj_celular' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>                                           
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Email:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_email" name="txt_email" class="form-control" required="" aria-required="true" value=""/>
                                                <i id='msj_email'
                                                   style='color:red;font-style: normal;' hidden></i>
                                            </div>
                                        </div> 

                                        <div class="form-group col-md-6">
                                            <label>Estado</label>
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
                                        <div class="form-group col-md-6">
                                            <label>Direci&oacute;n:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <textarea type="text" id="txt_direccion" name="txt_direccion" class="form-control" value=""></textarea>
                                                <!--<input type="text" id="comentario" name="comentario" class="form-control" value=""/>-->
                                            </div>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label>Referencia de la Direci&oacute;n:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <textarea type="text" id="txt_refdireccion" name="txt_refdireccion" class="form-control" value=""></textarea>
                                                <!--<input type="text" id="comentario" name="comentario" class="form-control" value=""/>-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Imagen</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="fileUpload btn w-lg m-b-5" id="multi" style="border-radius: 0px;background-color: #337Ab7;color: #fff;cursor:default;">
                                                    <div id="edi" ><i class="ion-upload m-r-15" style="font-size: 16px;"></i>Subir imagen</div>
                                                    <input name="file" id="file"  type="file" accept="image/*" class="upload" onchange='$("#upload-file-info").html($(this).val().slice(12));' >
                                                </div>
                                                &nbsp; &nbsp; <b class='' id="upload-file-info">Ningun imagen seleccionada</b>
                                            </div>
                                        </div>
                                        <img id="myImg" src="vistas/com/colaborador/imagen/default.png" alt="" />
                                        <input type="hidden" id="secretImg" />
                                        <script>
                                        $(function () {
                                            $(":file").change(function () {
                                                if (this.files && this.files[0]) {
                                                    var reader = new FileReader();
                                                    reader.onload = imageIsLoaded;
                                                    reader.readAsDataURL(this.files[0]);
                                                }
                                            });
                                        });

                                        function imageIsLoaded(e) {
                                            $('#secretImg').attr('value', e.target.result);
                                            $('#myImg').attr('src', e.target.result);
                                            $('#myImg').attr('width', '128px');
                                            $('#myImg').attr('height', '128px');
                                        };
                                        </script>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <a href="#" class="btn btn-info w-sm m-b-5" id="id" style="border-radius: 0px;" onclick="cargarDiv('#window', 'vistas/com/colaborador/colaborador_listar.php')" ><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;
                                            <button type="button" onclick="guardarColaborador('<?php echo $tipo; ?>')" value="buscar" name="btnguardarPerfil" id="btnguardarPerfil" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="vistas/com/colaborador/colaborador.js"></script>
    </body>
</html>
