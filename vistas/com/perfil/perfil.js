//var ax = new Ajaxp(URL_EXECUTECONTROLLER, 'POST', 'JSON');
var bandera_getMenu = false;
var bandera_insertaropciones = false;
var bandera_actualizar = false;
$('#codigo').keypress(function () {
    $('#msj_codigo').hide();
});

$('#descripcion').keypress(function () {
    $('#msj_desc').hide();
});

function validar_perfil_form()
{
    var bandera = true;
    var codigo = document.getElementById("codigo").value;
    var descripcion = document.getElementById("descripcion").value;
    var espacio = /^\s+$/;
    if (codigo == "" || espacio.test(codigo) || codigo.lenght == 0 || codigo == null) {
        $("#msj_codigo").removeProp("hidden");
        $("#msj_codigo").text("ingrese un codigo").show();
        bandera = false;
    }
    if (descripcion == "" || espacio.test(descripcion) || descripcion.lenght == 0 || descripcion == null)
    {
        $("msj_desc").removeProp(".hidden");
        $("#msj_desc").text("ingrese una descripción").show();
        bandera = false;
    }
    return bandera;
}

$(document).ready(function () {
    $("span.help-block").hide();
    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.PERFIL, "successPerfil");
    ax.setAccion("getDataGridPerfil");
    ax.consumir();
});

function guardarPerfil(tipo)
{
    var id_perfil = document.getElementById("id_perfil").value;
    var nombre = document.getElementById("descripcion").value;
    var codigo = document.getElementById("codigo").value;
    var descripcion = document.getElementById("comentario").value;
    var estado = document.getElementById("estado").value;
    var usuario = document.getElementById("usuario").value;
    var dashboard = document.getElementById("chk_dashboard").checked;
    var email = document.getElementById("chk_email").checked;
    var monetaria = document.getElementById("chk_monetaria").checked;
    if (dashboard)
    {
        dashboard = "1";
    } else
    {
        dashboard = "0";
    }
    if (email)
    {
        email = "1";
    } else
    {
        email = "0";
    }
    if (monetaria)
    {
        monetaria = "1";
    } else
    {
        monetaria = "0";
    }


    var rdpan_principal = document.getElementsByName("rdpantalla");
    var pant_principal = null;
    var tamanio = rdpan_principal.length;
    for (var i = 0; i < tamanio; i++)
    {
        var id_opcion = rdpan_principal[i].value;
        if (rdpan_principal[i].checked)
        {
            pant_principal = id_opcion;
        }
    }
    if (tipo == 1)
    {
        updatePerfil(id_perfil, codigo, nombre, descripcion, estado, usuario, dashboard, email, monetaria, pant_principal);
        updateDetOpcPerfil(id_perfil);
//        cargarDiv("#window", "vistas/com/perfil/perfil_listar.php");
       
    } else {
        insertPerfil(codigo, nombre, descripcion, estado, usuario, dashboard, email, monetaria, pant_principal);
    }
}
//function onResponseAjaxp(target, response) {
function successPerfil(response) {


    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridPerfil':
                onResponseAjaxpGetDataGridPerfiles(response.data);
                $('#datatable').dataTable();
                break;
            case 'insertPerfil':
                var id_usuario = document.getElementById('usuario').value;
                var id_perfil = getIdUltimoPerfil(response.data);
                insertDetOpcPerfil(id_perfil, id_usuario);
                limpiarformulario();
//                $.Notification.autoHideNotify('success', 'top-right', '&Eacute;xito', "Los Datos se registraron satisfactoriamente");
                break;
            case 'getPerfil':
                llenarFormularioEditar(response.data);
                break;
            case 'getMenu':
                if (bandera_getMenu == false)
                {
                    onResponseAjaxpGetOpcionesMenu(response.data);
//                    llenarFormularioEditar(response.data);
                    bandera_getMenu = true;
//                    alert(response.data[0].id_perfil)
                    if (response.data[0].id_perfil != null)
                    {
                        getPerfil(response.data[0].id_perfil);
                    }
                }
                break;
            case 'insertDetOpcPerfil':
                limpiarformulario();
                if (bandera_insertaropciones == false)
                {
                    $.Notification.autoHideNotify('success', 'top-right', '&Eacute;xito', "Los Datos se registraron satisfactoriamente");
                    bandera_insertaropciones = true;
                }
                break;
                
             case 'updatePerfil':
                 if(bandera_actualizar==false){
                 cargarDiv("#window", "vistas/com/perfil/perfil_listar.php");
                     bandera_actualizar = true;
                 }
                break;
        }
    }
}
function onResponseAjaxpGetDataGridPerfiles(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
            "<th style='text-align:center;'>Nombre</th>" +
            "<th style='text-align:center;'>Visibilidad Dashboard</th>" +
            "<th style='text-align:center;'>Visibilidad Monetaria</th>" +
            "<th style='text-align:center;'>Recibir Email</th>" +
            "<th style='text-align:center;'>Estado</th>" +
            "<th style='text-align:center;'>Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td style='text-align:center;'>" + item.nombre + "</td>" +
                "<td style='text-align:center;'><i class='" + item.dashboard_icono + "' style='color:" + item.dashboard_color + ";'></i></td>" +
                "<td style='text-align:center;'><i class='" + item.monetaria_icono + "' style='color:" + item.monetaria_color + ";'></i></td>" +
                "<td style='text-align:center;'><i class='" + item.email_icono + "' style='color:" + item.email_color + ";'></i></td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='color:" + item.color + ";'></i></td>" +
                "<td style='text-align:center;'>" +
                "<a href='#' onclick='cargarDivGetPerfil(" + item.id + ")'><b><i class='fa fa-edit'  style='color:#E8BA2F;cursor:hand;'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeletePerfil(" + item.id + ", \"" + item.nombre + "\")'><i class='fa fa-trash-o' style='color:#cb2a2a;'></i></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var pie = '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#datatable2").append(html);
}
function limpiarformulario() {
    document.getElementById("descripcion").value = '';
    document.getElementById("codigo").value = '';
    document.getElementById("comentario").value = '';
    document.getElementById("chk_dashboard").checked = false;
    document.getElementById("chk_email").checked = false;
    document.getElementById("chk_monetaria").checked = false;
    cancelarAsignarOpciones();
}


