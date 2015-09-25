<?php
require_once __DIR__."/../core/ModeloBase.php";
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";

/**
 * @author cheredia <cheredia@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2013, IMAGINA TECHNOLOGIES S.A.C.
 * 
 * @abstract PHPClass donde se implementará los Roles del Sistema
 */
class Rol extends ModeloBase{
    const DEFAULT_ALIAS = "rol";
    
    function __construct() {
        parent::__construct();
        $this->schema_name = Schema::adm;
        $this->table_name = 'rol';
        $this->fields = array('id','nombre','descripcion','codigo','estado','fecha_creacion',
                                'fecha_eliminacion','empresa_id','usuario_id');
    }
    
    /**
     * Crea la instancia del Rol.
     * 
     * @return Empresa
     */
    static function create()
    {
        return parent::create();
    }
        
    /**
     * Agrega el Join a la tabla RolAccion enlazada al Rol
     * 
     * @param string $aliasThis es el alias que recibe el Rol en la consulta
     * @param string $aliasForaneo es el alias que recibe el RolAccion en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useRolAccion($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = RolAccion::DEFAULT_ALIAS, $joinType = Join::left)
    {
        if ($aliasForaneo == null) $aliasForaneo = RolAccion::DEFAULT_ALIAS;
        
        return $this->useTable("id", "rolaccion", "rol_id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
    
     /**
     * Agrega el Join a la tabla UsuarioRol enlazada al Rol
     * 
     * @param string $aliasThis es el alias que recibe el Rol en la consulta
     * @param string $aliasForaneo es el alias que recibe el UsuarioRol en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useUsuarioRol($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = UsuarioRol::DEFAULT_ALIAS, $joinType = Join::left)
    {
        if ($aliasForaneo == null) $aliasForaneo = UsuarioRol::DEFAULT_ALIAS;
        
        return $this->useTable("id", "usuariorol", "rol_id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
    
}

?>
