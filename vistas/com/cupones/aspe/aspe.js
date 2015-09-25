/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function ComboPuente(){

    acciones.iniciaAjaxTest(COMPONENTES.CUPONES, "cuponOpcion");
    ax.setAccion("getComboPuente");
    ax.consumir();
}




function insertCupones(fecha)
{    
    
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
        ax.setAccion("insertCuponesA");
        ax.addParamTmp("fecha2", fecha);
        ax.consumir();
   
    
}
function cuponOpcion(response) {
    
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
         
            case 'insertCuponesA':
                CargaRespuesta(response.data);
                break;
          
        }
    }
}
function guardarCuponesA()
{
    spinner();
    var fecha = document.getElementById('fecha2').value;

    insertCupones(fecha);
     
}
function PaginaRespuesta(){
    cargarDiv("#window","vistas/com/cupones/aspe/respuestaCupon.php");
}S
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