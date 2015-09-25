<?php
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modelo/cuponera/Usuario.php';

require_once __DIR__ . '/../../modelo/cuponera/BloqueoCupones.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class BloqueoCuponesNegocio extends ModeloNegocioBase {
    public function getDataCupones() {
        session_start();
           $data2=  CuponesNegocio::create()->local();
        foreach ($data2 as $value) {
         $sucu=$value["sucu"];
      }
         $data1=  Cupones::create()->functionOrg($sucu);
       foreach ($data1 as $value) {
            $org_id = intval($value['org_id']);  
        }
        $dataU= BloqueoCupones::create()->getAllCupones(1,$org_id);
        return$dataU;
    }
    public function getDataUsuarios() {
                
        $dataU= Usuario::create()->getAllUsuarios(1);
        return $dataU;
    }
    public function getDataBloqueo() {
        session_start();
           $data2=  CuponesNegocio::create()->local();
        foreach ($data2 as $value) {
         $sucu=$value["sucu"];
      }
         $data1=  Cupones::create()->functionOrg($sucu);
       foreach ($data1 as $value) {
            $org_id = intval($value['org_id']);  
        }
        $dataB=  BloqueoCupones::create()->getAllBloqueo(4,$org_id);
        return$dataB;
    }
    public function functionDeleteBloqueoC($b_anio,$b_tipo,$usu_id) {
       $response=  BloqueoCupones::create()->deleteBloqueo(3,"",$b_anio,$b_tipo,$usu_id,"",""); 
       $descri = "Eliminacion bloqueo cupon - Valores: colaborador ($usu_id), cupon-tipo ($b_tipo), anio ($b_anio)";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($descri, $usu_id, $mov_ip, $mov_host);
        //falta enviar correo
        if ($response[0]["vout_exito"] == 0 && $response2[0]["vout_exito"] == 0) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = 'Se registro su solicitud.';
            //  $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
       
    }
    public function functionInsertBloqueoC($b_tipo,$usu_id) {
        session_start();
        $b_anio= date("Y");
        $response = BloqueoCupones::create()->insertBloqueo(1,"",$b_anio,$b_tipo,$usu_id,$_SESSION['rec_usu_id']);
$descri = "Registro nuevo bloqueo cupon - Nuevos valores: colaborador ($usu_id), cupon-tipo ($b_tipo)";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($descri, $usu_id, $mov_ip, $mov_host);
        //falta enviar correo
        if ($response[0]["vout_exito"] == 0 && $response2[0]["vout_exito"] == 0) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = 'Se registro su solicitud.';
            //  $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
          return $response;
    }
    
     
}
