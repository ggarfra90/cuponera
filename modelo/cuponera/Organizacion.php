<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Organizacion extends ModeloBase {

    const DEFAULT_ALIAS = "organizacion";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'organizacion';
        $this->fields = array('org_id', 'org_nombre', 'org_activo');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID() {
        $this->commandPrepare("sp_last_id_org");
        return $this->commandGetData();
    }
    public function functionListarOrganizacion() {
        $this->commandPrepare("sp_listar_organizacion");
        return $this->commandGetData();
        
    }
}

?>