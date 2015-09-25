<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/SucursalNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class SucursalControlador extends ControladorBase {

    public function functionObtenerSucursal() {
        $org_id=  $this->getParametro("org_id");
        $id=$this->getParametro("id_suc");
        return SucursalNegocio::create()->getObtenerSucursal($org_id,$id);
    }
    
}
