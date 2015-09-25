<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/DiaPuenteNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class DiaPuenteControlador extends ControladorBase {

    public function functionListarDiaPuente() {
        
        return DiaPuenteNegocio::create()->getDiaPuenteAnio();
    }

    public function functionNumeroDiaPuente() {
        $anio=  $this->getParametro("anio");
        if($anio==''|| $anio==NaN){
            $anio='';
        }
        return DiaPuenteNegocio::create()->getDiaPuente($anio);
    }
    public function functionValidaDiaPuente() {
        $anio=  $this->getParametro("anio");
        
        return DiaPuenteNegocio::create()->getDiaPuente($anio);
    }
    public function functionEditarDiaPuente() {
        $anio=  $this->getParametro("anio");
        $dias=  $this->getParametro("dias");
        $dp_id=  $this->getParametro("dp_id");
        $dia_ant=  $this->getParametro("dia_ant");
        return DiaPuenteNegocio::create()->functionEditarDiaPuente($anio,$dias,$dp_id,$dia_ant);
    }
    public function functionEliminarDiaPuente() {
        $anio=  $this->getParametro("anio");
        $dias=  $this->getParametro("dias");
        $dp_id=  $this->getParametro("dp_id");
        return DiaPuenteNegocio::create()->functionEliminarDiaPuente($anio,$dias,$dp_id);
    }
    public function functionInsertDiaPuenteAnio() {
        $anio=  $this->getParametro("anio");
        $dias=  $this->getParametro("dias");
        return DiaPuenteNegocio::create()->insertDiaPuenteAnio($anio,$dias);
    }

}
