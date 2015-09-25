<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/MovimientosNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class MovimientoControlador extends ControladorBase {

    public function insertMovimientos($mov_descri,$mov_usu_id,$mov_ip,$mov_host) {
        
        return MovimientosNegocio::create()->insertMovimiento($mov_descri,$mov_usu_id,$mov_ip,$mov_host);
    }
    
}
