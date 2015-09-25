<?php 
include_once __DIR__ . '/../../../../controlador/cuponera/CuponControlador.php';

session_start();
$id = null;
$tipo = null;
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
if (isset($f_id)) {
    $id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
}
if (isset($f_tipo)) {
    $tipo = (int) filter_var($f_tipo, FILTER_SANITIZE_NUMBER_INT);
    $_SESSION['tipo']=$tipo;
}
if (isset($f_tipo)) {
    //si el tipo es 1 se va a editar
    $tipo = (int) filter_var($f_tipo, FILTER_SANITIZE_NUMBER_INT);
}

$dat=  CuponControlador::getCuponTipo();
$cup_color=$dat["cup_color"];
$msg_cup=$dat["cup_estado"];
$bloqueo=$dat["cup_bloqueo"];
$fin= date("Y");
$sfin=$fin."-12-31";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Matrimonio - Recursos Humanos -  Netafim</title>


<!--Seccion jQuery-->

<!--Seccion jQuery-->
<!-- Counter-up -->
        
<!--Seccion Date Picker-->
    <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
      



        <script>
            
             $( "#fecha2" ).datepicker({
		  format: "yyyy-mm-dd",
                  language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	});
        $( "#fecha3" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: new Date(),
              
             // endDate:"",
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	});
            $( "#fecha4" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: new Date(),
              
             // endDate:"",
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	});
           $( "#fecha5" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: "",
             // endDate:"",
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	}); 
        $( "#fecha6" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: "",
             // endDate:"",
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	});
             $( "#cal" ).attr( "data-original-title", "Seleccione fecha de boda" );
                $( "#fecha3" ).prop( "disabled", true );
            $( "#fecha" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: new Date(),
              
              endDate:"<?php echo $sfin;?>",
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	}).on('changeDate',function(ev){
            var f3,f2;
                
                   var f=new Date(ev.date);
                              f2=f.getFullYear() + "-" +(f.getMonth() -2) + "-" + f.getDate()  ;
                              f3=f.getFullYear() + "-" +(f.getMonth() +4) + "-" + f.getDate()  ;
                 var m=f.getMonth() +1;
                    var fn=f.getFullYear() + "-" +(f.getMonth() +1) + "-" + f.getDate() ;
                    if(m==10){
                        f2=f.getFullYear() + "-" +(f.getMonth() -2) + "-" + f.getDate()  ;
                         f3=f.getFullYear() + "-" +(f.getMonth() +3) + "-" + f.getDate()  ;
                    }
                    if(m==11){
                        f2=f.getFullYear() + "-" +(f.getMonth() -2) + "-" + f.getDate()  ;
                         f3=f.getFullYear() + "-" +(f.getMonth() +2) + "-" + f.getDate()  ;
                    }
                     if(m==12){
                        f2=f.getFullYear() + "-" +(f.getMonth() -2) + "-" + f.getDate()  ;
                         f3=f.getFullYear() + "-" +(f.getMonth() +1) + "-" + f.getDate()  ;
                    }

                   
                $( "#cal" ).removeAttr("data-original-title", "Seleccione una fecha inicio" );
                $( "#fecha3" ).prop( "disabled", false );
                $( "#fecha3" ).datepicker('setStartDate',f2);
                $( "#fecha3" ).datepicker('setDate',f2);
                $( "#fecha3" ).datepicker('setEndDate',f3);
                $( "#fecha2" ).datepicker('setDate',fn);
      
    
        }); 
       
        <?php
	//echo "\t$( '#fecha' ).datepicker( 'setDate', '".date("Y-m-d")."' );\r\n";
?>
    //fecha que debe estar restringida con 3 meses 
     $( "#fecha3" ).datepicker({
		  format: "yyyy-mm-dd",
               //startDate: "",
             // endDate:"",
               language: "es",
               autoclose:"true"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    var fn2=f.getFullYear() + "-" +(f.getMonth() +1) + "-" + f.getDate()  ;
                
                     
                  $( "#fecha4" ).datepicker('setDate',fn2);
                  $( "#fecha5" ).datepicker('setDate',fn2);
                  $( "#fecha6" ).datepicker('setDate',fn2);
      
    
        }); 
       limpia();
        </script>



<style>
    @media (min-width: 768px){
.form-inline .input-group>.form-control {
  width: 140px;
}
    }
              .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
  position: relative;
  min-height: 1px;
  padding-right: 5px;
  padding-left: 10px;
}
</style>
</head>

