<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class DiaPuenteAnio extends ModeloBase {

    const DEFAULT_ALIAS = "dia_puente_anio";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'dia_puente_anio';
        $this->fields = array('dia_puente_id','anio','disponibles','org_id');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID() {
        $this->commandPrepare("sp_last_id_Mov");
        return $this->commandGetData();
    }
    public function functionListarPuenteAnio() {
        $this->commandPrepare("sp_cuponera_puente_anio");
        return $this->commandGetData();
    }
    public function functionVerificarAnioPuente($anio,$org_id) {
            $this->commandPrepare("sp_cuponera_puente_validar_anio");   
        $this->commandAddParameter(":vin_anio",$anio);
        $this->commandAddParameter(":vin_org_id",$org_id);
        return $this->commandGetData();
    }
    public function functionInsetarDiaAnioPuente($anio,$dias,$org_id) {
        $this->commandPrepare("sp_cuponera_puente_insertar");
        $this->commandAddParameter(":vin_anio", $anio);
        $this->commandAddParameter(":vin_dias",$dias);
        $this->commandAddParameter(":vin_org_id",$org_id);
        return $this->commandGetData();
    }
    public function functionEditarDiaAnioPuente($dias,$dp_id) {
        $this->commandPrepare("sp_cuponera_puente_editar");   
        $this->commandAddParameter(":vin_dias",$dias);
        $this->commandAddParameter(":vin_dp_id",$dp_id);
        return $this->commandGetData();
    }
    public function functionEliminarDiaAnioPuente($dp_id) {
        $this->commandPrepare("sp_cuponera_puente_eliminar");   
        $this->commandAddParameter(":vin_dp_id",$dp_id);
        return $this->commandGetData();
    }
}

?>