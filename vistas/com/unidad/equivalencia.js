$('#txt_factor1').keypress(function () {
    $('#msj_factor1').hide();
});

function onchangeAlternativa()
{
    $('#msj_alternativa').hide();
}
function onchangeUnidad()
{
    $('#msj_unidad').hide();
}

function limpiar_formulario_equivalencia()
{
    document.getElementById("frm_equivalencia").reset();
}

function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}

function cargarDivGetEquivalencia(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/unidad/equivalencia_form.php?id=" + id + "&" + "tipo=" + 1);
}

function validar_equivalencia_form() {
    var bandera = true;
    var espacio = /^\s+$/;
    var id = document.getElementById('id').value;
    var usu_creacion = document.getElementById('usuario').value;
    var fac_alternativa = document.getElementById('txt_factor1').value;
    var uni_alternativa = document.getElementById('cbo_alternativa').value;
    var fac_base = document.getElementById('txt_factor2').value;
    var uni_base = document.getElementById('cbo_unidad').value;

    if (fac_alternativa == "" || fac_alternativa == null || espacio.test(fac_alternativa) || fac_alternativa.length == 0)
    {
        $("msj_factor1").removeProp(".hidden");
        $("#msj_factor1").text("Ingrese un factor").show();
        bandera = false;
    }

    if (uni_alternativa == "" || uni_alternativa == null || espacio.test(uni_alternativa) || uni_alternativa.length == 0)
    {
        $("msj_alternativa").removeProp(".hidden");
        $("#msj_alternativa").text("Ingrese unidad alternativa").show();
        bandera = false;
    }

    if (fac_base == "" || fac_base == null || espacio.test(fac_base) || fac_base.length == 0)
    {
        $("msj_factor2").removeProp(".hidden");
        $("#msj_factor2").text("Ingrese un factor").show();
        bandera = false;
    }

    if (uni_base == "" || uni_base == null || espacio.test(uni_base) || uni_base.length == 0)
    {
        $("msj_unidad").removeProp(".hidden");
        $("#msj_unidad").text("Ingrese una unidad base").show();
        bandera = false;
    }

    return bandera;
}

function listarEquivalencias() {
//    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.EQUIVALENCIA, "successEquivalencia");
    ax.setAccion("getDataGridEquivalencia");
    ax.consumir();
}
function successEquivalencia(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridEquivalencia':
                onResponseAjaxpGetDataGridEquivalencia(response.data);
                $('#datatable').dataTable();
                break;
            case 'getComboAlternativa':
                llenarComboAlternativa(response.data);
                $('#cbo_alternativa').combobox();
//                getComboPerfil();
                break;
            case 'getComboUnidad':
                llenarComboUnidad(response.data);
                $('#cbo_unidad').combobox();
                break;
            case 'insertEquivalencia':
                limpiar_formulario_equivalencia();
                break;
            case 'getEquivalencia':
                llenarFormularioEquivalencia(response.data);
                break;
            case 'updateEquivalencia':
                cargarDiv("#window", "vistas/com/unidad/equivalencia_listar.php");
                break;

            case 'deleteEquivalencia':
                var error = response.data['0'].vout_exito;
                if (error > 0) {
///////
                    swal("Eliminado!", "La equivalencia entre " + response.data['0'].nombre1 + " con la unidad " + response.data['0'].nombre2 + ".", "success");
//////
                } else {
                    swal("Cancelado", "Upss!!.El tipo de unidad " + response.data['0'].nombre1 + " " + response.data['0'].vout_mensaje, "error");
                }
                break;
        }
    }
}

function onResponseAjaxpGetDataGridEquivalencia(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
//            "<th style='text-align:center;'>Factor</th>" +
            "<th style='text-align:center;'>Unidad Alternativa</th>" +
//            "<th style='text-align:center;'>Factor</th>" +
            "<th style='text-align:center;'>Unidad Base</th>" +
            "<th style='text-align:center;'>Estado</th>" +
            "<th style='text-align:center;'>Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        var complemento = " de " + item.unidad_alt;
        if (item.unidad_alt == null)
        {
            complemento = '';
        }
//        var complemento2 = " de " + item.unidad_alt;
//        if(item.unidad_alt==null)
//        {
//            complemento = '';
//        }
        cuerpo = "<tr>" +
//                "<td style='text-align:center;'>" + parseInt(item.factor_alt) + "</td>" +
                "<td style='text-align:center;'>" + item.equi_descripcion + complemento + "</td>" +
//                "<td style='text-align:center;'>" + parseInt(item.factor_uni) + "</td>" +
                "<td style='text-align:center;'>" + parseInt(item.factor_uni) + " " + item.unidad_descripcion + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='color:" + item.color + ";'></i></td>" +
                "<td style='text-align:center;'>" +
//                "<i class='fa  fa-file-text' onclick='cargarDivGetColaboradorDetalle(" + item.id + ")' style='color:#088A68;'></i>&nbsp;\n" +
                "<a href='#' onclick='cargarDivGetEquivalencia(" + item.id + ")'><b><i class='fa fa-edit' style='color:#E8BA2F;'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeleteEquivalencia(" + item.id + ", \"" + item.equi_descripcion + "\",\"" + item.unidad_descripcion + "\")'><b><i class='fa fa-trash-o' style='color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var pie = '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#dataList").append(html);
}

