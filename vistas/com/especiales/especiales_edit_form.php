<?php
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
$id = abs((int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT));
$alerta="<b class='text-justify'>Muestra u oculta el cup&oacute;n en la lista de cupones (Si el cup&oacute;n est&aacute; activo pero no est&aacute; vigente no aparecer&aacute; en la lista de cupones)</b>";
$alerta2="<b class='text-justify'>Usar imagenes peque&ntilde;as. Usar formato jpg. Tama&ntilde;o m&aacute;ximo 600kb.</b>";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"></meta>
    <title>Editar datos de cup&oacute;n especial - Recursos Humanos -  Netafim</title>
<link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>


<script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
<script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
     <script src="vistas/com/especiales/especiales.js" ></script>
     
<script>
    $(document).ready(function (){
        getDataEspecial(<?php echo $id;?>);
    });
$(function() {
     $( "#rfecha2" ).datepicker({
              format: "yyyy-mm-dd",
               //startDate: "",
               language: "es",
               autoclose:"true"

             });
             $( "#rfecha4" ).datepicker({
              format: "yyyy-mm-dd",
               //startDate: "",
               language: "es",
               autoclose:"true"

             });
        $( "#cal" ).attr( "data-original-title", "Seleccione fecha inicio" );
      $( "#rfecha3" ).prop( "disabled", true );
	$( "#rfecha" ).datepicker({
              format: "yyyy-mm-dd",
               //startDate: "",
               language: "es",
               autoclose:"true"

             }).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear() + "-" +(f.getMonth() + 1) + "-" + f.getDate()  ;
                $( "#cal" ).removeAttr("data-original-title", "Seleccione una fecha inicio" );
                $( "#rfecha3" ).prop( "disabled", false );
                $( "#rfecha3" ).datepicker('setStartDate',f2);
               
                  $( '#rfecha2' ).datepicker( 'setDate',f2 ); 
        });
             	
          $( "#rfecha3" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: "#rfecha",
               
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear() + "-" +(f.getMonth() + 1) + "-" + f.getDate()  ;
               
                    $( '#rfecha4' ).datepicker( 'setDate',f2 );    
        });
       
//       $( '#rfecha2' ).datepicker( 'setDate', '<?php //echo $fila['cep_fec_ini']; ?>' );
//       $( '#rfecha4' ).datepicker( 'setDate', '<?php //echo $fila['cep_fec_fin']; ?>' );
       
	
	
	

	
	
	
	
	
});
</script>


<script>
    $(document).ready(function (){
        document.getElementById("file").disabled=true;
                $( "#antes #multi").css( "opacity","0.4");
                $( "#file").css( "cursor","no-drop");
    });
function habFil(id) {
    if(id==3){
        var ant=$("#rut").val();
        var nant=$("#imgant").val();
     document.getElementById("upload-file-info").innerHTML=nant;


          $("#myImg").attr('src',ant);
    }
	if (id==1) {
                var dir = "http://" + location.host + "/cuponera/vistas/com/especiales/archivos/default.png";

                document.getElementById("upload-file-info").innerHTML="Seleccione nueva imagen.";
		document.getElementById("file").disabled=false;
                $( "#antes #multi").css( "opacity","1");
                 $( "#file").css( "cursor","pointer");
                 $("#myImg").attr('src',dir);
                
	} 
        if(id==0){
		document.getElementById("file").disabled=true;
                $( "#antes #multi").css( "opacity","0.4");
                $( "#file").css( "cursor","no-drop");
                 var dir = "http://" + location.host + "/cuponera/vistas/com/especiales/archivos/default.png";
                  $("#myImg").attr('src',dir);
                document.getElementById("upload-file-info").innerHTML="Se eliminará la imagen.";
	}
}
limpia();
altura();
</script>
<style>
      @media (max-width: 350px) {
    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
  position: relative;
  min-height: 1px;
  padding-right: 5px;
  padding-left: 5px;
}
.radio-inline{
    display: block;
}
     }
