<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/BloqueoCuponesNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class BloqueoCuponControlador extends ControladorBase {

    public function functionInsertBloqueo() {
        $usu_id=  $this->getParametro("usu_id"); 
        $cup_tipo=  $this->getParametro("cup_id");
        
       
        return BloqueoCuponesNegocio::create()->functionInsertBloqueoC($cup_tipo,$usu_id);
    }
    public function functionDeleteBloqueo() {
        $cup_anio=  $this->getParametro("cup_anio");
        $cup_tipo=  $this->getParametro("cup_tipo");
        $usu_id=  $this->getParametro("usu_id");
        return BloqueoCuponesNegocio::create()->functionDeleteBloqueoC($cup_anio,$cup_tipo,$usu_id);
    }
    public function getAllBloqueo() {
        
        return BloqueoCuponesNegocio::create()->getDataBloqueo();
    
        
    }
    public function getAllUsuarios() {
        
        return BloqueoCuponesNegocio::create()->getDataUsuarios();
    }
    public function getAllCupones() {
        return BloqueoCuponesNegocio::create()->getDataCupones();
    }
}
