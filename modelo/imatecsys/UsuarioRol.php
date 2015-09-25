<?php
require_once __DIR__."/../core/ModeloBase.php";
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";

/**
 * @author cheredia <cheredia@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2013, IMAGINA TECHNOLOGIES S.A.C.
 * 
 * @abstract PHPClass donde se implementará la relacion de loa usuarios con los roles (UsuarioRol) del Sistema
 */
class UsuarioRol extends ModeloBase{
    const DEFAULT_ALIAS = "usuariorol";
    
    function __construct() {
        parent::__construct();
        $this->schema_name = Schema::adm;
        $this->table_name = 'usuariorol';
        $this->fields = array('usuario_id','rol_id','fecha_creacion','usuariocreador_id');
    }
    
    /**
     * Crea la instancia de la UsuarioRol.
     * 
     * @return UsuarioRol
     */
    static function create()
    {
        return parent::create();
    }
        
    /**
     * Agrega el Join a la tabla Usuario enlazada al UsuarioRol
     * 
     * @param string $aliasThis es el alias que recibe el UsuarioRol en la consulta en la consulta
     * @param string $aliasForaneo es el alias que recibe el Usuario en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useUsuario($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = Usuario::DEFAULT_ALIAS, $joinType = Join::left)
    {
        if ($aliasForaneo == null) $aliasForaneo = Usuario::DEFAULT_ALIAS;
        
        return $this->useTable("usuario_id", "usuario", "id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
    
    /**
     * Agrega el Join a la tabla Rol enlazada al UsuarioRol
     * 
     * @param string $aliasThis es el alias que recibe el UsuarioRol en la consulta en la consulta
     * @param string $aliasForaneo es el alias que recibe el Rol en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useRol($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = Rol::DEFAULT_ALIAS, $joinType = Join::left)
    {
        if ($aliasForaneo == null) $aliasForaneo = Rol::DEFAULT_ALIAS;
        
        return $this->useTable("rol_id", "rol", "id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
    
}

?>
