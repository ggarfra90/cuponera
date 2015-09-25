$('#txt_descripcion').keypress(function () {
    $('#msj_descripcion').hide();
});
$('#fec_inicio').keypress(function () {
    $('#msj_fec_inicio').hide();
});
$('#fec_fin').keypress(function () {
    $('#msj_fec_fin').hide();
});
$('#fec_inicio').click(function () {
    $('#msj_fec_inicio').hide();
});
$('#fec_fin').click(function () {
    $('#msj_fec_fin').hide();
});

function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.notifyjs-corner');
    $("#window").html("");
    $(div).load(url);
}

function cargarDivGetServicio(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/servicio/servicio_form.php?id=" + id + "&" + "tipo=" + 1);
}

function limpiar_formulario_servicio()
{
    document.getElementById("frm_servicio").reset();
}

function validar_servicio_form() {
    var bandera = true;
    var espacio = /^\s+$/;
    var descripcion = document.getElementById('txt_descripcion').value;
    var fec_inicio = document.getElementById('fec_inicio').value;
    var fec_fin = document.getElementById('fec_fin').value;
    if (descripcion == "" || descripcion == null || espacio.test(descripcion) || descripcion.length == 0)
    {
        $("msj_descripcion").removeProp(".hidden");
        $("#msj_descripcion").text("Ingrese un descripcion").show();
        bandera = false;
    }
    if (fec_inicio == "" || fec_inicio == null || espacio.test(fec_inicio) || fec_inicio.length == 0)
    {
        $("msj_fec_inicio").removeProp(".hidden");
        $("#msj_fec_inicio").text("Ingrese una fecha").show();
        bandera = false;
    }

    if (fec_fin == "" || fec_fin == null || espacio.test(fec_fin) || fec_fin.length == 0)
    {
        $("msj_fec_fin").removeProp(".hidden");
        $("#msj_fec_fin").text("Ingrese una fecha").show();
        bandera = false;
    }
    return bandera;
}
function listarServicios() {
//    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.SERVICIO, "successPerfil");
    ax.setAccion("getDataGridServicio");
    ax.consumir();
}
function successPerfil(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridServicio':
                onResponseAjaxpGetDataGridServicio(response.data);
                $('#datatable').dataTable();
                break;
            case 'insertServicio':
                limpiar_formulario_servicio();
                break;
                
            case 'getServicio':
                llenarFormularioEditar(response.data);
                break;
             case 'updateServicio':
                cargarDiv("#window", "vistas/com/servicio/servicio_listar.php");
                break;
        }
    }
}

function onResponseAjaxpGetDataGridServicio(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
            "<th style='text-align:center;'>Descripcion</th>" +
            "<th style='text-align:center;'>Comentario</th>" +
            "<th style='text-align:center;'>Fecha de Inicio</th>" +
            "<th style='text-align:center;'>Fecha de Fin</th>" +
            "<th style='text-align:center;'>Estado</th>" +
            "<th style='text-align:center;'>Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td style='text-align:center;'>" + item.descripcion + "</td>" +
                "<td style='text-align:center;'>" + item.comentario + "</td>" +
                "<td style='text-align:center;'>" + item.fec_inicio + "</td>" +
                "<td style='text-align:center;'>" + item.fec_fin + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='color:" + item.color + ";'></i></td>" +
                "<td style='text-align:center;'>" +
//                "<i class='fa  fa-file-text' onclick='cargarDivGetColaboradorDetalle(" + item.id + ")' style='color:#088A68;'></i>&nbsp;\n" +
                "<a href='#' onclick='cargarDivGetServicio(" + item.id + ")'><b><i class='fa fa-edit' style='color:#E8BA2F;'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeleteServicio(" + item.id + ", \"" + item.descripcion + "\")'><b><i class='fa fa-trash-o' style='color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var pie = '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#datatable2").append(html);
}
function guardarServicio(tipo)
{
    var id = document.getElementById('id').value;
    var usu_creacion = document.getElementById('usuario').value;
    var descripcion = document.getElementById('txt_descripcion').value;
    var fec_inicio = document.getElementById('fec_inicio').value;
    var fec_fin = document.getElementById('fec_fin').value;
    var comentario = document.getElementById('txt_comentario').value;
    var estado = document.getElementById('estado').value;

    if (tipo == 1)
    {
        
        updateServicio(id, descripcion, fec_inicio, fec_fin, comentario, estado);
//        cargarDiv("#window", "vistas/com/usuario/usuario_listar.php");
    } else {
        insertServicio(descripcion, fec_inicio, fec_fin, comentario, estado, usu_creacion);
    }
}
function insertServicio(descripcion, fec_inicio, fec_fin, comentario, estado, usu_creacion)
{
    if (validar_servicio_form()) {
        ax.setAccion("insertServicio");
        ax.addParamTmp("descripcion", descripcion);
        ax.addParamTmp("fec_inicio", fec_inicio);
        ax.addParamTmp("fec_fin", fec_fin);
        ax.addParamTmp("comentario", comentario);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("usu_creacion", usu_creacion);
        ax.consumir();
    }
}
function getServicio(id_servicio)
{
    ax.setAccion("getServicio");
    ax.addParamTmp("id_servicio", id_servicio);
    ax.consumir();
}
function llenarFormularioEditar(data)
{
       document.getElementById('txt_descripcion').value = data[0].descripcion;
       document.getElementById('fec_inicio').value = data[0].fec_inicio;
       document.getElementById('fec_fin').value = data[0].fec_fin;
       document.getElementById('txt_comentario').value = data[0].comentario;
       document.getElementById('estado').value = data[0].estado;
}

function updateServicio(id, descripcion, fec_inicio, fec_fin, comentario, estado)
{
    
    if (validar_servicio_form()) {
        ax.setAccion("updateServicio");
        ax.addParamTmp("id_servicio", id);
        ax.addParamTmp("descripcion", descripcion);
        ax.addParamTmp("fec_inicio", fec_inicio);
        ax.addParamTmp("fec_fin", fec_fin);
        ax.addParamTmp("comentario", comentario);
        ax.addParamTmp("estado", estado);
        ax.consumir();
    }
}

function confirmarDeleteServicio(id,nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras el servicio " + nom + "!",
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
            deleteServicio(id);
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

function deleteServicio(id_servicio)
{
    ax.setAccion("deleteServicio");
    ax.addParamTmp("id_servicio", id_servicio);
    ax.consumir();
    cargarDiv("#window", "vistas/com/servicio/servicio_listar.php");
}