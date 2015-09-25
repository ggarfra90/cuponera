<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ColaboradorNegocio.php';

class ColaboradorControlador extends AlmacenIndexControlador {

    public function getDataGridColaborador() {
        return ColaboradorNegocio::create()->getDataColaborador();
    }

    public function insertColaborador() {
        $dni = $this->getParametro("dni");
        $nombre = $this->getParametro("nombre");
        $paterno = $this->getParametro("paterno");
        $materno = $this->getParametro("materno");
        $telefono = $this->getParametro("telefono");
        $celular = $this->getParametro("celular");
        $email = $this->getParametro("email");
        $direccion = $this->getParametro("direccion");
        $ref_direccion = $this->getParametro("ref_direccion");
        $pant_principal = $this->getParametro("pant_principal");
        $usuario = $this->getParametro("usuario");
        $estado = $this->getParametro("estado");
        $file = $this->getParametro("file");
        return ColaboradorNegocio::create()->insertColaborador($dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion, $ref_direccion, $usuario, $estado,$file);
    }

    public function getDetalleColaborador() {
        $id_colaborador = $this->getParametro("id_colaborador");
        return ColaboradorNegocio::create()->getDetalleColaborador($id_colaborador);
    }
    public function getColaborador() {
        $id_colaborador = $this->getParametro("id_colaborador");
        return ColaboradorNegocio::create()->getColaborador($id_colaborador);
    }
    
    public function updateColaborador() {
        $id = $this->getParametro("id_colaborador");
        $dni = $this->getParametro("dni");
        $nombre = $this->getParametro("nombre");
        $paterno = $this->getParametro("paterno");
        $materno = $this->getParametro("materno");
        $telefono = $this->getParametro("telefono");
        $celular = $this->getParametro("celular");
        $email = $this->getParametro("email");
        $direccion = $this->getParametro("direccion");
        $ref_direccion = $this->getParametro("ref_direccion");
        $estado = $this->getParametro("estado");
        return ColaboradorNegocio::create()->updateColaborador($id,$dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion, $ref_direccion, $estado);
    }
    
    public function deleteColaborador() {
        $id_colaborador = $this->getParametro("id_colaborador");
        return ColaboradorNegocio::create()->deleteColaborador($id_colaborador);
    }
    
}
