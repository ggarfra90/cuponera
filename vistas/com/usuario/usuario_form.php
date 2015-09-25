<?php
session_start();
$id = null;
$tip_f = 0;
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
if (isset($f_id)) {
    $id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
}
if (isset($f_tipo)) {
    //si el tipo es 1 se va a editar
    $tip_f = (int) filter_var($f_tipo, FILTER_SANITIZE_NUMBER_INT);
}

$titulo="Registro de ";
if($tip_f==1){
    $titulo="Editar";
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Mantenimietno de Perfiles</title>
              <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
     <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
                   <script src="vistas/com/usuario/usuario.js"></script>
        <link href="vistas/libs/imagina/css/bootstrap-combobox.css" rel="stylesheet">
<script>
                    <?php
        if ($tip_f == 1) {
            ?>
                
                    getUsuario(<?php echo $id; ?>);
              
                
            
            <?php
        }else{?>
             getComboOrganizacion();
       <?php } ?>
  
       
    limpia();
    altura();

        $("#fec_nac").datepicker({
            format: "yyyy-mm-dd",
            startView: 2,
               language: "es",
               autoclose:"true"
        });    
</script>
<style>
        
     @media (max-width: 350px) {
    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
  position: relative;
  min-height: 1px;
  padding-right: 5px;
  padding-left: 5px;
}
.panel-disabled{
        margin-right: -10px;
}
     }
     .input-group-addon {
  padding: 6px 12px;
  font-size: 14px;
  font-weight: 400;
  line-height: 1;
  color: #555;
  text-align: center;
   background-color: #fff; 
   border: 1px solid #eee;
  border-radius: 0px; 
}
     .typeahead-long {
  max-height: 300px;
  overflow-y: auto;
  width: 100%;
  
}
.quita{
    padding-left: 0px;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
    opacity: 1;
    cursor: pointer;
}
</style>
       
    </head>
    <body>

