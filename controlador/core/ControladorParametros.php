<?php

/**
 * Description of ControladorParametros
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */
class ControladorParametros {
    const FORMAT_JSON = "json_ajax";
    const FORMAT_JSON_EASYUI = "json_easyui";
    const FORMAT_OBJECT = "object";
    const FORMAT_DOWNLOAD = "download";
    const CURRENT_CULTURE = 'es_pe';
    const RESPONSE_ERROR = 'error';
    const RESPONSE_ERROR_PHP = 'error_php';
    const RESPONSE = 'response';
    
    var $params;
    var $requestType;
    
    var $componenteId;
    var $accion;
//    var $usu;
    var $sid;
    var $tag;
    
    public function getParametros(){
        return $this->params;
    }
    
    public function getRequestType(){
        return $this->requestType;
    }
    
    public function setParametros($value){
        $this->params = $value;
    }
    
    public function addParametro($key, $value){
        $this->params[$key] = $value;
    }
    
    public function getParametro($key){
        if (!array_key_exists($key, $this->params)) return NULL;
        if (ObjectUtil::isEmpty($this->params[$key])) return NULL;
        return $this->params[$key];
    }
    
    public function __construct(){
        $this->params = FALSE;
        $params = NULL;
        $this->requestType = self::FORMAT_JSON;
        
        // validamos si la peticion es ajax para que autamaticamente se ejecute 
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            /* si es un llamado ajax
             * es decir, para nuestro caso el llamado mediante jquery, javascript o jeasyui 
             * pasa por aqui
             */
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET': $params = $_GET;
                    break;
                case 'POST': $params = $_POST;
                    break;
                default :
                    return FALSE;
            }
            
//            $this->decodificaParametros();
        } else {
            $params = file_get_contents("php://input");
            $params = (array)json_decode($params); 
        }
        
        if (ObjectUtil::isEmpty($params) || count($params) < 3) return;

        if (!(array_key_exists(Configuraciones::PARAM_COMPONENTE_ID, $params) 
                && array_key_exists(Configuraciones::PARAM_ACCION_NAME, $params)
                && array_key_exists(Configuraciones::PARAM_SID, $params)
//                    && array_key_exists(Configuraciones::PARAM_USU, $params)
                ))
            return FALSE;
        if (ObjectUtil::isEmpty($params[Configuraciones::PARAM_COMPONENTE_ID])  
                || ObjectUtil::isEmpty(Configuraciones::PARAM_ACCION_NAME)
                || ObjectUtil::isEmpty(Configuraciones::PARAM_SID)
//                    || ObjectUtil::isEmpty(Configuraciones::PARAM_USU)
                )
            return FALSE;
        $this->componenteId=$params[Configuraciones::PARAM_COMPONENTE_ID];
        $this->accion=$params[Configuraciones::PARAM_ACCION_NAME];
        $this->sid=$params[Configuraciones::PARAM_SID];
//            $this->usu=$params[Configuraciones::PARAM_USU];
        $this->tag = array_key_exists(Configuraciones::PARAM_TAG, $params)? $params[Configuraciones::PARAM_TAG]:NULL;
        $this->params = array();
        foreach ($params as $key => $value) {
            if ($key != Configuraciones::PARAM_ACCION_NAME 
                    && $key != Configuraciones::PARAM_COMPONENTE_ID 
                    && $key != Configuraciones::PARAM_TAG
                    && $key != Configuraciones::PARAM_SID
//                        && $key != Configuraciones::PARAM_USU
                    )
                $this->params[$key] = isset($value) ? $value : NULL;
        }
    }
    
    /**
     * Valido la cookie de la sesion real con la de los parametros
     * @param type $params
     * @return boolean
     * @throws \WarningException
     */
    public function getCookieParam() {
        // Verificamos si existe el nombre de cookie en el browser 
        try {
            if (!isset($_COOKIE[Configuraciones::COOKIE_NAME_SID])) 
                throw new \CriticalException("No cuenta con una sesión válida o su sesión a expirado"); // la coockie no existe
            if ($_COOKIE[Configuraciones::COOKIE_NAME_SID] !== $this->sid)
                throw new \CriticalException("No cuenta con una sesión válida"); // la coockie no existe
            return $this->sid;
        } catch (Exception $e) {
            // la cookie no existe
            throw new \CriticalException("Error en la sesión");
        }

        // Comparamos el sid que lo obtenemos remotamente con el sid de la peticion
        if ($_COOKIE[Configuraciones::COOKIE_NAME_SID] !== $sid) {
            // No coinciden los sids
            throw new \CriticalException("La sesión esta corrupta");
        }
        return $sid;
    }
    
    /**
     * @author Christopher Heredia Lozada
     * 
     * Decodifica los valores enviados en el $param (solo los del primer nivel)
     * Formatea los campos de tipo string a utf8.
     * @param type $params
     * @return type
     */
    private function decodificaParametros(){
        foreach ($this->params as $key => $value)
            $this->params[$key] = (is_string($value))? utf8_decode($value) : $value;
    }
}
?>
