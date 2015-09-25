/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function insertCupones(fecha_b,fecha4,fecha6,fname,fsize,ftype,file)
{    
   
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
        ax.setAccion("insertCuponesM");
        ax.addParamTmp("fecha_b", fecha_b);
        ax.addParamTmp("fecha4", fecha4);
        ax.addParamTmp("fecha6", fecha6);
        ax.addParamTmp("fname", fname);
        ax.addParamTmp("fsize", fsize);
        ax.addParamTmp("ftype", ftype);
        ax.addParamTmp("file", file);
        ax.consumir();
   
    
}
function cuponOpcion(response) {
    
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
         
            case 'insertCuponesM':
                CargaRespuesta(response.data);
                break;
          
        }
    }
}
function guardarCuponesM()
{
    spinner();
    var fecha_b = document.getElementById('fecha2').value;
    var fecha_4=document.getElementById('fecha4').value;
    var fecha_6=document.getElementById('fecha6').value;
    var fname=document.getElementById('fname').value;
    var fsize=document.getElementById('fsize').value;
    var ftype=document.getElementById('ftype').value;
   var file = document.getElementById('secretImg').value;

    insertCupones(fecha_b,fecha_4,fecha_6,fname,fsize,ftype,file);
     
}
function PaginaRespuesta(){
    cargarDiv("#window","vistas/com/cupones/matri/respuestaCupon.php");
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
}/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


