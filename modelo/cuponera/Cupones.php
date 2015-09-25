<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Cupones extends ModeloBase {

    const DEFAULT_ALIAS = "cupon";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'cupones';
        $this->fields = array('cup_id', 'usu_id', 'cup_anio', 'cup_tipo', 'cup_estado','cup_fec_perm','cup_fec_perm2',
            'cup_fec_sol', 'cup_doc_attach', 'cup_fec_resp','cup_fec_hito','cup_fec_hito2','cup_vobo_rrhh','cup_part_time',
            'cup_rechazo_jefe','cup_rechazo_rrhh','cup_usu_anul','cup_fec_anul','cup_motivo_anul');
    }

    static function create() {
        return parent::create();
    }
      public function functionLastIDCup() {
        
         $this->commandPrepare("sp_last_id_Cup");
       return $this->commandGetData();
       
    }
    public function functionCuponNombre($cup_tipo) {
          $this->commandPrepare("sp_cupon_nombre");
        $this->commandAddParameter(":vin_cup_tipo", $cup_tipo);
        return $this->commandGetData();
    }
     public function functionOrg($sucu) {
        
         $this->commandPrepare("sp_cuponera_cupon_org");
        $this->commandAddParameter(":vin_sucu", $sucu);
       return $this->commandGetData();
       
    }
    public function functionCupNum($sucu) {
        
         $this->commandPrepare("sp_cuponera_cupon_num");
        $this->commandAddParameter(":vin_sucu", $sucu);
        return $this->commandGetData();
    }
    
     public function functionCupTipo($org) {
        
         $this->commandPrepare("sp_cuponera_cup_tipo");
        $this->commandAddParameter(":vin_id_org", $org);
        return $this->commandGetData();
    }
    public function functionCupBloqueo($a,$t,$ua) {
        
         $this->commandPrepare("sp_cuponera_cupon_bloqueo");
         $this->commandAddParameter(":vin_anio", $a);
        $this->commandAddParameter(":vin_tipo", $t);
        $this->commandAddParameter(":vin_usu", $ua);
        return $this->commandGetData();
    }
    public function functionCupVeri($t,$a,$ua) {
        
         $this->commandPrepare("sp_cuponera_cup_verifica");
         $this->commandAddParameter(":vin_cup_tipo", $t);
         $this->commandAddParameter(":vin_cup_anio", $a);
        $this->commandAddParameter(":vin_usu_id", $ua);
        return $this->commandGetData();
    }
    public function functionComboEspe($u,$f,$org) {
         $this->commandPrepare("sp_cup_especialies");
         $this->commandAddParameter(":vin_usu_id", $u);
         $this->commandAddParameter(":vin_fecha", $f);
         $this->commandAddParameter(":vin_org_id", $org);
         return $this->commandGetData();
    }
    public function functionDatosCupon($t){
        $this->commandPrepare("sp_cuponera_cup_datos");
         $this->commandAddParameter(":vin_id_tipo", $t);
         return $this->commandGetData();
    }
     public function functionFeriados($t,$anio) {
        $this->commandPrepare("sp_cuponera_feriados");
        $this->commandAddParameter(":vin_tipo", $t);
         $this->commandAddParameter(":vin_anio", $anio);
         return $this->commandGetData();
    }
    //falta agregar validacion para organizacion!!!
       public function functionPuente($t,$anio,$u,$org_id) {
        $this->commandPrepare("sp_cupones_puente");
        $this->commandAddParameter(":vin_tipo", $t);
         $this->commandAddParameter(":vin_anio", $anio);
         $this->commandAddParameter(":vin_id", $u);
         $this->commandAddParameter(":vin_org_id", $org_id);
         return $this->commandGetData();
    }
    
    public function functionDisP($anio,$org_id){
        $this->commandPrepare("sp_cuponera_dipu_disponibles");
        $this->commandAddParameter(":vin_anio", $anio);
                 $this->commandAddParameter(":vin_org_id", $org_id);

        return $this->commandGetData();
    }
    public function functionDisU($usu_id,$anio,$org_id) {
        $this->commandPrepare("sp_cuponera_dipu_usados");
        $this->commandAddParameter(":vin_usu_id",$usu_id);
        $this->commandAddParameter(":vin_anio",$anio);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
    public function functionComboPuente($org_id) {
        $this->commandPrepare("sp_cupones_listado_dia_puente");
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
   public function functionEstadoVerifica($usu_id,$anio,$fec_perm,$fec_perm2,$es,$cup_tipo) {
        $this->commandPrepare("sp_cupones_matri_vali");
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_anio", $anio);
         $this->commandAddParameter(":vin_fec_perm", $fec_perm);
         $this->commandAddParameter(":vin_fec_perm2", $fec_perm2);
         $this->commandAddParameter(":vin_estado", $es);
         $this->commandAddParameter(":vin_tipo", $cup_tipo);
        return $this->commandGetData();
    }
    public function functionDiasOcupados($usu_id,$anio) {
        $this->commandPrepare("sp_cupones_dias_ocupados");
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_anio", $anio);
         
        return $this->commandGetData();
    }
     public function functionEstadoSolicitudes($fec_ini,$fec_fin,$usu_id) {
        $this->commandPrepare("sp_cupones_estado_solicitudes");
        $this->commandAddParameter(":vin_fec_ini", $fec_ini);
        $this->commandAddParameter(":vin_fec_fin", $fec_fin);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
         
        return $this->commandGetData();
    }
    public function functionVacacionesEstado($fec_ini,$fec_fin,$usu_id) {
        $this->commandPrepare("sp_vacaciones_estado");
        $this->commandAddParameter(":vin_fec_ini", $fec_ini);
        $this->commandAddParameter(":vin_fec_fin", $fec_fin);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
         
        return $this->commandGetData();
    }
     public function functionObtenerCorreo($usu_ad) {
        $this->commandPrepare("sp_cuponera_correo_usuario");
        $this->commandAddParameter(":vin_usu_ad", $usu_ad);
         
        return $this->commandGetData();
    }
     public function functionJefes($usu_ad,$tipo_o) {
        $this->commandPrepare("sp_cupon_jefes");
        $this->commandAddParameter(":vin_usu_ad", $usu_ad);
         $this->commandAddParameter(":vin_tipo", $tipo_o);
        return $this->commandGetData();
    }
     public function functionAdministradores($tipo_o) {
        $this->commandPrepare("sp_cupon_Administradores");
         $this->commandAddParameter(":vin_tipo", $tipo_o);
        return $this->commandGetData();
    }
      public function functionDiasOcupadoCEspeciales($usu_id,$cep_id) {
        $this->commandPrepare("sp_Dias_Usados_C_Especial");
         $this->commandAddParameter(":vin_usu_id", $usu_id);
         $this->commandAddParameter(":vin_cep_id", $cep_id);
        return $this->commandGetData();
    }
    public function insertCupones($cup_usu_id,$cup_anio,$cup_tipo,$cup_fec_perm,$cup_fec_perm2,$cup_doc,$cup_fec_hito,$cup_fec_hito2,$cup_part_time)
     {
        $this->commandPrepare("sp_cuponera_cupones_insertar");
        $this->commandAddParameter(":vin_usu_id", $cup_usu_id);
        $this->commandAddParameter(":vin_cup_anio", $cup_anio);
        $this->commandAddParameter(":vin_cup_tipo", $cup_tipo);
        $this->commandAddParameter(":vin_cup_fec_perm", $cup_fec_perm);
        $this->commandAddParameter(":vin_cup_fec_perm2", $cup_fec_perm2);
        $this->commandAddParameter(":vin_cup_doc", $cup_doc);
        $this->commandAddParameter(":vin_cup_fec_hito", $cup_fec_hito);
        $this->commandAddParameter(":vin_cup_fec_hito2", $cup_fec_hito2);
        $this->commandAddParameter(":vin_cup_part_time", $cup_part_time);
        return $this->commandGetData();

        }
        
        public function functionNombreUsu($usu_id) {
         $this->commandPrepare("sp_cuponera_usu_nombre");
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        return $this->commandGetData();
    }
    public function functionFechaPrimeraSolicitudCupEsp($ope,$usu_id) {
        
        $this->commandPrepare("sp_fechaPrimeraSolicitudCupEsp");
        $this->commandAddParameter(":vin_ope", $ope);
        $this->commandAddParameter(":vin_ce_id", $usu_id);
        return $this->commandGetData();
    }
    public function obtnerAprobacionCupones($usu_jefe,$org_id) {
        $this->commandPrepare("sp_reporte_aprobacion_cupon");
        $this->commandAddParameter(":vin_usu_jefe", $usu_jefe);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
    public function functionOperacionesAprobacion($tipo,$mot,$cup_id,$usu_id) {
        $this->commandPrepare("sp_operaciones_aprobacion");
        $this->commandAddParameter(":vin_tipo", $tipo);
        $this->commandAddParameter(":vin_mot", $mot);
        $this->commandAddParameter(":vin_cup_id", $cup_id);
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        return $this->commandGetData();
    }
    public function functionAprobacionDatos($cup_id) {
        $this->commandPrepare("sp_aprobacion_cupones_datos");
        $this->commandAddParameter(":vin_cup_id", $cup_id);
        return $this->commandGetData();
    }
     public function functionAprobacionDatosEspeciales($usu_id) {
        $this->commandPrepare("sp_aprobacion_cupones_especiales_datos");
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        return $this->commandGetData();
    }
     public function obtnerAprobacionVistoBueno($org_id) {
        $this->commandPrepare("sp_listar_visto_bueno");
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
    public function functionOperacionesVistoBueno($tipo,$mot,$cup_id) {
        $this->commandPrepare("sp_operaciones_visto_bueno");
        $this->commandAddParameter(":vin_tipo", $tipo);
        $this->commandAddParameter(":vin_mot", $mot);
        $this->commandAddParameter(":vin_cup_id", $cup_id);
        return $this->commandGetData();
    }
    public function functionverificaPuenteCombo($anio,$org_id) {
         $this->commandPrepare("sp_cuponera_puente_verifica");
                 $this->commandAddParameter(":vin_cup_anio", $anio);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
}

?>