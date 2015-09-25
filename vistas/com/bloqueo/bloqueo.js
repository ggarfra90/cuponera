
//function AsigRH(id) {
//    $("#window").empty();
//    cargarDiv("#window", "vistas/com/asignaciones/asignaciones_listar.php?id=" + id);
//}
function regresarB() {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/bloqueo/bloqueo_listar.php");
}
function regresarBM() {
    mj="Registrado."
    $("#window").empty();
    cargarDiv("#window", "vistas/com/bloqueo/bloqueo_listar.php?mj="+mj);
}
//function regresarEM(op) {
//    $("#window").empty();
//    var mj="";
//    if (op==1){mj="Registrado."}
//   if(op==2){mj="Editado."}
//    cargarDiv("#window", "vistas/com/especiales/especiales_listar.php?mj="+mj);
//}
//function cargarDivGetUsuario(id) {
//    $("#window").empty();
//    cargarDiv("#window", "vistas/com/especiales/especiales_edit_form.php?id=" + id);
//}
function llenaCombos(){
    getCuponCombo();
    getUsuarioCombo(); 
}
function getCuponCombo() {
    acciones.iniciaAjaxTest(COMPONENTES.BLOQUEO, "successPerfil");
    ax.setAccion("getAllCupones");
    ax.consumir();
}
function getUsuarioCombo() {
    acciones.iniciaAjaxTest(COMPONENTES.BLOQUEO, "successPerfil");
    ax.setAccion("getAllUsuarios");
    ax.consumir();
}
function listarCuponesBloqueo() {
//    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.BLOQUEO, "successPerfil");
    ax.setAccion("getAllBloqueo");
    ax.consumir();
}
function delBloqCup(anio, tipo, usu_id) {
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.BLOQUEO, "successPerfil");
    ax.setAccion("functionDeleteBloqueo");
    ax.addParam("cup_anio",anio);
    ax.addParam("cup_tipo",tipo);
    ax.addParam("usu_id",usu_id);
    ax.consumir();
}
function enviarBloqueo(usu_id,cup_id) {
    acciones.iniciaAjaxTest(COMPONENTES.BLOQUEO, "successPerfil");
    ax.setAccion("functionInsertBloqueo");
    ax.addParam("usu_id", usu_id);
    ax.addParam("cup_id",cup_id);
    ax.consumir();
}

function successPerfil(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getAllBloqueo':
                onResponseAjaxpGetDataGridBloqueo(response.data);
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
                case 'functionDeleteBloqueo':
                cargarRespuesta(response.data);
                break;
            case 'functionInsertBloqueo':
                cargarRespuestaI(response.data);
                break;
            case 'getAllUsuarios':
                llenaComboUsuario(response.data);
                 $('#usu_id').combobox();
                break;
                case 'getAllCupones':
                llenaComboCupones(response.data);
                $('#cup_tipo').combobox();
                break;
//                case 'functionEditEspeciales':
//                cargarRespuestaInsert(response.data,2);
//                break;
        }
    }
}
function llenaComboUsuario(data){
     
    var cabeza="<option value='' disabled selected style='display:none;'>Ingrese colaborador</option>";
      var cuerpo_total = '';
    var cuerpo = '';
    $.each(data, function (index, item) {
        cuerpo = "<option value='"+item.usu_id+"'>"+item.usu_nombre+"</option>";
        cuerpo_total = cuerpo_total+cuerpo;
    });
    var html =cabeza+cuerpo_total;

    $("#usu_id").append(html);
}
function llenaComboCupones(data){
    var cabeza="<option value='' disabled selected style='display:none;'>Ingrese tipo de cup&oacute;n</option>";
      var cuerpo_total = '';
    var cuerpo = '';
    $.each(data, function (index, item) {
        cuerpo = "<option value='"+item.cup_tipo+"'>"+item.cup_nombre+"</option>";
        cuerpo_total = cuerpo_total+cuerpo;
    });
    var html =cabeza+cuerpo_total;

    $("#cup_tipo").append(html);
}
function validar(){
      var t,b;
      b=$("#usu_id").val();
      t=$("#cup_tipo").val();
      if(b==null){
      $("#msj2").show();
           
        return false;
      }

     if(t==null){
         $("#msj3").show();
           
        return false;
     }
      return true;
  }
function onResponseAjaxpGetDataGridBloqueo(data) {

    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Colaborador</th>' +
            '<th>A&ntilde;o</th>' +
            '<th>Tipo</th>' +
            '<th>Bloqueado por</th>' +
            '<th>Fecha bloqueo</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    //
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td >" + item.cup_anio + "</td>" +
                "<td >" + item.cup_nombre + "</td>" +
                "<td >" + item.bloq_usu_nombre + "</td>" + 
                "<td >" + item.bloq_fec_reg + "</td>" +
                "<td style='text-align:center;'>" +
                "<a href='#' onclick='delBloq(" + item.cup_anio + "," + item.cup_tipo+","+item.usu_id+", \""+item.cup_nombre+"\",\""+item.usu_nombre + "\")'><b><i class='fa fa-trash-o' data-toggle='tooltip' data-placement='left' title='' data-original-title='Eliminar' style='font-size:16px;color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#scroll").append(html);
}

function cargarRespuestaI(data) {
      if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        regresarBM();
        quitaSpinner();

    }
    if (data[0]['vout_exito'] == 0) {
         quitaSpinner();
        jQuery.each(data, function (index, value) {
            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
        });
       
    }
}
function cargarRespuesta(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        listarCuponesBloqueo();
        spinnerSA();

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}
//function cargarRespuestaInsert(data,op) {
//    if (data[0]["vout_exito"] == '1') {
//        $("#scroll").empty();
//        regresarEM(op);
//        quitaSpinner();
//
//    }
//    if (data[0]['vout_exito'] == 0) {
//         quitaSpinner();
//        jQuery.each(data, function (index, value) {
//            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
//        });
//       
//    }
//}



function  insertarBloqueo() {

    if (validar()) {
        spinner();
        var usu_id = document.getElementById("usu_id").value;
        var cup_tipo = document.getElementById("cup_tipo").value;
        
        enviarBloqueo(usu_id,cup_tipo);

    }
}

function delBloq(anio, tipo, usu_id, cup_nom, usu_nom) {

                swal({
                    title: "Est\xe1s seguro?",
                    text: "Desea eliminar el bloqueo del cup\u00f3n " + cup_nom + ' ' + anio + ' de ' + usu_nom + "!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#33b86c",
                    confirmButtonText: "Si, eliminar!",
                    cancelButtonColor: '#d33',
                    cancelButtonText: "No, cancelar !",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {

                        delBloqCup(anio, tipo, usu_id);
                    } else {
                        swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
                    }
                });
            }