<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Especiales extends ModeloBase {

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
    public function functionLastID($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
     public function functionDeleteEspecial($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
    public function functionSearchEspecial($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
    public function functionGetAll($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
     
  public function insertEspeciales($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);        
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
     public function dataEditEspeciales($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);        
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
        //opcion8
      public function dataCuponEspecial($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);        
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
     public function functionAprobadorLevel($ope,$ce_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_imagen,$ce_aprobador,$org_id)
     {
        $this->commandPrepare("sp_especiales_operaciones");
           $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_cep_id", $ce_id);
        $this->commandAddParameter(":vin_cep_fec_ini", $ce_fec_ini);
        $this->commandAddParameter(":vin_cep_fec_fin", $ce_fec_fin);
        $this->commandAddParameter(":vin_cep_nombre", $ce_nombre);
        $this->commandAddParameter(":vin_cep_descri", $ce_descri);
        $this->commandAddParameter(":vin_cep_saludo", $ce_saludo);        
        $this->commandAddParameter(":vin_cep_activo", $ce_activo);
        $this->commandAddParameter(":vin_cep_imagen", $ce_imagen);
        $this->commandAddParameter(":vin_cep_aprobador", $ce_aprobador);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
     }
     
     public function listarEspeciales() {
         $this->commandPrepare("sp_listar_especiales");
         return $this->commandGetData();
     }
     public function obtenerCuponesEspecialesUso($ce_id,$apro,$apro_c) {
         $this->commandPrepare("sp_reportes_cupones_especiales_uso");
          $this->commandAddParameter(":vin_ce_id",$ce_id);
        $this->commandAddParameter(":vin_apro", $apro);
         $this->commandAddParameter(":vin_cad_apro", $apro_c);
         return $this->commandGetData();
     }
     public function obtnerAprobacionCuponesEspeciales($usu_jefe) {
        $this->commandPrepare("sp_aprobaciones_especiales_reporte");
        $this->commandAddParameter(":vin_usu_je", $usu_jefe);
        $this->commandAddParameter(":vin_usu_ge", $usu_jefe);
        return $this->commandGetData();
    }
    public function functionOperacionesAprobacionEspeciales($tipo,$mot,$cep_id,$usu_id) {
        $this->commandPrepare("sp_operaciones_aprobacion_especiales");
        $this->commandAddParameter(":vin_tipo", $tipo);
        $this->commandAddParameter(":vin_motivo", $mot);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_cep_id", $cep_id);
        return $this->commandGetData();
    }
}

?>