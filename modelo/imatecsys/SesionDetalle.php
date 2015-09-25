<?php

/**
 * Administra los detalles de la sesión de cada usuario
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */

class SesionDetalle extends ModeloBase{
    function __construct() {
        parent::__construct();
        $this->schema_name = Schema::adm;
        $this->table_name = 'sesiondetalle';
        $this->fields = array('id', 'sesion_id', 'data', 'fecha_creacion');
        $this->sid = NULL;
    }
}

?>
