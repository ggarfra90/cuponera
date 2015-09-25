<?php
include_once __DIR__ . '/../../../controlador/cuponera/CuponControlador.php';
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

?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Mantenimietno de Perfiles</title>

        <script>
            altura();
        </script> 
    </head>
    <body>
        <div class="page-title"> 
                     <h3 class="title">Cuponera <?php echo $_SESSION['rec_anio']; ?></h3>
                </div>
             <?php
        $response = CuponControlador::getCupon();
             $c=count($response);
       ?>
            
        <?php
       
       $cont=0;
        for($i=1;$i<=$c;$i++){
           $r=0;
           $ra=5;
           if($i%3==0){
               $ra=2; 
               
           }
           if($i>2 || $cont==0){
           if(($i-1)%3==0 || $cont==0){
               $r=1;
               
           }
            if ($r==1) {
                echo '   <div class="row">';
            }
           }
           $nombre=$response[$i]['cup_nombre'];
             $icon=$response[$i]['cup_style'];
             $msj=$response[$i]['cup_msj'];
             $color=$response[$i]['cup_color'];
             $url=$response[$i]['cup_url'];
             $t=$response[$i]['cup_tipo'];
       $cont++;
            ?>
<!--        <section class="content">-->

        
                    <div class="col-md-4  ">
                        <a href="#" onclick="cargarDivCupon('<?php echo $url;?>','<?php echo $t;?>');limpia();">
                        <div class="widget-panel widget-style-1 bg-warning" style="background:<?php echo $color; ?>">
                            <div class="h2 text-white"><?php echo $nombre;?></div>
                            <span class="text-white"><?php echo $msj?></span>
                            <?php echo $icon;?> 
                        </div>
                            </a>
                    </div>
       <?php 
       
       if ($ra==2) {
                echo '   </div>';
            }
            }?>
               
                <!-- End row -->

  

                <div class="row">
                    <div class="col-md-4  ">
                       
                        <div class="widget-panel widget-style-1 bg-success">
                           <div class="h2 text-white">Especiales</div>
                           <div class="form-group" style="margin-bottom:5px;">
                               
                          
                               <select  class="form-control" name="id" id="id" >
                                   <option value='' disabled selected  style='display:none;'>Seleccione una opci&oacute;n</option>
                         </select>
                  </div>          
<i class="fa  fa-star-o" style="margin-right: 60px;margin-bottom: 95px;font-size:55px;"></i>           
<i class="fa  fa-star-o" style="font-size:55px;margin-right: 120px;margin-bottom: 115px;"></i> 
                        <i class="fa  fa-star-o" style="margin-right: 0px;margin-bottom: 75px;font-size: 55px;"></i></div>
                   
                    </div>
                </div>
                
        
    </body>
     
        </script>
    <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
         <script src="vistas/libs/imagina/assets/notifications/notify.min.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notify-metro.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notifications.js"></script>
        <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
      
    <script src="vistas/com/cupones/cupones.js"></script>
        <script src="vistas/com/especiales/especiales.js"></script>

    <script> 
        altura();
       
        $(document).ready(function (){
            ComboEspecial();
        });
    </script>
</html>
