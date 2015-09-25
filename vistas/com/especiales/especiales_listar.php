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
 <title>Mantenimietno de Usuarios</title>
 <script>
 $(document).ready(function (){
        var j="<?php echo $mj;?>";
        if(j!=""){
            $.Notification.autoHideNotify('success', 'right top', '&Eacute;xito', j);
        }
    });
 </script>
        <style type="text/css" media="screen">
        @media  (min-width: 1271px) and (max-width:1410px) {
            #scroll{
                width: 1200px;
            }
                   #muestrascroll{
                overflow-x:scroll;
            }  
}
        
            @media screen and (max-width: 1270px) {
            #scroll{
                width: 1100px;   
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
<h3 class="title">Mantenimiento de Cupones Especiales</h3>        </div>
        <div class="row">
            <div class="col-md-12 col-md-12 col-xs-12">
            <div class="panel panel-default">
                <a href="#" style="border-radius: 0px;" class="btn btn-info w-md" onclick="cargarDiv('#window', 'vistas/com/especiales/especiales_form.php')"><i class=" fa fa-plus" style="font-size: 16px;"></i>&nbsp;<i> </i>Nuevo</a>
                <br><br>
                <div class="panel panel-body" id="muestrascroll">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="scroll">
                     
</div>
                    </div>
                               <div style="clear:left">
<p><b>Leyenda:</b>
    <i class="fa fa-edit" style="color:#E8BA2F;"></i> Editar la informaci&oacute;n &nbsp;&nbsp;&nbsp;
    <i class="fa fa-group" style="color:#1ca8dd;"></i> Listar colaboradores asignados &nbsp;&nbsp;&nbsp;
    <i class="fa fa-trash-o" style="color:#cb2a2a;"></i> Eliminar&nbsp;&nbsp;&nbsp;
     <i class='ion-checkmark-circled' style="color:#5cb85c;"></i> Estado activo &nbsp;&nbsp;&nbsp;
      <i class="ion-flash-off" style="color:#cb2a2a;"></i> Estado inactivo 
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
     <script src="vistas/com/especiales/especiales.js"></script>

     <script type="text/javascript">
     $(document).ready(function(){
          listarEspeciales();
          
          });
          
          altura();
</script>
    </body>
</html>

