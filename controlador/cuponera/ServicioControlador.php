<?php

require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ServicioNegocio.php';

class ServicioControlador extends AlmacenIndexControlador {


    public function getDataGridServicio() {
        return ServicioNegocio::create()->getDataServicio();
    }
    
    public function insertServicio() {
        $descripcion = $this->getParametro("descripcion");
        $fec_inicio = $this->getParametro("fec_inicio");
        $fec_fin = $this->getParametro("fec_fin");
        $comentario = $this->getParametro("comentario");
        $estado = $this->getParametro("estado");
        $usu_creacion = $this->getParametro("usu_creacion");
        return ServicioNegocio::create()->insertServicio($descripcion, $fec_inicio, $fec_fin, $comentario, $estado, $usu_creacion);
    }
    
    public function getServicio() {
        $id_servicio = $this->getParametro("id_servicio");
        return ServicioNegocio::create()->getServicio($id_servicio);
    }
    
    public function updateServicio()
    {
        $id_servicio  = $usu_nombre = $this->getParametro("id_servicio");
        $descripcion = $this->getParametro("descripcion");
        $fec_inicio = $this->getParametro("fec_inicio");
        $fec_fin = $this->getParametro("fec_fin");
        $comentario = $this->getParametro("comentario");
        $estado = $this->getParametro("estado");
        return ServicioNegocio::create()->updateServicio($id_servicio,$descripcion,$fec_inicio,$fec_fin,$comentario,$estado);
    }
    
    public function deleteServicio() {
        $id_servicio = $this->getParametro("id_servicio");
        return ServicioNegocio::create()->deleteServicio($id_servicio);
    }
}
