<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/ReportesCupones.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';
require_once __DIR__ . '/../../util/ConstantesMail.php';

class AprobacionCuponesNegocio extends ModeloNegocioBase {

    public function ObtenerAprobacionesCupones() {
        session_start();
        $usu_jefe = $_SESSION['ldap_user'];
        $sucu = $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        $data = Cupones::create()->obtnerAprobacionCupones($usu_jefe, intval($org_id));
        $tam = count($data);
        for ($i = 0; $i < $tam; $i++) {
            $fec_perm = "";
            $fec_perm1 = "";
            $fec_perm2 = "";
            $fec_hito = "";
            $fec_hito1 = "";
            $fec_hito2 = "";
            $nota = "";
            if ($data[$i]['cup_tipo'] == 1) {
                $fec_perm = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
                $fec_hito = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito']);
                $nota = "Fecha de cumplea&ntilde;os " . $fec_hito;
            } elseif ($data[$i]['cup_tipo'] == 2) {
                $fec_perm1 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
                $fec_perm2 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm2']);
                $fec_perm = $fec_perm1 . " y " . $fec_perm2;
                $fec_hito = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito']);
                $nota = "Fecha de boda " . $fec_hito;
            } elseif ($data[$i]['cup_tipo'] == 3) {
                $fec_perm = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
                $fec_hito1 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito']);
                $fec_hito2 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito2']);
                $nota = "Inicio de curso " . $fec_hito1 . "<br>Fin de curso " . $fec_hito2;
            } elseif ($data[$i]['cup_tipo'] == 4 || $data[$i]['cup_tipo'] == 5 || $data[$i]['cup_tipo'] == 7 || $data[$i]['cup_tipo'] == 8) {
                $fec_perm = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
            } elseif ($data[$i]['cup_tipo'] == 6) {

                $turno = (($data[$i]['cup_part_time'] == 1) ? "ma&ntilde;ana (8:00am a 12:30pm)" : "tarde (12:30pm a 6:00pm)");
                $fec_perm = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
                $nota = "Turno solicitado " . $turno;
            }
            $ruta = '/../../cuponera/vistas/com/cupones/archivos/';
            if (strlen($data[$i]['cup_doc_attach']) > 0) {
                $data[$i]['ruta'] = 'href="' . $ruta . $data[$i]['cup_doc_attach'] . '"';
                $data[$i]['cursor'] = '';
                $data[$i]['disable'] = '';
                $data[$i]['doc_c'] = '#BF0A07';
                $data[$i]['doc'] = 'Ver documento';
                $data[$i]['target'] = "target='_blank'";
            } else {
                $data[$i]['ruta'] = '';
                $data[$i]['cursor'] = 'cursor:default;';
                $data[$i]['disable'] = '';
                $data[$i]['doc_c'] = '';
                $data[$i]['doc'] = 'Sin documento';
                $data[$i]['target'] = '';
            }
            $data[$i]['fech_perm'] = $fec_perm;
            $data[$i]['nota'] = $nota;
        }
        return $data;
    }

