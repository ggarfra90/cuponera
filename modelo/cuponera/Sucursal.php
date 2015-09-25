<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Sucursal extends ModeloBase {

    const DEFAULT_ALIAS = "sucursales";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'sucursales';
        $this->fields = array('suc_id', 'suc_nombre', 'suc_activo', 'suc_admin', 'org_id');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID() {
        $this->commandPrepare("sp_last_id_suc");
        return $this->commandGetData();
    }
    public function functionObtenerSucursal($org_id) {
        $this->commandPrepare("sp_obtener_sucursal");
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
        
    }
}

?>