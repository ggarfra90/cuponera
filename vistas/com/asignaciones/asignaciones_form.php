<?php

$id = null;
$tipo = null;
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
if (isset($f_id)) {
    $cep_id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
}
//while($fila=$result->fetch_array()){
//	$arr[$fila['usu_id']] = $fila['usu_nombre'];
//}

$c=2;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Agregar colaboradores a la lista de cup&oacute;n especial - Recursos Humanos -  Netafim</title>
    <link href="vistas/libs/imagina/css/bootstrap-combobox.css" rel="stylesheet" type="text/css"/>
     <link href="vistas/libs/imagina/assets/notifications/notification.css" rel="stylesheet" />
   <script src="vistas/libs/imagina/js/bootstrap-combobox_1.js" type="text/javascript"></script>
    <script src="vistas/com/asignaciones/asignaciones.js" ></script>
 <script>
    
     $(document).ready(function(){
         tituloAsignaciones(<?php echo $cep_id;?>);
          });
              var cont=<?php echo $c;?>;
              var ant;
               function elimar(i){
                   
           $("#debajo"+i).remove();
           limpia();
           altura();   
       }
        function  Otro(i){
        var c = $('#ag i').attr('class');   
        $("#ag").addClass('disabled');
    $("#ag i").removeClass(c);
    $("#ag i").addClass('fa fa-spinner fa-spin');
            cont++;
             ant=cont-1;
             otroDiv(i,cont);
                $("#ag").removeClass('disabled');
                $("#ag i").removeClass('fa-spinner fa-spin');
                $("#ag i").addClass(c);
                                 if(cont>5){limpia();altura();}

    }  
   
     limpia();
    </script>
    <style>
      #c{
            color: #D95252;
            opacity: 0.7;
        }
       #c:hover{
            color: #D95252;
            opacity: 1;
        }
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
.combobox-container{
   margin-bottom: 10px;
}
.typeahead-long {
  max-height: 300px;
  overflow-y: auto;
  width: 100%;
}

 @media (max-width: 450px) {
     #d1{
         min-width: 230px;
         margin-left: -55px;
     }
     #lb1{
         min-width: 230px;
  margin-left: -50px;
     }
     #lb2{
         min-width: 150px;
  margin-left: -50px;
     }
     #d2{
           min-width: 230px;
  margin-left: -52px;
     }
     }

    </style>
</head>

<body>
    <div class="page-title">
        </div>
    <div class="row">
           <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class=" panel-body">
                         <div class="col-md-12">
                            
                             <form class="form" action="" id="frm_asig" name="frm_asig" method="post">
                                 <div class="col-md-12" id="debajo1">
                                 <div id="vista" class="form-group col-md-6 ">
                                     <label id="lb1">Nombre del colaborador : </label>
                                     <div class=" col-md-12 quita" id="d1">
                                         <select id="combobox1"  class="form-control " onchange="$('#msjc').remove();"  name="usu_id[]">

                                        </select>
                                     </div>
                                 </div>
                                 <div class="form-group col-md-6"  >
                                      <label id="lb2">N&uacute;mero de d&iacute;as :</label>
                                      <div class="input-group col-md-12 quita" id="d2">

                                         <input type="text" name="dias[]" class="form-control " id="dias1" onkeypress="return isNumberKey(this);" onchange="$('#msjd').remove();"placeholder="Ingrese d&iacute;as" style="  margin-bottom: 10px;" >
                                             <span class="input-group-addon" style="border:0px none;"><i class="fa fa-close" style="color: #fff;"> </i></span>
                                     </div>
                                 </div>
                                 </div>
                                 <input type="hidden" name="cep_id" id="cep_id" value="<?php echo $cep_id; ?>">
    <div class="form-group col-md-12" id="bt">
        <button  type="button" onclick='AsigRH("<?php echo $cep_id;?>");limpia();' class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-close"></i>&nbsp;Cancelar</button>
        <button type="button"  id="ag" onclick='Otro(<?php echo $cep_id; ?>);' class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-plus"></i>&ensp;Agregar</button>
        <button type="button"  value="buscar" id="env" class="btn btn-info w-sm m-b-5" style="border-radius: 0px;"><i class="fa fa-send-o"></i>&ensp;Enviar</button>
    </div>
</form>
                </div>
                        <div style="clear:left;padding-bottom: 20px;" >
<p><b>Leyenda:&nbsp;</b>
     <i class="fa fa-close" style=" color:#D95252;"  ></i> Eliminar &nbsp;&nbsp;&nbsp;
   
</p>
</div>
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
          
 <script src="vistas/libs/imagina/js/jquery.tool.js" type="text/javascript"></script>
     <script type="text/javascript">
  $(document).ready(function(){
      allCombo(<?php echo $cep_id;?>);
   // 
  });
   
  function validat(){
      var valor=true;
          var frm = document.getElementById("frm_asig");
          
            var s=0;
	for (i=0;i<frm.elements.length;i++)
	{
           
      if(frm.elements[i].type=='text'){
                var id=frm.elements[i].id; 
                var t=document.getElementById(id).value;
                if(t=="" || t==0){
                    s=s+1;
               var id=frm.elements[i].id;
                var t=document.getElementById(id).value;
                if(t==""){
                    s=s+1;
               
                    var res = id.slice(4,5);
                   
                   
                   $("#msjd").remove();
                     $("#dias"+res).after("<i id='msjd'style='color:red;'>ingrese dias</i>");
           
                    valor=false;
                }
                if(t==0){
                    s=s+1;
               
                    var res = id.slice(4,5);
                   
                   
                   $("#msjd").remove();
                     $("#dias"+res).after("<i id='msjd'style='color:red;'>ingrese un valor mayor a 0.</i>");
           
                    valor=false;
                    
                }
                
              
  }
        }
    }
    return valor;
    }
  $("#env").click(function(){
            var frm = document.getElementById("frm_asig");
            var s=0;
	for (i=0;i<frm.elements.length;i++)
	{
             if(frm.elements[i].type=='select-one'){
               var id2=frm.elements[i].id;
               var t2=document.getElementById(id2).value;
              
              if(t2==''){
                    var res = id2.slice(8,9);
                     s=s+1;
                      
                      $("#msjc").remove();
                     $("#combobox"+res).before("<i id='msjc' style='color:red;'>Seleccione un colaborador</i>");
                   //alert('combo'+id2);
                   //return false;
                }
                     if(s>=1){
                // alert("valor s="+s);
                return false;
            } 
                   
                
                } 
            
           
	}
      
         if(validat())
         {  insertar(cont);}
       
    });
  altura();
</script>

</body>
</html>
