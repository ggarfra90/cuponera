<?php
$mj="";
if(isset($_GET["mj"])){
    $mj="Usuario ".$_GET["mj"];
}
?>
<html lang="es">
    <head>
  <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
            <link href="vistas/libs/imagina/assets/notifications/notification.css" rel="stylesheet" />
        <script src="vistas/com/usuario/usuario.js"></script>

        <title>Mantenimietno de Usuarios</title>
        <script>
            $(document).ready(function (){
                 var j="<?php echo $mj;?>";
        if(j!=""){
            $.Notification.autoHideNotify('success', 'right top', '&Eacute;xito', j);
        }
                listarUsuarios();
            });
            
        </script>
        <style type="text/css" media="screen">
        
   
        
      @media screen and (max-width: 1250px)  {
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
         <h3 class="title">Mantenimiento de usuarios</h3>
     </div>
    <div class="row">
        
        <div class="col-md-12 col-md-12 col-xs-12">
            <div class="panel panel-default">
               
                
                <a href="#" style="border-radius: 0px;" class="btn btn-info w-md"onclick="cargarDiv('#window','vistas/com/usuario/usuario_form.php')"><i class=" fa fa-plus" ></i>&nbsp;&nbsp;<i> </i><i> </i>Nuevo</a>
                    <br><br>
                <div class="panel panel-body" id="muestrascroll">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="scroll">
                        
</div>
                    </div>
                             <div style="clear:left">
<p><b>Leyenda:</b>&nbsp;&nbsp;&nbsp;
    <i class="fa fa-edit" style="color:#E8BA2F;"></i> Editar la informaci&oacute;n &nbsp;&nbsp;&nbsp;
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
         <script src="vistas/libs/imagina/assets/notifications/notify-metro.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notifications.js"></script>
        <script src="vistas/libs/imagina/assets/sweetalert2/sweetalert.min.js" type="text/javascript"></script>
        <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>
        <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script> <script type="text/javascript">
     
          altura();
</script>
    </body>
</html>

