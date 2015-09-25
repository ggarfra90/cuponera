<?php
$id = null;
$tipo = null;
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
if (isset($f_id)) {
    $id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
}
$mj="";
if(isset($f_mj)){
    $mj=$f_mj;
}
?>
<html lang="es">
    <head>
<link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
 <link href="vistas/libs/imagina/assets/notifications/notification.css" rel="stylesheet" />
 <script src="vistas/com/asignaciones/asignaciones.js" ></script>
 <script>
     
     $(document).ready(function(){
         tituloAsignaciones(<?php echo $id;?>);
          listarAsignaciones(<?php echo $id;?>);
          
          });
           $(document).ready(function (){
        var j="<?php echo $mj;?>";
        if(j!=""){
            $.Notification.autoHideNotify('success', 'right top', '&Eacute;xito', j);
        }
    });
 </script>
 
        <style>
 
        
             @media screen and (max-width: 850px) {
            #scroll{
                min-width:650px;
            }
                 #muestrascroll{
                overflow-x:scroll;
            }
            
}
#datatable td{
    vertical-align: middle;
}
.sweet-alert button.cancel {
  background-color: rgba(224, 70, 70, 0.8);
}
.sweet-alert button.cancel:hover {
  background-color:#E04646;
}
.sweet-alert {
 
   border-radius: 0px; 
  
}
.sweet-alert button {
     -webkit-border-radius: 0px; 
   border-radius: 0px; 

}
</style>
    </head>
    <body >
        <div class="page-title">

        </div>
        <div class="row">
        
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                 <div class="col-md-12">
                                
                              
                                  <a onclick="cargarDiv('#window','vistas/com/especiales/especiales_listar.php');
limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="ion-arrow-left-b"></i>&ensp;Regresar</a>&nbsp;&nbsp;&nbsp;
                    <a href="#" class="btn btn-info  w-sm m-b-5" onclick="nuevoAsig(<?php echo $id; ?>)"><i class=" fa fa-user-plus" style="border-radius: 0px;"></i> <i> </i>&nbsp;<i> </i>Agregar</a><br><br>

                            
                                </div>
                   
                            </div>
                                    

                                    <div class="panel panel-body" id="muestrascroll">
                                        <div class="col-md-12 col-md-12 col-xs-12 " id="scroll">
                        
     
</div>
                               
                    </div>
                                               <div style="clear:left">
<p><b>Leyenda:</b>
    
                                    <i class="fa fa-edit" style="color:#E8BA2F;"></i>Editar n&uacute;mero de dias &nbsp;&nbsp;&nbsp;
	
                                    <i class="fa fa-trash-o" style="color:#cb2a2a;"></i> Eliminar
</p>
</div>
                </div>
          
            </div>
        </div>      
           
          <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
         <script src="vistas/libs/imagina/assets/notifications/notify.min.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notify-metro.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notifications.js"></script>
 <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>
 <script src="vistas/libs/imagina/assets/sweetalert2/sweetalert.min.js" type="text/javascript"></script>
 <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
 
     <script type="text/javascript">
    
          
          altura();
</script>
    </body>
</html>

