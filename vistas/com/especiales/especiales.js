   $('#id').change(function() {
                var id=$('#id').val();
             llamaDias(id);

});
function AsigRH(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/asignaciones/asignaciones_listar.php?id=" + id);
}
function regresarE() {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/especiales/especiales_listar.php");
}
function regresarEM(op) {
    $("#window").empty();
    var mj="";
    if (op==1){mj="Registrado."}
   if(op==2){mj="Editado."}
    cargarDiv("#window", "vistas/com/especiales/especiales_listar.php?mj="+mj);
}
function cargarDivGetUsuario(id) {
    $("#window").empty();
    cargarDiv("#window", "vistas/com/especiales/especiales_edit_form.php?id=" + id);
}
function llenaDatosEpeciales(id){
   acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("DatosCuponEspecial");
    ax.addParamTmp("ce_id", id);
    ax.consumir();
}
function llamaDias(id) {

    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("DiasOcupados");
    ax.addParamTmp("ce_id", id);
    ax.consumir();
}
function getDataEspecial(id) {
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.addParamTmp("cep_id", id);
    ax.setAccion("getEditarData");
    ax.consumir();
}
function enviarSolicitud(id,fecha,dias) {

    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("InsertSolicitud");
    ax.addParamTmp("cep_id", id);
    ax.addParamTmp("fecha", fecha);
    ax.addParamTmp("dias", dias);
    ax.consumir();
}
function listarEspeciales() {
//    breakFunction();
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("getDataGridEspeciales");
    ax.consumir();
}
function delMante(id) {
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("functionDeleteEspeciales");
    ax.addParamTmp("cep_id", id);
    ax.consumir();
}
function enviarEspeciales(nombre, des, sal, fini, ffin, apro, est, fname, fsize, ftype, file) {
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("functionInsertEspeciales");
    ax.addParam("cep_fec_ini", fini);
    ax.addParam("cep_fec_fin", ffin);
    ax.addParam("cep_nombre", nombre);
    ax.addParam("cep_descripcion", des);
    ax.addParam("cep_saludo", sal);
    ax.addParam("cep_activo", est);
    ax.addParam("cep_aprobador", apro);
    ax.addParam("cep_doc", fname);
    ax.addParam("cep_doc_s", fsize);
    ax.addParam("cep_doc_t", ftype);
    ax.addParam("cep_file", file);
    ax.consumir();
}
function enviarEditarEspeciales(id,nombre, des, sal, fini, ffin, apro, est, fname, fsize, ftype, file,imgant,opim) {
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES, "successPerfil");
    ax.setAccion("functionEditEspeciales");
    ax.addParam("cep_id", id);
    ax.addParam("cep_fec_ini", fini);
    ax.addParam("cep_fec_fin", ffin);
    ax.addParam("cep_nombre", nombre);
    ax.addParam("cep_descripcion", des);
    ax.addParam("cep_saludo", sal);
    ax.addParam("cep_activo", est);
    ax.addParam("cep_aprobador", apro);
    ax.addParam("cep_doc", fname);
    ax.addParam("cep_doc_s", fsize);
    ax.addParam("cep_doc_t", ftype);
    ax.addParam("cep_file", file);
    ax.addParam("cep_imgant", imgant);
    ax.addParam("cep_op_img",opim);
     ax.consumir();
}
function successPerfil(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getDataGridEspeciales':
                onResponseAjaxpGetDataGridEspeciales(response.data);
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
            case 'functionDeleteEspeciales':
                cargarRespuesta(response.data);
                break;
            case 'functionInsertEspeciales':
                cargarRespuestaInsert(response.data);
                break;
            case 'getEditarData':
                llenarFormulario(response.data,1);
                break;
                case 'functionEditEspeciales':
                cargarRespuestaInsert(response.data,2);
                break;
                case 'DiasOcupados':
                solicitudEspecial(response.data);
                break;
            case 'DatosCuponEspecial':
                DatosEspecialCupon(response.data);
                break;
            case 'InsertSolicitud':
                respuestaSolicitud(response.data);
                break;
        }
    }
}
function respuestaS(){
    $("#window").empty();
    cargarDiv("#window","vistas/com/especiales/respuestaCuponEspecial.php");
}
function respuestaSolicitud(data){
         if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
       respuestaS();
        quitaSpinner();

    }
    if (data[0]['vout_exito'] == 0) {
         quitaSpinner();
        jQuery.each(data, function (index, value) {
            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
        });

    }
    }
    
  function enviarDatosS(){
      spinner();
      var id=$("#cep_id").val();
      var dias=$("#dias").val();
      var fecha=$("#fecha2").val();
      enviarSolicitud(id,fecha,dias);
  }