    public function functionAprobacionAnular($id, $op, $mot) {
        session_start();
        $flag = 0;
        $usu_id = $_SESSION['rec_usu_id'];

        $data = ReportesCupones::create()->obtenerDatosCupon($id);

        if ($data[0]['cup_estado'] <> 1) {
            $flag = 1;
            $response[2]["vout_exito"] = 0;
            $response[2]["vout_mensaje"] = "El cupon no está en estado pendiente";
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        foreach ($data as $fila) {
            $cup_fec_perm = $fila['cup_fec_perm'];
            $cup_fec_perm2 = $fila['cup_fec_perm2'];
            $cup_fec_sol = $fila['cup_fec_sol'];
            $cup_fec_hito = $fila['cup_fec_hito'];
            $cup_fec_hito2 = $fila['cup_fec_hito2'];
            $cup_tipo = $fila['cup_tipo'];
            $cup_nombre = $fila['cup_nombre'];
            $cup_part_time = $fila['cup_part_time'];
        }

        $dataD = Cupones::create()->functionAprobacionDatos($id);
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
        //op 3-->rechazar
        if ($op == 3 && $mot <> '') {
            $response = Cupones::create()->functionOperacionesAprobacion(intval($op), $mot, $id, "");
        }
        $response1 = Cupones::create()->functionOperacionesAprobacion(intval($op), $mot, $id, $usu_id);

        $mov_descri = "Actualizacion a estado (" . $op . ") de cupon (" . $id .ConstantesMail::PARAM_BODY_CUPON_FC;
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

        $to = "ggarcia@imaginatecperu.com";//CuponesNegocio::getCorreoUsuario($usu_tra_ad);
//        $cc = array();
//        if (strlen($usu_tra_usu_jefe) > 0)
//            array_push($cc, $usu_tra_usu_jefe . '@netafim.com.pe');
//        if (strlen($usu_tra_usu_gerente) > 0)
//            array_push($cc, $usu_tra_usu_gerente . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getAsistSocial() . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getJefeRRHH() . '@netafim.com.pe');
//        array_push($cc, 'rrhh@netafim.com.pe');
        $subject = ConstantesMail::PARAM_BODY_CUPON_H . $cup_nombre . " " . ($op == 2 ? "aprobado" : "rechazado") . " de " . $usu_tra_nombre;
        if ($cup_tipo == 1)
            $body =ConstantesMail::PARAM_BODY_CUPON. ($op == 2 ? "aprobado" : "rechazado") . ConstantesMail::PARAM_BODY_CUPON_B . $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_D. $cup_fec_perm . ConstantesMail::PARAM_BODY_CUPON_FD . $cup_nombre . ": " . $cup_fec_hito .ConstantesMail::PARAM_BODY_CUPON_FC;
        elseif ($cup_tipo == 2)
            $body =ConstantesMail::PARAM_BODY_CUPON. ($op == 2 ? "aprobado" : "rechazado") . ConstantesMail::PARAM_BODY_CUPON_B . $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_E . $cup_fec_perm . " y " . $cup_fec_perm2 . ConstantesMail::PARAM_BODY_CUPON_FD . $cup_nombre . ": " . $cup_fec_hito .ConstantesMail::PARAM_BODY_CUPON_FC;
        elseif ($cup_tipo == 3)
            $body =ConstantesMail::PARAM_BODY_CUPON. ($op == 2 ? "aprobado" : "rechazado") . ConstantesMail::PARAM_BODY_CUPON_B . $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_D. $cup_fec_perm . ConstantesMail::PARAM_BODY_CUPON_FI . $cup_fec_hito .ConstantesMail::PARAM_BODY_CUPON_FF . $cup_fec_hito2 .ConstantesMail::PARAM_BODY_CUPON_FC;
        elseif ($cup_tipo == 4 || $cup_tipo == 5 || $cup_tipo == 7 || $cup_tipo == 8)
            $body =ConstantesMail::PARAM_BODY_CUPON. ($op == 2 ? "aprobado" : "rechazado") . ConstantesMail::PARAM_BODY_CUPON_B . $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_D. $cup_fec_perm;
        elseif ($cup_tipo == 6) {
            $turno = (($cup_part_time == 1) ? ConstantesMail::PARAM_TURNO_M : ConstantesMail::PARAM_TURNO_T);
            $body =ConstantesMail::PARAM_BODY_CUPON. ($op == 2 ? "aprobado" : "rechazado") . ConstantesMail::PARAM_BODY_CUPON_B . $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_D. $cup_fec_perm . " para el turno de la " . $turno;
        }
        if (strlen($mot) > 0){
        $body .= ConstantesMail::PARAM_MOTIVO_R. $mot;}
            CuponesNegocio::enviarCorreo($to, $cc, $subject, $body);
            
             if (($response[0]["vout_exito"] == 0 || $response1[0]["vout_exito"] == 0) &&  $response3[0]["vout_exito"] ==0){
                 $response[0]["vout_exito"]=0;
                 $response[0]["vout_mensaje"]=$response[0]["vout_mensaje"]." ".$response1[0]["vout_mensaje"]." ".$response3[0]["vout_mensaje"];
        
            } else {
                  $response[0]["vout_exito"]='1';
                  $response[0]["vout_mensaje"]='Se registro su solicitud.';
            return $response;
        }
          return $response;
            
            
            
    }

}