</style>
</head>

<body>

    <div class="page-title">
        <h3 class="title">Editar cup&oacute;n especial</h3>
                </div>
<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-body " style="padding-top: 5px;">
                <div class="col-md-12">
                <div class="panel-body" style="padding-top: 5px;">
                    <h4><b>Datos del cup&oacute;n especial:</b></h4>
                        <form action=""   id="frm_recursosnew"  method="post" class="form m-t-10" enctype="multipart/form-data;charset=UTF-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Nombre</label>
                                        <div class="col-md-12  quita" >
                                            <input type="text" autocomplete="off" id="nom" name="nom" class="form-control"/>
                                            <i id='msj' style='color:red;' hidden>Ingrese nombre del cup&oacute;n</i>

                                        </div>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Descripci&oacute;n:</label>
                                        <div class=" col-md-12 quita">
                                            <input type="text" autocomplete="off" id="des" name="des" class="form-control" />
                                            <i id='msj2' style='color:red;' hidden>Ingrese descripci&oacute;n</i>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Mensaje de saludo</label>
                                        <div class="col-md-12  quita">
                                            <input type="text" autocomplete="off" id="sal" name="sal" class="form-control"/>
                                            <i id='msj3' style='color:red;' hidden>Ingrese mensaje de saludo</i>
                                        </div>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Fecha inicio</label>
                                        <div class="input-group col-md-12" >
                                            <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input type="text" id="rfecha" autocomplete="off" class="form-control" name="rfecha" value="">
                                        </div>
                                        <input type="hidden" value="" id="rfecha2" name="rfecha2" />  
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Fecha Fin</label>
                                        <div class="input-group col-md-12 " id="cal" data-toggle="tooltip" data-placement="bottom" title="">
                                            <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input type="text" id="rfecha3" autocomplete="off" class="form-control" name="rfecha3" value="">
                                        </div>
                                        <input type="hidden" id="rfecha4" value="" name="rfecha4" />  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label> Aprobador</label>
                                        <div class=" col-md-12  quita">
                                            <select name="aprob" id="aprob" class="form-control">
                                                <option value="0" style='display:none;'>Seleccione aprobador</option>

                                                <option value="1">Jefe inmediato</option>
                                                <option value="2">Gerente inmediato</option>
                                            </select>
                                            <i id='msj5' style='color:red;' hidden>Seleccione aprobador</i>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Estado</label>
                                        <div class="input-group col-md-12">
                                            <span class="input-group-addon white-bg " data-toggle="tooltip" data-placement="bottom"  title="" data-html='true' data-original-title="<?php echo $alerta; ?>"><i  class="ion-alert"></i></span>

                                            <select name="est" id="est" class="form-control">
                                                <option  value="3" style='display:none;'>Seleccione estado</option>
                                                <option value="1" >Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                            <i id='msj6' style='color:red;' hidden>Seleccione estado</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Opciones de imagen</label>
                                        <div class="  col-md-12 quita" >
                                            <div class="radio-inline" style="padding-left:0px;">
                                                 <label class="cr-styled" for="ima">
                                                    <input type="radio" id="ima" name="ima" value="1" checked onclick="habFil(3);"> 
                                                    <i class="fa"></i>
                                                   Mantener 
                                                </label>
                                            </div>
                                            <div class="radio-inline" style="margin-left:0px;margin-left: -20px;">
                                                <label class="cr-styled" for="ima2" data-toggle="tooltip" data-placement="bottom"  title="" data-html='true' data-original-title="<?php echo  $alerta2;?>">
                                                    <input type="radio" id="ima2" name="ima" value="2" onclick="habFil(1);"> 
                                                    <i class="fa"></i> 
                                                   Actualizar 
                                                </label>
                                            </div>
                                            <div class="radio-inline" style="margin-left:0px;margin-left:-20px;">
                                               <label class="cr-styled" for="ima3">
                                                    <input type="radio" id="ima3" name="ima" value="3" onclick="habFil(0);"> 
                                                    <i class="fa"></i> 
                                                   Eliminar 
                                                </label>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="form-group col-md-3" id="antes">
                                        <label>Subir imagen</label>
                                        <div class=" col-md-12  quita"> 

                                            <div class="fileUpload btn w-lg m-b-5" id="multi" style="border-radius: 0px;background-color: #337Ab7;color: #fff;opacity: 0.4;">

                                                <span><i class="ion-upload m-r-15"></i>Upload</span>

                                                <input name="file"  type="file" id="file"  class="upload"  onchange='$("#upload-file-info").html($(this).val().slice(12));' >
                                              <input type="hidden" id="secretImg" value="" />      

                                            </div>
                                            <script>
                                                $(':file').change(function(){
                                                    var file = this.files[0];
                                                    name = file.name;
                                                    size = file.size;
                                                    type = file.type;
                                                    $("#fname").val(name);
                                                    $("#fsize").val(size);
                                                    $("#ftype").val(type);
                                                    
                                                    if (this.files && this.files[0]) {
                                                            var reader = new FileReader();
                                                            reader.onload = imageIsLoaded;
                                                            reader.readAsDataURL(this.files[0]);
                                                        }
                                                        function imageIsLoaded(e) {
                                                    $('#secretImg').attr('value', e.target.result);
                                                    $('#myImg').attr('src', e.target.result);
                                                    $('#myImg').attr('width', '250px');
                                                    $('#myImg').attr('height', '128px');
                                                }
                                                   
                                                });
                                            </script>
                                            <input type="hidden" id="fname"   >                                       
                                                <input type="hidden" id="fsize"  >                                       
                                                    <input type="hidden" id="ftype" > 
                                                        <br> <b  class='' id="upload-file-info"></b> 
                                        </div>
                                        </div>
                                        <div class="col-md-3 p-b-10">
                                            <img id="myImg" src="" style="width: 128px;height: 128px;" />
                                        </div>
                                    
                                </div>

                            <input type="hidden" name="id" id="cep_id" value="<?php echo $id; ?>">
                                <input type="hidden" id="imgant" value="">
                                <input type="hidden" id="rut" value="">

                                    <div class="form-group col-md-12">


                                        <a onclick="cargarDiv('#window','vistas/com/especiales/especiales_listar.php');limpia();" class="btn btn-info w-sm m-b-5 " style="border-radius: 0px;  margin-left: -15px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;

                                    <button type="button" id="env" onclick="enviarEditar()"value="buscar" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>


                                    </div>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
