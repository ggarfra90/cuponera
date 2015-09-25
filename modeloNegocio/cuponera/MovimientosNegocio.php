<?php

require_once __DIR__ . '/../../modelo/cuponera/MOvimientos.php';

require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class MovimientosNegocio extends ModeloNegocioBase {

   
    public function insertMovimientos($mov_descri,$mov_usu_id,$mov_ip,$mov_host) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        
        $response = Movimientos::create()->insertMovimientos($mov_descri,$mov_usu_id,$mov_ip,$mov_host);
        
         if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
          return $response;
    }
    
     
}