function insertPerfil(codigo, nombre, descripcion, estado, usuario, dashboard, email, monetaria, pant_principal)
{
//    acciones.iniciaAjax(COMPONENTES.PERFIL);
    if (validar_perfil_form()) {
        ax.setAccion("insertPerfil");
        ax.addParamTmp("codigo", codigo);
        ax.addParamTmp("descripcion", nombre);
        ax.addParamTmp("comentario", descripcion);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("usuario", usuario);
        ax.addParamTmp("dashboard", dashboard);
        ax.addParamTmp("email", email);
        ax.addParamTmp("monetaria", monetaria);
        ax.addParamTmp("pant_principal", pant_principal);
        ax.consumir();
    }
}
function updatePerfil(id_perfil, codigo, nombre, descripcion, estado, usuario, dashboard, email, monetaria, pant_principal)
{
    if (validar_perfil_form()) {
        ax.setAccion("updatePerfil");
        ax.addParamTmp("id_perfil", id_perfil);
        ax.addParamTmp("codigo", codigo);
        ax.addParamTmp("descripcion", nombre);
        ax.addParamTmp("comentario", descripcion);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("usuario", usuario);
        ax.addParamTmp("dashboard", dashboard);
        ax.addParamTmp("email", email);
        ax.addParamTmp("monetaria", monetaria);
        ax.addParamTmp("pant_principal", pant_principal);
        ax.consumir();
    }
}

function getPerfil(id_perfil)
{
    ax.setAccion("getPerfil");
    ax.addParamTmp("id_perfil", id_perfil);
    ax.consumir();

}
function getIdUltimoPerfil(data)
{
    return data[0].id;
}
function llenarFormularioEditar(data)
{
    document.getElementById('codigo').value = data[0].codigo;
    document.getElementById('descripcion').value = data[0].nombre;
    document.getElementById('comentario').value = data[0].comentario;
    document.getElementById('estado').value = data[0].pestado;
    if (data[0].bandera_monetaria == 1)
        document.getElementById("chk_monetaria").checked = true;
    else
        document.getElementById("chk_monetaria").checked = false;

    if (data[0].bandera_email == 1)
        document.getElementById("chk_email").checked = true;
    else
        document.getElementById("chk_email").checked = false;

    if (data[0].bandera_dashboard == 1)
        document.getElementById("chk_dashboard").checked = true;
    else
        document.getElementById("chk_dashboard").checked = false;

//        $("#r12").prop("checked", true);

    $.each(data, function (index, item) {
        if (item.opcion_id == item.pant_principal)
        {
            var id_rd = "#r" + item.opcion_id.toString();
            $(id_rd).prop("checked", true);
        }
        if (item.estado == 1)
        {
            var id = "#" + item.opcion_id.toString();
            $(id).prop("checked", true);
        }
    });
}

