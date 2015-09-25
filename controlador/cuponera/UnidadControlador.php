<?php

require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/UnidadNegocio.php';

class UnidadControlador extends AlmacenIndexControlador {
    
    public function getDataGridUnidadTipo() {
        return UnidadNegocio::create()->getDataUnidadTipo();
    }
    
    public function insertUnidadTipo() {
        $descripcion = $this->getParametro("descripcion");
        $codigo = $this->getParametro("codigo");
        $comentario = $this->getParametro("comentario");
        $estado = $this->getParametro("estado");
        $usu_creacion = $this->getParametro("usu_creacion");
        return UnidadNegocio::create()->insertUnidadTipo($descripcion, $codigo, $comentario, $estado, $usu_creacion);
    }
    
    public function getUnidadTipo() {
        $id_unidad_tipo = $this->getParametro("id_unidad_tipo");
        return UnidadNegocio::create()->getUnidadTipo($id_unidad_tipo);
    }
    
    public function updateUnidadTipo()
    {
        $id_uni_tipo  = $usu_nombre = $this->getParametro("id_uni_tipo");
        $descripcion = $this->getParametro("descripcion");
        $codigo = $this->getParametro("codigo");
        $comentario = $this->getParametro("comentario");
        $estado = $this->getParametro("estado");
        return UnidadNegocio::create()->updateUnidadTipo($id_uni_tipo,$descripcion,$codigo,$comentario,$estado);
    }
    
    public function deleteUnidadTipo() {
        $id_uni_tipo = $this->getParametro("id_uni_tipo");
        $nom = $this->getParametro("nom");
        return UnidadNegocio::create()->deleteUnidadTipo($id_uni_tipo,$nom);
    }
     
    
    
    //////////////////////////////////////////////////////////////////////////
    
     public function getDataGridUnidad() {
        return UnidadNegocio::create()->getDataUnidad();
    }
    
    public function insertUnidad() {
        $descripcion = $this->getParametro("descripcion");
        $codigo = $this->getParametro("codigo");
        $tipo = $this->getParametro("tipo");
        $simbolo = $this->getParametro("simbolo");
        $estado = $this->getParametro("estado");
        $usu_creacion = $this->getParametro("usu_creacion");
        $factor = $this->getParametro("factor");
        return UnidadNegocio::create()->insertUnidad($descripcion, $codigo, $tipo,$simbolo, $estado, $usu_creacion,$factor);
    }
    
    public function getUnidad() {
        $id_unidad = $this->getParametro("id_unidad");
        return UnidadNegocio::create()->getUnidad($id_unidad);
    }
    
    public function updateUnidad()
    {
        $id_uni  = $usu_nombre = $this->getParametro("id_uni");
        $descripcion = $this->getParametro("descripcion");
        $codigo = $this->getParametro("codigo");
        $tipo = $this->getParametro("tipo");
        $simbolo = $this->getParametro("simbolo");
        $estado = $this->getParametro("estado");
        $factor = $this->getParametro("factor");
        return UnidadNegocio::create()->updateUnidad($id_uni,$descripcion,$codigo,$tipo,$simbolo,$estado,$factor);
    }
    
    public function deleteUnidad() {
        $id_uni = $this->getParametro("id_uni");
        $nom = $this->getParametro("nom");
        return UnidadNegocio::create()->deleteUnidad($id_uni,$nom);
    }
    
    public function getComboTipoUnidad()
    {
        $id_tipo = $this->getParametro("id_tipo");
        return UnidadNegocio::create()->getDataUnidadTipo($id_tipo);
    }
    
}
