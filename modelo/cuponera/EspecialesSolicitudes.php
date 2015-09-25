<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class EspecialesSolicitudes extends ModeloBase {

    const DEFAULT_ALIAS = "cup_esp_periodos";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'cup_esp_solicitudes';
        $this->fields = array('ces_id','usu_id','cep_id','ces_estado','ces_fec_ini','ces_fec_fin',
                                'ces_dias','ces_fec_sol','ces_fec_resp','ces_usu_resp','ces_rechazo_usu',
                            'ces_usu_anul','ces_fec_anul','ces_motivo_anul');
    }

    static function create() {
        return parent::create();
    }
    public function functionLastID($ope,$usu_id,$cep_id,$ces_estado,$ces_fec_ini,$ces_fec_fin,$ces_dias,
            $ces_fec_resp,$ces_usu_resp,$ces_rechazo_usu,$ces_usu_anul,$ces_fec_anul,$ces_motivo_anul)
     {
        $this->commandPrepare("sp_especiales_solicitud_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
           $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_id", $cep_id);
           $this->commandAddParameter(":vin_ces_estado", $ces_estado);
        $this->commandAddParameter(":vin_ces_fec_ini", $ces_fec_ini);
        $this->commandAddParameter(":vin_ces_fec_fin", $ces_fec_fin);
        $this->commandAddParameter(":vin_ces_dias", $ces_dias);
        $this->commandAddParameter(":vin_ces_fec_resp", $ces_fec_resp);
        $this->commandAddParameter(":vin_ces_usu_resp", $ces_usu_resp);
        $this->commandAddParameter(":vin_ces_rechazo_usu", $ces_rechazo_usu);
        $this->commandAddParameter(":vin_ces_usu_anul", $ces_usu_anul);
        $this->commandAddParameter(":vin_ces_fec_anul", $ces_fec_anul);
           $this->commandAddParameter(":vin_ces_motivo_anul", $ces_motivo_anul);
        return $this->commandGetData();
    }
        
  public function insertEspecialesSolicitudes($ope,$usu_id,$cep_id,$ces_estado,$ces_fec_ini,$ces_fec_fin,$ces_dias,
            $ces_fec_resp,$ces_usu_resp,$ces_rechazo_usu,$ces_usu_anul,$ces_fec_anul,$ces_motivo_anul)
     {
        $this->commandPrepare("sp_especiales_solicitud_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
           $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_id", $cep_id);
           $this->commandAddParameter(":vin_ces_estado", $ces_estado);
        $this->commandAddParameter(":vin_ces_fec_ini", $ces_fec_ini);
        $this->commandAddParameter(":vin_ces_fec_fin", $ces_fec_fin);
        $this->commandAddParameter(":vin_ces_dias", $ces_dias);
        $this->commandAddParameter(":vin_ces_fec_resp", $ces_fec_resp);
        $this->commandAddParameter(":vin_ces_usu_resp", $ces_usu_resp);
        $this->commandAddParameter(":vin_ces_rechazo_usu", $ces_rechazo_usu);
        $this->commandAddParameter(":vin_ces_usu_anul", $ces_usu_anul);
        $this->commandAddParameter(":vin_ces_fec_anul", $ces_fec_anul);
           $this->commandAddParameter(":vin_ces_motivo_anul", $ces_motivo_anul);
        return $this->commandGetData();
     }
    
}

?>