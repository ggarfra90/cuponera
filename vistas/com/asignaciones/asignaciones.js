function nuevoAsig(id) {
  
    $("#window").empty();
    cargarDiv("#window", "vistas/com/asignaciones/asignaciones_form.php?id=" + id);
}
function ListaInserta(id) {
    $("#window").empty();
    var mj="Registrado."
    cargarDiv("#window", "vistas/com/asignaciones/asignaciones_listar.php?id=" + id+"&mj="+mj);
}
function listarAsignaciones(id) {
//    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("getDataGridAsignaciones");
    ax.addParamTmp("cep_id", id);
    ax.consumir();
}

function tituloAsignaciones(id) {

    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("SearchDatoEspecial");
    ax.addParamTmp("cep_id", id);
    ax.consumir();

}
function allCombo(id) {
    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("functionCombo");
    ax.addParamTmp("cep_id", id);

    ax.consumir();
}
function llenarDivCombo(id, c) {
    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("functionCombo2");
    ax.addParamTmp("cep_id", id);
    ax.addParamTmp("cep_c", c);

    ax.consumir();
}
function delAsig(id, cep_id) {
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("functionDeleteAsignaciones");
    ax.addParamTmp("cep_id", cep_id);
    ax.addParamTmp("usu_id", id);

    ax.consumir();
}
function EditarAsig(id, cid, num) {
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("functionEditAsignaciones");
    ax.addParamTmp("cep_id", cid);
    ax.addParamTmp("usu_id", id);
    ax.addParamTmp("cea_dias", num);
    ax.consumir();
}
function InsertAsig(cid, id, num) {
    spinner();
    acciones.iniciaAjaxTest(COMPONENTES.ASIGNACIONES, "successPerfil");
    ax.setAccion("functionInsertAsignaciones");
    ax.addParamTmp("cep_id", cid);
    ax.addParamTmp("usu_id", id);
    ax.addParamTmp("cea_dias", num);
    ax.consumir();
}
function successPerfil(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridAsignaciones':
                onResponseAjaxpGetDataGridAsignaciones(response.data);
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
            case 'SearchDatoEspecial':
                onResponseAjaxpGetDataTitulo(response.data)

                break;
            case 'onResponseAjaxpGetDataGridAsignaciones':
                onResponseAjaxpGetDataGridAsignaciones(response.data);
                altura();
                break;
            case 'functionEditAsignaciones':
                respuestaEdit(response.data);
                break;
            case 'functionDeleteAsignaciones':
                respuestaEdit(response.data);
                break;
            case 'functionCombo':

                llenarCombo(response.data);
                $("#combobox1").combobox();
                break;
            case 'functionCombo2':
                $('[data-toggle="tooltip"]').tooltip();
                llenarCombo2(response.data);
                $("#combobox" + response.data[0].cep_c).combobox();
                break;
            case 'functionInsertAsignaciones':
                 respuestaInsert(response.data);
                break;

        }
    }
}
function onResponseAjaxpGetDataTitulo(data) {

    var titulo = "";
    $.each(data, function (index, item) {

        titulo = '<h3 class="title" style="display: inline-block">Colaboradores asignados a cup&oacute;n:&nbsp;</h3><h4 style="display: inline-block">' + item.cep_nombre + '-' + item.cep_descripcion + '</h4>';

    });
    $('.page-title').append(titulo);
}
//recibe el id del cupon especial

function onResponseAjaxpGetDataGridAsignaciones(data) {

    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Nombre del colaborador</th>' +
            '<th>D&iacute;as</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td style='width:35%;'>" + item.cea_dias + "</td>" +
                "<td style='text-align:center;width:15%;'>" +
                " <a href='#' onclick='editCol(" + item.usu_id + ",\"" + item.cep_id + "\")' ><b><i class='fa fa-edit' data-toggle='tooltip' data-placement='left' title='' data-original-title='Editar' style='font-size:16px;color:#E8BA2F;'></i></b></a>&nbsp;&nbsp;" +
                "<a href='#' onclick='delCol(" + item.usu_id + ",\"" + item.cep_id + "\"" + ",\"" + item.usu_nombre + "\")'><b><i class='fa fa-trash-o' data-toggle='tooltip' data-placement='left' title='' data-original-title='Eliminar' style='font-size:16px;color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#scroll").append(html);
}

