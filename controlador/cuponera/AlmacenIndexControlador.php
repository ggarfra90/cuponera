<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modeloNegocio/cuponera/UsuarioNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class AlmacenIndexControlador extends ControladorBase{
    public function getMenu() {
        $usuario_id = $this->getParametro("usuario_id");
        $opciones = PerfilNegocio::create()->getMenuPadreUsuario($usuario_id);
        return $this->formatOpciones($opciones);
    }
    
    private function formatOpciones($opciones){
        foreach ($opciones as $key=>$opcion){
            $opciones[$key]['class'] = ($opcion["id"] == $this->getParametro("opcion"))? 'active' : '';
        }
        return $opciones;
    }
}
