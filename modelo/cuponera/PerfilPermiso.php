<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class PerfilPermiso extends ModeloBase {

    const DEFAULT_ALIAS = "reportes_cupones";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'reportes_cupones';
        $this->fields = array();
    }

    static function create() {
        return parent::create();
    }
    public function getPermisos($op,$usu_ad,$rol) {
         $this->commandPrepare("sp_permisos");
        $this->commandAddParameter(":vin_ope", $op);
        $this->commandAddParameter(":vin_usu_ad",$usu_ad);
        $this->commandAddParameter(":vin_rol", $rol);
        return $this->commandGetData();
    }
}

?>