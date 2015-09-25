/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function insertCupones(fecha,fecha_cump)
{    
    
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
        ax.setAccion("insertCupones");
        ax.addParamTmp("fecha2", fecha);
        ax.addParamTmp("fecha_cump", fecha_cump);
        ax.consumir();
   
    
}
function cuponOpcion(response) {
    
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
         
            case 'insertCupones':
                CargaRespuesta(response.data);
                break;
          
        }
    }
}
function guardarCupones()
{
    spinner();
    var fecha = document.getElementById('fecha2').value;
    var fecha_cump=document.getElementById('cump').value;
    insertCupones(fecha,fecha_cump);
     
}
//function PaginaRespuesta(){
//    cargarDiv("#window","vistas/com/cupones/cump/respuestaCupon.php");
//}
function CargaRespuesta(response){
    if(response[0]['vout_exito']=='1'){
        quitaSpinner();
       // PaginaRespuesta();
    }
    if(response[0]['vout_exito']==0){
         jQuery.each(response, function (index, value) {
                $.Notification.autoHideNotify('warning', 'right top', 'ERROR', value.vout_mensaje);
                });
        quitaSpinner();
    }
}