
$('#chk_usu').click(function () {
    if ($(this).is(':checked')) {
        $('#oculto').removeClass("hidden");
    } else {
        $('#oculto').addClass("hidden");
    }
});

$("#org").change(function () {

    $("#jefe").combobox("clearTarget");  
    $("#jefe").combobox("clearElement");
    $("#ger").combobox("clearTarget");
    $("#ger").combobox("clearElement");
    agregarSC("#suc");
    $(".combobox-container").css("opacity", "0.5");
    agregarSC("#jefe");
    agregarSC("#ger");

    var b = 0, x = 0;

    var d = $("#org").val();
    var dd = $("#org").val();
    if (d != '') {
        b = 1;
    }
    if (b == 1) {
        getComboSucursal(d);

        x = 5;
    }
    if (x == 5) {
        getComboJefeGere(0, dd);
    }
});

$('#nom').change(function () {
    $('#msj').hide();
});
$('#uad').change(function () {
    $('#msj2').hide();
});

     $("#org").change(function () {
    $('#msj3').hide();
});
    $("#suc").change(function () {
    $('#msj4').hide();
});
    $("#jefe").change(function () {
    $('#msj5').hide();
});
    $("#ger").change(function () {
    $('#msj6').hide();
});
   $("#mtr").change(function () {
    $('#msj7').hide();
});
   $("#rol").change(function () {
    $('#msj8').hide();
});
   $("#clas").change(function () {
    $('#msj9').hide();
});
    $("#est").change(function () {
    $('#msj10').hide();
});
$("#cor").change(function () {
    $('#msj11').hide();
});
   $("#password").keypress(function () {
    $('#msj12').hide();
});
function validarUsuario(op) {
    var nombre, usu_ad, c1, suc_id, jefe, gerente, jefe_matricial,rol,clase,estado,clave,fec_cump,cargo,matricial,correo,cont=0;
    nombre = $("#nom").val();
    usu_ad = $("#uad").val();
    c1 = $("#org").val();
    suc_id = $("#suc").val();
    jefe = $("#jefe").val();
    gerente = $("#ger").val();
    jefe_matricial = $("#mtr").val();
    rol = $("#rol").val();
    clase = $("#clas").val();
    estado = $("#est").val();
    clave = $("#password").val();
    if ($("#chk_mtr").is(':checked')){
        
         matricial=$("#chk_mtr").val();
            }else{
          matricial=0;
    }
    if (nombre == "") {
        $("#msj").show();
        cont++;
    }
    if (usu_ad == "") {
        $("#msj2").show();
        cont++;
    }
    if (c1 == null) {
        $("#msj3").show();
        cont++;
    }
    if (suc_id == null) {
        $("#msj4").show();
        cont++;
    }
//    if (jefe == null) {
//        $("#msj5").show();
//        cont++;
//    }
//    if (gerente == null) {
//        $("#msj6").show();
//        cont++;
//    }
//    if (jefe_matricial == null) {
//        $("#msj7").show();
//        cont++;
//    }
     if (rol ==null) {
        $("#msj8").show();
        cont++;
    }
    if (clase == null) {
        $("#msj9").show();
        cont++;
    }
    if (estado ==null) {
        $("#msj10").show();
        cont++;
    }
    
 
    if ($("#chk_usu").is(':checked')){
      
        correo=$("#cor").val();
        if(correo==""){
            $("#msj11").show();
                    cont++;

        }
        fec_cump=$("#fec_nac").val();
        cargo=$("#car").val();
    }else{
          $('#msj11').hide();
          fec_cump="";
        cargo="";
    }

    if(cont==0){
         correo=$("#cor").val();
        
        var nivel=1;
        if(op==0){
       insertarUsuario(nombre,usu_ad,nivel,estado,jefe,gerente,jefe_matricial,clase,rol,clave,correo,suc_id,fec_cump,cargo,matricial);
   }
   if(op==1){
         var usu_id=$("#usu_id").val();
         var usu_ad_a=$("#usu_ad_a").val();
            editarUsuario(usu_id,nombre,usu_ad,usu_ad_a,nivel,estado,jefe,gerente,jefe_matricial,clase,rol,clave,correo,suc_id,fec_cump,cargo,matricial);
   }
        }
           

}
function cargarDiv(div, url)
{
    $('div').remove('.sweet-overlay');
    $('div').remove('.sweet-alert');
    $("#window").html("");
    $(div).load(url);
}
function cargarDivGetUsuario(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/usuario/usuario_form.php?id=" + id + "&" + "tipo=1");
}
function insertarUsuario(nombre,usu_ad,nivel,estado,jefe,gerente,jefe_matr,clase,rol,clave,correo,suc_id,fec_cump,cargo,matricial){
        spinner();
    acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
        ax.addParam("nombre",nombre);
        ax.addParam("usu_ad",usu_ad);
        ax.addParam("nivel",nivel);
        ax.addParam("estado",estado);
        ax.addParam("jefe",jefe);
        ax.addParam("gerente",gerente);
        ax.addParam("jefe_matricial",jefe_matr);
        ax.addParam("clase",clase);
        ax.addParam("rol",rol);
        ax.addParam("clave",clave);
        ax.addParam("correo",correo);
        ax.addParam("suc_id",suc_id);
        ax.addParam("fec_cump",fec_cump);
        ax.addParam("cargo",cargo);
        ax.addParam("matricial",matricial);
        ax.setAccion("insertUsuario");
        ax.consumir();
}
function editarUsuario(usu_id,nombre,usu_ad,usu_ad_a,nivel,estado,jefe,gerente,jefe_matr,clase,rol,clave,correo,suc_id,fec_cump,cargo,matricial){
        spinner();
    acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
        ax.addParam("usu_id",usu_id);
        ax.addParam("nombre",nombre);
        ax.addParam("usu_ad",usu_ad);
        ax.addParam("usu_ad_a",usu_ad_a);
        ax.addParam("nivel",nivel);
        ax.addParam("estado",estado);
        ax.addParam("jefe",jefe);
        ax.addParam("gerente",gerente);
        ax.addParam("jefe_matricial",jefe_matr);
        ax.addParam("clase",clase);
        ax.addParam("rol",rol);
        ax.addParam("clave",clave);
        ax.addParam("correo",correo);
        ax.addParam("suc_id",suc_id);
        ax.addParam("fec_cump",fec_cump);
        ax.addParam("cargo",cargo);
        ax.addParam("matricial",matricial);
        ax.setAccion("editUsuario");
        ax.consumir();
}
function eliminarUsuario(usu_id,nombre,usu_ad){
        spinnerAR();
        acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
        ax.addParam("id_usuario",usu_id);
        ax.addParam("nombre",nombre);
        ax.addParam("usu_ad",usu_ad);
        ax.setAccion("deleteUsuario");
        ax.consumir();
}
function listarUsuarios() {

    acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
    ax.setAccion("getDataGridUsuario");
    ax.consumir();
}
function getComboOrganizacion(org_id_b) {
    ax.addParam("org_id_b", org_id_b);
    acciones.iniciaAjaxTest(COMPONENTES.ORGANIZACION, "successPerfil");
    ax.setAccion("functionListarOrganizacion");
    ax.consumir();
}
function getComboSucursal(org_id,id_suc) {

    acciones.iniciaAjaxTest(COMPONENTES.SUCURSAL, "successPerfil");
    ax.addParam("org_id", org_id);
    ax.addParam("id_suc",id_suc)
    ax.setAccion("functionObtenerSucursal");
    ax.consumir();
}
function getComboJefeGere(op, org_id,g_ad,j_ad) {
    var matr="";
    acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
    ax.addParamTmp("op", op);
    ax.addParamTmp("id_org", org_id);
    ax.addParamTmp("g_ad", g_ad);
    ax.addParamTmp("j_ad", j_ad);
    ax.addParamTmp("matri_ad", matr);
    ax.setAccion("getDataUsuarioCombo");
    ax.consumir();
}
function getUsuario(id){
    acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
    ax.addParamTmp("usu_id", id);
    ax.setAccion("getUsuario");
    ax.consumir();
}
function getComboMatr(matr) {

    var op = 1;
    var org_id = 0;
    var g_ad ="";
    var j_ad ="";
    acciones.iniciaAjaxTest(COMPONENTES.USUARIO, "successPerfil");
    ax.addParamTmp("op", op);
    ax.addParamTmp("id_org", org_id);
     ax.addParamTmp("g_ad", g_ad);
    ax.addParamTmp("j_ad", j_ad);
    ax.addParamTmp("matri_ad", matr);
    ax.setAccion("getDataMatriCombo");
    ax.consumir();
}
function successPerfil(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridUsuario':
                onResponseAjaxpGetDataGridUsuarios(response.data);
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
            case 'functionListarOrganizacion':
                llenarComboOrganizacion(response.data);
                break;
            case 'getDataMatriCombo':
                llenarComboMatri(response.data);
                $('#mtr').combobox('refresh');
                $('#mtr').combobox();

                break;
            case 'functionObtenerSucursal':
                llenarComboSucursal(response.data);
                removeSC();
                break;
            case 'getDataUsuarioCombo':

                llenarComboJefeGer(response.data);
                $('#jefe').combobox('refresh');
                $('#jefe').combobox();
                $(".combobox-container").css("opacity", "1");
                removeSC();
                $('#ger').combobox('refresh');
                $('#ger').combobox();
                removeSC();
                removeSC();
                break;
            case 'insertUsuario':
                cargarRespuestaInsertar(response.data);
                break;
                case 'getUsuario':
               cargarRespuestaDataEditar(response.data);
                break;
                case 'editUsuario':
                cargarRespuestaEditar(response.data);
                break;
            case 'deleteUsuario':
                    cargarRespuestaEliminar(response.data);
                break;

        }
    }else{
        switch (response[PARAM_ACCION_NAME]) {
        case 'insertUsuario':
        quitaSpinner();break;
        }
    }
}

