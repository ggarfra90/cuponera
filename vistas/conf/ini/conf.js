
var ax = new Ajaxp(URL_EXECUTECONTROLLER, 'POST', 'JSON');

window.onload = function () {
    if (confirm("¿Desea iniciar la carga de configuraciones iniciales?") == true) {
        // Iniciamos los componentes
        acciones.iniciaAjax(COMPONENTES.SEGURIDAD);
        ax.addParamTmp(PARAM_ACCION_NAME, 'confIniDetPerMap');
        ax.consumir();
    } else {
        window.location.replace("../../../");
    }
}

function onResponseAjaxp(target, response) {
    setTimeout(function(){ window.location.replace("../../../"); }, 6000);
}