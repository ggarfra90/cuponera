<?php

require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/EspecialesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/AsignacionesNegocio.php';



class AsignacionesControlador extends ControladorBase {
    public function getDataGridAsignaciones() {
        $cep_id=  $this->getParametro("cep_id");
        return AsignacionesNegocio::create()->getDataAsignaciones($cep_id);
    }
    public function SearchDatoEspecial(){
        $cep_id=  $this->getParametro("cep_id");
        return EspecialesNegocio::create()->SearchEspecial($cep_id);
    }
    public function functionDeleteAsignaciones() {
        $cep_id=  $this->getParametro("cep_id");
        $usu_id=  $this->getParametro("usu_id");
        return AsignacionesNegocio::create()->functionDeleteAsignaciones($cep_id,$usu_id);
    }
    public function functionInsertAsignaciones() {
        $cep_id=  $this->getParametro("cep_id");
        $usu_id=  $this->getParametro("usu_id");
        $cea_dias=  $this->getParametro("cea_dias");
        return AsignacionesNegocio::create()->functionInsertAsignaciones($cep_id,$usu_id,$cea_dias);
    }
    public function functionEditAsignaciones() {
        $cep_id=  $this->getParametro("cep_id");
        $usu_id=  $this->getParametro("usu_id");
        $cea_dias=  $this->getParametro("cea_dias");
        return AsignacionesNegocio::create()->functionEditarAsignaciones($cep_id,$usu_id,$cea_dias);
    }
    public function functionCombo() {
        $cep_id=$this->getParametro("cep_id");
                return AsignacionesNegocio::create()->functionComboAsig($cep_id);

    }
    public function functionCombo2() {
        $cep_id=$this->getParametro("cep_id");
        $cep_c=$this->getParametro("cep_c");
                return AsignacionesNegocio::create()->functionComboAsig2($cep_id,$cep_c);

    }
   
}
