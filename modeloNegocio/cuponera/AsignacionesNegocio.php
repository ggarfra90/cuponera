<?php

require_once __DIR__ . '/../../modelo/cuponera/Asignaciones.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class AsignacionesNegocio extends ModeloNegocioBase {

    public function functionComboAsig($cep) {
        $data = Asignaciones::create()->functionCombo(6, $cep, "", "");
        return $data;
    }

    public function functionComboAsig2($cep, $c) {
        $data = Asignaciones::create()->functionCombo(6, $cep, "", "");
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {

            $data[$i]['cep_c'] = $c;
        }
        return $data;
    }

    public function getDataAsignaciones($cep_id) {
        $data = Asignaciones::create()->functionGetAll(1, $cep_id);
        return $data;
    }

    public function functionInsertAsignaciones($cep_id, $usu_id, $cea_dias) {

        $num=  count($cep_id);
        for($i=0;$i<$num;$i++){
        $response = Asignaciones::create()->insertAsignaciones(4, $cep_id, $usu_id[$i], $cea_dias[$i]);
        $descri = "Asignacion de usuario a cupon especial - identificador cupon especial  (" . $cep_id[$i] . ") " . $cea_dias[$i] . " dias al usuario id (" . $usu_id[$i]. ")";
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
        }
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

    public function functionEditarAsignaciones($cep_id, $usu_id, $cea_dias) {

        $datC = Asignaciones::create()->functionSearchAsignaciones(5, $cep_id, $usu_id, "");
        foreach ($datC as $fila) {
            $cep_dias = $fila['cea_dias'];
        }
        $response = Asignaciones::create()->insertAsignaciones(3, $cep_id, $usu_id, $cea_dias);
        $descri = "Cambio de dias asignados del cupon especial (" . $cep_id . ") de " . $cep_dias . " a " . $cea_dias . " dias del usuario id (" . $usu_id . ")";
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

    public function functionDeleteAsignaciones($cep_id, $usu_id, $cea_dias) {

        $response = Asignaciones::create()->functionDeleteAsignaciones(2, $cep_id, $usu_id, "");

        $descri = "Eliminacion de usuario de cupon especial (" . $cep_id . ") usuario id (" . $usu_id . ")";
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

}
