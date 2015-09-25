<?php

require_once __DIR__ . '/../../modelo/cuponera/Unidad.php';
require_once __DIR__ . '/../../modelo/cuponera/Equivalencia.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class EquivalenciaNegocio extends ModeloNegocioBase {

    public function getDataEquivalencia() {
        $data = Equivalencia::create()->getDataEquivalencia();
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

    public function insertEquivalencia($fac_alternativa, $uni_alternativa, $fac_base,$uni_base,$usu_creacion) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        $estado = ConstantesNegocio::PARAM_ACTIVO;
        $response = Equivalencia::create()->insertEquivalencia($fac_alternativa, $uni_alternativa, $fac_base,$uni_base,$estado,$visible,$usu_creacion);
        
         if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
          return $response;
    }
    
     public function getEquivalencia($id) {
        return Equivalencia::create()->getEquivalencia($id);
    } 
    public function updateEquivalencia($id_equivalencia,$fac_alternativa,$uni_alternativa,$fac_base,$uni_base)
    {
          $response = Equivalencia::create()->updateEquivalencia($id_equivalencia,$fac_alternativa,$uni_alternativa,$fac_base,$uni_base);
          if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }
    public function deleteEquivalencia($id,$nom1,$nom2) {
        $response = Equivalencia::create()->deleteEquivalencia($id);
        $response[0]['nombre1'] = $nom1;
        $response[0]['nombre2'] = $nom2;
        return $response;
    }   
}
