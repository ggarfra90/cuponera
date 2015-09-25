
function listarFeriadosAnio() {
    acciones.iniciaAjaxTest(COMPONENTES.FERIADOSANIO, "opcionFeriadoAnio");
    ax.setAccion("functionListarFeriadosAnio");
    ax.consumir();
}
function eliminarFeriadosAnio(id) {
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.FERIADOSANIO, "opcionFeriadoAnio");
    ax.addParam("id_feriado",id);
    ax.setAccion("functionEliminarFeriadosAnio");
    ax.consumir();
}
function enviarFeriadosAnio(fecha) {
    acciones.iniciaAjaxTest(COMPONENTES.FERIADOSANIO, "opcionFeriadoAnio");
    ax.setAccion("functionInsertarFeriadosAnio");
    ax.addParam("fecha", fecha);
    
    ax.consumir();
}

function opcionFeriadoAnio(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'functionListarFeriadosAnio':
                onResponseAjaxpGetDataGridFeriadoAnio(response.data);
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
                case 'functionInsertarFeriadosAnio':
                cargarRespuestaFeriadosAnio(response.data);
                break;
                case 'functionEliminarFeriadosAnio':
                cargarRespuestaEliminarFeriadosAnio(response.data);
                break;
            
        }
    }
}


function onResponseAjaxpGetDataGridFeriadoAnio(data) {

    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Fecha</th>' +
            '<th>Detalle</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    //
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.fecha + "</td>" +
                "<td >" + item.nota + "</td>" +
                "<td style='text-align:center;'>" +
                "<span onclick='"+item.funcion+"' data-toggle='tooltip' data-placement='left' title='' data-original-title='"+item.toltip+"' ><i class='fa fa-trash-o'style='font-size:18px;"+item.cursor+item.color+"'></i></span>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#scroll").append(html);
}
function regresarFA(){
    listarFeriadosAnio();
}
function cargarRespuestaFeriadosAnio(data) {
      if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        regresarFA();
         $.Notification.autoHideNotify('success', 'right top', 'Correcto', data[0]["vout_mensaje"]);

        quitaSpinnerAgregar();

    }
    if(data[0]['vout_exito']==0){
         jQuery.each(data, function (index, value) {
                $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
                });
        quitaSpinnerAgregar();
    }
}

function  cargarRespuestaEliminarFeriadosAnio(data){
     if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        regresarFA();
        spinnerSA();

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}

function  insertarFeriadoAnio() {

    
        spinner();
        var fecha = document.getElementById("fecha2").value;
        
        
        enviarFeriadosAnio(fecha);

    
}

function EliminarFeriados(i) {
    
      swal({   
            title: "Est\xe1s seguro?",   
            text: "Eliminar un feriado de Jueves Santo borra autom\xe1ticamente el feriado de Viernes Santo correspondiente. ",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#33b86c",  
            confirmButtonText: "Si, Eliminar!",   
            cancelButtonColor: '#d33',
            cancelButtonText: "No, cancelar !",  
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){
               $(".confirm").removeProp("disabled");
            if (isConfirm) {     
                 
                 eliminarFeriadosAnio(i);
            } else {     
                
                swal("Cancelada", "La eliminaci\xf3n", "error");  
                   $(".confirm").removeProp("disabled");
            } 
        });
}