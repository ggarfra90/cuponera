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
        <title>Cumplea&ntilde;os - Recursos Humanos -  Netafim</title>

<link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
 <link href="vistas/libs/imagina/assets/notifications/notification.css" rel="stylesheet" />
<script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
<script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
<?php 
   $fecha = $_SESSION['rec_fec_cump'];
   $f = $_SESSION['rec_fec_cump'];
   $nuevafecha5=date("Y-m-d");
$nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
$nuevafecha2 = date ( 'm-j' , $nuevafecha );
  $nuevafecha3 = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
$nuevafecha4 = date ( 'm-j' , $nuevafecha3 );
?>
        <script>

           
            $( "#fecha2" ).datepicker({
		  format: "yyyy-mm-dd",
               language: "es"
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	});
            $( "#fecha" ).datepicker({
		  format: "yyyy-mm-dd",
               language: "es",
               autoclose:"true"
	}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    var fl=f.getFullYear() + "-" +(f.getMonth() +1) + "-" + f.getDate()  ;
                
                 $( "#fecha2" ).datepicker('setDate',fl);
    
        });; 
        $("#fecha").datepicker('setDate','<?php echo $nuevafecha5;?>')
        limpia();
        altura();
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
                        <h3 class="title">Cup&oacute;n de Cumplea&ntilde;os</h3>
                    </div>
        <div class="row">    
            <div class="col-md-12">
                <div class="panel panel-default">
                    
                    <div class="panel-body">
                <div class="col-md-6">
                    <img style="height: 300px;" class="img-responsive" src="images/cumpleanios<?php echo ($cup_color == 0 ? "bw" : ""); ?>.png"  width="750" title="Cup&oacute;n de cumplea&ntilde;os"><br><br>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <p class="text-justify">Notas: Puede hacerse efectivo desde 7 d&iacute;as antes del d&iacute;a de cumplea&ntilde;os hasta 7 d&iacute;as despu&eacute;s.
                            Este beneficio es personal e intransferible. V&aacute;lido hasta diciembre del <?php echo $_SESSION['rec_anio']; ?>.
                            El d&iacute;a solicitado deber&aacute; ser coordinado anticipadamente con el jefe superior
                            <b>y estar&aacute; sujeto a las necesidades/actividades del &aacute;rea.</b><br><br>
                        </p></div>
                            <p><b><?php echo $msg_cup; ?></b><br></p>


                    <?php
                    if ($bloqueo > 0) {
                        echo "<p style='margin-left:15px;'><font color='red'><b>Cup&oacute;n bloqueado</b></font> (Consulte a Recursos Humanos para m&aacute;s informaci&oacute;n).<br></p>";
                     
                        $cup_color = 0;
                    }

                    if ($cup_color == 1) {
                        ?>
                        <div class="col-md-12">

                            <div class="panel-body">
                                <form class="form" role="form"  id="frm_cump" method="post" >
                                   
                                    <div class="form-group col-md-6">
                                        <label for="Fcumple" class="">Fecha de Cumpleaños</label>
                                        <div class=" input-group col-lg-12">
                                         <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                         
                                         <input type='text' class="form-control" style="background:#fff;" id="cump" value='<?php  echo $f; ?>' readonly="true">
                                        </div>
                                    </div>

                                    <div id="cal" class="form-group col-md-6" data-toggle="tooltip" data-placement="bottom" title="">
                                        <label for="FechSo">Fecha de solicitud:</label>
                                        <div class=" input-group col-lg-12">
                                           
                                                <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" id="fecha" name="fecha" class="form-control" >
                                                
                                            
                                            <input type="hidden" id="fecha2" name="fecha2" class="form-control" value="<?php echo date("Y-m-d"); ?>" >                                       
                                        </div>
                                    </div>
                                   
                                        <div class="form-group col-md-12">
                                
                              
                                            <a onclick="regresarC();limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;

                                            <button type="button" onclick="guardarCupones();" id="env" value="buscar" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>

                            
                                </div>
                                      
                                </form>
                            </div>

                            <?php
                        }else
        {
          ?>
         <div class="form-group col-md-3" >
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
        <script src="vistas/com/cupones/cump/cump.js" type="text/javascript"></script>
      <script>
          
        
          altura();
    
      
        </script>
</html>
