<?php
session_start();
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
$matri=0;
if (isset($_SESSION['rec_usu_matricial'])) {
    $matri=$_SESSION['rec_usu_matricial'];
}
$est_id = 255;
if (isset($f_est_id)) {
	$est_id=abs((int) filter_var($f_est_id, FILTER_SANITIZE_NUMBER_INT));
}
$org_id= $_SESSION['rec_org'];
if (isset($f_org)) {
	$org_id=abs((int) filter_var($f_org, FILTER_SANITIZE_NUMBER_INT));
}
$rfecha2 = Date('Y')."-01-01";
$rfecha4 = date("Y-m-d");

if (isset($f_rfecha2)&& isset($f_rfecha4)) {
	$rfecha2 = filter_var($f_rfecha2, FILTER_SANITIZE_STRING);
	$rfecha4 = filter_var($f_rfecha4, FILTER_SANITIZE_STRING);
	
}
?>
<html lang="es">
    <head>
        <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
        <script src="vistas/com/cupones/reportes/reporte_c.js"></script>

        <title>Mantenimietno de Colaboradores</title>
        <script>
            $(document).ready(function (){
               <?php
               if($matri==1){
                   ?>
                           getComboOrgacionzacionM(); 
                           <?php
               }
               ?> 
               
            getReporte('<?php echo $rfecha2;?>','<?php echo $rfecha4;?>',<?php echo $est_id;?>,<?php echo $org_id;?>);
                          

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
                 $( "#rfecha3" ).datepicker('setStartDate',f2);
                 $( "#rfecha2" ).datepicker('setDate',f2);
        });   	
          $( "#rfecha3" ).datepicker({
                  format: "yyyy-mm-dd",
               language: "es",
               autoclose:"true"
        //	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
        }).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear() + "-" +(f.getMonth() + 1) + "-" + f.getDate()  ;
            
                 $( "#rfecha4" ).datepicker('setDate',f2);
    
        });
        $( '#rfecha3' ).datepicker( 'setDate', '<?php echo $rfecha4; ?>' );	 
       
});      
limpia();
function exportar() {
	var nombre="";
        //var nombre = encodeURIComponent(document.getElementById("nombre").value);
	location.href="reporte_cupones_excel.php?fec_ini=<?php echo $rfecha2; ?>&fec_fin=<?php echo $rfecha4; ?>&est_id=<?php echo $est_id; ?>&nom="+nombre;
}
        </script>   
        
     <style type="text/css" media="screen">
           @media screen and (max-width: 1200px) {
           
                 #muestrascroll{
               overflow-x:scroll;
            }
           
}
 .table{width:100%;max-width:80%;margin-bottom:20px}
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
            <h3 class="title">Reporte de cupones</h3>
        </div>
        <div class="row">

            <!--<div class="col-md-12 col-md-12 col-xs-12">-->
            <div class="col-md-12">
            <div class="panel panel-default">
                
                <div class="panel-heading" >
                    <div class="panel-body">
                        <form method="post" id="frm_buscar" action="" class="form">
                           
                            <div class="form-group col-md-6" id="g1">
                                        <label>Fecha inicio</label>
                                        
                                            <div class="input-group col-md-12">
                                                <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" id="rfecha" name="rfecha" class="form-control" value="<?php echo $rfecha2; ?>" >
                                            </div>
                                        <input type="hidden" id="rfecha2" name="rfecha2" value="<?php echo $rfecha2; ?>" />                                 
                                       
                            </div>
                            <div class="form-group col-md-6" id="g2">
                                                <label>Fecha Fin</label>
                                        
                                                <div id="cal" class="input-group col-md-12" data-toggle="tooltip" data-placement="bottom" title="" >
                                                <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="text" id="rfecha3" class="form-control" name="rfecha3" value="<?php echo $rfecha4; ?>"  >
                                            </div>
                                                <input type="hidden" id="rfecha4" name="rfecha4"value="<?php echo $rfecha4; ?>" />                                     
                                       
                            </div>
                         <div class="form-group col-md-6" id="g3">
                                        <label>Estado</label>
                                        <div class="col-md-12 quita">
                                            <select id="estado" class="form-control" name="estado">
                    <option value="1" <?php if($est_id==1) echo "selected"; ?>>Solicitado</option>
                    <option value="2" <?php if($est_id==2) echo "selected"; ?>>Aprobado</option>
                    <option value="3" <?php if($est_id==3) echo "selected"; ?>>Rechazado</option>
                    <option value="101" <?php if($est_id==101) echo "selected"; ?>>Anulado</option>
                    <option value="255" <?php if($est_id==255) echo "selected"; ?>>Todos</option>
                </select>                                   
                         </div>              
                            </div>
                            <div id="oculto"></div>
                           <div class="form-group col-md-12">
                                <div class="form-group"> </div>
                                <div class="input-group col-md-8" style="  display: inline;"> 
                                  <a onclick='exportar();' class="btn btn-info w-lg m-b-10"style="border-radius:  0px;background-color:#337AB7;" id="boton" ><i class="fa fa-file-excel-o " ></i><span>&nbsp;&nbsp;Exportar</span></a>&nbsp;&nbsp;&nbsp;

                                  <button id="envb" onclick="buscarReporteCupones()" type="button" value="buscar" class="btn btn-info w-lg m-b-10"style="border-radius:  0px;background-color:#337AB7;"  ><i class="fa fa-search"></i><span>&nbsp;&nbsp;Buscar</span></button>

                              </div>
                                </div>   
                        </form>
                        
                    </div> 
                </div>
                <div class="panel-body" id="muestrascroll">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="scroll">
      
                    </div>              
                </div>
                       <div style="clear:left">
<p><b>Leyenda:&nbsp;&nbsp;</b>

         <i class="ion-checkmark-circled" style=" color:#5cb85c;"  ></i> Aprobado &nbsp;&nbsp;&nbsp;
    <i class='fa  fa-clock-o' style=' color:#EFF70D;'></i> Solicitado &nbsp;&nbsp;&nbsp;
    <i class='fa  fa-exclamation-circle'style="color:#FA9810;"></i> Rechazado &nbsp;&nbsp;&nbsp;
    <i class='fa  fa-times-circle' style="color:#DC3611;"></i>  Anulado &nbsp;&nbsp;&nbsp;
         <i class='fa fa-close'style=' color:#BF0A07;'></i> Anular &nbsp;&nbsp;&nbsp;
	<i class='fa fa-file-pdf-o'style='color:#BF0A07;'></i> Ver documento sustentario&nbsp;&nbsp;&nbsp;
        <i class='fa fa-file-pdf-o'></i> Sin documento 
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
        <script>
            

        altura();
            </script>
    </body>
</html>

