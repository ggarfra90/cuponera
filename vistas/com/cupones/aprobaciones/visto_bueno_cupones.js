function reVisto(id) {
	  swal({   title: "Rechazo de cup\xf3n",
        text: "Ingrese el motivo del rechazo:",  
        type: "input", 
        showCancelButton: true,
         confirmButtonColor: "#33b86c", 
        closeOnConfirm: false,
        inputPlaceholder: "Ingrese el motivo" }, 
    function(inputValue){ 
        if (inputValue === false) return false;
        if (inputValue === "") {  
            swal.showInputError("Debe ingresar un motivo!"); 
            return false 
        }  
        
    OpeCuponVistoBueno(id,inputValue,0);
    });

	
}
function aproVisto(id) {
		 swal({   
            title: "Est\xe1s seguro?",   
            text: "Deses aprobar la solicitud",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#33b86c",  
            confirmButtonText: "Si, aprobar!",   
            cancelButtonColor: '#d33',
            cancelButtonText: "No, cancelar !",  
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                 OpeCuponVistoBueno(id,"",1);
            } else {     
                swal("Cancelada", "La aprobaci\xf3n", "error");   
            } 
        });
}
function  OpeCuponVistoBueno(id,mot,op){
    spinnerAR();
    aprobacionAnularVistoBueno(id,mot,op);
}
function getAprobacionVistoBueno()
{
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionAprobacionVistoBueno");
    ax.setAccion("getAprobacionVistoBueno");
    ax.consumir();
   
}

function aprobacionAnularVistoBueno(cup_id,mot,op){
    acciones.iniciaAjaxTest(COMPONENTES.CUPON,"opcionAprobacionVistoBueno");
    ax.addParam("cup_id",cup_id);
    ax.addParam("opcion",op);
    ax.addParam("motivo",mot);
        ax.setAccion("functionAprobacionAnularVistoBueno");
    ax.consumir();
}
function opcionAprobacionVistoBueno(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
           
            case 'getAprobacionVistoBueno':
           onResponseAjaxpGetDataAprobacionVistoBueno(response.data);
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
            case "functionAprobacionAnularVistoBueno":
                repuestaAnularAprobarVistoBueno(response.data);
                break;
                
        }
    }
}
function onResponseAjaxpGetDataAprobacionVistoBueno(data){
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Colaboradores</th>' +
            '<th>Fecha de permiso</th>' +
            '<th>Fecha de solicitud</th>' +
            '<th>Tipo</th>' +
            '<th>Notas</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td >" + item.fech_perm + "</td>" +
                "<td >" + item.cup_fec_sol + "</td>" +
                "<td >" + item.cup_nombre + "</td>" +
                "<td >" + item.nota + "</td>" +
                  "<td style='text-align:center;vertical-align:middle;'>" +
                  "<a onClick='aproVisto(\""+item.cup_id+"\");' data-toggle='tooltip' data-placement='left' title='' data-original-title='Aprobar' ><i class='fa fa-check' style=' color:#5cb85c;font-size:18px;text-align:center;'></i> </a>&nbsp;&nbsp;"+
                  "<span onclick='reVisto(\""+item.cup_id+"\");' style='cursor: pointer' data-toggle='tooltip' data-placement='left' title='' data-original-title='Rechazar' ><i class='fa fa-times'style='font-size:18px; color:#DC3611;'></i></span>&nbsp;&nbsp;"+
                  " <a "+item.ruta+item.target+" style='"+item.cursor+item.disable+"'><b><i class='fa fa-file-pdf-o' style='font-size:18px;color:"+item.doc_c+";' data-toggle='tooltip' data-placement='left' title='' data-original-title='"+item.doc+"'></i></b></a>&nbsp;&nbsp;" +
                "</td>"+
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
     $("#scroll").empty();
    $("#scroll").append(html);
    
   
}
function repuestaAnularAprobarVistoBueno(data){
     
    if (data[0]["vout_exito"] == '1') {
       spinnerSA();
        getAprobacionVistoBueno();
        

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
    
}