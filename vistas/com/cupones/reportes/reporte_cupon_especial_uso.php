<?php
extract($_REQUEST, EXTR_PREFIX_ALL, "f");
if (isset($f_id)) {
    $id = (int) filter_var($f_id, FILTER_SANITIZE_NUMBER_INT);
}
?>
<html lang="es">
    <head>
        <link href="vistas/libs/imagina/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" ></link>
        <link href="vistas/libs/imagina/assets/sweetalert2/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="vistas/libs/imagina/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="vistas/libs/imagina/assets/timepicker/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
        <script src="vistas/com/cupones/reportes/reporte_cupon_especial.js"></script>
        <script src="vistas/com/cupones/reportes/reporte_cupon_especial_uso.js"></script>


        <title>Mantenimietno de Colaboradores</title>
        <script>
            $(document).ready(function () {
                listarComboEspecial();
                
            });

            limpia();
            function exportar() {
                location.href = "reporte_ce_uso_excel.php?id=<?php echo $id; ?>";
            }
        </script>   
        <style type="text/css" media="screen">


            @media  (min-width: 851px) and (max-width:960px) {
                #scroll{
                    width: 100%;  
                }
                #muestrascroll{
                    overflow-x:scroll;
                }  
            }
            @media screen and (max-width: 850px) {
                #scroll{
                    width: 70%; 
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
            <h3 class="title">Reporte de Utilizaci&oacute;n de Cupones Especiales</h3> 
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div class="panel-body">
                            <form method="post" action="javascript:ReporCupon(5);" id="frm_buscar3" class="form">
                                <div class="form-group col-md-12">
                                    <label>Seleccione cup&oacute;n especial</label>
                                    <div class="input-group col-lg-12">
                                        <select class="form-control" name="id" id="id">

                                        </select>
                                    </div>

                                </div>     
                                <div class="form-group col-md-12" >
                                    <div class="form-group col-md-12">

                                        <div class="input-group col-md-8" > 
                                            <a onclick='exportar();' class="btn btn-info w-lg m-b-10"style="background-color:#337AB7;border-radius:  0px;" id="boton" ><i class="fa fa-file-excel-o " ></i><span>&nbsp;&nbsp;Exportar</span></a>&nbsp;&nbsp;&nbsp;

                                            <button type="button" value="buscar" onclick="buscarReporteCuponesEspecialUso();" class="btn btn-info w-lg m-b-10"style="background-color:#337AB7;" id="envb" ><i class="fa fa-search"></i><span>&nbsp;&nbsp;Buscar</span></button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-body " id="muestrascroll">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="scroll" >
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Colaborador</th>
                                        <th>Dias asignados</th>
                                        <th>Dias solicitados</th>
                                        <th>Dias aprobados</th>
                                        <th>Dias sin usar</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table> 
                        </div>
                    </div>
                    <div style="clear:left">
                        <p><b>Leyenda:&nbsp;&nbsp;</b>
                            <i class='fa fa-info-circle' style="color:#ebc142;"></i> Ver informaci&oacute;n&nbsp;&nbsp;
                            <i class='fa fa-sign-in' style="color:#33b86c;"></i> Ver detalle
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
          
                                        $("#da").tooltip();
                                        $('[data-toggle="tooltip"]').tooltip();
                                        $('#datatable').dataTable({
                                            "language": {
                                                "sProcessing": "Procesando...",
                                                "sLengthMenu": "Mostrar _MENU_ registros",
                                                "sZeroRecords": "No se encontraron resultados",
                                                "sEmptyTable": "Ning\xfAn dato disponible en esta tabla",
                                                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                                                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                "sInfoPostFix": "",
                                                "sSearch": "Buscar:",
                                                "sUrl": "",
                                                "sInfoThousands": ",",
                                                "sLoadingRecords": "Cargando...",
                                                "oPaginate": {
                                                    "sFirst": "Primero",
                                                    "sLast": "Último",
                                                    "sNext": "Siguiente",
                                                    "sPrevious": "Anterior"
                                                },
                                                "oAria": {
                                                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                                }
                                            }
                                        }
                                        );

                                        altura();
        </script>
    </body>
</html>

