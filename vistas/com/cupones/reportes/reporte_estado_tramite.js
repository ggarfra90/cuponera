
function getReporteEstadoTramite()
{
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporteEstadoTramite");
    ax.setAccion("getReporteEstadoTramiteListar");
    ax.consumir();
   
}

function opcionReporteEstadoTramite(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
           
            case 'getReporteEstadoTramiteListar':
          onResponseAjaxpGetDataReporteEstadoTramite(response.data);
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
                $('[data-toggle="tooltip"]').tooltip();
                altura();
                break;
           
                
        }
    }
}
function onResponseAjaxpGetDataReporteEstadoTramite(data){
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Periodo</th>' +
            '<th>Inicio</th>' +
            '<th>Fin</th>' +
            '<th>D&iacute;as</th>' +
             '<th>Fecha solicitud</th>' +
            '<th>Notas</th>' +
            '<th>Estado</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.cep_nombre + "</td>" +
                "<td >" + item.ces_fec_ini + "</td>" +
                "<td >" + item.ces_fec_fin + "</td>" +
                 "<td style='width:2%;'>" + item.ces_dias + "</td>" +
                "<td >" + item.ces_fec_sol + "</td>" +
                 "<td style='width:14%;'>" + item.nota + "</td>" +
                "<td style='text-align:center;width:5%;'><i class='" + item.icono + "' style='font-size:20px;color:" + item.color + ";'data-toggle='tooltip' data-html='true' data-placement='left' title='' data-original-title='" + item.estado + "'></i></td>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
     $("#scroll").empty();
    $("#scroll").append(html);
    
   
}
