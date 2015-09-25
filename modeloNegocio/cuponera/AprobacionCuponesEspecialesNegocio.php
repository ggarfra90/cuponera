<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/Especiales.php';
require_once __DIR__ . '/../../modelo/cuponera/ReportesCupones.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';
require_once __DIR__ . '/../../util/ConstantesMail.php';

class AprobacionCuponesEspecialesNegocio extends ModeloNegocioBase {

    public function ObtenerAprobacionesCuponesEspeciales() {
        session_start();
        $usu_jefe = $_SESSION['ldap_user'];

        $data = Especiales::create()->obtnerAprobacionCuponesEspeciales($usu_jefe);
        $tam = count($data);
        for ($i = 0; $i < $tam; $i++) {
            $arr = CuponesNegocio::getDetalleDiasCupEsp($data[$i]['ces_fec_ini'], $data[$i]['ces_dias']);
            $nota = "";
            foreach ($arr as $v) {
                $nota .= CuponesNegocio::diaconfecha($v) . "<br>";
            }
            $data[$i]['nota'] = $nota;
        }
        return $data;
    }

    public function functionAprobacionAnularEspeciales($id, $op, $mot) {
        
        session_start();
        $flag = 0;
        $usu_id = $_SESSION['rec_usu_id'];

        $data = ReportesCupones::create()->obtenerDatosCuponEspecial($id);

        if ($data[0]['ces_estado'] <> 1) {
            $flag = 1;
            $response[2]["vout_exito"] = 0;
            $response[2]["vout_mensaje"] = "El cupon especial no está en estado pendiente";
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        foreach ($data as $fila) {
            $ces_fec_ini = $fila['ces_fec_ini'];
            $ces_fec_fin = $fila['ces_fec_fin'];
            $ces_dias = $fila['ces_dias'];
            $ces_fec_sol = $fila['ces_fec_sol'];
            $usu_id = $fila['usu_id'];
            $cep_id = $fila['cep_id'];
        }
        $arr = CuponesNegocio::getDetalleDiasCupEsp($ces_fec_ini, $ces_dias);


        $dataD = Cupones::create()->functionAprobacionDatosEspeciales($usu_id);
        $tam = count($dataD);
        if ($tam <> 1) {
            $flag = 1;
            $response[3]["vout_exito"] = 0;
            $response[3]["vout_mensaje"] = 'El usuario conectado no tiene jefe';
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }

        if ($dataD[0]['usu_jefe'] <> $_SESSION['ldap_user']) {
            $flag = 1;
            $response[4]["vout_exito"] = 0;
            $response[4]["vout_mensaje"] = 'No puede aprobar cupones de otros jefes';
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        foreach ($dataD as $value) {
            $usu_tra_ad = $value['usu_ad'];
            $usu_tra_nombre = $value['usu_nombre'];
            $usu_tra_usu_jefe = $value['usu_jefe'];
            $usu_tra_usu_gerente = $value['usu_gerente'];
        }
        if (!strlen($usu_tra_usu_gerente) > 0) {
            $flag = 1;
            $response[4]["vout_exito"] = 0;
            $response[4]["vout_mensaje"] = 'El usuario del cupon seleccionado no tiene gerente asignado';
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        //op 3-->rechazar

        $response = Especiales::create()->functionOperacionesAprobacionEspeciales(intval($op), $mot, $id, $usu_id);


        $mov_descri = "Actualizacion a estado (" . $op . ") de cupon especial (" . $id . ConstantesMail::PARAM_BODY_CUPON_FC;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response3 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);

        // enviar correo

        $to = "ggarcia@imaginatecperu.com"; //CuponesNegocio::getCorreoUsuario($usu_tra_ad);
//        $cc = array();

//        if (CuponesNegocio::getAprobadorLevel($cep_id) == 2) {
//            array_push($cc, $usu_tra_usu_gerente . '@netafim.com.pe');
//        } else {
//            array_push($cc, $usu_tra_usu_jefe . '@netafim.com.pe');
//        }
//
//        array_push($cc, CuponesNegocio::ogetAsistSocial() . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getJefeRRHH() . '@netafim.com.pe');
//        array_push($cc, 'rrhh@netafim.com.pe');
        $subject = "Solicitud " . ($op == 2 ? "Aprobada" : "Rechazada") . " de Cupon Especial de " . $usu_tra_nombre;
        $body = "Se ha " . ($op == 2 ? "APROBADO" : "RECHAZADO") . " la solicitud fechada el " . $ces_fec_sol . " del cupon especial de " . $cep_id . " de " . $usu_tra_nombre . " para usar " . $ces_dias . " dia(s) de acuerdo al siguiente detalle:\n\n";
        foreach ($arr as $k => $v) {
            $fecha=CuponesNegocio::diaconfecha($v);
            $body .= "Dia " . ($k + 1) . ": " . $fecha . "\n";
        }
        if (strlen($mot) > 0)
            $body .= "Motivo de rechazo: " . $mot ."";
        
        CuponesNegocio::enviarCorreo($to, $cc, $subject, $body);

        if ($response[0]["vout_exito"] == 0  && $response3[0]["vout_exito"]) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response3[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = 'Se registro su solicitud.';
            //  $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
        return $response;
    }

}
