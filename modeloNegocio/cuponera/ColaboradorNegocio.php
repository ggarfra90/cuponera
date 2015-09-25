<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

require_once __DIR__ . '/../../modelo/cuponera/Colaborador.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class ColaboradorNegocio extends ModeloNegocioBase {

    
    public function getDataColaborador($id_bandera) {
        $data = Colaborador::create()->getDataColaborador();
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
            if($id_bandera!=null)
            {
              $data[$i]['id_bandera'] = $id_bandera;
            }          
        }
        return $data;
    }
    
    public function insertColaborador($dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion,$ref_direccion,$usuario,$estado,$file) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        $response = Colaborador::create()->insertColaborador($dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion,$ref_direccion,$usuario,$estado,$visible,$file);
        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }
    
     public function getDetalleColaborador($id) {
        return Colaborador::create()->getColaborador($id);
    }       
      public function getColaborador($id) {
        return Colaborador::create()->getColaborador($id);
    } 
    
    public function updateColaborador($id,$dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion,$ref_direccion,$estado) {
        $response = Colaborador::create()->updateColaborador($id,$dni, $nombre, $paterno, $materno, $telefono, $celular, $email, $direccion,$ref_direccion,$estado);
        if ($response[0]["vout_exito"] == 0) {
            throw new WarningException($response[0]["vout_mensaje"]);
        } else {
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
    }
    
    public function deleteColaborador($id) {
        return Colaborador::create()->deleteColaborador($id);
    }   
}