</form>



        <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
 <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>

<script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
<script>
    $('#nom')change(function(){
                $( '#msj' ).hide();
        });
         $('#des').change(function(){
                $( '#msj2' ).hide();
        });
        $('#sal').change(function(){
                $( '#msj3' ).hide();
        });
       
         $('#des').change(function(){
                $( '#msj2' ).hide();
        });
         $('#aprob').change(function(){
            // $("#env").removeClass("disabled");
                $( '#msj5' ).hide();
        });
        $('#est').change(function(){
            
                $( '#msj6' ).hide();
        });
   $(document).ready(function (){
       
	
                document.getElementById("file").disabled=true;
                $( "#antes #multi").css( "opacity","0.4");
                 $( "#antes #multi").css( "cursor","no-drop");
             $( "#file").css( "cursor","no-drop");
             $("#frm_recursos").submit(function (){
            var n,u,c1,c4,c5;
            n=$("#nom").val();
            u=$("#des").val();
            c1=$("#sal").val();
            
            c4=$("#aprob").val();
            c5=$("#est").val();
            if(n==""){
                $("#msj").show();
                return false;
            }
            if(u==""){
                $("#msj2").show();
                return false;
            }
            if(c1==""){
                $("#msj3").show();
                return false;
            }
          
            if(c4=='0'){
                $("#msj5").show();
                return false;
            }
             if(c5=='3'){
                $("#msj6").show();
                return false;
            }
            return true;
        });
	
}
   );

</script>

</body>
</html>