function deletePerfil(id_perfil)
{
    ax.setAccion("deletePerfil");
    ax.addParamTmp("id_perfil", id_perfil);
    ax.consumir();
    cargarDiv("#window", "vistas/com/perfil/perfil_listar.php");
}


function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}

function confirmarDeletePerfil(id, nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras el perfil " + nom + "!",
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
            deletePerfil(id);
//               var error=deletePerfil(id);
//               if(error > 0){

            swal("Eliminado!", "El perfil " + nom + ".", "success");

//               }else{
//                      swal("Cancelado", "Upss!!...Ocurri\xf3 un error", "error");  
//               }

        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }

    });
    //var res=confirm('Est\u00e1 seguro que desea eliminar el cupon especial '+nom+'?');

}

function cargarMenu(id_perfil) {
    ax.setAccion("getMenu");
    ax.addParamTmp("id_perfil", id_perfil);
    ax.consumir();
}
function onResponseAjaxpGetOpcionesMenu(data) {

    var cuerpo_total = '';
    var cuerpoh;
    var cuerpop = '';
    var cuerpop_total = '';

    var cabeza = '<table>';
    var pie = '</table>';


    $.each(data, function (index, item) {
        var cuerpoh_total = '';
        var cuerpoh = '';
        var cuerpoh_total = '';
        cuerpop = '<thead>' +
                ' <tr>' +
                '<th width=270>' + item.nombre + '</th>' +
                '<th width=270>Pantalla Prinicipal</th>' +
                '</tr>' +
                ' </thead>';
        $.each(item.hijo, function (indexh, itemh) {
            cuerpoh = '<tbody>' +
                    '<tr>' +
                    '<td width=270><div class="checkbox">' +
                    '<label class="cr-styled">' +
                    '<input type="checkbox" name="opcion" id="' + itemh.id + '" value="' + itemh.id + '">' +
                    '<i class="fa"></i> ' +
                    itemh.nombre +
                    '</label>' +
                    ' </div></td>' +
                    '<td width=270>' +
                    ' <div class="radio">' +
                    '<label class="cr-styled">' +
                    '<input type="radio" id="r' + itemh.id + '" name="rdpantalla" value="' + itemh.id + '"> ' +
                    '<i class="fa"></i> ' +
                    '</label>' +
                    '</div>' +
                    '</td>' +
                    '</tr>' +
                    '</tbody>';
            cuerpoh_total = cuerpoh_total + cuerpoh;
        });
        cuerpop_total = cuerpop_total + cuerpop + cuerpoh_total;
    });
    cuerpo_total = cabeza + cuerpop_total + pie;

    $("#opcionp").append(cuerpo_total);
}
function cancelarAsignarOpciones(id)
{
    $("#opcionp").empty();
    //document.getElementById("opcionp").innerHTML = "";
    cargarMenu(id);
    bandera_getMenu = false;
}

function insertDetOpcPerfil(id_per, id_usu)
{
    if (validar_perfil_form()) {
        var opcion = document.getElementsByName('opcion');
        for (var i = 0; i < opcion.length; i++)
        {
            var estado_opcion = 0;
            var id_opcion = opcion[i].value;
            if (opcion[i].checked)
            {
                estado_opcion = "1";
            }
            ax.setAccion("insertDetOpcPerfil");
            ax.addParamTmp("id_per", id_per);
            ax.addParamTmp("id_usu", id_usu);
            ax.addParamTmp("estado", estado_opcion);
            ax.addParamTmp("id_opcion", id_opcion);
            ax.consumir();
        }
    }
}

function updateDetOpcPerfil(id_per)
{
    if (validar_perfil_form()) {
        var opcion = document.getElementsByName('opcion');
        for (var i = 0; i < opcion.length; i++)
        {
            var estado = 0;
            var id_opcion = opcion[i].value;
            if (opcion[i].checked)
            {
                estado = "1";
            }
            ax.setAccion("updateDetOpcPerfil");
            ax.addParamTmp("id_per", id_per);
            ax.addParamTmp("id_opcion", id_opcion);
            ax.addParamTmp("estado", estado);
            ax.consumir();
        }
    }
}
