<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Asignaciones extends ModeloBase {

    const DEFAULT_ALIAS = "cup_esp_asignaciones";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'cup_esp_asignaciones';
        $this->fields = array('cep_id','usu_id','cea_dias');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID($ope,$cep_id,$usu_id,$cea_dias){
        $this->commandPrepare("sp_especiales_asignaciones_operaciones");
        $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cep_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);
         return $this->commandGetData();
    }
     public function functionDeleteAsignaciones($ope,$cep_id,$usu_id,$cea_dias){
        $this->commandPrepare("sp_especiales_asignaciones_operaciones");
        $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cep_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);
         return $this->commandGetData();
    }
    public function functionSearchAsignaciones($ope,$cea_id,$usu_id,$cea_dias){
         $this->commandPrepare("sp_especiales_asignaciones_operaciones");
         $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cea_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);

         return $this->commandGetData();
    }
   public function functionCombo($ope,$cea_id,$usu_id,$cea_dias){
         $this->commandPrepare("sp_especiales_asignaciones_operaciones");
         $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cea_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);

         return $this->commandGetData();
    }
    public function functionGetAll($ope,$cea_id,$usu_id,$cea_dias){
         $this->commandPrepare("sp_especiales_asignaciones_operaciones");
         $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cea_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);

         return $this->commandGetData();
    }
  public function insertAsignaciones($ope,$cea_id,$usu_id,$cea_dias)
     {
        $this->commandPrepare("sp_especiales_asignaciones_operaciones");
        $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cea_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);
        return $this->commandGetData();
     }
     //opcion8
     public function DiasCuponAsignado($ope,$cea_id,$usu_id,$cea_dias)
     {
        $this->commandPrepare("sp_especiales_asignaciones_operaciones");
        $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $cea_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_dias", $cea_dias);
        return $this->commandGetData();
     }
}

?>