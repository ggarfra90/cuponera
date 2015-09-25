<?php
require_once __DIR__."/../core/ModeloBase.php";
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";
require_once __DIR__."/espacioTrabajo/EspacioTrabajo.php";
require_once __DIR__."/Accion.php";
require_once __DIR__."/RolAccion.php";
require_once __DIR__."/../sbssys/ComponenteInstancia.php";
require_once __DIR__."/../sbsadm/EspacioTrabajoInstancia.php";

/**
 * @author cheredia <cheredia@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2013, IMAGINA TECHNOLOGIES S.A.C.
 * 
 * @abstract PHPClass donde se implementará el la tabla (RolAccion) que relaciona el Rol con la Accion de el Sistema
 */
class RolAccion extends ModeloBase{
    const DEFAULT_ALIAS = "rolaccion";
    const PERMISO_DENEGADO = "0";
    const PERMISO_CONCEDIDO= "1";
    function __construct() {
        parent::__construct();
        $this->schema_name = Schema::adm;
        $this->table_name = 'rolaccion';
        $this->fields = array('id','rol_id','accion_id','componenteinstancia_id','espaciotrabajo_id',
                                'permiso','fecha_creacion','usuario_creacion','fecha_eliminacion');
    }
    
    /**
     * Crea la instancia del RolAccion.
     * 
     * @return Empresa
     */
    static function create()
    {
        return parent::create();
    }
      
    /**
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function filterByPermiso($permiso = self::PERMISO_CONCEDIDO)
    {
       
        return $this->whereAdd("espaciotrabajo_id", "espaciotrabajo", "id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
    
    /**
     * Agrega el Join a la tabla EspacioTrabajo  enlazada al RolAccion
     * 
     * @param string $aliasThis es el alias que recibe el RolAccion en la consulta
     * @param string $aliasForaneo es el alias que recibe el EspacioTrabajo en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useEspacioTrabajo($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = EspacioTrabajo::DEFAULT_ALIAS, $joinType = Join::left)
    {
        if ($aliasForaneo == null) $aliasForaneo = EspacioTrabajo::DEFAULT_ALIAS;
        
        return $this->useTable("espaciotrabajo_id", "espaciotrabajo", "id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
    
    /**
     * Agrega el Join a la tabla Rol enlazada al RolAccion
     * 
     * @param string $aliasThis es el alias que recibe el RolAccion en la consulta
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
    
    /**
     * Agrega el Join a la tabla Accion enlazada al RolAccion
     * 
     * @param string $aliasThis es el alias que recibe el RolAccion en la consulta
     * @param string $aliasForaneo es el alias que recibe la Accion en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useAccion($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = Accion::DEFAULT_ALIAS, $joinType = Join::left)
    {
        if ($aliasForaneo == null) $aliasForaneo = Accion::DEFAULT_ALIAS;
        
        return $this->useTable("accion_id", "accion", "id", Schema::adm, $aliasForaneo, $aliasThis, $joinType);
    }
      
    public function useComponenteInstancia($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = ComponenteInstancia::DEFAULT_ALIAS, $joinType = Join::inner)
    {
        if ($aliasForaneo == null) $aliasForaneo = ComponenteInstancia::DEFAULT_ALIAS;
        
        return $this->useTable("componenteinstancia_id", "componenteinstancia", "id", Schema::sys, $aliasForaneo, $aliasThis, $joinType)
                    ->useTable("id", "espaciotrabajoinstancia", "componenteinstancia_id", Schema::adm, EspacioTrabajoInstancia::DEFAULT_ALIAS, $aliasForaneo, $joinType);
    }
}

?>
