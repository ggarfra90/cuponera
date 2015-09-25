<?php

require_once __DIR__ . '/../../modelo/cuponera/Usuario.php';
require_once __DIR__ . '/../../modelo/cuponera/Servicio.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class ServicioNegocio extends ModeloNegocioBase {

    public function getDataServicio() {
        $data = Servicio::create()->getDataServicio();
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";
            } else {
                $data[$i]['icono'] = "ion-flash-off";
                $data[$i]['color'] = "#cb2a2a";
            }
        }
        return $data;
    }

    public function insertServicio($descripcion, $fec_inicio, $fec_fin, $comentario, $estado, $usu_creacion) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        
        $response = Servicio::create()->insertServicio($descripcion, $fec_inicio, $fec_fin, $comentario, $estado,$visible,$usu_creacion);
        
         if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
          return $response;
    }
    
     public function getServicio($id) {
        return Servicio::create()->getServicio($id);
    } 
    public function updateServicio($id_servicio,$descripcion,$fec_inicio,$fec_fin,$comentario,$estado)
    {
          $response = Servicio::create()->updateServicio($id_servicio,$descripcion,$fec_inicio,$fec_fin,$comentario,$estado);
          if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }
    public function deleteServicio($id) {
        return Servicio::create()->deleteServicio($id);
    }   
}