function llenarCombo(data) {
    var cabeza = "<option value='' disabled selected style='display:none;'>Ingrese colaborador</option>";
    var cuerpo_total = '';
    var cuerpo = '';
    $.each(data, function (index, item) {

        cuerpo = "<option value='" + item.usu_id + "'>" + item.usu_nombre + "</option>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var html = cabeza + cuerpo_total;

    $("#combobox1").append(html);
}
function llenarCombo2(data) {
    var c;
    var cabeza = "<option value='' disabled selected style='display:none;'>Ingrese colaborador</option>";
    var cuerpo_total = '';
    var cuerpo = '';
    $.each(data, function (index, item) {

        cuerpo = "<option value='" + item.usu_id + "'>" + item.usu_nombre + "</option>";
        cuerpo_total = cuerpo_total + cuerpo;
        c = item.cep_c;
    });
    var html = cabeza + cuerpo_total;

    $("#combobox" + c).append(html);
}
function otroDiv(id, c) {
    var b;
    var m;
    var html = '<div class="col-md-12" style="border-top: 1px solid #ddd;padding-top:20px;" id="debajo' + c + '" >' +
            '<div id="vista" class="form-group col-md-6 ">'
            + '<label id="lb1">Nombre del colaborador : </label>'
            + '<div class=" col-md-12 quita" id="d1">';
    b = "#msjc";
    var html2 = "<select id='combobox" + c + "'onchange='$(\"" + b + "\").remove();' class='combobox form-control'   name='usu_id[]' autofocus>";

    var html3 = '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group col-md-6"  >'
            + '<label id="lb2">N&uacute;mero de d&iacute;as :</label>'
            + '<div class=" input-group col-md-12 quita" id="d2">';
    m = "#msjd";
    var html4 = "<input type='text' name='dias[]' class='form-control' id='dias" + c + "' onchange='$(\"" + m + "\").remove();' placeholder='Ingrese d&iacute;as' onkeypress='return isNumberKey(this);'  >"
            + ' <span class="input-group-addon" style="border:0px none;"><i id="c" style="cursor:pointer;margin-bottom:10px;" onclick="elimar(' + c + ')" class="fa fa-close" data-toggle="tooltip" data-placement="left" title="" data-original-title="Eliminar"></i></span>'
            + '</div>'
            + '</div>'
            + '</div>';
    $("#debajo1").after(html + html2 + html3 + html4);
    llenarDivCombo(id, c);
}
function editCol(id, ceid) {

    swal({title: "Editar d\xedas",
        text: "Ingrese n\xfamero de d\xedas:",
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#33b86c",
        closeOnConfirm: false,
        //animation: "slide-from-top",
        inputPlaceholder: "Ingrese d\xedas"},
    function (inputValue) {

        if (inputValue === false)
            return false;
        if (inputValue === "") {
            swal.showInputError("Debe ingresar un valor!");
            return false
        }
        if ($.isNumeric(inputValue) == false) {
            swal.showInputError("Debe ingresar un valor numerico!");
            return false
        }

        EditarAsig(id, ceid, inputValue);
    });
    $('input:text').keypress(function (evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    });
}
function delCol(id, cep_id, nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras al colaborador(a) " + nom + "!",
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

            delAsig(id, cep_id);
        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }
    });
}
function respuestaInsert(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        ListaInserta(data[0]["cep_id"]);
        quitaSpinner();

    } 
    if(data[0]['vout_exito']==0){
         jQuery.each(data, function (index, value) {
                $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
                });
        quitaSpinner();
    }
}
function respuestaEdit(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        listarAsignaciones(data[0]["cep_id"]);
        spinnerSA();

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}

function insertar(c){
   
    var usu_array=[];
    var dias_array=[];
    var d=c-1;
    var cid=document.getElementsByName("cep_id")[0].value;
    for(i=0;i<d;i++){
    var usuario = document.getElementsByName("usu_id[]")[i].value;
    
    var dias =document.getElementsByName('dias[]')[i].value;
   
     usu_array[i]=usuario;
     dias_array[i]=dias;
     if(i==(d-1)){
         InsertAsig(cid,usu_array,dias_array);
      
  }
        } 
     
     
}

