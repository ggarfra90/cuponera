<?php

require_once __DIR__ . '/../../modelo/cuponera/Unidad.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class UnidadNegocio extends ModeloNegocioBase {

    public function getDataUnidadTipo($id_bandera) {
        $data = Unidad::create()->getDataUnidadTipo();
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";
            } else {
                $data[$i]['icono'] = "ion-flash-off";
                $data[$i]['color'] = "#cb2a2a";
            }
              if (id_usuario != null) {
                $data[$i]['id_bandera'] = $id_bandera;
              }
        }
        return $data;
    }

    public function insertUnidadTipo($descripcion, $codigo, $comentario, $estado, $usu_creacion) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;

        $response = Unidad::create()->insertUnidadTipo($descripcion, $codigo, $comentario, $estado, $visible, $usu_creacion);

        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
        return $response;
    }

    public function getUnidadTipo($id) {
        return Unidad::create()->getUnidadTipo($id);
    }

    public function updateUnidadTipo($id_uni_tipo, $descripcion, $codigo, $comentario, $estado) {
        $response = Unidad::create()->updateUnidadTipo($id_uni_tipo, $descripcion, $codigo, $comentario, $estado);
        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }

    public function deleteUnidadTipo($id_uni_tipo,$nom) {
        $response = Unidad::create()->deleteUnidadTipo($id_uni_tipo);
        $response[0]['nombre'] = $nom;
        return $response;
    }
    //////////////////////////////////////
    //unidades
    /////////////////////////////////////
    public function getDataUnidad($id_bandera) {
        $data = Unidad::create()->getDataUnidad();
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";
            } else {
                $data[$i]['icono'] = "ion-flash-off";
                $data[$i]['color'] = "#cb2a2a";
            }
            if ($id_bandera != null) {
                $data[$i]['id_bandera'] = $id_bandera;
            }
        }
        return $data;
    }

    public function insertUnidad($descripcion, $codigo, $tipo,$simbolo, $estado, $usu_creacion,$factor) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;

        $response = Unidad::create()->insertUnidad($descripcion, $codigo, $tipo,$simbolo,$estado, $visible, $usu_creacion,$factor);

        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
        return $response;
    }

    public function getUnidad($id) {
        return Unidad::create()->getUnidad($id);
    }

    public function updateUnidad($id_uni,$descripcion,$codigo,$tipo,$simbolo,$estado,$factor) {
        $response = Unidad::create()->updateUnidad($id_uni,$descripcion,$codigo,$tipo,$simbolo,$estado,$factor);
        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }

    public function deleteUnidad($id_uni,$nom) {
        $response = Unidad::create()->deleteUnidad($id_uni);
        $response[0]['nombre'] = $nom;
        return $response;
    }
    
}