<body>
    
  <div class="page-title">
            <h3 class="title">Cup&oacute;n de Matrimonio</h3>
        </div>
 <div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
      
        <div class="panel-body">
     <div class="col-md-6 ">
         <img class="img-responsive" style="height: 350px;"  src="images/matrimonio<?php echo ($cup_color==0?"bw":""); ?>.png" border="1" width="750" title="Cup&oacute;n de matrimonio">
  
     </div>       
 <div class="col-md-6 ">
     <p class="text-justify">Notas: Puede hacerse efectivo desde 3 meses antes del d&iacute;a de la boda hasta 3 meses despu&eacute;s.
Es indispensable incluir el documento sustentario y deber&aacute; estar en formato pdf, jpg, microsoft word, zip o rar y
no podr&aacute; exceder los 6 megabytes de tama&ntilde;o.
Este beneficio es personal e intransferible. V&aacute;lido hasta diciembre del <?php echo $_SESSION['rec_anio'];?>.
El d&iacute;a solicitado deber&aacute; ser coordinado anticipadamente con el jefe superior
<b>y estar&aacute; sujeto a las necesidades/actividades del &aacute;rea.</b></p>
     <p><b><?php echo $msg_cup; ?></b></p>
     <div class="col-md-12" style="  padding-left: 0px;">
<?php
if ($bloqueo>0) {
	echo "<p style='margin-left:15px;'><font color='red'><b>Cup&oacute;n bloqueado</b></font> (Consulte a Recursos Humanos para m&aacute;s informaci&oacute;n).<br></p>";
	 ?>
                   
                    <?php
                        $cup_color = 0;
}

if ($cup_color==1) {
?>
        <div class="panel-body">
        <form id="frm_matri" method="post" enctype="multipart/form-data" class="form">
                                   
                                    <div class="form-group col-md-6">
                                        <label for="Nombre" >Fecha de la Boda:</label>
                                        
                                            <div class="input-group col-xs-12 col-md-12">
                                                 <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" autocomplete="off" placeholder="A-m-d" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="form-control" >
                                                <input type="hidden" id="fecha2" name="fecha2" value="<?php echo date("Y-m-d"); ?>"  > 
                                            </div>
                                                                                
                                            
                                        </div>
                                        <div class="form-group col-md-6" >
                                         <label for="Nombre" >Fecha del permiso:</label>
                                         <div id="cal" class="input-group col-lg-12" data-toggle="tooltip" data-placement="bottom" title="">
                                                 <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                 <input type="text" autocomplete="off" placeholder="A-m-d" id="fecha3" value="<?php echo date("Y-m-d"); ?>"  name="fecha3"  class="form-control"  >
                                                
                                        
                                          <input type="hidden" id="fecha4" name="fecha4" class="form-control" value="<?php echo date("Y-m-d"); ?>" >                                       
                                            </div>
                                        </div>
                                
                                         
                                        
                                           
                                                 <input type="hidden" placeholder="A-m-d" id="fecha5" name="fecha5" class="form-control" >
                                           
                                          <input type="hidden" id="fecha6" name="fecha6" class="form-control"value="<?php echo date("Y-m-d"); ?>" >                                       
                                           
                                        
                            <div class="form-group col-md-12 col-sm-12">
                                        <label for="Documento" >Documento sustentario:</label>
                                        <div class=" input-group col-md-12">
                                            <div class="fileUpload btn " style="border-radius: 0px; color: rgb(255, 255, 255); opacity: 1; cursor: pointer; background-color: rgb(51, 122, 183);" >
                                    <span><i class="ion-upload m-r-5"></i>Seleccionar Archivo</span>
                                    <input name="file"  type="file" id="file"  class="upload" onchange='$("#upload-file-info").html($(this).val().slice(12));' >
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
                                                    
                                                }
                                                   
                                                });
                                            </script>
                                            <input type="hidden" id="fname"   >                                       
                                                <input type="hidden" id="fsize"  >                                       
                                                    <input type="hidden" id="ftype" >                                       
                                            &nbsp;
                                            <b class='' id="upload-file-info"></b>
                                        </div>
                                        
                            </div>
            <br><br>
            <div class="form-group col-md-12">
                                
                              
                <a onclick="regresarC();limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;

                <button type="button" id="env" onclick="guardarCuponesM();" value="buscar" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>

                            
                                </div>

                </form>
        </div>      
        

        <?php   
        }else
        {
          ?>
        <div class="form-group col-md-3" style="padding-left: 0px;">
                         <br><br>
                                 <a  href="#" onclick="regresarC();limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="ion-arrow-left-b"></i>&ensp;Regresar</a>  
                                        

                                    </div>
        <?php
        }
    ?>
    </div>

    </div>
</div>
    </div>
 </div>

 </div>

</body>
      
    <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
         <script src="vistas/libs/imagina/assets/notifications/notify.min.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notify-metro.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notifications.js"></script>
        <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
          <script src="vistas/com/cupones/matri/matri.js" type="text/javascript"></script>
      <script>
          
        
          altura();
    
      
        </script>
</html>
