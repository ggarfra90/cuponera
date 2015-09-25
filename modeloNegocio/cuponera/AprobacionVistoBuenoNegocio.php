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
//include dirname(dirname(__FILE__))."/Mailer/Entidades/ConstructorMail.php";
class AprobacionVistoBuenoNegocio extends ModeloNegocioBase {

    public function ObtenerAprobacionesVistoBueno() {
        session_start();
        $sucu = $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        $data = Cupones::create()->obtnerAprobacionVistoBueno(intval($org_id));
        $tam = count($data);
        for ($i = 0; $i < $tam; $i++) {
            $fec_perm = "";
            $nota = "";

            if ($data[$i]['cup_tipo'] == 2) {
                $fec = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito']);
                $fec1 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
                $fec2 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm2']);
                $fec_perm = $fec1 . " y " . $fec2;
                $nota = "Fecha de boda " . $fec;
            } elseif ($data[$i]['cup_tipo'] == 3) {

                $fec_perm = CuponesNegocio::diaconfecha($data[$i]['cup_fec_perm']);
                $fec1 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito']);
                $fec2 = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito2']);
                $nota = "Inicio de curso " . $fec1 . "<br>Fin de curso " . $fec2;
            }
            $data[$i]['fech_perm'] = $fec_perm;
            $data[$i]['nota'] = $nota;
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
        }
        return $data;
    }

    public function functionAprobacionAnularVistoBueno($id, $op, $mot) {
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
        if (!is_null($data[0]['cup_vobo_rrhh'])) {
            $flag = 1;
            $response[3]["vout_exito"] = 0;
            $response[3]["vout_mensaje"] = "El cup&oacute;n ya fue procesado por recursos humanos";
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


        foreach ($dataD as $value) {
            $usu_tra_ad = $value['usu_ad'];
            $usu_tra_nombre = $value['usu_nombre'];
            $usu_tra_usu_jefe = $value['usu_jefe'];
            $usu_tra_usu_gerente = $value['usu_gerente'];
        }
        //op 3-->rechazar
        if ($mot <> '') {
            $response = Cupones::create()->functionOperacionesVistoBueno(intval($op), $mot, $id);
        }
        if ($op == 1) {
            $response1 = Cupones::create()->functionOperacionesVistoBueno(intval($op), $mot, $id);
        }
        if ($op == 0) {
            $response1 = Cupones::create()->functionOperacionesVistoBueno(intval($op), $mot, $id);
        }
        $mov_descri = "RRHH " . (($op == 1) ? "aprobacion" : "rechazo") . " de cupon (" . $id . ")";
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
//        if (strlen($usu_tra_usu_jefe) > 0)
//            array_push($cc, $usu_tra_usu_jefe . '@netafim.com.pe');
//        if (strlen($usu_tra_usu_gerente) > 0)
//            array_push($cc, $usu_tra_usu_gerente . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getAsistSocial() . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getJefeRRHH() . '@netafim.com.pe');
//        array_push ($cc, CuponesNegocio::getAsistCompen().'@netafim.com.pe');
//        array_push($cc, 'rrhh@netafim.com.pe');
        $subject = ConstantesMail::PARAM_BODY_CUPON_H . $cup_nombre . " de " . $usu_tra_nombre . " " . ($opcion == 1 ? ConstantesMail::PARAM_SUBJECT_VB_S : ConstantesMail::PARAM_SUBJECT_VB_N);
        if ($cup_tipo == 2)
            $body = ConstantesMail::PARAM_BODY_CUPON . ($opcion == 1 ? ConstantesMail::PARAM_BODY_1 :ConstantesMail::PARAM_BODY_0) . ConstantesMail::PARAM_BODY_CUPON_B . $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_E . $cup_fec_perm . " y " . $cup_fec_perm2 . ConstantesMail::PARAM_BODY_CUPON_FD . $cup_nombre . ": " . $cup_fec_hito . ")";
        elseif ($cup_tipo == 3)
            $body = ConstantesMail::PARAM_BODY_CUPON . ($opcion == 1 ?  ConstantesMail::PARAM_BODY_1 :ConstantesMail::PARAM_BODY_0) . ConstantesMail::PARAM_BODY_CUPON_B. $cup_fec_sol . ConstantesMail::PARAM_BODY_CUPON_C . $cup_nombre . " de " . $usu_tra_nombre . ConstantesMail::PARAM_BODY_CUPON_D. $cup_fec_perm . ConstantesMail::PARAM_BODY_CUPON_FI . $cup_fec_hito .ConstantesMail::PARAM_BODY_CUPON_FF . $cup_fec_hito2 . ")";
        if (strlen($mot) > 0) {
            $body .= ConstantesMail::PARAM_MOTIVO_R . $mot;
        } else {
            $espc = $body;
            $body .= ConstantesMail::PARAM_BODY_H_JD;
        }
        CuponesNegocio::enviarCorreo($to, $cc, $subject, $body);
        //envio de correo constructor mail--proyecto mailer
        if($op == 1) {
	$id                = $id;
	$aprobador         = $usu_tra_usu_jefe;
	$location          = "recursos/aprobaciones";
	$detalle_operacion = $espc;
	$operacion         = "utilizar un cupón";
	//ConstructorMail::enviarCorreoAprobacion($id, $aprobador, $location, $detalle_operacion, $operacion, "template_1", "", array("subject" => $subject));
}
        
        if (($response[0]["vout_exito"] == 0 || $response1[0]["vout_exito"] == 0) && $response3[0]["vout_exito"]==0) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response1[0]["vout_mensaje"] . " " . $response3[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = 'Se registro su solicitud.';
            return $response;
        }
        return $response;
    }

}
