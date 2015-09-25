<?php

require_once __DIR__ . '/../../modelo/cuponera/Sucursal.php';

require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class SucursalNegocio extends ModeloNegocioBase {

   
    public function getObtenerSucursal($org_id,$id) {
        $data=  Sucursal::create()->functionObtenerSucursal($org_id);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]["id"]=$id;
        }
        
        return $data;
    }
    
     
}
