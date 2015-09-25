<?php

require_once __DIR__.'/../core/ModeloBase.php';
//require_once __DIR__.'../core/ModeloBase.php';
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Login
 *
 * @author JSC7
 */
class Unidad extends ModeloBase{
    
    const DEFAULT_ALIAS = "usuario";
    public function __construct() {
        parent::__construct();
        $this->schema_name = Schema::cbp;
        $this->table_name = 'usuario';
        $this->fields = array('id', 'persona_id', 'usuario', 'clave',
            'estado', 'visible', 'fec_creacion', 'usu_creacion');
    }
    
    static function create()
    {
       return parent::create();
    }
    public function getDataUnidadTipo() {
        $this->commandPrepare("sp_uni_listar_unidad_tipo");
        return $this->commandGetData();
    }
     public function insertUnidadTipo($descripcion,$codigo, $comentario, $estado,$visible,$usu_creacion)
     {
        $this->commandPrepare("sp_uni_insertar_unidad_tipo");
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_codigo", $codigo);
        $this->commandAddParameter(":vin_comentario", $comentario);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visible", $visible);
        $this->commandAddParameter(":vin_usu_creacion", $usu_creacion);
        return $this->commandGetData();
     }
    
    public function getUnidadTipo($id) {
        $this->commandPrepare("sp_uni_obtener_unidad_tipo_por_id");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }

    public function updateUnidadTipo($id,$descripcion,$codigo,$comentario,$estado)
     {
        $this->commandPrepare("sp_uni_actualizar_unidad_tipo");
        $this->commandAddParameter(":vin_id", $id);
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_codigo", $codigo);
        $this->commandAddParameter(":vin_comentario", $comentario);
        $this->commandAddParameter(":vin_estado", $estado);
        return $this->commandGetData();
     }
        public function deleteUnidadTipo($id) {
        $this->commandPrepare("sp_uni_eliminar_unidad_tipo");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }
    
    ////////////////////////////
    //unidad
    //////////////////////////
     public function getDataUnidad() {
        $this->commandPrepare("sp_uni_listar_unidad");
        return $this->commandGetData();
    }
     public function insertUnidad($descripcion, $codigo, $tipo,$simbolo,$estado, $visible, $usu_creacion,$factor)
     {
        $this->commandPrepare("sp_uni_insertar_unidad");
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_codigo", $codigo);
        $this->commandAddParameter(":vin_tipo", $tipo);
        $this->commandAddParameter(":vin_simbolo", $simbolo);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visible", $visible);
        $this->commandAddParameter(":vin_usu_creacion", $usu_creacion);
        $this->commandAddParameter(":vin_factor", $factor);
        return $this->commandGetData();
     }
    
    public function getUnidad($id) {
        $this->commandPrepare("sp_uni_obtener_unidad_por_id");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }

    public function updateUnidad($id,$descripcion,$codigo,$tipo,$simbolo,$estado,$factor)
     {
        $this->commandPrepare("sp_uni_actualizar_unidad");
        $this->commandAddParameter(":vin_id", $id);
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_codigo", $codigo);
        $this->commandAddParameter(":vin_tipo", $tipo);
        $this->commandAddParameter(":vin_simbolo", $simbolo);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_factor", $factor);
        return $this->commandGetData();
     }
        public function deleteUnidad($id) {
        $this->commandPrepare("sp_uni_eliminar_unidad");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }
}