function solicitudEspecial(data){
    var dias_dis=data.cea_dias;
    var id=data.cep_id;
    var dias=data.dias;
    $("#window").empty();
    cargarDiv("#window","vistas/com/especiales/especiales_solicitud_form.php?id="+id+"&dias_d="+dias_dis+"&dias="+dias);



}

function  DatosEspecialCupon(data) {
   
    var str="";
    var titulo = "";
    var fecha = "";
    var img="";
    var dir="";
    $.each(data, function (index, item) {
        
        str =item.cep_fec_fin;
        $("#fecha").datepicker('setEndDate',str);
        
       var di=dia_semana(str);
        titulo = "<h3 class='title'>Cup&oacute;n especial:" +item.cep_nombre + "</h3>";
        fecha = "    Nota: Los d&iacute;as pueden ser utilizados por separado o en conjunto. V&aacute;lido hasta el d&iacute;a" +" <b>"+di +
                "</b>.El/los d&iacute;a(s) solicitado(s) deber&aacute;(n)\n\
                    ser autorizado(s) anticipadamente por el Gerente del &aacute;rea y estar&aacute; \n\
                   sujeto a las necesidades/actividades del &aacute;rea."
       img=item.cep_imagen;
        if (item.cep_imagen == null || item.cep_imagen == "")
    {
       
       img = "default.png"; 
    }
    
   
    });
     dir = "http://" + location.host + "/cuponera/vistas/com/especiales/archivos/"+img;
    $(".page-title").append(titulo);
     $("#text1").append(fecha);
     $("#imagen").attr("src",dir);
     
    //alert(data.cep_imagen);
}

function onResponseAjaxpGetDataGridEspeciales(data) {

    var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Nombre</th>' +
            '<th>Descripci&oacute;n</th>' +
            '<th>Inicio</th>' +
            '<th>Fin</th>' +
            '<th>Aprobador</th>' +
            '<th>Estado</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.cep_nombre + "</td>" +
                "<td >" + item.cep_descripcion + "</td>" +
                "<td >" + item.cep_fec_ini + "</td>" +
                "<td >" + item.cep_fec_fin + "</td>" +
                "<td style='text-align:center;'>" + item.aprobador + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='font-size:20px;color:" + item.color + ";'data-toggle='tooltip' data-placement='top' title='' data-original-title='" + item.estado + "'></i></td>" +
                "<td style='text-align:center;'>" +
                "<a href='#' onclick='cargarDivGetUsuario(" + item.cep_id + ")'><b><i class='fa fa-edit' data-toggle='tooltip' data-placement='left' title='' data-original-title='Editar' style='font-size:16px;color:#E8BA2F;'></i><b></a>&nbsp;&nbsp;" +
                " <a href='#' onclick='AsigRH(" + item.cep_id + ")' ><b><i class='fa fa-group' style='font-size:16px;color:#1ca8dd;' data-toggle='tooltip' data-placement='left' title='' data-original-title='Listar colaboradores asignados'></i></b></a>&nbsp;&nbsp;" +
                "<a href='#' onclick='confirmarDeleteEspecial(" + item.cep_id + ", \"" + item.cep_nombre + "\")'><b><i class='fa fa-trash-o' data-toggle='tooltip' data-placement='left' title='' data-original-title='Eliminar' style='font-size:16px;color:#cb2a2a;'></i><b></a>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
    $("#scroll").append(html);
}

function confirmarDeleteEspecial(id, nom) {
    swal({
        title: "Est\xe1s seguro?",
        text: "Eliminarás el cup\xf3n especial " + nom + "!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#33b86c",
        confirmButtonText: "Si, eliminar!",
        cancelButtonColor: '#d33',
        cancelButtonText: "No, cancelar !",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        $(".confirm").removeProp("disabled");

        if (isConfirm) {

            delMante(id);
        } else {
            swal("Cancelado", "La eliminaci\xf3n fue cancelada", "error");
        }

    });
}
function cargarRespuesta(data) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        listarEspeciales();
        spinnerSA();

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}
function cargarRespuestaInsert(data,op) {
    if (data[0]["vout_exito"] == '1') {
        $("#scroll").empty();
        regresarEM(op);
        quitaSpinner();

    }
    if (data[0]['vout_exito'] == 0) {
         quitaSpinner();
        jQuery.each(data, function (index, value) {
            $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
        });

    }
}

