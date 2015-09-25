<?php

/**
 * Configurations: Constantes que comparten tanto la vista como el controlador
 * @version 1.0
 * @author Christopher Heredia <cheredia@imaginatecperu.com>
 */

class Configuraciones 
{
    // *******************************************************************************
    // - CONFIGURACION A CAMBIAR EN CADA SITIO WEB.
    // *******************************************************************************
    const COOKIE_NAME_SID = "imaginatecperu_sid";
    // *******************************************************************************
    
    const TIME_OUT = 2592000; //60*60*24*30 = 2'592,000 = 30 dias
    const TIPO_SUPERUSUARIO = 0;
    const SBS_DEBUG = "itc-debug";
    const PARAM_SID = "param_sid";
    const PARAM_USU = "param_usu";
    const PARAM_TAG = "tag";
    const PARAM_COD_AD = "param_cod_ad";
    
    const DEFAULT_CULTURE = 'es_pe';
    
    const PARAM_ACCION_NAME = "action_name";
    const PARAM_COMPONENTE_ID = "param_componente_id";
    
    const PARAM_CRITERIOS_BUSQUEDA = "criterios_busqueda";
    
    const PAGE_NUMBER = 'pageNumber';
    const PAGE_SIZE = 'pageSize';
    
    const PARAM_CONTEXT_FUNCTIONS = 'contextFunctions';
    const PATH_IMG_PDF = "controlador/commons/generadorPdf/plantillas/images/";
    const PARAM_COMPONENT_ID = 'componentId'; // Id del componente generado por el desarrollador
    
    // Representan los parametros que se usaran para obtener los labels dinamicamente
    const PARAM_GET_LABELS = "get_labels";
    const RESPONSE_LABELS = 'labels';
    
    // Parametros para obtener los labels de varios controles
    const PARAM_GET_LABELS_CONTROLS = 'get_labels_controls'; // parametro donde se pasaran los codigos de los controles de los que se quiere obtener sus labels.
    const PARAM_LABELS_CONTROLS = 'labels_controls'; // parametro donde se pasaran los LABELS de los controles que se especificaron sus codigos.
    
    const PARAM_GET_ACCIONES_SEGURIDAD = 'get_acciones_seguridad'; // parámetro que se le pasa al controlador para que me devuelva las acciones por el rol de usuario
    const PARAM_CAMPOS_GRILLA = 'configuraciones_campos_grilla'; // Configuraciones del espacio del Control por Espacio de Trabajo que contiene los  Campos a mostrar en la grilla
    const PARAM_CAMPOS_FORMULARIO = 'configuraciones_campos_formulario'; // Configuraciones del espacio del Control por Espacio de Trabajo que contiene los  Campos a mostrar en el formulario
    const PARAM_CONTROLES_MOSTRAR = 'configuraciones_controles_mostrar';  // Configuraciones del espacio del Control por Espacio de Trabajo que contiene los  Controles dependientes a mostrar
    const RESPONSE_CONFIGURACIONES_ESPACIO_TRABAJO = 'configuraciones_espacio_trabajo';
    const RESPONSE_ACCIONES_SEGURIDAD = 'acciones_seguridad';
    
    const PARAM_TIME_ZONE = 'param_time_zone';
    
    const CLASIFICACION_TICKET_ESTUDIO = 51; // Enumerado de la clasificaion del ticket
    const CLASIFICACION_TICKET_EVENTO = 46; // Enumerado de la clasificaion del ticket
    const MODO_ESTUDIO_ID = 39;
    const MODO_EVENTO_ID = 38;
    
    const MENSAJE_ERROR = 'error';
    const MENSAJE_WARNING = 'warning';
    const MENSAJE_INFORMATION = 'info';
    const MENSAJE_OK = 'success';
    
    const RESPONSE_MENSAJE_EMERGENTE = "response_mensaje_emergente";
    const RESPONSE_MENSAJE_EMERGENTE_MODAL = "response_mensaje_emergente_modal";
    const RESPONSE_MENSAJE_EMERGENTE_MENSAJE = "response_mensaje_emergente_mensaje";
    const UPLOAD_FOLDER = "uploads";
    const UPLOAD_NAME = "upload_file";
    const IMG_PDF_DIR = "vistas/images/netafimboletas.jpg";
    // Metodos 
    public static function url_base(){
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parse = parse_url($url);
        return "http://".$parse['host']."/cuponera/";
    }
}   
?>