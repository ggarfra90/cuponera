<?php
require_once __DIR__.'/Connection.php';
require_once __DIR__.'/../../util/Configuraciones.php';
require_once __DIR__.'/../../util/ObjectUtil.php';
/**
 * Description of CommonsPersistence
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */
class CommonsPersistence {
     private $base_mensaje;
    
    /**
     * @var Connection 
     */
    public $c;
    private static $hInstance;
    
    function __construct() {
        $this->c = new Connection();
        $this->base_mensaje = null;
    }
    
    public static function create() {
        if (!(self::$hInstance instanceof self)) {
            self::$hInstance = new self();
        }
        return self::$hInstance;
    }
    
    /**
     * Seteo de mensaje personalizado en caso todo haya ocurrido correctamente.
     * 
     * @param int $clave Clave de tipo  MENSAJE EMERGENTE | TOOLTIP (12)
     * 
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     */
    public function setMensajeEmergente($mensaje, $concatenacion, $tipo){
        $titulo = "";
        switch ($tipo){
            case Configuraciones::MENSAJE_OK:
                $titulo = "Confirmación";
                if (ObjectUtil::isEmpty($mensaje)) $mensaje = 'Ok';
                break;
            default :
                $titulo = "Validación";
                break;
        }
        $this->base_mensaje = array('titulo' => "Confirmación", 'mensaje' => $mensaje, 'tipo' => $tipo);
    }
    
    /**
     * Obteniendo el mensaje personalizado en caso todo haya ocurrido correctamente.
     * 
     * @param int $clave Clave de tipo  MENSAJE EMERGENTE | TOOLTIP (12) de la tabla Idioma contenido 
     * 
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     */
    public function getMensajeEmergente(){
        return $this->base_mensaje;
    }
}
