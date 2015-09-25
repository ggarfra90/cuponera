<?php

require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/EquivalenciaNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/UnidadNegocio.php';

class EquivalenciaControlador extends AlmacenIndexControlador {

    public function getDataGridEquivalencia() {
        return EquivalenciaNegocio::create()->getDataEquivalencia();
    }

    public function getComboAlternativa() {
        $id_unidad = $this->getParametro("id_unidad");
        return UnidadNegocio::create()->getDataUnidad($id_unidad);
    }

    public function getComboUnidad() {
        $id_unidad = $this->getParametro("id_unidad");
        return UnidadNegocio::create()->getDataUnidad($id_unidad);
    }

    public function insertEquivalencia() {
        $fac_alternativa = $this->getParametro("fac_alternativa");
        $uni_alternativa = $this->getParametro("uni_alternativa");
        $fac_base = $this->getParametro("fac_base");
        $uni_base = $this->getParametro("uni_base");
        $usu_creacion = $this->getParametro("usu_creacion");
        return EquivalenciaNegocio::create()->insertEquivalencia($fac_alternativa, $uni_alternativa, $fac_base, $uni_base, $usu_creacion);
    }

    public function getEquivalencia() {
        $id_equivalencia = $this->getParametro("id_equivalencia");
        return EquivalenciaNegocio::create()->getEquivalencia($id_equivalencia);
    }

    public function updateEquivalencia() {
        $id_equivalencia = $usu_nombre = $this->getParametro("id_equivalencia");
        $fac_alternativa = $this->getParametro("fac_alternativa");
        $uni_alternativa = $this->getParametro("uni_alternativa");
        $fac_base = $this->getParametro("fac_base");
        $uni_base = $this->getParametro("uni_base");
        return EquivalenciaNegocio::create()->updateEquivalencia($id_equivalencia, $fac_alternativa, $uni_alternativa, $fac_base, $uni_base);
    }

    public function deleteEquivalencia() {
        $id_equi = $this->getParametro("id_equivalencia");
        $nom1 = $this->getParametro("nom1");
        $nom2 = $this->getParametro("nom2");
        return EquivalenciaNegocio::create()->deleteEquivalencia($id_equi, $nom1, $nom2);
    }

}