function onResponseAjaxpGetDataGridUsuarios(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered"><thead>' +
            " <tr>" +
            "<th >Colaboradores</th>" +
            "<th >Usuario</th>" +
            "<th >Jefe</th>" +
            "<th >Gerente</th>" +
            "<th >Clase</th>" +
            "<th >Rol</th>" +
            "<th >Organización</th>" +
            "<th >Sucursal</th>" +
            "<th >Estado</th>" +
            "<th >Acciones</th>" +
            "</tr>" +
            "</thead>";
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td >" + item.usu_ad + "</td>" +
                "<td >" + item.usu_jefe + "</td>" +
                "<td >" + item.usu_gerente + "</td>" +
                "<td >" + item.cup_clase + "</td>" +
                "<td >" + item.usu_rol + "</td>" +
                "<td >" + item.org_nombre + "</td>" +
                "<td >" + item.suc_nombre + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='font-size:20px;color:" + item.color + ";' data-toggle='tooltip' data-placement='left' title='' data-original-title='" + item.estado + "'></i></td>" +
                "<td style='text-align:center;'>" +
                "<a href='#' onclick='cargarDivGetUsuario(" + item.usu_id + ")'><b><i class='fa fa-edit' style='font-size:16px;color:#E8BA2F;' data-toggle='tooltip' data-placement='left' title='' data-original-title='Editar'></i><b></a>&nbsp;\n" +
                "<a href='#' onclick='confirmarDeleteUsuario("+ item.usu_id +",\""+item.usu_ad+"\",\"" + item.usu_nombre +"\")'><b><i class='fa fa-trash-o' style='font-size:16px;color:#cb2a2a;' data-toggle='tooltip' data-placement='left' title='' data-original-title='Eliminar'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });

    var html = cabeza + cuerpo_total;
    $("#scroll").append(html);
}
function getComboColaborador(id)
{
    ax.setAccion("getComboColaborador");
    ax.addParamTmp("id_usuario", id);
    ax.consumir();
}

