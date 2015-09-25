$('#txt_dni').keypress(function () {
    $('#msj_dni').hide();
});

$('#txt_nombre').keypress(function () {
    $('#msj_nombre').hide();
});
$('#txt_apepaterno').keypress(function () {
    $('#msj_paterno').hide();
});

$('#txt_apematerno').keypress(function () {
    $('#msj_materno').hide();
});
$('#txt_email').keypress(function () {
    $('#msj_email').hide();
});

$('#txt_celular').keypress(function () {
    $('#msj_celular').hide();
});

$('#txt_telefono').keypress(function () {
    $('#msj_telefono').hide();
});

$('#txt_celular').keydown(function () {
    $('#msj_celular').hide();
});

$('#txt_telefono').keydown(function () {
    $('#msj_telefono').hide();
});

function limpiar_formulario_colaborador()
{
    document.getElementById("frm_colaborador").reset();
}
function validar_colaborador_form()
{
    var bandera = true;
    var dni = document.getElementById("txt_dni").value;
    var nombre = document.getElementById("txt_nombre").value;
    var ape_paterno = document.getElementById("txt_apepaterno").value;
    var ape_materno = document.getElementById("txt_apematerno").value;
    var email = document.getElementById("txt_email").value;
    var celular = document.getElementById("txt_celular").value;
    var telefono = document.getElementById("txt_telefono").value

    //expresiones de validacion 

    var exp_email = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
    var letras_latinas = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
    var expresion_dni = /^\d{8}[0-9]$/;
    var phoneNumber = /^[0-9-()+]{3,20}/;
    var espacio = /^\s+$/;

    if (dni == "" || espacio.test(dni) || dni.lenght == 0 || dni == null) {
        $("#msj_dni").removeProp("hidden");
        $("#msj_dni").text("Ingrese el numero de DNI").show();
//        $("#msj_codigo").show();
        bandera = false;

    } else
    {
        if (isNaN(dni))
        {
            $("#msj_dni").removeProp("hidden");
            $("#msj_dni").text("Solo se admiten numeros").show();
            bandera = false;
        }
    }
    if (nombre == "" || nombre==null || espacio.test(nombre) || nombre.length == 0)
    {
        $("msj_nombre").removeProp(".hidden");
        $("#msj_nombre").text("Ingrese un Nombre").show();
        bandera = false;
    } else {
        if (!letras_latinas.test(nombre))
        {
            $("msj_nombre").removeProp(".hidden");
            $("#msj_nombre").text("Solo se Admiten letras").show();
            bandera = false;
        }
    }

    if (ape_paterno == "" || ape_paterno==null || espacio.test(ape_paterno) || ape_paterno.length == 0)
    {
        $("msj_paterno").removeProp(".hidden");
        $("#msj_paterno").text("Ingrese apellido paterno").show();
        bandera = false;
    }else {
        if (!letras_latinas.test(ape_paterno))
        {
            $("msj_paterno").removeProp(".hidden");
            $("#msj_paterno").text("Solo se Admiten letras").show();
            bandera = false;
        }
    }

    if (ape_materno == "" || ape_materno==null || espacio.test(ape_materno) || ape_materno.length == 0)
    {
        $("msj_materno").removeProp(".hidden");
        $("#msj_materno").text("Ingrese apellido materno").show();
        bandera = false;
    }else {
        if (!letras_latinas.test(ape_materno))
        {
            $("msj_materno").removeProp(".hidden");
            $("#msj_materno").text("Solo se Admiten letras").show();
            bandera = false;
        }
    }


    if (email == "" || email==null || espacio.test(email) || email.length == 0)
    {
        $("msj_email").removeProp(".hidden");
        $("#msj_email").text("Ingrese un correo electronico").show();
        bandera = false;

    } else
    {
        if (!exp_email.test(email))
        {
            $("msj_email").removeProp(".hidden");
            $("#msj_email").text("No es un correo valido").show();
            bandera = false;
        }
    }
    if (celular != "" || celular == null || !espacio.test(celular) || celular.length != 0) {
        if (isNaN(celular))
        {
            $("msj_celular").removeProp(".hidden");
            $("#msj_celular").text("No es un numero de celular valido").show();
            bandera = false;
        }
    }

    if (telefono != "" || !espacio.test(telefono) || telefono.length != 0) {
        if (isNaN(telefono))
        {
            $("msj_telefono").removeProp(".hidden");
            $("#msj_telefono").text("No es un numero de teléfono valido").show();
            bandera = false;
        }
    }
      return bandera;
}

