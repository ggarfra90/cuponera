<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class BloqueoCupones extends ModeloBase {

    const DEFAULT_ALIAS = "cupones_bloqueo";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'cupones_bloqueo';
        $this->fields = array('cup_anio', 'cup_tipo', 'usu_id', 'bloq_usu_regis', 'bloq_fec_regis');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID($ope_t,$org_id,$b_anio,$b_tipo,$usu_id,$usu_regi,$fec_regis)
     {

        $this->commandPrepare("sp_cuponera_bloqueo_operaciones");
        $this->commandAddParameter(":vin_ope", $ope_t);
        $this->commandAddParameter(":vin_org_id", $org_id);
        $this->commandAddParameter(":vin_cup_anio", $b_anio);
          $this->commandAddParameter(":vin_cup_tipo", $b_tipo);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_bloq_usu_reg", $usu_regi);
        $this->commandAddParameter(":vin_bloq_fec_reg", $fec_regis);
        return $this->commandGetData();
     }
  public function insertBloqueo($ope_t,$org_id,$b_anio,$b_tipo,$usu_id,$usu_regi)
     {

        $this->commandPrepare("sp_cuponera_bloqueo_operaciones");
        $this->commandAddParameter(":vin_ope", $ope_t);
        $this->commandAddParameter(":vin_org_id", $org_id);
        $this->commandAddParameter(":vin_cup_anio", $b_anio);
          $this->commandAddParameter(":vin_cup_tipo", $b_tipo);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_bloq_usu_reg", $usu_regi);
        return $this->commandGetData();
     }
   
     public function deleteBloqueo($ope_t,$org_id,$b_anio,$b_tipo,$usu_id,$usu_regi)
     {

        $this->commandPrepare("sp_cuponera_bloqueo_operaciones");
        $this->commandAddParameter(":vin_ope", $ope_t);
        $this->commandAddParameter(":vin_org_id", $org_id);
        $this->commandAddParameter(":vin_cup_anio", $b_anio);
          $this->commandAddParameter(":vin_cup_tipo", $b_tipo);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_bloq_usu_reg", $usu_regi);
        return $this->commandGetData();
     }
     public function getAllBloqueo($ope_t,$org_id,$b_anio,$b_tipo,$usu_id,$usu_regi)
     {

        $this->commandPrepare("sp_cuponera_bloqueo_operaciones");
        $this->commandAddParameter(":vin_ope", $ope_t);
        $this->commandAddParameter(":vin_org_id", $org_id);
        $this->commandAddParameter(":vin_cup_anio", $b_anio);
          $this->commandAddParameter(":vin_cup_tipo", $b_tipo);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_bloq_usu_reg", $usu_regi);
        return $this->commandGetData();
     }
     function getAllCupones($ope,$org_id) {
         $this->commandPrepare("sp_cupones_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
}

?>