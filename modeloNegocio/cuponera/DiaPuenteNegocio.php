<?php

require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/DiaPuenteAnio.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class DiaPuenteNegocio extends ModeloNegocioBase {

    public function getDiaPuente($anio) {
        session_start();
        if($anio==''){
        $anio=date('Y');
        
        }
        $data=  CuponesNegocio::listadiapuentehtml($anio);
        $data[10]['tamanio']=count($data);      
        return $data;
    }
    public function getDiaPuenteAnio() {
        $data=  DiaPuenteAnio::create()->functionListarPuenteAnio();
        return $data;
    }
    public function functionEditarDiaPuente($anio,$dias,$dp_id,$dia_ant) {
        session_start();
        $response='';
    $usu_id=$_SESSION['rec_usu_id'];
        $response1=  DiaPuenteAnio::create()->functionEditarDiaAnioPuente($dias,$dp_id) ;
        $desc = "Cambio de dias puente del anio ".$anio." de ".$dia_ant;
	$desc2 = " a ".$dias;
        $mov_descri =$desc.$desc2;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response1[0]["vout_exito"] =='1') {
            $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);
         }
         
         if ( $response2[0]["vout_exito"] == 0 ) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"];
          
            return $response;
        }
    }
    public function functionEliminarDiaPuente($anio,$dias,$dp_id) {
        session_start();
        $response='';
    $usu_id=$_SESSION['rec_usu_id'];
        $response1=  DiaPuenteAnio::create()->functionEliminarDiaAnioPuente($dp_id) ;
        $mov_descri = "Eliminación del dia puente  ".$anio." de ".$dias." días.";
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response1[0]["vout_exito"] =='1') {
            $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);
         }
         
         if ( $response2[0]["vout_exito"] == 0 ) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"];
          
            return $response;
        }
        return $response;
    }
    public function insertDiaPuenteAnio($anio,$dias) {
        session_start();
        $sucu = $_SESSION['rec_suc_id'];
        $usu_id=$_SESSION['rec_usu_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        
        if ($dias=='') {
            $flag = 1;
            $response[1]["vout_exito"] = 0;
            $response[1]["vout_mensaje"] ="Ingrese un numero de dias.";
        }
        if ($anio=='' || strlen($anio)<4 || $anio<=0) {
            $flag = 1;
            $response[2]["vout_exito"] = 0;
            $response[2]["vout_mensaje"] ="Ingrese un año valido.";
        }
        
        
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
                $veri=  DiaPuenteAnio::create()->functionVerificarAnioPuente($anio,$org_id);

        if ($veri[0]['vout_exito']=='0') {
            $flag = 1;
            $response[3]["vout_exito"] = 0;
            $response[3]["vout_mensaje"] =$veri[0]['vout_mensaje'];
        }
        
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        $response1=  DiaPuenteAnio::create()->functionInsetarDiaAnioPuente($anio,$dias,$org_id);
        $mov_descri =  "Registro nuevo: ".$dias." dia(s) puente para anio ".$anio." en la organizacion ".$org_id." en la sucursal: ".$sucu;
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response1[0]["vout_exito"] =='1') {
            $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);
         }
         
         if ( $response2[0]["vout_exito"] == 0 ) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"];
          
            return $response;
        }
        
        return $response;
    }


}
