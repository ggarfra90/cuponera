<?php

/**
 * Description of ControladorErrores
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */

//require_once __DIR__ . '/../../modelo/sbssys/IdiomaContenido.php';
require_once __DIR__ . '/../../util/ObjectUtil.php';

class ControladorErrores {
    const CURRENT_CULTURE = 'es_pe';
    
    public $has_error_php = FALSE;
    public $has_error = FALSE;
    
    private $error_tipo;
    private $last_error;
    private $titulo;
    private $modal = true;
    
    public function getTitulo(){
        return $this->titulo;
    }
    public function getModal(){
        return $this->modal;
    }
    public function getError(){
        return $this->last_error;
    }
    public function getErrorTipo(){
        return $this->error_tipo;
    }

// <editor-fold defaultstate="collapsed" desc="Metodos principales">
    public function __construct(){
        //Inicializo las variables de errores
        $this->has_error = FALSE;
        $this->last_error = "";
    }
    
    
    /**
     * Metodo encargado de preparar el mensaje de error hacia el Usuario
     * 
     * @param string|integer $value Cadena de error o clave del error
     * @param IdiomaContenidoTipo $type Es el tipo de Error definido en el sistema
     * 
     * @author Christopher Heredia <cheredia@imaginatecperu.com>
     * 
     */
    public function responseError($error_object, $type) {
        $this->has_error = TRUE;
        $this->error_tipo = $type;
        $this->titulo = $error_object->getTitulo();
        $this->last_error = $error_object->getMessage();
        $this->modal = $error_object->getModal();
    }
// </editor-fold>
    
// <editor-fold defaultstate="collapsed" desc="Métodos de apoyo">
// </editor-fold>
}
?>
