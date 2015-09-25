<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

require_once __DIR__ . '/../../modelo/cuponera/Perfil.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class PerfilNegocio extends ModeloNegocioBase {

    public function getMenuUsuario($perfil_id) {

        $data = array();
        $arrayPadre = Perfil::create()->getMenuPadreUsuario($perfil_id);
        $cont = 0;
        foreach ($arrayPadre as $value) {
            $d = $value['id'];
            $nombre = $value['text'];
            $url = $value['url'];
            $arrayHijo = Perfil::create()->getMenuHijoUsuario($d, $perfil_id);
            $data[$cont] = array('id' => $d, 'nombre' => $nombre, 'url' => $url, 'hijo' => $arrayHijo);
            $cont++;
        }
        return $data;
    }

    public function getDataPerfil($id_bandera) {
        $data = Perfil::create()->getDataPerfil($id_usuario);
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";
            } else {
                $data[$i]['icono'] = "ion-flash-off";
                $data[$i]['color'] = "#cb2a2a";
            }
            if ($data[$i]['bandera_dashboard'] == 1) {
                $data[$i]['dashboard_icono'] = 'fa fa-unlock';
                $data[$i]['dashboard_color'] = "#5cb85c";
            } else {
                $data[$i]['dashboard_icono'] = 'fa fa-lock';
                $data[$i]['dashboard_color'] = "#cb2a2a";
            }
            if ($data[$i]['bandera_monetaria'] == 1) {
                $data[$i]['monetaria_icono'] = 'fa fa-unlock';
                $data[$i]['monetaria_color'] = "#5cb85c";
            } else {
                $data[$i]['monetaria_icono'] = 'fa fa-lock';
                $data[$i]['monetaria_color'] = "#cb2a2a";
            }

            if ($data[$i]['bandera_email'] == 1) {
                $data[$i]['email_icono'] = 'fa fa-unlock';
                $data[$i]['email_color'] = "#5cb85c";
            } else {
                $data[$i]['email_icono'] = 'fa fa-lock';
                $data[$i]['email_color'] = "#cb2a2a";
            }
            if ($id_bandera != null) {
                $data[$i]['id_bandera'] = $id_bandera;
            }
        }
        return $data;
    }

    public function insertPerfil($codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $usuario, $pant_principal) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        $response = Perfil::create()->insertPerfil($codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $visible, $usuario, $pant_principal);
        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }

    public function updatePerfil($id, $codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $pant_principal) {
        $response = Perfil::create()->updatePerfil($id, $codigo, $nombre, $descripcion, $estado, $dashboard, $email, $monetaria, $pant_principal);
        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }

    public function getPerfil($id) {
        return Perfil::create()->getPerfil($id);
    }

    public function deletePerfil($id) {
        return Perfil::create()->deletePerfil($id);
    }

    public function getMenu($id_perfil) {
        $data = array();
        $arrayPadre = Perfil::create()->getMenuPadre();
        $cont = 0;
        foreach ($arrayPadre as $value) {
            $d = $value['id'];
            $nombre = $value['text'];
            $url = $value['url'];
            $arrayHijo = Perfil::create()->getMenuHijo($d);
            $count2 = 0;

            $data[$cont] = array('id_perfil' => $id_perfil, 'id' => $d, 'nombre' => $nombre, 'url' => $url, 'hijo' => $arrayHijo);
            $count2++;
            $cont++;
        }
        return $data;
    }

    public function insertDetOpcPerfil($id_per, $id_opcion, $id_usu, $estado) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        return Perfil::create()->insertDetOpcPerfil($id_per, $id_opcion, $estado, $visible, $id_usu);
    }

    public function updateDetOpcPerfil($id_per, $id_opcion, $estado) {
//        $visible = ConstantesNegocio::PARAM_VISIBLE;
        return Perfil::create()->updateDetOpcPerfil($id_per, $id_opcion, $estado);
    }
   
    
    public function obtenerPantallaPrincipal($id)
    {
        return Perfil::create()->obtenerPantallaPrincipal($id);
    }
}
