<html lang="es">
    <head>
 <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>            <script src="vistas/com/cupones/reportes/reporte_dias_ocupados.js"></script>
            <title>Mantenimietno de Colaboradores</title>
        <script>
            $(document).ready(function (){
                getReporteDiasOcupados();
            });
            altura();
        </script>   
        <style type="text/css" media="screen">

	
        @media screen and (max-width: 800px) {
            #scroll{
                width: 650px; 
            }
                 #muestrascroll{
                overflow-x:scroll;
            }
            
}
#datatable td{
    vertical-align: middle;
}
</style>
        
        
    </head>

    <body >
        <div class="page-title">
         <h3 class="title">Reporte d&iacute;as ocupados</h3>
                </div>
    <div class="row">
       
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                
                <div class="panel-body" id="muestrascroll">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="scroll">
                            
  
</div>
                        </div>
                <div style="clear:left">
<p><b>Leyenda:&nbsp;</b>
     <i class="ion-checkmark-circled" style=" color:#5cb85c;"  ></i> Aprobado &nbsp;&nbsp;&nbsp;
    <i class='fa  fa-clock-o' style=' color:#EFF70D;'></i> Solicitado &nbsp;&nbsp;&nbsp;
        <i class='fa fa-play-circle' style='color:#337AB7;'></i> Ejecutado &nbsp;&nbsp;&nbsp;

    <i class='fa  fa-times-circle' style="color:#DC3611;"></i>&nbsp;Inv&aacute;lido
    
    
</p>
</div>
                    </div>
            </div>
        </div>
        <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>  
        <script src="vistas/libs/imagina/assets/sweetalert2/sweetalert.min.js" type="text/javascript"></script>
        <script src="vistas/libs/imagina/js/jquery.tool.js"></script>
    

    </body>
</html>

