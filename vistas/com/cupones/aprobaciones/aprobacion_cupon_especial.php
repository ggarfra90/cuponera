<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Aprobaciones de Cupones Especiales Pendientes - Recursos Humanos - Netafim</title>
<link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
<script src="vistas/com/cupones/aprobaciones/aprobacion_cupon_especial.js"></script>
<script>
    limpia();
$(function (){
        getAprobacionCuponesEspeciales();
    });
</script>
<style type="text/css" media="screen">
            @media screen and (max-width: 1050px) {
            #scroll{
                width: 850px;
                
                
                
            }
            #muestrascroll{
                overflow-x: scroll;
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
<body>
   <div class="page-title">
       <h3>Aprobaci&oacute;n de cupones especiales pendientes</h3>
                </div>
    <div class="row">
      
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
               
                <div class="panel-body" id="muestrascroll">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="scroll">
                        
 
</div>
                    </div>
                    <div style="clear:left">
                        <p><b>Leyenda:&nbsp;&nbsp;</b>
	<i class="fa fa-check" style=" color:#5cb85c;" ></i> Aprobar &nbsp;&nbsp;&nbsp;
            <i class='fa fa-times'style=' color:#DC3611;'></i> Rechazar &nbsp;&nbsp;&nbsp;
</p>
</div>
                </div>
            </div>
            
        </div>
    
        <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
        
     <script src="vistas/libs/imagina/assets/sweetalert2/sweetalert.min.js" type="text/javascript"></script>
 <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>

<script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                
                altura();
            } );
  
        </script>



</body>
</html>
