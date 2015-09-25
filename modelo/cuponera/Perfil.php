<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Perfil extends ModeloBase {

    const DEFAULT_ALIAS = "perfil";

    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'perfil';
        $this->fields = array('id', 'codigo', 'nombre', 'descripcion', 'estado',
            'visible', 'fec_creacion', 'usu_creacion');
    }

    static function create() {
        return parent::create();
    }

    public function getMenuPadreUsuario($perfil_id) {
        $this->commandPrepare("sp_seg_obtener_menup_perfil");
        $this->commandAddParameter(":vin_perfil_id", $perfil_id);
        return $this->commandGetData();
    }

    public function getMenuHijoUsuario($opcion_id_predecesor, $perfil_id) {

        $this->commandPrepare("sp_seg_obtener_menuh_perfil");
        $this->commandAddParameter(":vin_predecesor_id", $opcion_id_predecesor);
        $this->commandAddParameter(":vin_perfil_id", $perfil_id);
        return $this->commandGetData();
    }

    public function getDataPerfil() {
        $this->commandPrepare("sp_seg_listar_perfil");
        return $this->commandGetData();
    }

    public function insertPerfil($codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $visible, $usuario, $pant_principal) {
        $this->commandPrepare("sp_seg_insertar_perfil");
        $this->commandAddParameter(":vin_codigo", $codigo);
        $this->commandAddParameter(":vin_nombre", $nombre);
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visible", $visible);
        $this->commandAddParameter(":vin_dashboard", $dashboard);
        $this->commandAddParameter(":vin_email", $email);
        $this->commandAddParameter(":vin_monetaria", $monetaria);
        $this->commandAddParameter(":vin_usu_creacion", $usuario);
        $this->commandAddParameter(":vin_pant_principal", $pant_principal);
        return $this->commandGetData();
    }

    public function getPerfil($id) {
        $this->commandPrepare("sp_seg_obtener_perfil_por_id");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }

    public function updatePerfil($id, $codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $pant_principal) {
        $this->commandPrepare("sp_seg_actualizar_perfil");
        $this->commandAddParameter(":vin_id", $id);
        $this->commandAddParameter(":vin_codigo", $codigo);
        $this->commandAddParameter(":vin_nombre", $nombre);
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_dashboard", $dashboard);
        $this->commandAddParameter(":vin_email", $email);
        $this->commandAddParameter(":vin_monetaria", $monetaria);
        $this->commandAddParameter(":vin_pant_principal", $pant_principal);
        return $this->commandGetData();
    }

    public function deletePerfil($id) {
        $this->commandPrepare("sp_seg_eliminar_perfil");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }

    public function getMenuPadre() {
        $this->commandPrepare("sp_seg_obtener_menup");
        return $this->commandGetData();
    }

    public function getMenuHijo($opcion_id_predecesor) {
        $this->commandPrepare("sp_seg_obtener_menuh_usuario2");
        $this->commandAddParameter(":vin_predecesor_id", $opcion_id_predecesor);
        return $this->commandGetData();
    }

    public function insertDetOpcPerfil($id_per, $id_opcion, $estado, $visible, $id_usu) {
        $this->commandPrepare("sp_seg_insertar_det_opc_perfil");
        $this->commandAddParameter(":vin_perifl_id", $id_per);
        $this->commandAddParameter(":vin_opcion_id", $id_opcion);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visibilidad", $visible);
        $this->commandAddParameter(":vin_usuario_id", $id_usu);
        return $this->commandGetData();
    }

    public function getDetOpcPer($id_perfil) {
        $this->commandPrepare("sp_seg_obtener_opcion_por_perfil");
        $this->commandAddParameter(":vin_perifl_id", $id_per);
    }

    public function updateDetOpcPerfil($id_per, $id_opcion, $estado) {
        $this->commandPrepare("sp_seg_update_det_opc_perfil");
        $this->commandAddParameter(":vin_perfil_id", $id_per);
        $this->commandAddParameter(":vin_opcion_id", $id_opcion);
        $this->commandAddParameter(":vin_estado", $estado);
        return $this->commandGetData();
    }

    public function insertDetUsuarioPerfil($id_usuario, $id_perfil, $usu_creacion, $estado, $visible) {
        $this->commandPrepare("sp_seg_insertar_det_usu_perfil");
        $this->commandAddParameter(":vin_usuario_id", $id_usuario);
        $this->commandAddParameter(":vin_perfil_id", $id_perfil);
        $this->commandAddParameter(":vin_usu_creacion", $usu_creacion);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visible", $visible);
        return $this->commandGetData();
    }
    
    public function obtenerPantallaPrincipal($id)
    {
        $this->commandPrepare("sp_seg_optener_pantalla_principal");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }
}

?>