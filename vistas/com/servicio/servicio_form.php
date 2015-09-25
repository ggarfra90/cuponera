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
    $titulo = "Editar Servicio";
else
    $titulo = "Nuevo Servicio";
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Mantenimietno de Perfiles</title>
        <link href="vistas/libs/imagina/assets/modal-effect/css/component.css" rel="stylesheet">

        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
        <script>
            altura();
        </script> 
        <?php
        if ($tipo == 1) {
            ?>
            <script language="javascript">
                getServicio(<?php echo $id; ?>);
            </script>
            <?php
        }
        ?>
        <script>
$(function() {
      $( "#fec_inih" ).datepicker({
              format: "yyyy-mm-dd",
               //startDate: "",
               language: "es",
               autoclose:"true"

             });
             $( "#fec_finh" ).datepicker({
              format: "yyyy-mm-dd",
               //startDate: "",
               language: "es",
               autoclose:"true"

             });
        $( "#cal" ).attr( "data-original-title", "Seleccione fecha inicio" );
      $( "#fec_fin" ).prop( "disabled", true );
	$( "#fec_inicio" ).datepicker({
              format: "yyyy-mm-dd",
               //startDate: "",
               language: "es",
               autoclose:"true"

             }).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear() + "-" +(f.getMonth() + 1) + "-" + f.getDate()  ;
                $( "#cal" ).removeAttr("data-original-title", "Seleccione una fecha inicio" );
                $( "#fec_fin" ).prop( "disabled", false );
                $( "#fec_fin" ).datepicker('setStartDate',f2);
                    $( '#fec_inicioh' ).datepicker( 'setDate',f2 );    
        });
             	
          $( "#fec_fin" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: "#rfecha",
               
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear() + "-" +(f.getMonth() + 1) + "-" + f.getDate()  ;
               
                    $( '#fec_finh' ).datepicker( 'setDate',f2 );    
        });
        $( '#fec_fin' ).datepicker( 'setDate', '<?php echo date("Y-m-d"); ?>');	 
	
});
        </script>    

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
                                <form  id="frm_servicio"  method="post" class="form" enctype="multipart/form-data;charset=UTF-8">
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['id_usuario']; ?>"/>
                                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                                    <div class="row">
                                        <div class="form-group col-md-6 ">
                                            <label>Descripci&oacute;n:   </label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" id="txt_descripcion" name="txt_descripcion" class="form-control" value="" />
                                            </div>
                                            <span id='msj_descripcion' class="control-label"
                                                  style='color:red;font-style: normal;' hidden></span>
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
                                        <div class="form-group col-md-6">
                                            <label>Fecha Inicio</label>
                                            <div class="input-group col-lg-12 " id="cal" data-toggle="tooltip" data-placement="bottom" title="">
                                                <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" id="fec_inicio" class="form-control" name="fec_inicio" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                             <input type="hidden" id="fec_inicioh" name="rfecha2" />  
                                            <span id='msj_fec_inicio' class="control-label"
                                                      style='color:red;font-style: normal;' hidden></span>
<!--                                            <input type="hidden" id="rfecha4" name="rfecha4" />  -->
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Fecha Fin</label>
                                            <div class="input-group col-lg-12 " id="cal" data-toggle="tooltip" data-placement="bottom" title="">
                                                <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" id="fec_fin" class="form-control" name="fec_fin" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                             <input type="hidden" id="fec_finh" name="rfecha2" />  
                                            <span id='msj_fec_fin' class="control-label"
                                                      style='color:red;font-style: normal;' hidden></span>
                                       <!--<input type="hidden" id="rfecha4" name="rfecha4" />-->  
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Comentario:</label>
                                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <textarea type="text" id="txt_comentario" name="txt_comentario" class="form-control" value=""></textarea>
                                                <!--<input type="text" id="comentario" name="comentario" class="form-control" value=""/>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <a href="#" class="btn btn-info w-sm m-b-5" id="id" style="border-radius: 0px;" onclick="cargarDiv('#window', 'vistas/com/servicio/servicio_listar.php')" ><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;
                                            <button type="button" onclick="guardarServicio('<?php echo $tipo; ?>')" value="buscar" name="btnguardarPerfil" id="btnguardarPerfil" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="vistas/com/servicio/servicio.js"></script>
    </body>
</html>
