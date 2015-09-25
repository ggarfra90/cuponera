<?php

extract($_REQUEST, EXTR_PREFIX_ALL, "f");
$mj="";
if(isset($f_mj)){
    $mj=$f_mj;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Mantenimiento de Cupones Especiales - Recursos Humanos - Netafim</title>
   <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
      <script src="vistas/com/feriados_anio/feriados_anio.js" type="text/javascript"></script>
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
</style>
        <script>
           
               $(document).ready(function (){
                   listarFeriadosAnio();
        var j="<?php echo $mj;?>";
        if(j!=""){
            $.Notification.autoHideNotify('success', 'right top', '&Eacute;xito', j);
        }
    });
            
       
     $( "#fecha2" ).datepicker({
		  format: "yyyy-mm-dd",
               language: "es",
               autoclose:"true"
	});
                    var f=new Date();
                   
                    var fn=f.getFullYear() + "-" +(f.getMonth() +1) + "-" + (f.getDate())  ;
            $( "#fecha" ).datepicker({
		  format: "yyyy-mm-dd",
                  setDate:fn,
               language: "es",
                daysOfWeekDisabled: "0,1,2,3,5,6",
               autoclose:"true",
               toggleActive: true
	//	onClose: function( selectedDate ) { $( "#rfecha" ).datepicker( "option", "maxDate", selectedDate ); }
	}).on('changeDate',function(ev){
                 var f=new Date(ev.date);
                    var fn=f.getFullYear() + "-" +(f.getMonth() +1) + "-" + f.getDate()  ;
                  $( "#fecha2" ).datepicker('setDate',fn);
        }); 

limpia();
</script>
    </head>
    <body>
        <div class="page-title">
       <h3>Mantenedor de d&iacute;as feriados</h3>
                </div>
    <div class="row">
      
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="panel-body">
   </p>
                        <form method="post" name="frm_feriado" id="frm_feriado" action="" class="form">
                            <div class="col-md-12">
                                                        <p class="text-justify m-b-30"><b>Nota: </b>Solo permite agregar los feriados de semana santa.<br>
                                                                                                      
                            </div>
                            <div class="form-group col-md-12 m-t-10" id="g3">
                                <label>Jueves santo</label>&nbsp;
                                    <div class="input-group col-md-12 quita">
                                        <span class="input-group-addon white-bg "><i class="glyphicon glyphicon-calendar"></i></span>
                                                        <input type="text" id="fecha" placeholder="A-m-d" name="fecha" class="form-control" value="<?php echo date("Y-m-d"); ?>" >
                                             <input type="hidden" id="fecha2" name="fecha2" class="form-control" value="<?php echo date("Y-m-d"); ?>" >               
                                    </div>   
                                        
                            </div>
                                <div class="form-group col-md-12">
                                            <div class="input-group col-md-8" > 

                                                <button type="button" id="env" onclick="insertarFeriadoAnio();" value="buscar"  class="btn btn-info w-sm m-b-10" id="env" style="border-radius:  0px;background-color:#337AB7;"  ><i class="fa fa-plus"></i><span>&nbsp;&nbsp;Agregar</span></button>
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
	
            <i class='fa fa-trash-o'style=' color:#DC3611;'></i> Eliminar &nbsp;&nbsp;&nbsp;
            <i class='fa fa-trash-o'></i> Sin acci&oacute;n &nbsp;&nbsp;&nbsp;       
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