<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Nuevo bloqueo de cup&oacute;n - Recursos Humanos -  Netafim</title>
    <link href="vistas/libs/imagina/css/bootstrap-combobox.css" rel="stylesheet" type="text/css"/>
    <script> 
      limpia();
    </script>
    <style>
        .input-group-addon {
  border: 1px solid #eee;
   border-radius: none;
}
.input-group-addon {
  padding: 6px 12px;
  font-size: 14px;
  font-weight: 400;
  line-height: 1;
  color: #555;
  text-align: center;
   background-color: #fff; 
   border: 1px solid #eee;
  border-radius: 0px; 
}
  .typeahead-long {
  max-height: 215px;
  overflow-y: auto;
  width: 100%;
  
}
    </style>
</head>

<body>
    <div class="page-title">
        <h3 class="title" >Nuevo bloqueo de cup&oacute;n</h3>
        </div>
   
    <div class="row">
           <div class="col-md-12 ">
                <div class="panel panel-default">
         
                    <div class=" panel-body">
                        <h4><b>Datos del cup&oacute;n a bloquear:</b></h4>
                        <h6><b>Nota:</b> Solo se pueden registrar bloqueos nuevos que pertenezcan al a&ntilde;o actual <?php echo date("Y"); ?>.</h6>
                         <div class="col-md-12 ">
                         
                             <form class="form" action="" id="frm_bloqn" method="post">
                                 <div class="form-group col-md-6">
                                     <label>Nombre del colaborador</label>
                                     <div class="input-group col-lg-12">
	
                                         <select id="usu_id" class="form-control" name="usu_id">
                                             <option value='' disabled selected style='display:none;'>Ingrese colaborador</option>

                                             
                                         </select>
                                         <i id='msj2' style='color:red;' hidden>Ingrese un colaborador</i>


                                    </div>
                                 </div>
                                 <div class="form-group col-md-6">
                                      <label>Tipo de cup&oacute;n</label>
                                      <div class="input-group col-lg-12">
                                          <select id="cup_tipo" class="form-control" name="cup_tipo">
                                              <option value='' disabled selected style='display:none;'>Ingrese tipo de cup&oacute;n</option>
                                              
                                          </select>
                                          <i id='msj3' style='color:red;' hidden>Ingrese tipo cup&oacute;n</i>

                                      </div>
                                      
                                 </div>
                                 <div class="form-group col-md-12">


                                     <a onclick='regresarB();limpia();' class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-close"></i>&ensp;Cancelar</a>&nbsp;&nbsp;&nbsp;

                                     <button type="button" id="env"  onclick="insertarBloqueo();"value="buscar" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>


                                 </div>
</form>
<br>
  
                </div>
              </div>
        </div>
    </div>
    </div>
       <script src="vistas/libs/imagina/js/pace.min.js"></script>
        <script src="vistas/libs/imagina/js/wow.min.js"></script>
        <script src="vistas/libs/imagina/js/jquery.nicescroll.js" type="text/javascript"></script>
 <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>
        <script src="vistas/libs/imagina/js/bootstrap-combobox.js" type="text/javascript"></script>
 <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
  <script src="vistas/com/bloqueo/bloqueo.js" type="text/javascript"></script>


     <script type="text/javascript">
         $("#usu_id").change(function (){
             $("#msj2").hide();
         });
         $("#cup_tipo").change(function (){
             $("#msj3").hide();
         });
  $(document).ready(function(){
      llenaCombos();
      });
   
    
     
 

  altura();
</script>

</body>
</html>
