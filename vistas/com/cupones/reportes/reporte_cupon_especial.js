
function confirmarAnularCuponEspecial(id){
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
        
  anularCuponEspecial(id,inputValue,101);
    });
    
}
function listarComboEspecial(){
    acciones.iniciaAjaxTest(COMPONENTES.ESPECIALES,"opcionReporteEspecial")
    ax.setAccion('getComboEspecial');
    ax.consumir();
}
function anularCuponEspecial(id,mot,op){
    spinnerAR();
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporteEspecial");
    ax.addParam("ce_id",id);
    ax.addParam("motivo",mot);
    ax.addParam("opcion",op);
    ax.setAccion("anularCuponEspecial");
    ax.consumir();
}
function getReporteCuponEspecial(ce_id,fec1,fec2,est,usu)
{
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "opcionReporteEspecial");
    ax.addParam("ce_id",ce_id);
    ax.addParam("fecha_ini",fec1);
    ax.addParam("fecha_fin",fec2);
    ax.addParam("est",est);
    ax.addParam("usu_id",usu);
    ax.setAccion("getReporteCuponEspecial");
    ax.consumir();
   
}

function opcionReporteEspecial(response){
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            case 'getComboEspecial':
                onResponseAjaxpGetDataComboEspecial(response.data);
                break;
            case 'getReporteCuponEspecial':
             onResponseAjaxpGetDataReporteCuponEspecial(response.data);
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
            case 'anularCuponEspecial':
                respuestaAnularEspecial(response.data);
                break;
                
        }
    }
}
function onResponseAjaxpGetDataReporteCuponEspecial(data){
     var cuerpo_total = '';
    var cuerpo = '';
    var cabeza = '<table id="datatable" class="table table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th>Colaborador</th>' +
            '<th>Periodo</th>' +
            '<th>Inicio</th>' +
            '<th>Fin</th>' +
            '<th>D&iacute;as</th>' +
            '<th>Fechas solicitud</th>' +
            '<th>Fecha aprobaci&oacute;n</th>' +
            '<th>Notas</th>' +
            '<th>Estado</th>' +
            '<th>Acc</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
    $.each(data, function (index, item) {
        cuerpo = "<tr>" +
                "<td >" + item.usu_nombre + "</td>" +
                "<td >" + item.cep_nombre + "</td>" +
                "<td >" + item.ces_fec_ini + "</td>" +
                "<td >" + item.ces_fec_fin + "</td>" +
                "<td>" + item.ces_dias + "</td>" +
                "<td >" + item.ces_fec_sol + "</td>" +
                "<td >" + item.ces_fec_respu + "</td>" +
                "<td >" + item.nota + "</td>" +
                "<td style='text-align:center;'><i class='" + item.icono + "' style='font-size:20px;color:" + item.color + ";'data-toggle='tooltip' data-html='true' data-placement='top' title='' data-original-title='" + item.estado + "'></i></td>" +
                "<td style='text-align:center;'>" +
                "<span onclick='"+item.funcion+"' style='"+item.cursorf+"' ><b><i class='fa fa-close' data-toggle='tooltip' data-placement='left' title='' data-original-title='"+item.estadof+"' style='font-size:18px;color:"+item.colorf+";'></i><b></span>" +
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
function respuestaEspecialA(){
    buscarReporteCuponesEspecial();
}



function respuestaAnularEspecial(data){
     spinnerSA();
    if (data[0]["vout_exito"] == '1') {
       
        respuestaEspecialA();
        

    } else {
        $(".confirm").removeProp("disabled");
        $(".cancel").removeProp("disabled");
        swal("Upss...", "Error:" + "Al procesar la solicitud", "error");
    }
}

function buscarReporteCuponesEspecial(){
     var f2,f4,est,id;
    id=$("#id").val();
    f2=$("#rfecha2").val();
    f4=$("#rfecha4").val();
    est=$("#estado").val();
    est=$("#usu_id").val();
    
    spinnerBuscar();
   getReporteCuponEspecial(id,f2,f4,est);
  
}
function onResponseAjaxpGetDataComboEspecial(data) {
    var cuerpo_total = '';
    var cuerpo = '';
        var cabeza='<option value="255" >Todos</option>';

    $.each(data, function (index, item) {
       
        cuerpo = "<option  value='"+item.cep_id+"'>"+item.cep_nombre+": "+item.cep_descripcion +" (Vence: "+dia_semana(item.cep_fec_fin)+")</option>";
        cuerpo_total = cuerpo_total+cuerpo;
    });
    var html = cabeza+cuerpo_total;

    $("#id").append(html);
}