<!--        <section class="content">-->
        <div class="page-title">
        <h3 class="title"><?php echo $titulo;?> usuario</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="col-md-12">

                        <div class="panel-body">
                            <form action=""   id="frm_usunew"  method="post" class="form" >
                                <div class="row">
                                    <div class="form-group col-md-6 " id="cu">
                                        <label>Nombre : </label> 
                                        <div class=" col-md-12 quita" >
                                            <input type="text" id="nom" autocomplete="off" name="nom"  class="form-control" />
                                            <i id='msj' style='color:red;' hidden>Ingrese nombre</i>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 " id="cu">
                                        <label>Usuario de dominio : </label> 
                                        <div class=" col-md-12 quita" >
                                            <input type="text" id="uad" autocomplete="off" name="uad"  class="form-control" />
                                            <i id='msj2' style='color:red;' hidden>Ingrese usuario de dominio</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-b-10">
                                    <div class="form-group col-md-6">
                                        <label>Organizaci&oacute;n :</label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="org" id="org" >
                                                <option value='0' disabled selected  style='display:none;'>Seleccione organizaci&oacute;n</option>
                                               
                                            </select>
                                            <i id='msj3' style='color:red;' hidden>Seleccione organización.</i>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Sucursal: </label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="suc" id="suc">
                                               
                                            </select>
                                            <i id='msj4' style='color:red;' hidden>Seleccione sucursal</i>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row m-b-10">
                                    <div class="form-group col-md-6">
                                        <label>Jefe inmediato :</label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="jefe" id="jefe" >
                                                <option value='' disabled selected  style='display:none;'>Ingrese jefe</option>
                                               
                                            </select>
                                            <i id='msj5' style='color:red;' hidden>Ingrese jefe inmendiato</i>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Gerente inmendiato : </label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="ger" id="ger">
                                                <option value='' disabled selected  style='display:none;'>Ingrese gerente</option>
                                               
                                            </select>
                                            <i id='msj6' style='color:red;' hidden>Ingrese gerente inmediato</i>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row m-b-10">
                                    <div class="form-group col-md-6">
                                        <label>Jefe Matricial :</label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="mtr" id="mtr" >
                                                <option value='' disabled selected  style='display:none;'>Ingrese jefe matricial.</option>
                                               
                                            </select>
                                            <i id='msj7' style='color:red;' hidden>Ingrese jefe Matricial</i>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <div class="form-group col-md-6 quita">
                                        <label>Rol :</label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="rol" id="rol" >
                                                <option value='' disabled selected  style='display:none;'>Ingrese usuario</option>
                                                <option value="USER">Usuarios (USER)</option>
                                                <option value="ADMI">Administradores (ADMI)</option>
                                                <option value="COMP">Compensaciones (COMP)</option>
                                                <option value="GERE">Gerente General (GERE)</option>
                                                <option value="RRHH">Recursos Humanos Jefatura (RRHH)</option>
                                                <option value="SIST">Sistemas (SIST)</option>
                                                <option value="SOCI">Asistente Social (SOCI)</option>
                                                <option value="TESO">Tesoreria (TESO)</option>
                                            </select>
                                            <i id='msj8' style='color:red;' hidden>Seleccione rol</i>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 m-t-30 quita" id="cu">
                                        <label class="cr-styled">
                                            <label>Rol Matricial</label>
                                            &nbsp;&nbsp;
                                            <input type="checkbox" id="chk_mtr" value="1" >
                                            <i class="fa"></i> 
                                        </label>
                                    </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="row m-b-10">
                                    <div class="form-group col-md-6">
                                        <label>Clase : </label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="clas" id="clas" >
                                                <option value='' disabled selected  style='display:none;'>Ingrese clase</option>
                                                <option value="E">Empleado</option>
                                                <option value="P">Planta</option>
                                            </select>
                                            <i id='msj9' style='color:red;' hidden>Seleccione clase de colaborador</i>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Estado : </label>
                                        <div class="col-md-12 quita">
                                            <select class="form-control" name="est" id="est" >
                                                <option value='' disabled selected  style='display:none;'>Seleccione estado</option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                            <i id='msj10' style='color:red;' hidden>Seleccione estado</i>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row m-b-10">
                                    <div class="form-group col-md-6 " id="cu">
                                        <label>Correo: </label> 
                                        <div class=" col-md-12 quita" >
                                            <input type="text" id="cor" autocomplete="off" name="cor"  class="form-control" />
                                            <i id='msj11' style='color:red;' hidden>Ingrese correo corpotativo.</i>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 " id="cu">
                                        <label>Clave de dominio : </label> 
                                        <div class=" col-md-12 input-group" >
                                     <span class="input-group-addon white-bg ">
                                         <label id="tp" data-toggle='tooltip' data-html='true' data-placement='top' title=''  class="cr-styled">
                                          <input type="checkbox" id="show" >
                                            <i class="fa"></i> 
                                        </label>
                                     </span>
                                            <input type="password" name="password" id="password" class="form-control" />
                                        </div>

                                    </div>
                                    
                                </div>
                                <div class="row m-b-10">
                                    
                                    <div class="form-group col-md-6 " id="cu">
                                        <label class="cr-styled">
                                            <label>Datos especiales</label>
                                            &nbsp;&nbsp;
                                            <input type="checkbox" id="chk_usu" >
                                            <i class="fa"></i> 
                                        </label>
                                    </div>
                                </div>
                                <div class="row hidden" id="oculto">
                                    <div class="form-group col-md-6 " >
                                        <label>Cargo: </label> 
                                        <div class=" col-md-12 quita" >
                                            <input type="text" id="car" autocomplete="off" name="car" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 " >
                                        <label>Fecha de cumpleaños: </label> 
                                         <div class=" col-md-12 input-group" >
                                     <span class="input-group-addon white-bg ">
                                         <i class="glyphicon glyphicon-calendar"></i>
                                     </span>
                                             <input readonly="true" type="text"  id="fec_nac" autocomplete="off" name="fec_nac" value="<?php echo date("Y-m-d");?>"  class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 quita">
                                    <a onclick="cargarDiv('#window','vistas/com/usuario/usuario_listar.php');limpia();" class="btn btn-info w-sm m-b-10 m-r-15" style="border-radius: 0px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>
                                    <button type="button"  onclick="validarUsuario(<?php echo $tip_f;?>);" value="buscar" class="btn btn-info  w-sm m-b-10" id="env" style="border-radius: 0px;"><i id="icon" class="fa fa-send-o"></i>&ensp;Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
</div>
        <script src="vistas/libs/imagina/js/bootstrap-combobox.js"></script>
        <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
         <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
        <script type="text/javascript">
          
             
       
                                              altura();
  $(document).ready( function(){

	$('#show').attr('checked', false);
        $('#tp').attr('data-original-title','Mostrar Constraseña.');
	$('#show').click(function(){
            $('#tp').remove('data-original-title');
		var name="";
                var value="";
		name = $('#password').attr('name');
		value = $('#password').val();
		if($(this).is(':checked'))
		{   
                            $('#tp').attr('data-original-title','Ocultar Constraseña.');
                                var a="'#msj12'";
			html = '<input type="text" name="'+ name + '" value="' + value + '" onkeypress="$('+a+').hide();" class="form-control" id="password">';
			$('#password').after(html).remove();
		}
		else
		{           var a="'#msj12'";
                                $('#tp').attr('data-original-title','Mostrar Constraseña.');
			html = '<input type="password" name="'+ name + '" value="' + value + '" onkeypress="$('+a+').hide();" class="form-control" id="password">';
			$('#password').after(html).remove();
		}
	});
});
        </script>

    </body>
</html>
