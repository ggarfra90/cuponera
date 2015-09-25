<?php
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
$cep_id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
	$dias_disp = (int) filter_var($f_dias_d, FILTER_SANITIZE_NUMBER_INT);
        	$dias = (int) filter_var($f_dias, FILTER_SANITIZE_NUMBER_INT);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cupones Especiales - Recursos Humanos -  Netafim</title>

<link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
 <link href="vistas/libs/imagina/assets/notifications/notification.css" rel="stylesheet" />
<script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
<script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
<script src="vistas/com/util/Utils.js" type="text/javascript"></script>
<script src="vistas/com/especiales/especiales.js" type="text/javascript"></script>


<script>
    $(document).ready(function (){
        llenaDatosEpeciales(<?php echo $cep_id;?>);
    });
$(function(){
   
     
    $( "#fecha2" ).datepicker({
		   format: "yyyy-mm-dd",
             
               language: "es"
	});
	$( "#fecha" ).datepicker({
		   format: "yyyy-mm-dd",
               startDate: "<?php echo date("Y-m-d");?>",
              //endDate:"",//se cargara con un setEndDate desde js
               language: "es",
               autoclose:"true",
               todayHighlight: true
	}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear() + "-" +(f.getMonth() + 1) + "-" + f.getDate()  ;
        
                 $( "#fecha2" ).datepicker('setDate',f2);
    
        });
	
});
limpia();
</script>
<style>

    @media (max-width: 350px) {

  
        #fechas{
            width: 130px;
        }
         #combo{
            width: 175px;
        }
}
</style>
</head>
   
    <body onload="limpia();">
    

<div class="page-title">
                </div>
 <div class="row">
        <div class="col-md-12">
            <div class=" panel panel-default">
                
                <div class="panel-body">
                  
                    <div class="col-md-7">
                        
           <p class=" col-md-12 text-justify">


    <b>Reconocemos tu esfuerzo y dedicaci&oacute;n</b><br>
           </p>
                        <p class=" col-md-12 text-justify">
    En compensaci&oacute;n a todo el tiempo que invertiste, te otorgamos <?php echo $dias; ?> d&iacute;as. Tienes <?php echo $dias_disp; ?> d&iacute;as disponibles para usar.
                        </p>
                        <p id="text1" class=" col-md-12 text-justify p-b-10">

</p>
                             <div class="panel-body">
    <div class="col-md-12"> 
<?php
if ($dias_disp>0) {
    
?>
                  
                        
                        <form action="" id="frm_ce" method="post" class="form">
<input type="hidden" name="cep_id" id="cep_id" value="<?php echo $cep_id; ?>">
   	
	
    <div class="form col-md-6 " id="combo">
                <label for="Nombre" >Seleccione cantidad de d&iacute;as:</label>
                                        <div class=" col-md-10 quita">
                                            <select name="dias" id="dias" class="form-control">
<?php
for ($i = 1; $i <= $dias_disp; $i++) {
	echo "\t\t\t<option value=".$i.">$i</option>\n";
}
?>
		</select>
                                        </div>
            </div>
                        <div class="form-group col-md-6">
                                         <label for="fecha" >Fecha de inicio de permiso:</label>
                                        
                                         <div class="input-group  col-md-12" id="fechas">
                                                 <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                 <input type="text" id="fecha" name="fecha" class="form-control" value="<?php echo date("Y-m-d");?>">
                                               
                                          <input type="hidden" id="fecha2" name="fecha2" class="form-control" value="<?php echo date("Y-m-d");?>" >                                       
                                            </div>
                                        </div>
	 <div class="form-group col-md-12">
                                
                              
             <a onclick="regresarC();limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;

             <button type="button" onclick="enviarDatosS();" id="env" value="buscar" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>

                            
                                </div>
    
</form>

                        
       <?php 
} else {
    
                         echo "<b style='color:red;'>Nota:No quedan d&iacute;as disponibles.</b><br>";
         echo " <br><br>";
                          echo ' <a href="#" onclick="regresarC();limpia();" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-check"></i>&nbsp;&nbsp;Aceptar</a>&nbsp;&nbsp;&nbsp;';


}      
	
?>     
    </div>
<br>    
  
                   </div>
                    </div>
                      <div class="col-md-5">
                          <img style='height:350px;' class='img-responsive' width='650' id="imagen" src="">
                         
                    </div>
                               
                </div>

            </div>
        </div>
    </div>
</body>
     <script>
      
          altura() ;
    </script>
        <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
     <script src="vistas/libs/imagina/assets/notifications/notify.min.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notify-metro.js"></script>
        <script src="vistas/libs/imagina/assets/notifications/notifications.js"></script>
        
 
</html>
