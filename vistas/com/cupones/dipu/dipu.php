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
$dipu_disp=$dat["dipu_disponible"];
$msg_nohay=$dat["dipu_msj"];
$dipu_usad=$dat["dipu_usad"];
$fin= date("Y");
$sfin=$fin."-12-31";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>D&iacute;a Puente - Recursos Humanos -  Netafim</title>
   <link href="vistas/libs/imagina/assets/notifications/notification.css" rel="stylesheet" />
           <script src="vistas/com/cupones/dipu/dipu.js"></script>
           <script>
$(document).ready(function (){
            ComboPuente();
        });
            </script>
<style>
    @media (min-width: 768px){
.form-inline .input-group>.form-control {
  width: 240px;
}
  @media (min-width: 300px){
.form-inline .input-group>.form-control {
  width: 240px;
}
    }
  
    }
              .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
  position: relative;
  min-height: 1px;
  padding-right: 5px;
  padding-left: 10px;
}
</style>
 <script>
        limpia();
         
    </script>
</head>

    <body onload="altura();">

     <div class="page-title">
                 <h3 class="title">Cup&oacute;n de D&iacute;a Puente</h3>
     </div>

<div class="row">
   

   
<div class="col-md-12">
         <div class="panel panel-default"> 
            
               <div class="panel-body"> 
            <div class="col-md-6">
                <img class="img-responsive" style="height: 350px;"  width="750" src="images/diapuente<?php echo ($cup_color==0?"bw":""); ?>.png" border="1" title="Cup&oacute;n de d&iacute;a puente"><br><br>
            </div>    
            <div class="col-md-6">
     <p class="text-justify"> Notas: Solo puede hacerse efectivo en las fechas especificadas en la lista.
Este beneficio es personal e intransferible. V&aacute;lido hasta diciembre del <?php echo $_SESSION['rec_anio'];?>.
El d&iacute;a solicitado deber&aacute; ser coordinado anticipadamente con el jefe superior
<b>y estar&aacute; sujeto a las necesidades/actividades del &aacute;rea.</b><br><br>

        D&iacute;as puente disponibles para el presente a&ntilde;o:<b> <?php echo $dipu_disp;?></b>&nbsp;&nbsp;&nbsp;&nbsp;
        D&iacute;as puente utilizados para el presente a&ntilde;o:<b> <?php echo $dipu_usad;?></b><br><br>
            <?php echo $msg_cup; ?><br><br></p>

<?php
if ($dipu_disp == "No definido") echo "No se han definido d&iacute;as puente para este a&ntilde;o, consulte con RRHH<br><br>";
echo $msg_nohay;

if ($bloqueo>0) {
	echo "<p style='margin-left:15px;'><font color='red'><b>Cup&oacute;n bloqueado</b></font> (Consulte a Recursos Humanos para m&aacute;s informaci&oacute;n).<br></p>";
?>
                    <?php
                        $cup_color = 0;
                    }


if ($cup_color==1) {
?>
                <div class="col-md-12">
                    
                        <form action=""  id="frm_dipu" method="post" class="form">
                                   
                             <div class="form-group col-md-12">
                                         <label >Fecha de solicitud para cup&oacute;n: </label>
                                        
                                            <div class="input-group col-md-12">
                                                 <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                 <select id="fecha2" name="fecha2" class="form-control">
                                                          
                                                    </select>
                                            </div>                       
                                           
                                        </div>
                                        
                     
                                           <div class="form-group col-md-12">
                                
                              
                                               <a onclick="regresarC();limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;

                                               <button type="button" onclick="guardarCuponesP()" id="env" value="buscar" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>

                            
                                </div>
</form>
                        </div>
                    </div>
<br>
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

</body>
      
    <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
         <script src="vistas/libs/imagina/assets/notifications/notify.min.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notify-metro.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notifications.js"></script>
        <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
                
    
    <script>   
        altura();
       
        
    </script>
</html>