function llenarFormulario(data) {
    document.getElementById('upload-file-info').innerHTML = data[0].cep_imagen;
    document.getElementById("imgant").value = data[0].cep_imagen;
    if (data[0].cep_imagen == null || data[0].cep_imagen == "")
    {
        document.getElementById("ima3").disabled = true;
        data[0].cep_imagen = "default.png"

        document.getElementById('upload-file-info').innerHTML = "Ninguna imagen para mostrar"
    }
    var dir = "http://" + location.host + "/cuponera/vistas/com/especiales/archivos/" + data[0].cep_imagen;
      $( '#rfecha' ).datepicker( 'setDate', data[0].cep_fec_ini);
       $( '#rfecha3' ).datepicker( 'setDate',data[0].cep_fec_fin);  
    $( '#rfecha2' ).datepicker( 'setDate', data[0].cep_fec_ini);
       $( '#rfecha4' ).datepicker( 'setDate',data[0].cep_fec_fin);
    document.getElementById("nom").value = data[0].cep_nombre;
    document.getElementById("des").value = data[0].cep_descripcion;
    document.getElementById("sal").value = data[0].cep_saludo;
    document.getElementById("rfecha2").value = data[0].cep_fec_ini;
    document.getElementById("rfecha4").value = data[0].cep_fec_fin;
    document.getElementById("rfecha").value = data[0].cep_fec_ini;
    document.getElementById("rfecha3").value = data[0].cep_fec_fin;
    document.getElementById("aprob").value = data[0].cep_aprobador;
    document.getElementById("est").value = data[0].cep_activo;
    document.getElementById("rut").value = dir;
    document.getElementById('myImg').src = dir;
   document.getElementById('fname').value=data[0].cep_imagen;
}
//insertar especiales
function validar() {
    var bandera = true;
    var n, u, c1, c4, c5;
    n = $("#nom").val();
    u = $("#des").val();
    c1 = $("#sal").val();

    c4 = $("#aprob").val();
    c5 = $("#est").val();
    if (n == "") {
        $("#msj").show();
        bandera = false;
    }
    if (u == "") {
        $("#msj2").show();
        bandera = false;
    }
    if (c1 == "") {
        $("#msj3").show();
        bandera = false;
    }

    if (c4 == '0') {
        $("#msj5").show();
        bandera = false;
    }
    if (c5 == '3') {
        $("#msj6").show();
        bandera = false;
    }
    return bandera;
}
function  insertarCupon() {

    if (validar()) {
        spinner();
        var nombre = document.getElementById("nom").value;
        var des = document.getElementById("des").value;
        var sal = document.getElementById("sal").value;
        var fini = document.getElementById("rfecha2").value;
        var ffin = document.getElementById("rfecha4").value;
        var apro = document.getElementById("aprob").value;
        var est = document.getElementById("est").value;
        var fname = document.getElementById('fname').value;
        var fsize = document.getElementById('fsize').value;
        var ftype = document.getElementById('ftype').value;
        var file = document.getElementById('secretImg').value;
        enviarEspeciales(nombre, des, sal, fini, ffin, apro, est, fname, fsize, ftype, file);

    }
}
function  enviarEditar(){

    if (validar()) {
        spinner();
        var id=document.getElementById("cep_id").value;
        var nombre = document.getElementById("nom").value;
        var des = document.getElementById("des").value;
        var sal = document.getElementById("sal").value;
        var fini = document.getElementById("rfecha2").value;
        var ffin = document.getElementById("rfecha4").value;
        var apro = document.getElementById("aprob").value;
        var est = document.getElementById("est").value;
        var fname = document.getElementById('fname').value;
        var fsize = document.getElementById('fsize').value;
        var ftype = document.getElementById('ftype').value;
        var file = document.getElementById('secretImg').value;
        var imgan=document.getElementById('imgant').value;
        var opim=$('input:radio[name=ima]:checked').val();

     enviarEditarEspeciales(id,nombre, des, sal, fini, ffin, apro, est, fname, fsize, ftype, file,imgan,opim);

    }
    
}