$(document).ready(function () {
    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.COLABORADOR, "successColaborador");
    ax.setAccion("getDataGridColaborador");
    ax.consumir();
});


function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}
function cargarDivGetColaboradorDetalle(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/colaborador/colaborador_detalle_form.php?id=" + id);
}

function cargarDivGetColaborador(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/colaborador/colaborador_form.php?id=" + id + "&" + "tipo=" + 1);
}

function successColaborador(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridColaborador':
                onResponseAjaxpGetDataGridColaboradores(response.data);
                $('#datatable').dataTable();
                break;
            case 'insertColaborador':
                limpiar_formulario_colaborador();
                break; 
            case 'getDetalleColaborador':
                onResponseDetalleColaborador(response.data);
                break;
            case 'getColaborador':
                llenarFormularioEditar(response.data);
                break;
           case 'updateColaborador':
                cargarDiv("#window", "vistas/com/colaborador/colaborador_listar.php");
                break;
        }
    }
}

function onResponseAjaxpGetDataGridColaboradores(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
            "<th style='text-align:center;'>Nombre</th>" +
            "<th style='text-align:center;'>Apellidos</th>" +
            "<th style='text-align:center;'>Celular</th>" +
            "<th style='text-align:center;'>Email</th>" +
            "<th style='text-align:center;'>Direccion</th>" +
//            "<th style='text-align:center;'>Imagen</th>" +
            "<th style='text-align:center;'>Estado</th>" +
            "<th style='text-align:center;'>Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td style='text-align:center;'>" + item.nombres + "</td>" +
                "<td style='text-align:center;'>" + item.apellidos + "</td>" +
                "<td style='text-align:center;'>" + item.celular + "</td>" +
                "<td style='text-align:center;'>" + item.email + "</td>" +
                "<td style='text-align:center;'>" + item.direccion + "</td>" +
//                "<td style='text-align:center;'><img src='"+item.imagen+"'/></td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='color:" + item.color + ";'></i></td>" +
                "<td style='text-align:center;'>" +
//                "<i class='fa  fa-file-text' onclick='cargarDivGetColaboradorDetalle(" + item.id + ")' style='color:#088A68;'></i>&nbsp;\n" +
                "<a href='#' onclick='cargarDivGetColaborador(" + item.id + ")'><b><i class='fa fa-edit' style='color:#E8BA2F;'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeleteColaborador(" + item.id + ", \"" + item.nombres + "\")'><b><i class='fa fa-trash-o' style='color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var pie = '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#datatable2").append(html);
}
function guardarColaborador(tipo)
{
    var id = document.getElementById('id').value;
    var dni = document.getElementById('txt_dni').value;
    var nombre = document.getElementById('txt_nombre').value;
    var paterno = document.getElementById('txt_apepaterno').value;
    var materno = document.getElementById('txt_apematerno').value;
    var telefono = document.getElementById('txt_telefono').value;
    var celular = document.getElementById('txt_celular').value;
    var email = document.getElementById('txt_email').value;
    var direccion = document.getElementById('txt_direccion').value;
    var ref_direccion = document.getElementById('txt_refdireccion').value;
    var usuario = document.getElementById('usuario').value;
    var estado = document.getElementById('cbo_estado').value;
    var file = document.getElementById('file').value;
    if (tipo == 1)
    {
        updateColaborador(id, dni, nombre, paterno, materno, telefono, celular, email, direccion, ref_direccion, usuario, estado,file);
//        cargarDiv("#window", "vistas/com/colaborador/colaborador_listar.php");
    } else {
        insertColaborador(dni, nombre, paterno, materno, telefono, celular, email, direccion, ref_direccion, usuario, estado,file);
    }
}

function insertColaborador(dni, nombre, paterno, materno, telefono, celular, email, direccion, ref_direccion, usuario, estado,file)
{
//    acciones.iniciaAjax(COMPONENTES.PERFIL);
//    var exp_email = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
//    var letras_latinas = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
//    var espacio = /^\s+$/;
//    validar_colaborador_form();
//    if ((dni != "" || !espacio.test(dni) || !dni.length == 0) && !isNaN(dni) && (nombre != "" || !espacio.test(nombre) || !nombre.length == 0) && letras_latinas.test(nombre) && (paterno != "" || !espacio.test(paterno) || !paterno.length == 0) && (materno != "" || !espacio.test(materno) || !materno.length == 0) && (email != "" || !espacio.test(email) || !email.length == 0) && exp_email.test(email) && (!isNaN(celular) || celular == "") && (!isNaN(telefono) || telefono != "")) {
    if(validar_colaborador_form()){
        ax.setAccion("insertColaborador");
        ax.addParamTmp("dni", dni);
        ax.addParamTmp("nombre", nombre);
        ax.addParamTmp("paterno", paterno);
        ax.addParamTmp("materno", materno);
        ax.addParamTmp("telefono", telefono);
        ax.addParamTmp("celular", celular);
        ax.addParamTmp("email", email);
        ax.addParamTmp("direccion", direccion);
        ax.addParamTmp("ref_direccion", ref_direccion);
        ax.addParamTmp("usuario", usuario);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("file", file);
        ax.consumir();
    }
}

