$('#txt_codigo').keypress(function () {
    $('#msj_codigo').hide();
});
$('#txt_descripcion').keypress(function () {
    $('#msj_descripcion').hide();
});
$('#txt_simbolo').keypress(function () {
    $('#msj_simbolo').hide();
});
$('#txt_simbolo').keypress(function () {
    $('#msj_simbolo').hide();
});

function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}

function cargarDivGetUnidad(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/unidad/unidad_form.php?id=" + id + "&" + "tipo=" + 1);
}

//$('#cbo_tipo').keypress(function () {
//    $('#msj_tipo').hide();
//});
function onchangeTipoUnidad()
{
    $('#msj_tipo').hide();
}

function limpiar_formulario_unidad()
{
    document.getElementById("frm_unidad").reset();
}

function validar_unidad_form() {
    var bandera = true;
    var espacio = /^\s+$/;
    var descripcion = document.getElementById('txt_descripcion').value;
    var simbolo = document.getElementById('txt_simbolo').value;
    var codigo = document.getElementById('txt_codigo').value;
    var tipo = document.getElementById('cbo_tipo').value;
    if (descripcion == "" || descripcion == null || espacio.test(descripcion) || descripcion.length == 0)
    {
        $("msj_descripcion").removeProp(".hidden");
        $("#msj_descripcion").text("Ingrese una descripción").show();
        bandera = false;
    }
    if (codigo == "" || codigo == null || espacio.test(codigo) || codigo.length == 0)
    {
        $("msj_codigo").removeProp(".hidden");
        $("#msj_codigo").text("Ingrese un código").show();
        bandera = false;
    }

    if (simbolo == "" || simbolo == null || espacio.test(simbolo) || simbolo.length == 0)
    {
        $("msj_simbolo").removeProp(".hidden");
        $("#msj_simbolo").text("Ingrese un simbolo para esta unidad").show();
        bandera = false;
    }
    if (tipo == "" || tipo == null || espacio.test(tipo) || tipo.length == 0)
    {
        $("msj_tipo").removeProp(".hidden");
        $("#msj_tipo").text("Ingrese un tipo de unidad").show();
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

function cargarDivGetUnidad(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/unidad/unidad_form.php?id=" + id + "&" + "tipo=" + 1);
}
function listarUnidad() {
    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.UNIDAD, "successUnidad");
    ax.setAccion("getDataGridUnidad");
    ax.consumir();
}
function successUnidad(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridUnidad':
                onResponseAjaxpGetDataGridUnidad(response.data);
                $('#datatable').dataTable();
                break;

            case 'getComboTipoUnidad':
                llenarComboUnidadTipo(response.data);
                $('#cbo_tipo').combobox();
//                getComboPerfil();
                break;
            case 'insertUnidad':
                limpiar_formulario_unidad();
                break;

            case 'getUnidad':
                llenarFormularioEditar(response.data);
                break;
            case 'updateUnidad':
                cargarDiv("#window", "vistas/com/unidad/unidad_listar.php");
                break;
            case 'deleteUnidad':
                var error = response.data['0'].vout_exito;
                if (error > 0) {
///////
                    swal("Eliminado!", "El tipo de unidad " + response.data['0'].nombre + ".", "success");
//////
                } else {
                    swal("Cancelado", "Upss!!.El tipo de unidad " + response.data['0'].nombre + " " + response.data['0'].vout_mensaje, "error");
                }
                break;
        }
    }
}
function onResponseAjaxpGetDataGridUnidad(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
            "<th style='text-align:center;'>Codigo</th>" +
//            "<th style='text-align:center;'>Factor</th>" +
            "<th style='text-align:center;'>Descripción</th>" +
            "<th style='text-align:center;'>Simbolo</th>" +
            "<th style='text-align:center;'>Tipo</th>" +
            "<th style='text-align:center;'>Estado</th>" +
            "<th style='text-align:center;'>Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        var factor = item.unidad;
         var complemento = " de " + item.unidad;
        if(item.unidad==null)
        {
            factor='';
            complemento = '';
        }
        cuerpo = "<tr>" +
                "<td style='text-align:center;'>" + item.codigo + "</td>" +
//                 "<td style='text-align:center;'>" + factor + "</td>" +
                "<td style='text-align:center;'>" + item.um_descripcion + complemento + "</td>" +
                "<td style='text-align:center;'>" + item.simbolo + "</td>" +
                "<td style='text-align:center;'>" + item.tm_descripcion + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='color:" + item.color + ";'></i></td>" +
                "<td style='text-align:center;'>" +
                "<a href='#' onclick='cargarDivGetUnidad(" + item.id + ")'><b><i class='fa fa-edit' style='color:#E8BA2F;'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeleteUnidad(" + item.id + ", \"" + item.tm_descripcion + "\")'><b><i class='fa fa-trash-o' style='color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var pie = '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#dataList").append(html);
}
function guardarUnidad(tipo_accion)
{
    var id = document.getElementById('id').value;
    var usu_creacion = document.getElementById('usuario').value;
    var descripcion = document.getElementById('txt_descripcion').value;
    var simbolo = document.getElementById('txt_simbolo').value;
    var codigo = document.getElementById('txt_codigo').value;
    var tipo_unidad = document.getElementById('cbo_tipo').value;
    var estado = document.getElementById('cbo_estado').value;
    var factor = document.getElementById('txt_factor').value;
    if (tipo_accion == 1)
    {
        updateUnidad(id, descripcion, codigo, simbolo, tipo_unidad, estado,factor);
    } else {
        insertUnidad(descripcion, codigo, tipo_unidad, simbolo, estado, usu_creacion,factor);
    }
}

