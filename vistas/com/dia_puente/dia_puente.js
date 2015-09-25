
function getComboDiaPuente(anio) {
    acciones.iniciaAjaxTest(COMPONENTES.DIAPUENTE, "opcionDiaPuente");
    if (anio != '') {
        ax.addParam('anio', anio);
    }
    ax.setAccion("functionNumeroDiaPuente");
    ax.consumir();
}
function getCantidadDias(anio) {
    acciones.iniciaAjaxTest(COMPONENTES.DIAPUENTE, "opcionDiaPuente");
    ax.addParam('anio', anio);
    ax.setAccion("functionValidaDiaPuente");
    ax.consumir();
}
function getListaDiaPuenteAnio() {
    acciones.iniciaAjaxTest(COMPONENTES.DIAPUENTE, "opcionDiaPuente");
    ax.setAccion("functionListarDiaPuente");
    ax.consumir();
}
function eliminarDiaPuente(anio,dias,dp_id){
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.DIAPUENTE, "opcionDiaPuente");
    ax.setAccion("functionEliminarDiaPuente");
    ax.addParam("anio", anio);
    ax.addParam("dias", dias);
    ax.addParam("dp_id", dp_id);
    ax.consumir();
}
function editarDiaPuenteAnio(anio,dias,dp_id,dia_ant){
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.DIAPUENTE, "opcionDiaPuente");
    ax.setAccion("functionEditarDiaPuente");
    ax.addParam("anio", anio);
    ax.addParam("dias", dias);
    ax.addParam("dp_id", dp_id);
    ax.addParam("dia_ant", dia_ant);
    ax.consumir();
}
function enviarDiaPuenteAnio(anio, dias) {
    acciones.iniciaAjaxTest(COMPONENTES.DIAPUENTE, "opcionDiaPuente");
    ax.setAccion("functionInsertDiaPuenteAnio");
    ax.addParam("anio", anio);
    ax.addParam("dias", dias);
    ax.consumir();
}

function opcionDiaPuente(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'functionNumeroDiaPuente':
                getComboCantidadDias(response.data);
                altura();
                break;
            case 'functionValidaDiaPuente':
                getCantidadDiasR(response.data);
                altura();
                break;
            case 'functionListarDiaPuente':
                onResponseAjaxpGetDataGridDiaPuente(response.data);
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
            case 'functionInsertDiaPuenteAnio':
                cargarRespuestaDiaPuente(response.data);
                break;
            case 'functionEditarDiaPuente':
                cargarRespuestaEditarDiaPuente(response.data);
                break;
            case 'functionEliminarDiaPuente':
                cargarRespuestaEliminarDiaPuente(response.data);
                break;

        }
    }
}
function getCantidadDiasR(data) {
    var cont = 0;

    cont = data[10]['tamanio'];
        $("#dias").append("<input type='hidden' id='numero' value='"+cont+"'></input>")
    
}

function getComboCantidadDias(data) {
    var cont = 0;
    var cuerpo_total = '';
    cont = data[10]['tamanio'];
    for (var i = 1; i <= cont; i++) {

        var cuerpo = '';

        cuerpo = "<option value='" + i + "'>" + i + "</option>";
        cuerpo_total = cuerpo_total + cuerpo;
    }
    $("#dias").empty();
    $("#dias").append(cuerpo_total);
    removeSC();
}
function onResponseAjaxpGetDataGridDiaPuente(data) {

    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Año</th>' +
            '<th>Días puente utilizables</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';

    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.anio + "</td>" +
                "<td >" + item.disponibles + "</td>" +
                "<td style='text-align:center;'>" +
                "<a onClick='Edit(\"" + item.anio + "\",\"" + item.disponibles + "\", \"" + item.dia_puente_id + "\");' data-toggle='tooltip' data-placement='left' title='' data-original-title='Editar' ><i class='fa fa-edit' style=' color:#CBDF18;font-size:18px;text-align:center;'></i> </a>&nbsp;&nbsp;" +
                "<span onclick='Elimi(\"" + item.anio + "\",\"" + item.disponibles + "\", \"" + item.dia_puente_id + "\");' style='cursor: pointer' data-toggle='tooltip' data-placement='left' title='' data-original-title='Eliminar' ><i class='fa fa-trash-o'style='font-size:18px; color:#DC3611;'></i></span>&nbsp;" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#scroll").empty();
    $("#scroll").append(html);
}
function regresarFA() {
    listarDiaPuente();
}
function cargarRespuestaDiaPuente(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        getListaDiaPuenteAnio();
        $.Notification.autoHideNotify('success', 'right top', 'Correcto', data[0]["vout_mensaje"]);

        quitaSpinnerAgregar();

    }
    if (data[0]['vout_exito'] == 0) {
        jQuery.each(data, function (index, value) {
            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
        });
        quitaSpinnerAgregar();
    }
}

function  cargarRespuestaEliminarDiaPuente(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        getListaDiaPuenteAnio();
        spinnerSA();

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}
function  cargarRespuestaEditarDiaPuente(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
           getListaDiaPuenteAnio();
        spinnerSA();

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}



numero();
function Edit(a, d, i) {
    $("#numero").remove();
     getCantidadDias(a);
     
    swal({
        title: "Editar d\xedas",
        text: "Ingrese n\xfamero de d\xedas:",
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#33b86c",
        closeOnConfirm: false,
        inputPlaceholder: "Ingrese d\xedas,actual " + d + " d\xedas"},
    function (inputValue) {
       var valor=0;
       valor=$("#numero").val();
        $(".cancel").removeProp("disabled");
        
        if (inputValue === "") {
            swal.showInputError("Debe ingresar un valor!");
            return false;
        }
        if (parseInt(inputValue)<=0) {
            swal.showInputError("Ingrese un valor mayor a 0.");
            return false;
        }
        if (parseInt(inputValue)>parseInt(valor)) {
            swal.showInputError("El máximo de días puente para el año "+a+" es: "+valor+".");
            return false;
        }
        if (inputValue === false){
            return false;}
        $(".confirm").removeProp("disabled");
        editarDiaPuenteAnio(a,inputValue,i,d);
    });
    $('input:text').keypress(function (evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    });
}
function Elimi(a,d,i) {

    swal({
        title: "Est\xe1s seguro?",
        text: "desea elminar el registro " + i,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#33b86c",
        confirmButtonText: "Si, Eliminar!",
        cancelButtonColor: '#d33',
        cancelButtonText: "No, cancelar !",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        $(".confirm").removeProp("disabled");
        if (isConfirm) {

           eliminarDiaPuente(a,d,i);
        } else {

            swal("Cancelada", "La eliminaci\xf3n", "error");
            $(".confirm").removeProp("disabled");
        }
    });

}

$('#anio').change(function () {
    $('#msj').hide();

});
$('#dias').change(function () {
    $('#msj2').hide();

});

$("#env").click(function () {

var cont=0;
    var anio = document.getElementById("anio").value;
    var dias = document.getElementById("dias").value;

    if (anio == "") {
        $("#msj").removeProp("hidden");
        $("#msj").show();
            cont++;
    }
    if (dias == "") {
        $("#msj2").removeProp("hidden");
        $("#msj2").show();
        cont++;
    }
    
    if(cont==0){
      spinner();
       enviarDiaPuenteAnio(anio, dias);
   }
   

});