function getDetalleColaborador(id_colaborador)
{
    ax.setAccion("getDetalleColaborador");
    ax.addParamTmp("id_colaborador", id_colaborador);
    ax.consumir();
}
function onResponseDetalleColaborador(data)
{
    var cuerpo = '';
    var cabeza = ' <table class="table"><tbody>';
    cuerpo = '<tr>' +
            '<th width="20%">DNI:</th>' +
            '<td >' + data[0].dni + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Nombres:</th>' +
            '<td>' + data[0].nombres + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Apellidos:</th>' +
            '<td>' + data[0].ape_paterno + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Apellidos:</th>' +
            '<td>' + data[0].ape_materno + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Celular:</th>' +
            '<td>' + data[0].celular + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Tel&eacute;fono:</th>' +
            '<td>' + data[0].telefono + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Email:</th>' +
            '<td>' + data[0].email + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Direcci&oacute;n:</th>' +
            '<td>' + data[0].direccion + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th width="20%">Referencia:</th>' +
            '<td>' + data[0].dir_referencia + '</td>' +
            '</tr>';
    var pie = '</table></tbody>';
    var html = cabeza + cuerpo + pie;
    $("#listar_detalle").append(html);
}


function getColaborador(id_colaborador)
{
    ax.setAccion("getColaborador");
    ax.addParamTmp("id_colaborador", id_colaborador);
    ax.consumir();

}

function llenarFormularioEditar(data)
{
    document.getElementById('txt_dni').value = data[0].dni;
    document.getElementById('txt_nombre').value = data[0].nombres;
    document.getElementById('txt_apepaterno').value = data[0].ape_paterno;
    document.getElementById('txt_apematerno').value = data[0].ape_materno;
    document.getElementById('txt_telefono').value = data[0].telefono;
    document.getElementById('txt_celular').value = data[0].celular;
    document.getElementById('txt_email').value = data[0].email;
    document.getElementById('txt_direccion').value = data[0].direccion;
    document.getElementById('txt_refdireccion').value = data[0].dir_referencia;
    document.getElementById('cbo_estado').value = data[0].estado;
}

function updateColaborador(id, dni, nombre, paterno, materno, telefono, celular, email, direccion, ref_direccion, usuario, estado)
{
//    acciones.iniciaAjax(COMPONENTES.PERFIL);
//    var exp_email = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
//    var letras_latinas = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
//    var espacio = /^\s+$/;
//    validar_colaborador_form();
//    if ((dni != "" || !espacio.test(dni) || !dni.length == 0) && !isNaN(dni) && (nombre != "" || !espacio.test(nombre) || !nombre.length == 0) && letras_latinas.test(nombre) && (paterno != "" || !espacio.test(paterno) || !paterno.length == 0) && (materno != "" || !espacio.test(materno) || !materno.length == 0) && (email != "" || !espacio.test(email) || !email.length == 0) && exp_email.test(email) && (!isNaN(celular) || celular == "") && (!isNaN(telefono) || telefono != "")) {
    if(validar_colaborador_form()){    
    ax.setAccion("updateColaborador");
        ax.addParamTmp("id_colaborador", id);
        ax.addParamTmp("dni", dni);
        ax.addParamTmp("nombre", nombre);
        ax.addParamTmp("paterno", paterno);
        ax.addParamTmp("materno", materno);
        ax.addParamTmp("telefono", telefono);
        ax.addParamTmp("celular", celular);
        ax.addParamTmp("email", email);
        ax.addParamTmp("direccion", direccion);
        ax.addParamTmp("ref_direccion", ref_direccion);
        ax.addParamTmp("estado", estado);
        ax.consumir();
    }
}

function confirmarDeleteColaborador(id, nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras el Colaborador " + nom + "!",
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
            deleteColaborador(id);
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

function deleteColaborador(id_colaborador)
{
    ax.setAccion("deleteColaborador");
    ax.addParamTmp("id_colaborador", id_colaborador);
    ax.consumir();
    cargarDiv("#window", "vistas/com/colaborador/colaborador_listar.php");
}
