

function insertCupones(fecha2,fecha4)
{    
   
    acciones.iniciaAjaxTest(COMPONENTES.CUPON, "cuponOpcion");
        ax.setAccion("insertCuponesPT");
        ax.addParamTmp("fecha2", fecha2);
        ax.addParamTmp("turno", fecha4);

        ax.consumir();
   
    
}
function cuponOpcion(response) {
    
    if (response['status'] === 'ok') {
        switch (response[PARAM_ACCION_NAME]) {
         
            case 'insertCuponesPT':
                CargaRespuesta(response.data);
                break;
          
        }
    }
}
function guardarCuponesPT()
{
    spinner();
    var fecha2 = document.getElementById('fecha2').value;
    var fecha_4=document.getElementById('fecha4').value;
  
    
    insertCupones(fecha2,fecha_4);
     
}
function PaginaRespuesta(){
    cargarDiv("#window","vistas/com/cupones/pati/respuestaCupon.php");
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

