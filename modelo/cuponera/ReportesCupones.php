<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class ReportesCupones extends ModeloBase {

    const DEFAULT_ALIAS = "cup_esp_periodos";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'cup_esp_periodos';
        $this->fields = array('cep_id','cep_fec_ini','cep_fec_fin','cep_nombre','cep_descripcion',
                               'cep_saludo','cep_activo','cep_imagen','cep_aprobador','org_id');
    }

    static function create() {
        return parent::create();
    }
    public function getReporteC($ope,$fec1,$fec2,$est,$apro,$cad,$org) {
        $this->commandPrepare("sp_cuponera_reportes");
        $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_fec_ini", $fec1);
        $this->commandAddParameter(":vin_fec_fin", $fec2);
        $this->commandAddParameter(":vin_est", $est);
        $this->commandAddParameter(":vin_apro", $apro);
        $this->commandAddParameter(":vin_cad_apro", $cad);
        $this->commandAddParameter(":vin_cad_org", $org);
        return $this->commandGetData();
    }
     public function obtenerDatosCuponUsuario($id) {
        $this->commandPrepare("sp_cuponera_cup_det_usuario");
        $this->commandAddParameter(":vin_c_id", $id);
         return $this->commandGetData();
    }
    public function obtenerDatosCupon($id) {
        $this->commandPrepare('sp_cuponera_cup_det');
        $this->commandAddParameter(":vin_c_id", $id);
         return $this->commandGetData();
    }
    public function anularCupon($id_a,$mot,$c_id) {
        $this->commandPrepare("sp_cuponera_cup_anular");
        $this->commandAddParameter("vin_usu_anul", $id_a);
        $this->commandAddParameter("vin_motivo", $mot);
        $this->commandAddParameter("vin_c_id", $c_id);
        return $this->commandGetData();

    }
    // reporte cupones especiales
     public function listarCuponEspecial($ce_id,$fec1,$fec2,$est,$apro,$cad,$q_usu) {
        $this->commandPrepare("sp_reportes_cupones_especiales");
        $this->commandAddParameter(":vin_ce_id", $ce_id);
        $this->commandAddParameter(":vin_fec_ini", $fec1);
        $this->commandAddParameter(":vin_fec_fin", $fec2);
        $this->commandAddParameter(":vin_est", $est);
        $this->commandAddParameter(":vin_apro", $apro);
        $this->commandAddParameter(":vin_cad_apro", $cad);
                $this->commandAddParameter(":vin_usu_id", $q_usu);
        return $this->commandGetData();
    }
    public function obtenerDatosCuponEspecial($id) {
        $this->commandPrepare("sp_cuponera_esp_det");
        $this->commandAddParameter(":vin_ce_id", $id);
         return $this->commandGetData();
    }
    public function obtenerDatosUsuarioCuponEspecial($usu_id) {
        $this->commandPrepare('sp_cuponera_especial_usuario');
        $this->commandAddParameter(":vin_ce_id", $usu_id);
         return $this->commandGetData();
    }
    public function anularCuponEspecial($id_a,$mot,$ce_id) {
        $this->commandPrepare("sp_cuponera_especial_anular");
        $this->commandAddParameter("vin_usu_anul", $id_a);
        $this->commandAddParameter("vin_motivo", $mot);
        $this->commandAddParameter("vin_ce_id", $ce_id);
        return $this->commandGetData();

    }
    public function listarEstadoTramite($usu_id) {
        $this->commandPrepare("sp_reporte_estado_tramite");
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        return $this->commandGetData();
    }
}

?>