/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function insertCupones(fecha2,fecha4,fecha6,fname,fsize,ftype,file)
{    
   
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
        ax.setAccion("insertCuponesG");
        ax.addParamTmp("fecha4", fecha4);
        ax.addParamTmp("fecha6", fecha6);
        ax.addParamTmp("fname", fname);
        ax.addParamTmp("fsize", fsize);
        ax.addParamTmp("ftype", ftype);
        ax.addParamTmp("fecha2", fecha2);
         ax.addParamTmp("file", file);
        ax.consumir();
   
    
}
function cuponOpcion(response) {
    
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
         
            case 'insertCuponesG':
                CargaRespuesta(response.data);
                break;
          
        }
    }
}
function guardarCuponesG()
{
    spinner();
    var fecha2 = document.getElementById('fecha2').value;
    var fecha_4=document.getElementById('fecha4').value;
    var fecha_6=document.getElementById('fecha6').value;
    var fname=document.getElementById('fname').value;
    var fsize=document.getElementById('fsize').value;
    var ftype=document.getElementById('ftype').value;
   var file = document.getElementById('secretImg').value;
 
    insertCupones(fecha2,fecha_4,fecha_6,fname,fsize,ftype,file);
     
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
