/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function insertCupones(fecha2)
{    
   
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
        ax.setAccion("insertCuponesP");
        ax.addParamTmp("fecha2", fecha2);
        
        ax.consumir();
   
    
}
function ComboPuente(){

    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
    ax.setAccion("getComboPuente");
    ax.consumir();
}
function cuponOpcion(response) {
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
            
                case 'getComboPuente':
                onResponseAjaxpGetDataComboPuente(response.data);
                break;
                   case 'insertCuponesP':
                CargaRespuesta(response.data);
                break;
        }
    }
}
function onResponseAjaxpGetDataComboPuente(data) {
    var cuerpo_total = '';
    var cuerpo = '';
    $.each(data, function (index, item) {
        cuerpo = "<option value='"+item.id+"'>"+item.fecha+"</option>";
        cuerpo_total = cuerpo_total+cuerpo;
    });
    var html = cuerpo_total;

    $("#fecha2").append(html);
}
function guardarCuponesP()
{
    spinner();
    var fecha2 = document.getElementById('fecha2').value;
   insertCupones(fecha2);
     
}
function PaginaRespuesta(){
    cargarDiv("#window","vistas/com/cupones/grad/respuestaCupon.php");
}
function CargaRespuesta(response){
    if(response[0]['vout_exito']=='1'){
        quitaSpinner();
      PaginaRespuesta();
    }
    if(response[0]['vout_exito']==0){
         jQuery.each(response, function (index, value) {
                $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
                });
        quitaSpinner();
    }
}