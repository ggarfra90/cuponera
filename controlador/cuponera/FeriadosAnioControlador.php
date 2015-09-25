<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/FeriadosAnioNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class FeriadosAnioControlador extends ControladorBase {

    

    public function functionListarFeriadosAnio() {
        return FeriadosAnioNegocio::create()->getFeriadosAnio();
    }

    public function functionInsertarFeriadosAnio() {
        $fecha=  $this->getParametro("fecha");
        return FeriadosAnioNegocio::create()->insertFeriadosAnio($fecha);
    }
    public function functionEliminarFeriadosAnio() {
        $id=$this->getParametro("id_feriado");
        return FeriadosAnioNegocio::create()->eliminarFeriadosAnio($id);;
    }

}
