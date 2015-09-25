<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/PerfilNegocio.php';

class PerfilControlador extends AlmacenIndexControlador {

    public function getMenuUsuario($perfil_id) {
        return PerfilNegocio::create()->getMenuUsuario($perfil_id);
    }

    public function getDataGridPerfil() {
        return PerfilNegocio::create()->getDataPerfil();
    }

    public function insertPerfil() {
        $codigo = $this->getParametro("codigo");
        $nombre = $this->getParametro("descripcion");
        $descripcion = $this->getParametro("comentario");
        $estado = $this->getParametro("estado");
        $dashboard = $this->getParametro("dashboard");
        $email = $this->getParametro("email");
        $monetaria = $this->getParametro("monetaria");
        $usuario = $this->getParametro("usuario");
        $pant_principal = $this->getParametro("pant_principal");
        return PerfilNegocio::create()->insertPerfil($codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $usuario,$pant_principal);
    }

    public function getPerfil() {
        $id_perfil = $this->getParametro("id_perfil");
        return PerfilNegocio::create()->getPerfil($id_perfil);
    }

    public function updatePerfil() {
        $id_perfil = $this->getParametro("id_perfil");
        $codigo = $this->getParametro("codigo");
        $nombre = $this->getParametro("descripcion");
        $descripcion = $this->getParametro("comentario");
        $estado = $this->getParametro("estado");
        $dashboard = $this->getParametro("dashboard");
        $email = $this->getParametro("email");
        $monetaria = $this->getParametro("monetaria");
        $pant_principal = $this->getParametro("pant_principal"); 
        return PerfilNegocio::create()->updatePerfil($id_perfil, $codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria,$pant_principal);
    }

    public function deletePerfil() {
        $id_perfil = $this->getParametro("id_perfil");
        return PerfilNegocio::create()->deletePerfil($id_perfil);
    }
     public function getMenu() {
        $id_perfil = $this->getParametro("id_perfil");
        return PerfilNegocio::create()->getMenu($id_perfil);
    }
    
    
    public function insertDetOpcPerfil()
    {
         $id_per = $this->getParametro("id_per");
         $id_usu = $this->getParametro("id_usu");
         $id_opcion = $this->getParametro("id_opcion");
         $estado = $this->getParametro("estado");
//         return $id_usuario;
        return PerfilNegocio::create()->insertDetOpcPerfil($id_per, $id_opcion, $id_usu,$estado);
    }
    
    public function updateDetOpcPerfil()
    {
         $id_per = $this->getParametro("id_per");
         $id_opcion = $this->getParametro("id_opcion");
         $estado = $this->getParametro("estado");
        return PerfilNegocio::create()->updateDetOpcPerfil($id_per, $id_opcion,$estado);
    }    
    
    public function obtenerPantallaPrincipal()
    {
        $id_per = $this->getParametro("id_per");
        return PerfilNegocio::create()->obtenerPantallaPrincipal($id_per);
    }
}