function llenarComboOrganizacion(data)
{  
    var cuerpo_total = '';
    var cuerpo = '';
    var d = 0;
    var org_id_b=0;
       
    $.each(data, function (index, item) {
        cuerpo = '';
        org_id_b=item.orga;
        d=item.org;
            cuerpo = '<option value="' + item.org_id + '">' + item.org_nombre + '</option>';
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var html = cuerpo_total;
    $("#org").append(html);
    agregarSC("#mtr");
    if(org_id_b==''){
    getComboMatr();
    }
    if (d != 0) {
        $("#org option[value='" + d + "']").attr("selected", "selected");
        agregarSC("#suc");
        agregarSC("#jefe");
        agregarSC("#ger");
        getComboSucursal(d);
        getComboJefeGere(0, d)
    }
    if(org_id_b!=null || org_id_b!=''){
                $("#org option[value='" + org_id_b + "']").attr("selected", "selected");

    }
}

function llenarComboSucursal(data)
{
    var cuerpo_total = '';
    var cuerpo = '';
    var id_suc="";
    var cabeza = '<option value="" disabled selected  style="display:none;">Ingrese sucursal</option>';
    $.each(data, function (index, item) {
        id_suc=item.id;
        cuerpo = '';
        
         
        cuerpo = '<option value="' + item.suc_id + '">' + item.suc_nombre + '</option>';
    
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var html = cabeza + cuerpo_total;
    $("#suc").empty();
    $("#suc").append(html);
    if(id_suc!=null || id_suc!=''){
       $("#suc option[value='" + id_suc + "']").attr("selected", "selected");
    }

}
function llenarComboJefeGer(dat)
{
    $("#jefe").empty();
    $("#ger").empty();
    var cuerpo_total = '';
    var cuerpo = '';
    var jefe_c = '';
    var gere_c = '';
    var cabeza = '<option value="" disabled selected  style="display:none;">Ingrese un usario</option>';
    $.each(dat, function (index, item) {
        cuerpo = '';
        gere_c=item.g_ad;
        jefe_c=item.j_ad;
        cuerpo = '<option value="' + item.usu_ad + '">' + item.usu_ad + '</option>';

        cuerpo_total = cuerpo_total + cuerpo;
    });
    var html = cabeza + cuerpo_total;

    $("#jefe").append(html);
    $("#ger").append(html);
    if(jefe_c!=null || jefe_c!=''){
       $("#jefe option[value='"+jefe_c+"']").attr("selected", "selected");
   }
    if(gere_c!=null || gere_c!=''){
       $("#ger option[value='"+gere_c+"']").attr("selected", "selected");
   }
}
function llenarComboMatri(dat)
{
    $("#mtr").empty();

    var cuerpo_total = '';
    var cuerpo = '';
    var matri_c = '';
    var cabeza = '<option value="" disabled selected  style="display:none;">Ingrese un usario</option>';
    $.each(dat, function (index, item) {
        cuerpo = '';
        matri_c=item.m_ad;
        cuerpo = '<option value="' + item.usu_ad + '">' + item.usu_ad + '</option>';

        cuerpo_total = cuerpo_total + cuerpo;
    });
    var html = cabeza + cuerpo_total;

    $("#mtr").append(html);
if(matri_c!=null || matri_c!=''){
       $("#mtr option[value='"+matri_c+"']").attr("selected", "selected");
   }

}

function cargarRespuestaInsertar(data){
    if (data[0]["vout_exito"] == '1') {
        $("#window").empty();
            cargarDiv("#window","vistas/com/usuario/usuario_listar.php?mj=registrado.");
    }
    if (data[0]['vout_exito'] == 0) {
        jQuery.each(data, function (index, value) {
            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
        });
        quitaSpinner();
    }
}
function cargarRespuestaDataEditar(data){
     var id_d="",jefe="",gere="",matri="",o="";
        $.each(data, function (index, item) {
        id_d=item.suc_id;
        o=item.org_id;
        jefe=item.usu_jefe;
        gere=item.usu_gerente;
        matri=item.usu_jefe_matricial;
    });
     $("#nom").val(data[0]['usu_nombre']);
     $("#uad").val(data[0]['usu_ad']);
    agregarSC("#org");
     agregarSC("#suc");
        agregarSC("#jefe");
        agregarSC("#ger");
     getComboOrganizacion(o);
      getComboSucursal(o,id_d);
      getComboJefeGere(0,o,gere,jefe);
      getComboMatr(matri);
      $("#rol option[value='"+data[0]['usu_rol']+"']").attr("selected", "selected");
      if(data[0]['usu_matricial']==1){
      $( "#chk_mtr" ).attr( "checked", "checked" );
    }
          $("#est option[value='"+data[0]['usu_estado']+"']").attr("selected", "selected");
      $("#clas option[value='"+data[0]['cup_clase']+"']").attr("selected", "selected");
    if(data[0]['usu_fec_cump']!="" && data[0]['usu_fec_cump']!=null){
         
        $("#fec_nac").datepicker('setDate',data[0]['usu_fec_cump']);
        $("#car").val(data[0]['usu_cargo']);
      $( "#chk_usu" ).attr( "checked", "checked" );
      $('#oculto').removeClass("hidden");
    }
     $("#password").val(data[0]['usu_clave']); 
     $("#cor").val(data[0]['usu_correo']);
     $("#oculto").append("<input type='hidden' id='usu_id' value='"+data[0]['usu_id']+"' >");
     $("#oculto").append("<input type='hidden' id='usu_ad_a' value='"+data[0]['usu_ad']+"' >");

}

function confirmarDeleteUsuario(i,ad,nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminaras al usuario " + nom + "!",
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
            eliminarUsuario(i,nom,ad);
        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }

    });

}

function cargarRespuestaEditar(data){
    if (data[0]["vout_exito"] == '1') {
        $("#window").empty();
            cargarDiv("#window","vistas/com/usuario/usuario_listar.php?mj=Editado.");
    }
    if (data[0]['vout_exito'] == 0) {
        jQuery.each(data, function (index, value) {
            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
        });
        quitaSpinner();
    }
}

function cargarRespuestaEliminar(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        listarUsuarios();
        spinnerSA();

    }else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}