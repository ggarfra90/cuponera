<?php

require_once __DIR__ . "/../core/ModeloBase.php";
require_once __DIR__ . "/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Perfil
 *
 * @author JSC7
 */
class Colaborador extends ModeloBase {

    const DEFAULT_ALIAS = "colaborador";

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
    public function getDataColaborador() {
        $this->commandPrepare("sp_col_listar_colaboradores");
        return $this->commandGetData();
    }
    
     public function insertColaborador($dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion,$ref_direccion,$usuario,$estado,$visible,$file) {
        $this->commandPrepare("sp_col_insertar_colaborador");
        $this->commandAddParameter(":vin_dni", $dni);
        $this->commandAddParameter(":vin_nombre", $nombre);
        $this->commandAddParameter(":vin_paterno", $paterno);
        $this->commandAddParameter(":vin_materno", $materno);
        $this->commandAddParameter(":vin_telefono", $telefono);
        $this->commandAddParameter(":vin_celular", $celular);
        $this->commandAddParameter(":vin_email", $email);
        $this->commandAddParameter(":vin_direccion", $direccion);
        $this->commandAddParameter(":vin_ref_direccion", $ref_direccion);
        $this->commandAddParameter(":vin_usuario", $usuario);
        $this->commandAddParameter(":vin_estado", $estado);
        $this->commandAddParameter(":vin_visible", $visible);
        $this->commandAddParameter(":vin_file", $file);
        return $this->commandGetData();
    }  
    public function getColaborador($id) {
        $this->commandPrepare("sp_col_obtener_colaborador_por_id");
        $this->commandAddParameter(":vin_perfil_id", $id);
        return $this->commandGetData();
    }
     public function updateColaborador($id,$dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion,$ref_direccion,$estado) {
        $this->commandPrepare("sp_col_actualizar_colaborador");
        $this->commandAddParameter(":vin_id", $id);
        $this->commandAddParameter(":vin_dni", $dni);
        $this->commandAddParameter(":vin_nombre", $nombre);
        $this->commandAddParameter(":vin_paterno", $paterno);
        $this->commandAddParameter(":vin_materno", $materno);
        $this->commandAddParameter(":vin_telefono", $telefono);
        $this->commandAddParameter(":vin_celular", $celular);
        $this->commandAddParameter(":vin_email", $email);
        $this->commandAddParameter(":vin_direccion", $direccion);
        $this->commandAddParameter(":vin_ref_direccion", $ref_direccion);
        $this->commandAddParameter(":vin_estado", $estado);
        return $this->commandGetData();
    }  
    
     public function deleteColaborador($id) {
        $this->commandPrepare("sp_col_eliminar_colaborador");
        $this->commandAddParameter(":vin_id", $id);
        return $this->commandGetData();
    }

    
    
}
?>