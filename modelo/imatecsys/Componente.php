<?php
require_once __DIR__."/../core/ModeloBase.php";
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";

/**
 * @author Christopher Heredia <cheredia@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 *
 * @abstract Clase donde se implementará el Componente
 */
class Componente extends ModeloBase {
    
    const DEFAULT_ALIAS = "componente";
    
    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::sys;
        $this->table_name = 'componente';
        $this->fields = array('id', 'nombre', 'codigo', 'descripcion', 'estado', 
                              'controlador_url', 'controlador_nombre');
    }
    
    /**
     * Crea la instancia del Componente.
     *
     * @return Componente
     */
    static function create()
    {
       return parent::create();
    }
    
    /**
     * Obtiene un componente en base al código
     * 
     * @param string $codigo El código en el componente
     * @param ComponenteTipo $tipo Es el tipo de componente a solicitar
     * @return DataTable
     */
    public function getComponenteById($id){
        //En caso nos piden que filtremos ademas por el tipo
        $this->disponible()
             ->whereAdd(Array(ElementoSQL::first_col => "id",
                              ElementoSQL::val => $id));
        return $this->getEntity();
    }
}
?>