<?php

require_once __DIR__ . '/../../modelo/cuponera/FeriadosAnio.php';
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';

require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class FeriadosAnioNegocio extends ModeloNegocioBase {

    public function getFeriadosAnio() {
        session_start();
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        $data = FeriadosAnio::create()->listarFeriadosAnio(intval($org_id));
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['nota'] == "Jueves Santo") {
                $funcion = 'EliminarFeriados('. $data[$i]['feriado_id'] .');';
                $cursor = 'cursor:pointer;';
                $toltip = 'Eliminar';
                $color = 'color:#DC3611;';
            } else {
                $funcion = '';
                $cursor = 'cursor:default;';
                $toltip = 'Sin acción';
                $color = '';
            }
            $data[$i]['funcion'] = $funcion;
            $data[$i]['cursor'] = $cursor;
            $data[$i]['toltip'] = $toltip;
            $data[$i]['color'] = $color;
        }
        return $data;
    }

    public function insertFeriadosAnio($fecha) {
        session_start();
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        if (date('D', strtotime($fecha)) != "Thu") {
            $flag = 1;
            $response[1]["vout_exito"] = 0;
            $response[1]["vout_mensaje"] = "S&oacute;lo se permite seleccionar la fecha de feriado para los d&iacute;as jueves<br>";
        }
        $anio = date('Y', strtotime($fecha));
        $dat = FeriadosAnio::create()->functionValidarFeriados(1,$anio,$org_id,"");
        $numero = $dat[0]['numero'];
        if ($numero > 0) {
            $flag = 1;
            $response[2]["vout_exito"] = 0;
            $response[2]["vout_mensaje"] = "ERROR: Ya existen feriados de Semana Santa para el a&ntilde;o seleccionado<br>";
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        $usu_id=$_SESSION['rec_usu_id'];
        
        $response = FeriadosAnio::create()->functionInsertarFeriadosAnio($fecha, 1, $org_id);
        if ($response[0]['vout_exito'] == '1') {
            $fecha2 = date('Y-m-d', strtotime($fecha . "+ 1 day"));
            $response1 = FeriadosAnio::create()->functionInsertarFeriadosAnio($fecha2, 2, $org_id);
        }
        $mov_descri ="Registro nuevo: Semana santa para los dias ".$fecha." y ".$fecha2;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response1[0]["vout_exito"] =='1' && $response[0]["vout_exito"] =='1') {
        $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);
         }
        if ($response[0]["vout_exito"] == 0 && $response1[0]["vout_exito"] == 0 && $response2[0]["vout_exito"] == 0) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response1[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = 'Se registro su solicitud.';
            //  $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
        return $response;
    }
    
    public function EliminarFeriadosAnio($id) {
        session_start();
        $usu_id = $_SESSION['rec_usu_id'];
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
       
       
        $dat = FeriadosAnio::create()->functionValidarFeriados(2,"",  intval($org_id),  intval($id));
        $anio=$dat[0]['anio'];
        $response=  FeriadosAnio::create()->functionEliminarFeriadosAnio($anio,$org_id);
       $mov_descri= "Eliminacion de los feriados de semana santa del anio ".$anio."de la organizacion ".$org_id;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response[0]["vout_exito"] =='1') {
        $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);
         }
          if ($response[0]["vout_exito"] ==0 && $response2[0]["vout_exito"] == 0) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = 'Se registro su solicitud.';
            //  $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
        return $response;
    }

}
