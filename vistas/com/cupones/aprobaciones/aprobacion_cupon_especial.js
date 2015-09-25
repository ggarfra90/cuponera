function aprobCe(id){
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
              
                 OpeCuponEspecial(id,"",2);
            } else {     
                swal("Cancelada", "La aprobaci\xf3n", "error");   
            } 
        });
        //ce_aprob_p.php?id=".$fila['ces_id']."&opcion=2
    }
function rechazar(id) {
    
     swal({   title: "Rechazo de solicitud",
        text: "Ingrese el motivo del rechazo:",  
        type: "input", 
        showCancelButton: true,
         confirmButtonColor: "#33b86c", 
        closeOnConfirm: false,
        //animation: "slide-from-top",
        inputPlaceholder: "Ingrese el motivo" }, 
    function(inputValue){ 
        if (inputValue === false) return false;
        if (inputValue === "") {  
            swal.showInputError("Debe ingresar un motivo!"); 
            return false 
        }  
        
    OpeCuponEspecial(id,inputValue,3);
    });
    
	

	//if(motivo!=null) { location.href="ce_aprob_p.php?id="+id+"&opcion=3&motivo="+motivo; }
}
function  OpeCuponEspecial(id,mot,op){
    spinnerAR();
    aprobacionAnularEspeciales(id,mot,op);
}
function getAprobacionCuponesEspeciales()
{
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "opcionAprobacionCuponesEspeciales");
    ax.setAccion("getAprobacionCuponesEspeciales");
    ax.consumir();
   
}

function aprobacionAnularEspeciales(cup_id,mot,op){
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES,"opcionAprobacionCuponesEspeciales");
    ax.addParam("cep_id",cup_id);
    ax.addParam("motivo",mot);
    ax.addParam("opcion",op);
    ax.setAccion("functionAprobarAnularEspecial");
    ax.consumir();
}
function opcionAprobacionCuponesEspeciales(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
           
            case 'getAprobacionCuponesEspeciales':
           onResponseAjaxpGetDataAprobacionCuponesEspeciales(response.data);
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
            case "functionAprobarAnularEspecial":
                repuestaAnularAprobarEspeciales(response.data);
                break;
                
        }
    }
}
function onResponseAjaxpGetDataAprobacionCuponesEspeciales(data){
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Colaboradores</th>' +
            '<th>Cupón especial</th>' +
            '<th>Inicio</th>' +
            '<th>Fin</th>' +
            '<th>Días</th>' +
            '<th>Fecha solicitud</th>' +
            '<th>Notas</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td >" + item.cep_nombre + "</td>" +
                "<td >" + item.ces_fec_ini + "</td>" +
                "<td >" + item.ces_fec_fin + "</td>" +
                "<td >" + item.ces_dias + "</td>" +
                 "<td >" + item.ces_fec_sol + "</td>" +
                  "<td >" + item.nota + "</td>" +
                  "<td style='text-align:center;vertical-align:middle;'>" +
                  "<a onClick='aprobCe(\""+item.ces_id+"\");' data-toggle='tooltip' data-placement='top' title='' data-original-title='Aprobar' ><i class='fa fa-check' style=' color:#5cb85c;font-size:18px;text-align:center;'></i> </a>&nbsp;&nbsp;"+
                  "<span onclick='rechazar(\""+item.ces_id+"\");' style='cursor: pointer' data-toggle='tooltip' data-placement='top' title='' data-original-title='Rechazar' ><i class='fa fa-times'style='font-size:18px; color:#DC3611;'></i></span>"+
                "</td>"+
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
     $("#scroll").empty();
    $("#scroll").append(html);
    
   
}
function repuestaAnularAprobarEspeciales(data){
     
    if (data[0]["vout_exito"] == '1') {
       spinnerSA();
        getAprobacionCuponesEspeciales();
        

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
    
}