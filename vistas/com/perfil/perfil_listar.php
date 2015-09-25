<html lang="es">
    <head>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <title>Mantenimietno de Perfiles</title>

        <script>
            altura();
        </script> 

    </head>

    <body >
        <div class="page-title">
            <h3 class="title">Mantenimiento de Perfiles</h3>
        </div>
        <div class="row">

            <!--<div class="col-md-12 col-md-12 col-xs-12">-->
            <div class="panel panel-default">
                <a href="#" style="border-radius: 0px;" class="btn btn-info w-md" onclick="cargarDiv('#window', 'vistas/com/perfil/perfil_form.php')"><i class=" fa fa-plus-square-o" style="font-size: 18px;"></i>&nbsp;&nbsp;<i> </i><i> </i>Nuevo</a>
                <br><br>
                <div class="panel panel-body">
                    <div class="col-md-12 col-sm-12 col-xs-12" >
                        <div class="table-responsive">
                            <div id="datatable2">

                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear:left">
                    <p><b>Leyenda:</b>&nbsp;&nbsp;
                        <i class="fa fa-edit" style="color:#E8BA2F;"></i> Editar la informaci&oacute;n &nbsp;&nbsp;&nbsp;
                        <!--<i class="fa fa-group" style="color:#1ca8dd;"></i> Listar colaboradores asignados &nbsp;&nbsp;&nbsp;-->
                        <i class="fa fa-trash-o" style="color:#cb2a2a;"></i> Eliminar&nbsp;&nbsp;&nbsp;
                        <i class='fa fa-unlock' style="color:#5cb85c;"></i> Visible&nbsp;&nbsp;&nbsp;
                        <i class="fa fa-lock" style="color:#cb2a2a;"></i>  No visible&nbsp;&nbsp;&nbsp;
                        <i class='ion-checkmark-circled' style="color:#5cb85c;"></i> Estado activo &nbsp;&nbsp;&nbsp;
                        <i class="ion-flash-off" style="color:#cb2a2a;"></i> Estado inactivo 
                    </p>
                </div>

            </div>
        </div>
        <script src="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="vistas/libs/imagina/assets/datatables/dataTables.bootstrap.js"></script>  
        <script src="vistas/libs/imagina/assets/sweetalert2/sweetalert.min.js" type="text/javascript"></script>
        <script src="vistas/libs/imagina/js/jquery.tool.js"></script>
        <script src="vistas/com/perfil/perfil.js"></script>
    </body>
</html>

