
function confirmarAnularCupon(id) {
    
      swal({   title: "Anular cup\xf3n",
        text: "Ingrese el motivo de la anulaci\xf3n:",  
        type: "input", 
        showCancelButton: true,
         confirmButtonColor: "#33b86c", 
        closeOnConfirm: false,
        //animation: "slide-from-top",
        inputPlaceholder: "Ingrese el motivo" }, 
    function(inputValue){ 
        if (inputValue === false) return false;
        if (inputValue === "") {  
            swal.showInputError("Debe ingresar un motivo!"); 
            return false 
        }  
        
    anularCupon(id,inputValue,101);
    });
}
function anularCupon(id,mot,op){
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporte");
    ax.addParam("id_cupon",id);
    ax.addParam("motivo",mot);
    ax.addParam("opcion",op);
    ax.setAccion("anularCupon");
    ax.consumir();
}
function getReporte(fec1,fec2,est,org_id)
{
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporte");
    ax.addParam("fecha_ini",fec1);
    ax.addParam("fecha_fin",fec2);
    ax.addParam("est",est);
    ax.addParam("org_id",org_id);
    ax.setAccion("getReporteCupon");
    ax.consumir();
   
}
function getComboOrgacionzacionM(){
     acciones.iniciaAjaxTest(COMPONENTES.ORGANIZACION, "opcionReporte");
    //ax.addParam("flag_org",flag_org);
    ax.setAccion("getOrganizacionMatricial");
    ax.consumir();
}
function opcionReporte(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getReporteCupon':
                onResponseAjaxpGetDataReporteC(response.data);
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
            case 'anularCupon':
                respuestaAnular(response.data);
                break;
            case 'getOrganizacionMatricial':
                cargarComboMatricial(response.data);
                break;
        }
    }
}
function onResponseAjaxpGetDataReporteC(data){
    
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Organización</th>' +
            '<th>Colaborador</th>' +
            '<th>Fecha de permiso</th>' +
            '<th>Fecha de solicitud</th>' +
            '<th>Fecha de aprobaci&oacute;n</th>' +
            '<th>Tipo</th>' +
            '<th>Notas</th>' +
            '<th>Estado</th>' +
            '<th>Aprob RRHH</th>' +
            '<th>Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        
        cuerpo = "<tr>" +
                "<td >" + item.org_nombre + "</td>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td style='width:8%;'>" + item.fec_perm + "</td>" +
                "<td >" + item.cup_fec_sol + "</td>" +
                "<td >" + item.fec_resp + "</td>" +
                "<td style='width:7%;'>" + item.cup_nombre + "</td>" +
                "<td style='width:17%;'>" + item.nota + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='font-size:20px;color:" + item.color + ";'data-toggle='tooltip' data-html='true' data-placement='top' title='' data-original-title='" + item.estado + "'></i></td>" +
                "<td style='text-align:center;width:7%;'>" + item.rrhh + item.r_etiqueta+"</td>" +
                "<td style='text-align:center;'>" +
                " <a "+item.ruta+item.target+" style='"+item.cursor+item.disable+"'><b><i class='fa fa-file-pdf-o' style='font-size:18px;color:"+item.doc_c+";' data-toggle='tooltip' data-placement='left' title='' data-original-title='"+item.doc+"'></i></b></a>&nbsp;&nbsp;" +
                "<span onclick='"+item.funcion+"' style='"+item.cursorf+item.disablef+"' ><b><i class='fa fa-close' data-toggle='tooltip' data-placement='left' title='' data-original-title='"+item.estadof+"' style='font-size:18px;color:"+item.colorf+";'></i><b></span>" +
                "</td>" +
                "</tr>";
        cuerpo_total = cuerpo_total + cuerpo;
    });
    var pie = '</tbody>' + '</table>';
    var html = cabeza + cuerpo_total + pie;
     $("#scroll").empty();
    $("#scroll").append(html);
    quitaSpinnerBuscar();
}
function respuestaA(){
    buscarReporteCupones();
}

function cargarComboMatricial(data){
    var div='<div class="form-group col-md-6" id="g3"><label>Organización</label><div class="col-md-12 quita"><select id="org" class="form-control" name="org">';
    var divC='</select></div></div>';
    var cuerpo="";
    var cuerpo_total;
     $.each(data, function (index, item) {
         cuerpo="";
         if(item.org_id==item.flag_org){
        cuerpo = "<option value='"+item.org_id+"' selected>"+item.org_nombre+"</option>";
    }else{
    cuerpo = "<option value='"+item.org_id+"' >"+item.org_nombre+"</option>";
    }
        cuerpo_total = cuerpo_total+cuerpo;
    });
    var todos="<option value='0' >Todos</option>";
    var html = div+cuerpo_total+todos+divC;
    $("#oculto").html(html);
}

function respuestaAnular(data){
     spinnerSA();
    if (data[0]["vout_exito"] == '1') {
       
        respuestaA();
        

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}

function buscarReporteCupones(){
     var f2,f4,est;
    f2=$("#rfecha2").val();
    f4=$("#rfecha4").val();
    est=$("#estado").val();
    org=$("#org").val();
    spinnerBuscar();
      //  $("#scroll").append('<div class="panel-disabled"  style="heigth:700px;width:100%;"><div class="loader-1"></div></div>');

    getReporte(f2,f4,est,org);
 //  cargarDiv("#window",'vistas/com/cupones/reportes/cupones_listar.php?rfecha2='+f2+'&rfecha4='+f4+'&est_id='+est);


    
}