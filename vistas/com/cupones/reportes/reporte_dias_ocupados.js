
function getReporteDiasOcupados()
{
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporteDiasOcupados");
    ax.setAccion("getReporteDiasOcupados");
    ax.consumir();
   
}

function opcionReporteDiasOcupados(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
           
            case 'getReporteDiasOcupados':
             onResponseAjaxpGetDataReporteDiasOcupados(response.data);
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
function onResponseAjaxpGetDataReporteDiasOcupados(data){
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Fecha</th>' +
            '<th>Categor&iacute;a</th>' +
            '<th>Tipo</th>' +
            '<th>Estado</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.fecha + "</td>" +
                "<td >" + item.categoria + "</td>" +
                "<td >" + item.tipo + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='font-size:20px;color:" + item.color + ";'data-toggle='tooltip' data-html='true' data-placement='top' title='' data-original-title='" + item.estado + "'></i></td>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
     $("#scroll").empty();
    $("#scroll").append(html);
    
   
}
