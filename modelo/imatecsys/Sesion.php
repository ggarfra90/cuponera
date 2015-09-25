<?php

require_once __DIR__."/../core/ModeloBase.php";

/**
 * Description of Sesion
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */

class Sesion extends ModeloBase {
    function __construct() {
        parent::__construct();
        
        // agregamos los parametros iniciales para la clase
        $this->schema_name = Schema::adm;
        $this->table_name = 'sesion';
        $this->fields = array('id', 'usuario_id','sid', 'direccion_ip',
            'navegador', 'nombre_cookie', 'fecha_inicio', 'fecha_cierre', 
            'fecha_ultimoacceso', 'estado', 'zona_horaria');
        
        // asignamos sus relaciones 
        $this->setConfigRelated("SesionDetalle", "sesion_id");
        
    }
    
    /**
     * 
     * @return Sesion
     */
    static function create()
    {
        return parent::create();
    }
    
    public function filterSesionesByUsuarioId($usuario_id){
        return $this->whereAdd(Array(ElementoSQL::first_col => "usuario_id",
                                    ElementoSQL::val => $usuario_id));
    }
    
    /**
     * Cierra todas las sesiones del usuario
     * @param type $usuario_id
     * @return boolean
     */
    public function cierraSesion($usuario_id){
        $this->beginUpdate();
        $this->data["estado"] = 0;
        
        return $this->whereAdd(Array(ElementoSQL::first_col => "usuario_id",
                                    ElementoSQL::val => $usuario_id))
                    ->updateRecord();
    }
    
    public function updUltimoAcceso($usuario_id){
        $this->beginUpdate();
        $this->data["fecha_ultimoacceso"] = date('Y-m-d H:i:s', time());
        
        return $this->whereAdd(Array(ElementoSQL::first_col => "usuario_id",
                                    ElementoSQL::val => $usuario_id))
                    ->whereAdd(Array(ElementoSQL::first_col => "estado",
                                    ElementoSQL::val => 1));
        
        return $this->updateRecord();
    }
    
    public function getSesionById($sid, $estado = 1){
        return $this->clearSQL()
                ->whereAdd(Array(ElementoSQL::first_col => 'sid',
                                ElementoSQL::first_alias => 'tab',
                                ElementoSQL::val => $sid))
                ->whereAdd(Array(ElementoSQL::first_col => 'estado',
                                ElementoSQL::first_alias => 'tab',
                                ElementoSQL::val => $estado))
                ->getEntity();
    }
    
    public function getSesionUltimoAccesoById($sid){
        return $this->clearSQL()
                ->whereAdd(Array(ElementoSQL::first_col => 'sid',
                                ElementoSQL::first_alias => 'tab',
                                ElementoSQL::val => $sid))
                ->getEscalar("fecha_ultimoacceso");
    }
}

?>
