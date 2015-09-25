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
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Mantenimiento de Cupones Especiales - Recursos Humanos - Netafim</title>
        <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
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
            .sweet-alert[data-has-cancel-button=false] button {
                background-color: rgb(67, 119, 19);
            }
            .typeahead-long {
                max-height: 300px;
                overflow-y: auto;
                width: 100%;

            }
        </style>
        <script>
               $(document).ready(function (){
        var j="<?php echo $mj;?>";
        if(j!=""){
            $.Notification.autoHideNotify('success', 'right top', '&Eacute;xito', j);
        }
    });
            $(document).ready(function () {
                limpia();
            });
          
       
        </script>
    </head>
    <body>
        <div class="page-title">
            <h3 class="title">Bloqueo de Cupones</h3>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <a href="#" style="border-radius: 0px;" class="btn btn-info w-md m-b-15"onclick="cargarDiv('#window', 'vistas/com/bloqueo/bloqueo_form.php')"><i class=" fa fa-plus" ></i>&nbsp;&nbsp;Nuevo</a>
                    <div class="panel panel-body" id="muestrascroll">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="scroll">

                        </div>
                    </div>
                    <div style="clear:left">
                        <p><b>Leyenda:</b>
                            <i class="fa fa-trash-o" style="color:#cb2a2a;"></i> Eliminar bloqueo&nbsp;
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
          <script src="vistas/com/bloqueo/bloqueo.js"></script>

     <script type="text/javascript">
     $(document).ready(function(){
          listarCuponesBloqueo();
          
          });
    
                        altura();
                        $('.comfirm').removeProp('style');
        </script>

    </body>
</html>