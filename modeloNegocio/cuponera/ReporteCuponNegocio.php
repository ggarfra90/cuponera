<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modelo/cuponera/ReportesCupones.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/PermisosPerfilNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class ReporteCuponNegocio extends ModeloNegocioBase {

    public function getReporteCupones($rfecha2, $rfecha4, $est_id,$org) {
        session_start();
        $es_rrhh = PermisosPerfilNegocio::getPermisosAdministrativos('RRHH');
        $count = $es_rrhh;
        $count += PermisosPerfilNegocio::getPermisosAdministrativos('SOCI');
        $count += PermisosPerfilNegocio::getPermisosAdministrativos('COMP');
        $aprob = 0;
        if ($count == 0) {
            $aprob = PermisosPerfilNegocio::getPermisosAdministrativos('GERENTEINMEDIATO');
            $aprob +=PermisosPerfilNegocio::getPermisosAdministrativos('JEFEINMEDIATO');
        }
        if ($aprob > 0) {
            $count += $aprob;
        }
        $q_aprob = "";
        if ($aprob > 0) {
            $user=  trim($_SESSION['ldap_user']);
            $q_aprob = $user;
        }
       
        
        
        $data = ReportesCupones::create()->getReporteC(1, $rfecha2, $rfecha4, $est_id, $aprob,trim($q_aprob),$org);

        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            //$data[$i]['per_mtr']=$_SESSION['rec_usu_matricial'];
            //tipo de cupon
            $fec_perm = $data[$i]['cup_fec_perm'];
            $nota = "";
            if ($data[$i]['cup_tipo'] == 1) {
                $nota = "Fecha de cumpleaños " . $data[$i]['cup_fec_hito'];
            } elseif ($data[$i]['cup_tipo'] == 2) {
                $fec_perm = $data[$i]['cup_fec_perm'] . " y<br>" . $data[$i]['cup_fec_perm2'];
                $nota = "Fecha de boda " . $data[$i]['cup_fec_hito'];
            } elseif ($data[$i]['cup_tipo'] == 3) {
                $fechaf = CuponesNegocio::diaconfecha($data[$i]['cup_fec_hito2']);
                $nota = "Inicio de curso " . $data[$i]['cup_fec_hito'] . "<br>Fin de curso " . $fechaf;
            } elseif ($data[$i]['cup_tipo'] == 6) {
                $turno = (($data[$i]['cup_part_time'] == 1) ? "mañana (8:00am a 12:30pm)" : "tarde (12:30pm a 6:00pm)");
                $nota = "Turno solicitado " . $turno;
            }
            $data[$i]['nota'] = $nota;
            $data[$i]['fec_perm'] = (!is_null($fec_perm)) ? $fec_perm : '';
            //mensaje cuando se rechaza
            if (!is_null($data[$i]['cup_vobo_rrhh'])) {
                $rrhh = ($data[$i]['cup_vobo_rrhh'] == 1 ? "Si" : "No");
                $data[$i]['rrhh'] = $rrhh;
            } else {
                $rrhh = "N/A";
                $data[$i]['rrhh'] = $rrhh;
            }

            if (!is_null($data[$i]['cup_rechazo_jefe'])) {
                $rechazo_jefe = $data[$i]['cup_rechazo_jefe'];
                $data[$i]['rechazo_jefe'] = $rechazo_jefe;
            } else {
                $data[$i]['rechazo_jefe'] = "";
            }
            if (!is_null($data[$i]['cup_rechazo_rrhh'])) {
                $rechazo_rrhh = $data[$i]['cup_rechazo_rrhh'];
                $data[$i]['rechazo_rrhh'] = $rechazo_rrhh;
            } else {
                $rechazo_rrhh = "";
                $data[$i]['rechazo_rrhh'] = $rechazo_rrhh;
            }
            if (strlen($data[$i]['rechazo_rrhh']) > 0) {
                $data[$i]['r_etiqueta'] = "&nbsp;&nbsp;<i class='fa fa-info-circle' style='color:#ebc142;font-size:16px;' id='da' data-toggle='tooltip' data-html='true' data-placement='left' title='' data-original-title='$rechazo_rrhh'>";
            } else {
                $data[$i]['r_etiqueta'] = "";
            }
            $fechaA = CuponesNegocio::diaconfecha($data[$i]['cup_fec_anul']);
            $nombre_usu = CuponesNegocio::getUsuNom($data[$i]['cup_usu_anul']);
            $msj_anulacion = '<b>Estado:</b>&nbsp;Anulado<br><b>Motivo:</b>&nbsp;' . $data[$i]['cup_motivo_anul'] . '<br>' . "<b>Fecha:</b>&nbsp;" . $fechaA . "<br> <b>Colaborador:&nbsp;</b>" . $nombre_usu . "";

            // estado 

            if ($data[$i]['cup_estado'] == 1) {
                $data[$i]['icono'] = "fa  fa-clock-o";
                $data[$i]['color'] = "#EFF70D";
                $estado = "Pendiente";
            } elseif ($data[$i]['cup_estado'] == 2) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";
                $estado = "Aprobado";
            } elseif ($data[$i]['cup_estado'] == 3) {
                $data[$i]['icono'] = "fa  fa-exclamation-circle";
                $data[$i]['color'] = "#FA9810";
                $estado = "Rechazado";
            } elseif ($data[$i]['cup_estado'] == 101) {
                $data[$i]['icono'] = "fa  fa-times-circle";
                $data[$i]['color'] = "#DC3611";
                $estado = "Anulado";
            }

            if ($data[$i]['cup_estado'] != 101) {
                (strlen($data[$i]['rechazo_jefe']) > 0) ? $data[$i]['estado'] = $data[$i]['rechazo_jefe'] : $data[$i]['estado'] = $estado;
            } else {
                $data[$i]['estado'] = $msj_anulacion;
            }
            $data[$i]['fec_resp'] = (!is_null($data[$i]['cup_fec_resp'])) ? $data[$i]['cup_fec_resp'] : '';
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
            if ($es_rrhh > 0 && $data[$i]['cup_estado'] != 3 && $data[$i]['cup_estado'] != 101) {
                $data[$i]['funcion'] = 'confirmarAnularCupon("' . $data[$i]['cup_id'] . '");';
                $data[$i]['cursorf'] = 'cursor:pointer;';
                $data[$i]['disablef'] = '';
                $data[$i]['estadof'] = 'Anular';
                $data[$i]['colorf'] = '#DC3611;';
            } else {
                $data[$i]['funcion'] = '';
                $data[$i]['cursorf'] = 'cursor:default;';
                $data[$i]['disablef'] = '';
                $data[$i]['colorf'] = '';
                if ($data[$i]['cup_estado'] == 3) {
                    $data[$i]['estadof'] = 'Rechazado';
                }
                if ($data[$i]['cup_estado'] == 101) {
                    $data[$i]['estadof'] = 'Anulado';
                }
            }
        }
        return $data;
    }

    //anular cupon
    public function functionAnular($id, $op, $mot) {
        session_start();
        $array = ReportesCupones::create()->obtenerDatosCupon($id);
        foreach ($array as $fila) {
            $cup_fec_perm = $fila['cup_fec_perm'];
            $cup_fec_perm2 = $fila['cup_fec_perm2'];
            $cup_fec_sol = $fila['cup_fec_sol'];
            $cup_fec_hito = $fila['cup_fec_hito'];
            $cup_fec_hito2 = $fila['cup_fec_hito2'];
            $cup_tipo = $fila['cup_tipo'];
            $cup_nombre = $fila['cup_nombre'];
            $cup_part_time = $fila['cup_part_time'];
        }
        $array2 = ReportesCupones::create()->obtenerDatosCuponUsuario($id);
        if (count($array2) < 0) {

            $flag = 1;
            $response[3]["vout_exito"] = 0;
            $response[3]["vout_mensaje"] = 'El usuario del cupon asignado no tiene jefe';
        }
        foreach ($array2 as $fila) {
            $usu_tra_ad = $fila['usu_ad'];
            $usu_tra_nombre = $fila['usu_nombre'];
            $usu_tra_usu_jefe = $fila['usu_jefe'];
            $usu_tra_usu_gerente = $fila['usu_gerente'];
        }
        if (!strlen($usu_tra_usu_gerente) > 0) {

            $flag = 1;
            $response[2]["vout_exito"] = 0;
            $response[2]["vout_mensaje"] = 'El usuario del cupon asignado no tiene gerente';
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al procesar datos.";
            return $response;
            exit();
        }
        $response = ReportesCupones::create()->anularCupon($_SESSION['rec_usu_id'], $mot, $id);
        $descri = "Actualizacion a estado (" . $op . ") de cupon (" . $id . ")";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($descri, $_SESSION['rec_usu_id'], $mov_ip, $mov_host);
        //start ec
        $to = "ggarcia@imaginatecperu.com"; //CuponesNegocio::create()->getCorreoUsuario($usu_tra_ad);
        //descomentar aparitr de linea 212 y eliminar linea 210
        $cc = "ggarcia@imaginatecperu.com"; // array();
//        $cc = array();
//        if (strlen($usu_tra_usu_jefe) > 0)
//            array_push($cc, $usu_tra_usu_jefe . '@netafim.com.pe');
//        if (strlen($usu_tra_usu_gerente) > 0)
//            array_push($cc, $usu_tra_usu_gerente . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getAsistSocial() . '@netafim.com.pe');
//        array_push($cc, CuponesNegocio::getJefeRRHH() . '@netafim.com.pe');
//        array_push($cc, 'rrhh@netafim.com.pe');
        $subject = ConstantesMail::PARAM_ANULACION . $cup_nombre . " de " . $usu_tra_nombre;
        if ($cup_tipo == 1)
            $body = ConstantesMail::PARAM_SUBJECT_CA . $cup_fec_sol . " para utilizar el cupón de " . $cup_nombre . " de " . $usu_tra_nombre . " para el dia " . $cup_fec_perm . " (Fecha de " . $cup_nombre . ": " . $cup_fec_hito . ")";
        elseif ($cup_tipo == 2)
            $body = ConstantesMail::PARAM_SUBJECT_CA . $cup_fec_sol . " para utilizar el cupón de " . $cup_nombre . " de " . $usu_tra_nombre . " para los dias " . $cup_fec_perm . " y " . $cup_fec_perm2 . " (Fecha de " . $cup_nombre . ": " . $cup_fec_hito . ")";
        elseif ($cup_tipo == 3)
            $body = ConstantesMail::PARAM_SUBJECT_CA . $cup_fec_sol . " para utilizar el cupón de " . $cup_nombre . " de " . $usu_tra_nombre . " para el dia " . $cup_fec_perm . " (Fecha de inicio de curso " . $cup_fec_hito . ", fecha de fin de curso " . $cup_fec_hito2 . ")";
        elseif ($cup_tipo == 4 || $cup_tipo == 5 || $cup_tipo == 7 || $cup_tipo == 8)
            $body = ConstantesMail::PARAM_SUBJECT_CA . $cup_fec_sol . " para utilizar el cupón de " . $cup_nombre . " de " . $usu_tra_nombre . " para el dia " . $cup_fec_perm;
        elseif ($cup_tipo == 6) {
            $turno = (($cup_part_time == 1) ? ConstantesMail::PARAM_TURNO_M : ConstantesMail::PARAM_TURNO_T);
            $body = ConstantesMail::PARAM_SUBJECT_CA . $cup_fec_sol . ConstantesMail::PARAM_SUBJRCT_CA2 . $cup_nombre . " de " . $usu_tra_nombre . " para el dia " . $cup_fec_perm . " para el turno de la " . $turno;
        }
        $body .= "\n\nMotivo de anulación: " . $mot;
        $nombre_u = CuponesNegocio::getUsuNom($_SESSION['rec_usu_id']);
        $body .= "\nAnulado por: " . $nombre_u;
        CuponesNegocio::create()->enviarCorreo($to, $cc, $subject, $body);
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
