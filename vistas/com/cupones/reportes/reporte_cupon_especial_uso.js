

function getReporteCuponEspecialUso(id)
{
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporteEspecialUso");
    ax.setAccion("getReporteCuponEspecialUso");
    ax.addParam("ce_id",id);
    ax.consumir();
   
}

function opcionReporteEspecialUso(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            
            case 'getReporteCuponEspecialUso':
             onResponseAjaxpGetDataReporteCuponEspecialUso(response.data);
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
                break;
            
                
        }
    }
}
function onResponseAjaxpGetDataReporteCuponEspecialUso(data){
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Colaborador</th>' +
            '<th>Dias asignados</th>' +
            '<th>Dias solicitados</th>' +
            '<th>Dias aprobados</th>' +
            '<th>Dias sin usar</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.nombre + "</td>" +
                "<td >" + item.cea_dias + "</td>" +
                "<td >" + item.dias_sol +item.det_sol+"</td>" +
                "<td>" + item.dias_apro + item.det_apro+ "</td>" +
                "<td >" + item.dias_su + "</td>" +
               "<td style='text-align:center;'><a href='#' onclick='detalleCuponEspecial("+item.usu_id+");' data-toggle='tooltip' data-placement='left' title='' data-html='true' data-original-title='Ver detalle'><i class='fa fa-sign-in' style='font-size:22px;color:#33b86c;'></i></td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
     $("#scroll").empty();
    $("#scroll").append(html);
    quitaSpinnerBuscar();
}



function buscarReporteCuponesEspecialUso(){
     var id;
    id=$("#id").val();
    
    
    spinnerBuscar();
   getReporteCuponEspecialUso(id);
  
}
function detalleCuponEspecial(id){
  var id2=$("#id").val();
    $("#window").empty(), cargarDiv("#window", "vistas/com/cupones/reportes/reporte_cupon_especial.php?id=" + id2 + "&usu_id=" + id)
 
}
