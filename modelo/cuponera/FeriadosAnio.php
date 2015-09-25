<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class FeriadosAnio extends ModeloBase {

    const DEFAULT_ALIAS = "movimientos";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'feriados_anio';
        $this->fields = array('feriado_id','fecha','nota','org_id');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID() {
        $this->commandPrepare("sp_last_id_Mov");
        return $this->commandGetData();
    }
    public function listarFeriadosAnio($org_id) {
        $this->commandPrepare("sp_listar_feriados_anio");
        $this->commandAddParameter(":vin_org_id",$org_id);
        return $this->commandGetData();
    }
    public function functionValidarFeriados($tipo,$anio,$org_id,$id) {
                $this->commandPrepare("sp_validar_feriados");
                $this->commandAddParameter(":vin_ope",$tipo);
        $this->commandAddParameter(":vin_anio",$anio);
                $this->commandAddParameter(":vin_org_id",$org_id);
                $this->commandAddParameter(":vin_feriado_id",$id);
        return $this->commandGetData();
    }
    public function functionInsertarFeriadosAnio($fecha,$dia,$org_id) {
                $this->commandPrepare("sp_insertar_feriados_anio");
         $this->commandAddParameter(":vin_fecha",$fecha);        
        $this->commandAddParameter(":vin_dia",$dia);
        $this->commandAddParameter(":vin_org_id",$org_id);
        return $this->commandGetData();
    }
    public function functionEliminarFeriadosAnio($anio,$org_id) {
            $this->commandPrepare("sp_eliminar_feriados_anio");   
        $this->commandAddParameter(":vin_anio",$anio);
        $this->commandAddParameter(":vin_org_id",$org_id);
        return $this->commandGetData();
    }
}

?>