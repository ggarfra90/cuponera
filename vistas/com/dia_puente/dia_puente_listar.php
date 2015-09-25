<?php

extract($_REQUEST, EXTR_PREFIX_ALL, "f");
$mj="";
if(isset($f_mj)){
    $mj=$f_mj;
}
$y=date('Y');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Mantenimiento de Cupones Especiales - Recursos Humanos - Netafim</title>
   <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
      <script src="vistas/com/dia_puente/dia_puente.js" type="text/javascript"></script>
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
.typeahead-long {
  max-height: 300px;
  overflow-y: auto;
  width: 100%;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
    background-color: rgba(239, 242, 243, 0);
    cursor: pointer;
}
</style>
        <script>
           
               $(document).ready(function (){
                    getComboDiaPuente();
                    getListaDiaPuenteAnio();
                  
        var j="<?php echo $mj;?>";
        if(j!=""){
            $.Notification.autoHideNotify('success', 'right top', '&Eacute;xito', j);
        }
    });
         $('#anio').datepicker({
    format: "yyyy",
    minViewMode: 2,
    language: "es",
    orientation: "top auto",
    autoclose: true,
    toggleActive: true
}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    
                var f2=f.getFullYear();
                agregarSC("#dias");
                 getComboDiaPuente(f2);
        });   
       
     

limpia();
</script>
    </head>
    <body>
        <div class="page-title">
       <h3>Mantenedor de d&iacute;as puente</h3>
                </div>
    <div class="row">
      
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="panel-body">
                        <form method="post" name="frm_puente" id="frm_puente" action="" class="form">
                           
                            
                            
                                <div class="form-group col-md-6" id="g3">
                                    <label>A&ntilde;o</label>&nbsp;
                                        <div class="col-md-12 quita">
                                            <input type="text" name="anio" placeholder='Seleccione año' maxlength="4"  id="anio" autocomplete='off' value="<?php echo $y;?>" class="form-control" readonly="true">               
                                                             <i id='msj' style='color:red;font-style: normal;font-size: 14px;' hidden>Ingrese a&ntilde;o</i>

                                        </div>   
                                        
                            </div>  
                             <div class="form-group col-md-6" id="g3">
                                 <label>N&deg; de d&iacute;as puente</label>&nbsp;
                                        <div class="col-md-12 quita" >
<select  class="form-control" name="dias" id="dias" >
                         </select>                                                         <i id='msj2' style='color:red;font-style: normal;font-size: 14px;'' hidden>Ingrese un n&uacute;mero</i>

                                        </div>           
                                        
                            </div> 
                         
                              
                           <div class="form-group col-md-12">
                                <div class="input-group col-md-8" > 

                                    <button type="button" value="buscar"  class="btn btn-info w-sm m-b-10" id="env" style="border-radius:  0px;background-color:#337AB7;"  ><i class="fa fa-plus"></i><span>&nbsp;&nbsp;Agregar</span></button>

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
	<i class="fa fa-edit" style=" color:#CBDF18" ></i> Editar &nbsp;&nbsp;&nbsp;
            <i class='fa fa-trash-o'style=' color:#DC3611;'></i> Eliminar &nbsp;&nbsp;&nbsp;
          
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
                        altura();
                        $('.comfirm').removeProp('style');
        </script>

    </body>
</html>