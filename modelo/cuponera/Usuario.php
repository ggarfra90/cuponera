<?php

require_once __DIR__ . '/../core/ModeloBase.php';
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";
require_once __DIR__ . "/../core/ConnectionMSSQL.php";


/**
 * Description of Login
 *
 * @author JSC7
 */
class Usuario extends ModeloBase {

    const DEFAULT_ALIAS = "usuarios";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'usuarios';
        $this->fields = array('usu_id', 'usu_ad', 'usu_nombre', 'usu_nivel', 'usu_estado', 'usu_jefe', 'usu_gerente',
            'cup_clase', 'usu_rol', 'usu_clave', 'usu_correo', 'suc_id');
    }

    static function create() {
        return parent::create();
    }

    public function getAllUsuarios($ope) {
        $this->commandPrepare("sp_usuario_operaciones");
        $this->commandAddParameter(":vin_ope", $ope);
        return $this->commandGetData();
    }

    public function validateLogin($usuario) {
        $this->commandPrepare("sp_validar_login");
        $this->commandAddParameter(":vin_usu_ad", $usuario);
        return $this->commandGetData();
    }
    public function validateLoginWP($usuario) {
        $this->commandPrepare("sp_validar_login_cms_wp");
        $this->commandAddParameter(":vin_usu_ad", $usuario);
        return $this->commandGetData();
    }

    public function getUsuarioID($usuario) {
        $this->commandPrepare("sp_cuponera_obtener_id_usuario");
        $this->commandAddParameter(":pusuario", $usuario);
        return $this->commandGetData();
    }

    public function getDataUsuario($mtr, $org_id) {
        $this->commandPrepare("sp_listar_usuario");
        $this->commandAddParameter(":vin_mtr", $mtr);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }

    
    public function getDataUsuarioCombo($op, $org_id) {
        $this->commandPrepare("sp_obtener_usuario_org");
        $this->commandAddParameter(":vin_op", $op);
        $this->commandAddParameter(":vin_org_id", $org_id);
        return $this->commandGetData();
    }
    public function functionValidarUsuarioAd($usu_ad) {
        $this->commandPrepare("sp_usuario_usu_ad_validar");
        $this->commandAddParameter(":vin_usu_ad", $usu_ad);
        return $this->commandGetData();
    }
    public function insertarUsuario($usu_nombre, $usu_ad, $usu_nivel, $usu_estado, $usu_jefe, $usu_gerente, $usu_jefe_matricial, $usu_clase, $usu_rol, $usu_clave, $usu_correo, $suc_id, $usu_fec_cump, $usu_cargo, $usu_matricial) {
        $this->commandPrepare("sp_usuario_insertar");
        $this->commandAddParameter(":vin_usu_ad", $usu_ad);
        $this->commandAddParameter(":vin_usu_nombre", $usu_nombre);
        $this->commandAddParameter(":vin_usu_nivel", $usu_nivel);
        $this->commandAddParameter(":vin_usu_estado", $usu_estado);
        $this->commandAddParameter(":vin_usu_jefe", $usu_jefe);
        $this->commandAddParameter(":vin_usu_gerente", $usu_gerente);
        $this->commandAddParameter(":vin_usu_jefe_matricial", $usu_jefe_matricial);
        $this->commandAddParameter(":vin_cup_clase", $usu_clase);
        $this->commandAddParameter(":vin_usu_rol", $usu_rol);
        $this->commandAddParameter(":vin_usu_clave", $usu_clave);
        $this->commandAddParameter(":vin_usu_correo", $usu_correo);
        $this->commandAddParameter(":vin_suc_id", $suc_id);
        $this->commandAddParameter(":vin_usu_fec_cump", $usu_fec_cump);
        $this->commandAddParameter(":vin_usu_cargo", $usu_cargo);
        $this->commandAddParameter(":vin_usu_matricial", $usu_matricial);
        return $this->commandGetData();
    }
       public function editarUsuario($usu_id,$usu_nombre, $usu_ad, $usu_nivel, $usu_estado, $usu_jefe, $usu_gerente, $usu_jefe_matricial, $usu_clase, $usu_rol, $usu_clave, $usu_correo, $suc_id, $usu_fec_cump, $usu_cargo, $usu_matricial) {
        
        $this->commandPrepare("sp_usuario_editar");
        $this->commandAddParameter(":vin_usu_id", $usu_id);
        $this->commandAddParameter(":vin_usu_ad", $usu_ad);
        $this->commandAddParameter(":vin_usu_nombre", $usu_nombre);
        $this->commandAddParameter(":vin_usu_nivel", $usu_nivel);
        $this->commandAddParameter(":vin_usu_estado", $usu_estado);
        $this->commandAddParameter(":vin_usu_jefe", $usu_jefe);
        $this->commandAddParameter(":vin_usu_gerente", $usu_gerente);
        $this->commandAddParameter(":vin_usu_jefe_matricial", $usu_jefe_matricial);
        $this->commandAddParameter(":vin_cup_clase", $usu_clase);
        $this->commandAddParameter(":vin_usu_rol", $usu_rol);
        $this->commandAddParameter(":vin_usu_clave", $usu_clave);
        $this->commandAddParameter(":vin_usu_correo", $usu_correo);
        $this->commandAddParameter(":vin_suc_id", $suc_id);
        $this->commandAddParameter(":vin_usu_fec_cump", $usu_fec_cump);
        $this->commandAddParameter(":vin_usu_cargo", $usu_cargo);
        $this->commandAddParameter(":vin_usu_matricial", $usu_matricial);
        return $this->commandGetData();
    }
    public function functionObtenerXId($id) {
        $this->commandPrepare("sp_usuario_obtener_x_id");
        $this->commandAddParameter(":vin_usu_id", $id);
        return $this->commandGetData();
    }
    public function deleteUsuario($id) {
        $this->commandPrepare("sp_usuario_eliminar");
        $this->commandAddParameter(":vin_usu_id", $id);
        return $this->commandGetData();
    }
    
    public function obtenerCodigoGeneral($user){
        $mssql = new ConnectionMSSQL();
        $rs = $mssql->ejecutar("select IDCODIGOGENERAL from PERSONAL_VARIABLES where IDVARIABLE = 'USR' AND VALOR ='".$user."'");
        $response = array();
        while (!$rs->EOF) {
            $val = new stdClass();
            $val->idcodigogeneral = utf8_encode($rs->Fields->Item('IDCODIGOGENERAL')->value);
            array_push($response, $val);
            $rs->MoveNext();
        }
        $mssql->close();
        return $response;
    }
    public function obtenerFechaCumpleaños($idcodigo) {
        $mssql = new ConnectionMSSQL();
        $rs = $mssql->ejecutar("select FECHA_NACIMIENTO from PERSONAL_GENERAL where IDCODIGOGENERAL ='".$idcodigo."'");
        $response = array();
        while (!$rs->EOF) {
            $val = new stdClass();
            $val->fec_cump = utf8_encode($rs->Fields->Item('FECHA_NACIMIENTO')->value);
            array_push($response, $val);
            $rs->MoveNext();
        }
        $mssql->close();
        return $response;
    }
}