function getComboAlternativa(id)
{
    ax.setAccion("getComboAlternativa");
    ax.addParamTmp("id_unidad", id);
    ax.consumir();
}
function llenarComboAlternativa(data)
{
    var cuerpo_total = '';
    var cuerpo = '';
    var pie = '';

    var cabeza = '<select id="cbo_alternativa" onChange="onchangeAlternativa();" class="form-control" name="cbo_alternativa">' +
            '<option value="" id="s1"  style="display:none;">Unidad alternativa</option>';
//            '<option value="#">&nbsp;</option>';


    if (data[0].id_bandera == null)
    {
        $.each(data, function (index, item) {
            var complementob = " de " + item.unidad;
            if (item.unidad == null)
            {
                complementob = '';
            }
            cuerpo = '<option value="' + item.id + '">' + item.um_descripcion + complementob + '</option>';
            cuerpo_total = cuerpo_total + cuerpo;
        });
    } else {
        $.each(data, function (index, item) {
            var complemento = " de " + item.unidad;
            if (item.unidad == null)
            {
                complemento = '';
            }
            if (item.id == item.id_bandera) {
                cuerpo = '<option value="' + item.id + '"  selected>' + item.um_descripcion + complemento + '</option>';
            } else {
                cuerpo = '<option value="' + item.id + '">' + item.um_descripcion + complemento + '</option>';
            }
            cuerpo_total = cuerpo_total + cuerpo;
        });
    }
    pie = '</select>';
    var html = cabeza + cuerpo_total + pie;
    $("#combo_unidad").append(html);
}

function getComboUnidad(id)
{
    ax.setAccion("getComboUnidad");
    ax.addParamTmp("id_unidad", id);
    ax.consumir();
}

function llenarComboUnidad(data)
{
    var cuerpo_total = '';
    var cuerpo = '';
    var pie = '';
    var cabeza = '<select id="cbo_unidad" onChange="onchangeUnidad();" class="form-control" name="cbo_unidad">' +
            '<option value="" style="display:none;">Unidad Base</option>';
    if (data[0].id_bandera == null)
    {
        $.each(data, function (index, item) {
            var complementob = " de " + item.unidad;
            if (item.unidad == null)
            {
                complementob = '';
            }
            cuerpo = '<option value="' + item.id + '">' + item.um_descripcion + complementob + '</option>';
            cuerpo_total = cuerpo_total + cuerpo;
        });
    } else {
        $.each(data, function (index, item) {
            var complemento = " de " + item.unidad;
            if (item.unidad == null)
            {
                complemento = '';
            }
            if (item.id == item.id_bandera)
            {
                cuerpo = '<option value="' + item.id + '" selected>' + item.um_descripcion + complemento + '</option>';
            } else
            {
                cuerpo = '<option value="' + item.id + '" >' + item.um_descripcion + complemento + '</option>';
            }
            cuerpo_total = cuerpo_total + cuerpo;
        });
    }
    pie = '</select>';
    var html = cabeza + cuerpo_total + pie;
    $("#combo_unidades").append(html);
}

function guardarEquivalencia(tipo)
{
    var id = document.getElementById('id').value;
    var usu_creacion = document.getElementById('usuario').value;
    var fac_alternativa = document.getElementById('txt_factor1').value;
    var uni_alternativa = document.getElementById('cbo_alternativa').value;
    var fac_base = document.getElementById('txt_factor2').value;
    var uni_base = document.getElementById('cbo_unidad').value;
    if (tipo == 1)
    {
        updateEquivalencia(id, fac_alternativa, uni_alternativa, fac_base, uni_base);
//        cargarDiv("#window", "vistas/com/usuario/usuario_listar.php");
    } else {
        insertEquivalencia(fac_alternativa, uni_alternativa, fac_base, uni_base, usu_creacion);
    }
}
function insertEquivalencia(fac_alternativa, uni_alternativa, fac_base, uni_base, usu_creacion)
{
    if (validar_equivalencia_form()) {
        ax.setAccion("insertEquivalencia");
        ax.addParamTmp("fac_alternativa", fac_alternativa);
        ax.addParamTmp("uni_alternativa", uni_alternativa);
        ax.addParamTmp("fac_base", fac_base);
        ax.addParamTmp("uni_base", uni_base);
        ax.addParamTmp("usu_creacion", usu_creacion);
        ax.consumir();
    }
}
function getEquivalencia(id_equivalencia)
{
    ax.setAccion("getEquivalencia");
    ax.addParamTmp("id_equivalencia", id_equivalencia);
    ax.consumir();

}
function llenarFormularioEquivalencia(data)
{
    document.getElementById('txt_factor1').value = parseInt(data[0].factor_alt);
    document.getElementById('txt_factor2').value = parseInt(data[0].factor_uni);
    getComboAlternativa(data[0].alternativa_id);
    getComboUnidad(data[0].uni_medida_id);
}

function updateEquivalencia(id, fac_alternativa, uni_alternativa, fac_base, uni_base)
{
    if (validar_equivalencia_form()) {
        ax.setAccion("updateEquivalencia");
        ax.addParamTmp("id_equivalencia", id);
        ax.addParamTmp("fac_alternativa", fac_alternativa);
        ax.addParamTmp("uni_alternativa", uni_alternativa);
        ax.addParamTmp("fac_base", fac_base);
        ax.addParamTmp("uni_base", uni_base);
        ax.consumir();
    }
}
function confirmarDeleteEquivalencia(id, nom1, nom2) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras la equivalencia " + nom1 + " con la unidad " + nom2 + "!",
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
            deleteEquivalencia(id, nom1, nom2);
        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }
    });
    //var res=confirm('Est\u00e1 seguro que desea eliminar el cupon especial '+nom+'?');
}

function deleteEquivalencia(id_equivalencia, nom1, nom2)
{
    ax.setAccion("deleteEquivalencia");
    ax.addParamTmp("id_equivalencia", id_equivalencia);
    ax.addParamTmp("nom1", nom1);
    ax.addParamTmp("nom2", nom2);
    ax.consumir();
    cargarDiv("#window", "vistas/com/unidad/equivalencia_listar.php");
}