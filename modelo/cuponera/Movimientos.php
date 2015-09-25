<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Movimientos extends ModeloBase {

    const DEFAULT_ALIAS = "movimientos";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'movimientos';
        $this->fields = array('mov_id', 'usu_id', 'mov_detalle', 'mov_fecha', 'mov_ip','mov_host');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID() {
        $this->commandPrepare("sp_last_id_Mov");
        return $this->commandGetData();
    }
  public function insertMovimientos($mov_descri,$mov_usu_id,$mov_ip,$mov_host)
     {
        $this->commandPrepare("sp_cuponera_movimientos_insertar");
        $this->commandAddParameter(":vin_usu_id", $mov_usu_id);
        $this->commandAddParameter(":vin_mov_descri", $mov_descri);
        $this->commandAddParameter(":vin_mov_ip", $mov_ip);
        $this->commandAddParameter(":vin_mov_host", $mov_host);
        return $this->commandGetData();
     }
}

?>