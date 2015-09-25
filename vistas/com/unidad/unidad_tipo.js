$('#txt_codigo').keypress(function () {
    $('#msj_codigo').hide();
});
$('#txt_descripcion').keypress(function () {
    $('#msj_descripcion').hide();
});
$('#txt_comentario').keypress(function () {
    $('#msj_comentario').hide();
});

function limpiar_formulario_unidad()
{
    document.getElementById("frm_unidad_tipo").reset();
}

function validar_unidad_tipo_form() {
    var bandera = true;
    var espacio = /^\s+$/;
    var descripcion = document.getElementById('txt_descripcion').value;
    var codigo = document.getElementById('txt_codigo').value;
    var comentario = document.getElementById('txt_comentario').value;
    if (descripcion == "" || descripcion == null || espacio.test(descripcion) || descripcion.length == 0)
    {
        $("msj_descripcion").removeProp(".hidden");
        $("#msj_descripcion").text("Ingrese una descripcion").show();
        bandera = false;
    }
    if (codigo == "" || codigo == null || espacio.test(codigo) || codigo.length == 0)
    {
        $("msj_codigo").removeProp(".hidden");
        $("#msj_codigo").text("Ingrese un codigo").show();
        bandera = false;
    }

    if (comentario == "" || comentario == null || espacio.test(comentario) || comentario.length == 0)
    {
        $("msj_comentario").removeProp(".hidden");
        $("#msj_comentario").text("Ingrese un comentario").show();
        bandera = false;
    }
    return bandera;
}

function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}

function cargarDivGetUnidadTipo(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/unidad/unidad_tipo_form.php?id=" + id + "&" + "tipo=" + 1);
}
function listarUnidadTipo() {
    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.UNIDAD, "successPerfil");
    ax.setAccion("getDataGridUnidadTipo");
    ax.consumir();
}
function successPerfil(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridUnidadTipo':
                onResponseAjaxpGetDataGridUnidadTipo(response.data);
                $('#datatable').dataTable();
                break;
            case 'insertUnidadTipo':
                limpiar_formulario_unidad();
                break;

            case 'getUnidadTipo':
                llenarFormularioEditar(response.data);
                break;
            case 'updateUnidadTipo':
                cargarDiv("#window", "vistas/com/unidad/unidad_tipo_listar.php");
                break;
            case 'deleteUnidadTipo':
                  var error = response.data['0'].vout_exito;
               if(error > 0){
///////
            swal("Eliminado!", "El tipo de unidad " + response.data['0'].nombre + ".", "success");
//////
               }else{
                      swal("Cancelado", "Upss!!.El tipo de unidad "+response.data['0'].nombre+" "+response.data['0'].vout_mensaje+" en el mantenedor unidades", "error");  
               }
                break;    
        }
    }
}
function onResponseAjaxpGetDataGridUnidadTipo(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
            "<th style='text-align:center;'>Codigo</th>" +
            "<th style='text-align:center;'>Descripcion</th>" +
            "<th style='text-align:center;'>Comentario</th>" +
            "<th style='text-align:center;'>Estado</th>" +
            "<th style='text-align:center;'>Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td style='text-align:center;'>" + item.codigo + "</td>" +
                "<td style='text-align:center;'>" + item.descripcion + "</td>" +
                "<td style='text-align:center;'>" + item.comentario + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='color:" + item.color + ";'></i></td>" +
                "<td style='text-align:center;'>" +
//                "<i class='fa  fa-file-text' onclick='cargarDivGetColaboradorDetalle(" + item.id + ")' style='color:#088A68;'></i>&nbsp;\n" +
                "<a href='#' onclick='cargarDivGetUnidadTipo(" + item.id + ")'><b><i class='fa fa-edit' style='color:#E8BA2F;'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeleteUnidadTipo(" + item.id + ", \"" + item.descripcion + "\")'><b><i class='fa fa-trash-o' style='color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var pie = '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#dataList").append(html);
}
function guardarUnidadTipo(tipo)
{
    var id = document.getElementById('id').value;
    var usu_creacion = document.getElementById('usuario').value;
    var descripcion = document.getElementById('txt_descripcion').value;
    var codigo = document.getElementById('txt_codigo').value;
    var comentario = document.getElementById('txt_comentario').value;
    var estado = document.getElementById('cbo_estado').value;
    if (tipo == 1)
    {
        updateUnidadTipo(id, descripcion, codigo, comentario, estado);
    } else {
        insertUnidadTipo(descripcion, codigo, comentario, estado, usu_creacion);
    }
}

function insertUnidadTipo(descripcion, codigo, comentario, estado, usu_creacion)
{
    if (validar_unidad_tipo_form()) {
        ax.setAccion("insertUnidadTipo");
        ax.addParamTmp("descripcion", descripcion);
        ax.addParamTmp("codigo", codigo);
        ax.addParamTmp("comentario", comentario);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("usu_creacion", usu_creacion);
        ax.consumir();
    }
}
function getUnidadTipo(id_unidad_tipo)
{
    ax.setAccion("getUnidadTipo");
    ax.addParamTmp("id_unidad_tipo", id_unidad_tipo);
    ax.consumir();
}

function llenarFormularioEditar(data)
{
       document.getElementById('txt_descripcion').value = data[0].descripcion;
       document.getElementById('txt_codigo').value = data[0].codigo;
       document.getElementById('txt_comentario').value = data[0].comentario;
       document.getElementById('cbo_estado').value = data[0].estado;
}
function updateUnidadTipo(id, descripcion, codigo, comentario, estado)
{
    if (validar_unidad_tipo_form()) {
        ax.setAccion("updateUnidadTipo");
        ax.addParamTmp("id_uni_tipo", id);
        ax.addParamTmp("descripcion", descripcion);
        ax.addParamTmp("codigo", codigo);
        ax.addParamTmp("comentario", comentario);
        ax.addParamTmp("estado", estado);
        ax.consumir();
    }
}
function confirmarDeleteUnidadTipo(id,nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras el tipo de unidad " + nom + "!",
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
         deleteUnidadTipo(id,nom);
        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }
    });
    //var res=confirm('Est\u00e1 seguro que desea eliminar el cupon especial '+nom+'?');
}

function deleteUnidadTipo(id_uni_tipo,nom)
{
    ax.setAccion("deleteUnidadTipo");
    ax.addParamTmp("id_uni_tipo", id_uni_tipo);
    ax.addParamTmp("nom", nom);
    ax.consumir();
    cargarDiv("#window", "vistas/com/unidad/unidad_tipo_listar.php");
}