/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var MENSAJE_ERROR = 'error';
var MENSAJE_WARNING = 'warning';
var MENSAJE_INFORMATION = 'info';
var MENSAJE_OK = 'success';

var MENSAJE_CALLBACK_ONSHOW = 'onShow';
var MENSAJE_CALLBACK_ONAFFTERSHOW = 'afterShow';
var MENSAJE_CALLBACK_ONCLOSECLICK = 'onCloseClick';
var MENSAJE_CALLBACK_ONCLOSED = 'onClose';

function mostrarError(mensaje){
    mostrarMensajeNoty("Error", mensaje, MENSAJE_ERROR);
}
function mostrarAdvertencia(mensaje){
    mostrarMensajeNoty("Validación", mensaje, MENSAJE_WARNING);
}
function mostrarInformacion(mensaje){
    mostrarMensajeNoty("Información", mensaje, MENSAJE_INFORMATION);
}
function mostrarOk(mensaje){
    mostrarMensajeNoty("Ok", mensaje, MENSAJE_OK);
}
function mostrarMensajeNoty(titulo, mensaje, tipo, callback, callback_tipo, ajaxp, modal){
    if (isEmpty(tipo)) tipo = MENSAJE_OK;
    if (isEmpty(modal)) modal = true;
    var objMensaje = new Object();
//    objMensaje.text = "<b>"+titulo+": </b>"+mensaje;
    $.Notification.autoHideNotify(tipo, 'top right', titulo, mensaje);
//    switch(tipo){
//        case MENSAJE_OK:
//            $.Notification.autoHideNotify('success', 'top right', 'Ok',mensaje);
////            objMensaje.type = 'success';
////            objMensaje.timeout = 5000;
////            objMensaje.modal = false;
////            objMensaje.layout = 'topRight';
//            break;
//        case MENSAJE_WARNING:
//            objMensaje.type = 'warning';
//            objMensaje.timeout = 5000;
//            objMensaje.modal = modal;
//            objMensaje.layout = 'top';
//            break;
//        case MENSAJE_INFORMATION:
//            objMensaje.type = 'information';
//            objMensaje.timeout = 5000;
//            objMensaje.modal = modal;
//            objMensaje.layout = 'top';
//            break;
//        case MENSAJE_ERROR:
//            objMensaje.type = 'error';
//            objMensaje.timeout = false;
//            objMensaje.modal = modal;
//            objMensaje.layout = 'top';
//            break;
//        default:
//            objMensaje.type = 'alert';
//            break;
//    }
    if (!isEmpty(callback)){
//        if (!isEmpty(callback_tipo)){
//            objMensaje.callback = new Object();
//            objMensaje.callback[callback_tipo] = callback;
//        }
//        else{
//            objMensaje.callback = {afterShow: callback};
//            //console.log(callback_tipo);
//        }
        callback;
    }else if (!isEmpty(ajaxp)){
        objMensaje.callback = {onShow: ajaxp.eventoMensajeOnShow,
                                afterShow: ajaxp.eventoMensajeAfterShow,
                                onCloseClick: ajaxp.eventoMensajeOnCloseClick,
                                onClose: ajaxp.eventoMensajeOnClose};
    }
//    noty(objMensaje);
}

