<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modelo/cuponera/Especiales.php';
require_once __DIR__ . '/../../modelo/cuponera/ReportesCupones.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/EspecialesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/PermisosPerfilNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class ReporteEspecialNegocio extends ModeloNegocioBase {

    public function listarCuponEspecial() {
        $data = Especiales::create()->listarEspeciales();
        return $data;
    }

    public function getReporteCuponesEspeciales($ce_id, $rfecha2, $rfecha4, $est_id,$q_usu_id) {
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
            $q_aprob = "AND ( u.usu_jefe='" . $_SESSION['ldap_user'] . "'
                OR u.usu_gerente='" . $_SESSION['ldap_user'] . "'OR u2.usu_ad='" . $_SESSION['ldap_user'] . "')";
        }
        if (intval($q_usu_id)!=0) {
	$q_usu = "AND u.usu_id=".intval($q_usu_id);
}else {
    $q_usu = "";
    
}
        $data = ReportesCupones::create()->listarCuponEspecial($ce_id, $rfecha2, $rfecha4, $est_id, $aprob, $q_aprob,$q_usu);

        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            $data[$i]['ces_fec_respu'] = (is_null($data[$i]['ces_fec_resp'])) ? '' : $data[$i]['ces_fec_resp'];
            $arr = CuponesNegocio::getDetalleDiasCupEsp($data[$i]['ces_fec_ini'], $data[$i]['ces_dias']);
            $nota = '';
            foreach ($arr as $v) {
                $nota .= CuponesNegocio::diaconfecha($v) . "<br>";
            }
            $data[$i]['nota'] = $nota;
            $fecha = CuponesNegocio::diaconfecha($data[$i]['ces_fec_resp']);
            $fechaAnul = CuponesNegocio::diaconfecha($data[$i]['ces_fec_anul']);
            if ($data[$i]['ces_estado'] == 1) {
                $data[$i]['icono'] = "fa  fa-clock-o";
                $data[$i]['color'] = "#EFF70D";
                $estado = "Pendiente";
            } elseif ($data[$i]['ces_estado'] == 2) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";

                $not = "<b>Estado:</b>&nbsp;Aprobado<br><b>Colaborador:</b>&nbsp;" . $data[$i]['usu_gerente'] . "<br><b>Fecha:</b>&nbsp;" . $fecha . "<br>";
                $estado = $not;
            } elseif ($data[$i]['ces_estado'] == 3) {
                $data[$i]['icono'] = "fa  fa-exclamation-circle";
                $data[$i]['color'] = "#FA9810";
                $not2 = "<b>Estado:</b>&nbsp;Rechazado<br><b >Colaborador:</b>&nbsp;" . $fila['usu_gerente'] . "<br>";
                $not2.="<b >Fecha:</b>&nbsp;" . $fecha . "<br>";
                if (strlen($data[$i]['ces_rechazo_usu']) > 0)
                    $not2.="<b>Motivo:</b> &nbsp;" . $data[$i]['ces_rechazo_usu'];

                $estado = $not2;
            } elseif ($data[$i]['ces_estado'] == 101) {
                $data[$i]['icono'] = "fa  fa-times-circle";
                $data[$i]['color'] = "#DC3611";
                $nombre = CuponesNegocio::getUsuNom($data[$i]['ces_usu_anul']);
                $not3 = "<b>Estado:</b>&nbsp;Anulado<br><b>Colaborador:</b>&nbsp;" . $nombre . "<br><b>Fecha:&nbsp;</b>" . $fechaAnul . "<br>";
                $not3 .= "<b>Motivo:</b>&nbsp;" . $data[$i]['ces_motivo_anul'];
                $estado = $not3;
            }
            $data[$i]['estado'] = $estado;
            if ($es_rrhh > 0 && $data[$i]['ces_estado'] != 3 && $data[$i]['ces_estado'] != 101) {
                $data[$i]['funcion'] = 'confirmarAnularCuponEspecial("' . $data[$i]['ces_id'] . '");';
                $data[$i]['estadof'] = 'Anular';
                $data[$i]['cursorf'] = 'cursor: pointer;';
                $data[$i]['colorf'] = '#DC3611;';
            } else {
                switch ($data[$i]['ces_estado']) {
                    case 3:
                        $data[$i]['funcion'] = '';
                        $data[$i]['estadof'] = 'Rechazado';
                        $data[$i]['cursorf'] = 'cursor:default';
                        $data[$i]['colorf'] = '';
                        break;
                    case 101:
                        $data[$i]['funcion'] = '';
                        $data[$i]['estadof'] = 'Anulado';
                        $data[$i]['cursorf'] = 'cursor:default';
                        $data[$i]['colorf'] = '';
                        break;
                }
            }
        }
        return $data;
    }

    public function functionAnularEspecial($id, $op, $mot) {
        session_start();
        $array = ReportesCupones::create()->obtenerDatosCuponEspecial($id);
        foreach ($array as $fila) {
            $ces_fec_ini = $fila['ces_fec_ini'];
            $ces_fec_fin = $fila['ces_fec_fin'];
            $ces_dias = $fila['ces_dias'];
            $ces_fec_sol = $fila['ces_fec_sol'];
            $usu_id = $fila['usu_id'];
            $cep_id = $fila['cep_id'];
        }
        $arr = CuponesNegocio::getDetalleDiasCupEsp($ces_fec_ini, $ces_dias);
        $array2 = ReportesCupones::create()->obtenerDatosUsuarioCuponEspecial($usu_id);
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
        $response = ReportesCupones::create()->anularCuponEspecial($_SESSION['rec_usu_id'], $mot, $id);
        $descri = "Actualizacion a estado (" . $op . ") de cupon especial (id : " . $id . ")";
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
        $to = CuponesNegocio::create()->getCorreoUsuario($usu_tra_ad);
        $cc = $cc = "ggarcia@imaginatecperu.com"; // array();

        array_push($cc, $usu_tra_usu_jefe . '@netafim.com.pe');
        array_push($cc, $usu_tra_usu_gerente . '@netafim.com.pe');
        array_push($cc, CuponesNegocio::getAsistSocial() . '@netafim.com.pe');
        array_push($cc, CuponesNegocio::getJefeRRHH() . '@netafim.com.pe');
        array_push($cc, 'rrhh@netafim.com.pe');
        $subject = ConstantesMail::PARAM_SUBJECT_A . $usu_tra_nombre;
        $array3 = EspecialesNegocio::DatosCuponEspecial($cep_id);
        foreach ($array3 as $fila) {
            $ces_nombre = $fila['cep_nombre'];
        }
        $body = ConstantesMail::PARAM_BODY_A . $ces_fec_sol . " del cupon especial de " . $ces_nombre . " de " . $usu_tra_nombre . " para usar " . $ces_dias . ConstantesMail::PARMA_E_BODY_2;
        foreach ($arr as $k => $v) {
            $diacon = CuponesNegocio::diaconfecha($v);
            $body .= "Dia " . ($k + 1) . ": " . $diacon . "\n";
        }
        $body .= ConstantesMail::PARAM_BODY_A_2 . $mot;
        $usu_nombre = CuponesNegocio::getUsuNom($_SESSION['rec_usu_id']);
        $body .= ConstantesMail::PARAM_ANUL . $usu_nombre;
        $body .= "\n";
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

    public function functionCuponesEspecialesUso($id) {
        session_start();
        $es_rrhh = PermisosPerfilNegocio::getPermisosAdministrativos($_SESSION['ldap_user'], 'RRHH');
        $count = $es_rrhh;
        $count += PermisosPerfilNegocio::getPermisosAdministrativos($_SESSION['ldap_user'], 'SOCI');
        $count += PermisosPerfilNegocio::getPermisosAdministrativos($_SESSION['ldap_user'], 'COMP');
        $aprob = 0;
        if ($count == 0) {
            $aprob = PermisosPerfilNegocio::getPermisosAdministrativos($_SESSION['ldap_user'], 'GERENTEINMEDIATO');
            $aprob += PermisosPerfilNegocio::getPermisosAdministrativos($_SESSION['ldap_user'], 'JEFEINMEDIATO');
        }
        if ($aprob > 0)
            $count += $aprob;
        $data = EspecialesNegocio::getCuponesEspecialesUso(intval($id), $aprob);
        //list($usu_nombre, $cea_dias, $dias_sol, $msg_det_sol, $dias_aprob, $msg_det_aprob, $dias_sin_usar, $usu_id) = $v;
            $array=array();
        $cont=0;
        foreach ($data as $value) {
            
        if($value[2] > 0){
            $info="<span id='pri'><i class='fa fa-info-circle'  style='color:#ebc142;font-size:18px;' id='da' data-toggle='tooltip' data-html='true'  data-placement='left' title='' data-original-title='$value[3]'></i></span>";
        }else{
            $info="";
            
        }   
      if($value[4] > 0){ 
      $apro="<span  ><i class='fa fa-info-circle'  style='color:#ebc142;font-size:18px;' id='da' data-toggle='tooltip' data-html='true'  data-placement='left' title='' data-original-title='$value[5]'  ></i></span>";}
      else{
          $apro="";
          
      }
      $dia_su=$value[6];
      if($value[6]<0){
          $dia_su=0;
      }
          $array[$cont]=array('nombre'=>$value[0],'cea_dias'=>$value[1],'dias_sol'=>$value[2],'det_sol'=>$info,'dias_apro'=>$value[4],
         'det_apro'=>$apro,'dias_su'=>$dia_su,'usu_id'=>$value[7]);
          $cont++;
        }
        
        return $array;
    }

}
