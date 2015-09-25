<?php

require_once __DIR__.'/../core/ModeloBase.php';
//require_once __DIR__.'../core/ModeloBase.php';
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Login
 *
 * @author JSC7
 */
class Servicio extends ModeloBase{
    
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
        
    
    
    public function getDataServicio() {
        $this->commandPrepare("sp_serv_listar_servicios");
        return $this->commandGetData();
    }
     public function insertServicio($descripcion, $fec_inicio, $fec_fin, $comentario, $estado,$visible,$usu_creacion)
     {
        $this->commandPrepare("sp_serv_insertar_servicio");
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_fec_inicio", $fec_inicio);
        $this->commandAddParameter(":vin_fec_fin", $fec_fin);
        $this->commandAddParameter(":vin_comentario", $comentario);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visible", $visible);
        $this->commandAddParameter(":vin_usu_creacion", $usu_creacion);
        return $this->commandGetData();
     }
    
    public function getServicio($id) {
        $this->commandPrepare("sp_serv_obtener_servicio_por_id");
        $this->commandAddParameter(":vin_servicio_id", $id);
        return $this->commandGetData();
    }

    public function updateServicio($id_servicio,$descripcion,$fec_inicio,$fec_fin,$comentario,$estado)
     {
        $this->commandPrepare("sp_serv_actualizar_servicio");
        $this->commandAddParameter(":vin_id", $id_servicio);
        $this->commandAddParameter(":vin_descripcion", $descripcion);
        $this->commandAddParameter(":vin_fec_inicio", $fec_inicio);
        $this->commandAddParameter(":vin_fec_fin", $fec_fin);
        $this->commandAddParameter(":vin_comentario", $comentario);
        $this->commandAddParameter(":vin_estado", $estado);
        return $this->commandGetData();
     }
        public function deleteServicio($id) {
        $this->commandPrepare("sp_serv_eliminar_servicio");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }
}