function insertUnidad(descripcion, codigo, tipo_unidad, simbolo, estado, usu_creacion,factor)
{
    if (validar_unidad_form()) {
        ax.setAccion("insertUnidad");
        ax.addParamTmp("descripcion", descripcion);
        ax.addParamTmp("codigo", codigo);
        ax.addParamTmp("tipo", tipo_unidad);
        ax.addParamTmp("simbolo", simbolo);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("usu_creacion", usu_creacion);
        ax.addParamTmp("factor", factor);
        ax.consumir();
    }
}
function getUnidad(id_unidad)
{
    ax.setAccion("getUnidad");
    ax.addParamTmp("id_unidad", id_unidad);
    ax.consumir();
}

function llenarFormularioEditar(data)
{
    document.getElementById('txt_descripcion').value = data[0].descripcion;
    document.getElementById('txt_codigo').value = data[0].codigo;
    document.getElementById('txt_simbolo').value = data[0].simbolo;
    document.getElementById('txt_factor').value = data[0].unidad;
    document.getElementById('cbo_estado').value = data[0].estado;
    getComboUnidadTipo(data[0].tipo_id);
}
function updateUnidad(id, descripcion, codigo, simbolo, tipo, estado,factor)
{
    if (validar_unidad_form()) {
        ax.setAccion("updateUnidad");
        ax.addParamTmp("id_uni", id);
        ax.addParamTmp("descripcion", descripcion);
        ax.addParamTmp("codigo", codigo);
        ax.addParamTmp("tipo", tipo);
        ax.addParamTmp("simbolo", simbolo);
        ax.addParamTmp("estado", estado);
        ax.addParamTmp("factor", factor);
        ax.consumir();
    }
}
function confirmarDeleteUnidad(id, nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras la unidad de medida " + nom + "!",
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
            deleteUnidad(id, nom);
        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }
    });
    //var res=confirm('Est\u00e1 seguro que desea eliminar el cupon especial '+nom+'?');
}

function deleteUnidad(id_uni_tipo, nom)
{
    ax.setAccion("deleteUnidad");
    ax.addParamTmp("id_uni", id_uni_tipo);
    ax.addParamTmp("nom", nom);
    ax.consumir();
    cargarDiv("#window", "vistas/com/unidad/unidad_listar.php");
}

function getComboUnidadTipo(id)
{
    ax.setAccion("getComboTipoUnidad");
    ax.addParamTmp("id_tipo", id);
    ax.consumir();
}

function llenarComboUnidadTipo(data)
{
    var cuerpo_total = '';
    var cuerpo = '';
    var pie = '';
    var cabeza = '<select id="cbo_tipo" onChange="onchangeTipoUnidad();" class="form-control" name="cbo_tipo">' +
            '<option value="" style="display:none;">Ingrese el Tipo de Unidad</option>';
    if (data[0].id_bandera == null)
    {
        $.each(data, function (index, item) {
            cuerpo = '<option value="' + item.id + '">' + item.descripcion + '</option>';
            cuerpo_total = cuerpo_total + cuerpo;
        });
    } else {
        $.each(data, function (index, item) {
            if (item.id == item.id_bandera)
            {
                cuerpo = '<option value="' + item.id + '" selected>' + item.descripcion + '</option>';
            } else
            {
                cuerpo = '<option value="' + item.id + '" >' + item.descripcion + '</option>';
            }
            cuerpo_total = cuerpo_total + cuerpo;
        });
    }
    pie = '</select>';
    var html = cabeza + cuerpo_total + pie;
    $("#combo_tipo").append(html);
}
