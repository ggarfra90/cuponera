<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
include_once __DIR__ . '/../cuponera/util/Util.php';
require_once __DIR__ . '/../../vistas/libs/imagina/phpMailer/class.phpmailer.php';
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Especiales.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class CuponesNegocio extends ModeloNegocioBase {

    public function local() {
        $sucu = $_SESSION['rec_suc_id'];
        $ua = $_SESSION['rec_usu_id'];
        $data = array();
        $data[1] = array("sucu" => $sucu, "ua" => $ua);
        return $data;
    }

    public function getIniciaCupon() {

        $data = CuponesNegocio::local();
        foreach ($data as $value) {
            $sucu = $value["sucu"];
            $ua = $value["ua"];
        }
        return CuponesNegocio::getCupones($ua, $sucu);
    }

    public function getCupones($ua, $sucu) {
        $a = date('Y');
        $dataE = array();
        $datat = CuponesNegocio::getTipo($sucu);
        $td = count($datat);
        $cont = 1;
        for ($i = 1; $i <= $td; $i++) {
            $t = $datat[$i]['cup_tipo'];
            $nom = $datat[$i]['cup_nombre'];
            $titulo = $datat[$i]['cup_titulo'];
            $id_tipo = $datat[$i]['id_tipo'];
            if ($datat[$i]['cup_clase'] != '') {
                $clas = $datat[$i]['cup_clase'];
            } else {
                $clas = 'S';
            }
            $bloq = Cupones::create()->functionCupBloqueo(intval($a), intval($t), $ua);
            foreach ($bloq as $value) {
                $bloqueo = $value['num'];
            }
            $datag = CuponesNegocio::getVerifica(intval($t), intval($a), $ua);
            $es = 0;
            if ($bloqueo > 0) {

                $st = CuponesNegocio::getIcon(intval($id_tipo));
                $msj = CuponesNegocio::getEstado(intval($es));
                $col = CuponesNegocio::getColor(intval($id_tipo));
                $rrayu = CuponesNegocio::getDatosCupon(intval($id_tipo));
                foreach ($rrayu as $value3) {
                    $url = $value3["url"];
                }
                if (count($bloq) > 0) {
                    $col = '#D3D1D1;';
                    $msj = '<b>Bloqueado</b>';
                }
                if ($_SESSION['rec_cup_clase'] == $clas || $clas == 'S') {
                    $dataE[$cont] = array('cup_nombre' => $titulo, 'cup_style' => $st, 'cup_msj' => $msj, 'cup_color' => $col, 'cup_url' => $url, 'cup_tipo' => $t);
                    $cont++;
                }
            } else {
                foreach ($datag as $value2) {
                    $es = $value2['cup_estado'];
                }
                $st = CuponesNegocio::getIcon(intval($id_tipo));
                $msj = CuponesNegocio::getEstado(intval($es));
                $col = CuponesNegocio::getColor(intval($id_tipo));
                if ($es == 1) {
                    $col = "#D3D1D1;";
                }
                $rrayu = CuponesNegocio::getDatosCupon(intval($id_tipo));
                foreach ($rrayu as $value4) {
                    $url = $value4["url"];
                }
                if ($bloqueo > 0) {
                    $col = '#D3D1D1;';
                    $msj = '<b>Bloqueado</b>';
                }
                if ($_SESSION['rec_cup_clase'] == $clas || $clas == 'S') {
                    $dataE[$cont] = array('cup_nombre' => $titulo, 'cup_style' => $st, 'cup_msj' => $msj, 'cup_color' => $col, 'cup_url' => $url, 'cup_tipo' => $t);
                    $cont++;
                }
                //$dat=var_dump($dataE);
            }
        }
        return $dataE;
    }

    public function getTipo($sucu) {
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        $datac = array();
        $dataf = array();
        $cont = 0;
        $data3 = Cupones::create()->functionCupTipo($org_id);
        $tam = count($data3);
        $cont = 1;
        foreach ($data3 as $value) {
            $ct = $value['cup_tipo'];
            $cnombre = $value['cup_nombre'];
            $clas = $value['cup_clase'];
            $titulo = $value['cup_titulo'];
            $id_tipo = $value['cup_id_tipo'];
            $datac[$cont] = array('cup_tipo' => $ct, 'cup_nombre' => $cnombre, 'cup_clase' => $clas, 'cup_titulo' => $titulo, 'id_tipo' => $id_tipo);
            $cont++;
        }
        return $datac;
    }

    public function getVerifica($t, $a, $ua) {

        $datab = Cupones::create()->functionCupVeri($t, $a, $ua);
        return $datab;
    }

    public function getDatosCupon($t) {

        $datab = Cupones::create()->functionDatosCupon($t);
        return $datab;
    }

    public function getColor($tipo) {

        switch ($tipo) {
            case 1:
                $color = '#F4A54A';
                break;
            case 2:
                $color = 'rgba(244, 205, 0, 0.65);';
                break;
            case 3:
                $color = 'rgba(28, 168, 221, 0.8);';
                break;
            case 4:
                $color = 'rgba(51, 184, 108, 0.8);';
                break;
            case 5:
                $color = 'rgba(28, 168, 221, 0.8);';
                break;
            case 6:
                $color = 'rgba(244, 205, 0, 0.65);';
                break;
            case 7:
                $color = 'rgba(40, 197, 0, 0.67);';
                break;
            case 8:
                $color = 'rgba(244, 205, 0, 0.65);';
                break;
        }

        return $color;
    }

    public function getIcon($tipo) {

        switch ($tipo) {
            case 1:
                $style = ' <i class="fa  fa-birthday-cake"></i> ';
                break;
            case 2:
                $style = "<i class='fa  fa-female' style='margin-right: 32px;'></i><i class='fa  fa-male'></i>";
                break;
            case 3:
                $style = '<i class="fa  fa-graduation-cap"></i>';
                break;
            case 4:
                $style = '<i class="fa  fa-group"></i>';
                break;
            case 5:
                $style = '<i class="fa  fa-child" style="margin-right: 55px;"></i>
                            <i class="fa  fa-road"></i>';
                break;
            case 6:
                $style = ' <i class="ion-ios7-alarm"></i><i class="ion-ios7-alarm" style="margin-right: 40px;margin-bottom: 50px;"></i> 
             <i class="ion-ios7-alarm" style="margin-right: 80px;"></i> ';
                break;
            case 7:
                $style = '<i class="fa fa-star" style="font-size: 15px;margin-bottom:70px;margin-right: 20px;"></i>
                            <i class="fa  fa-tree"></i> ';
                break;
            case 8:
                $style = '<i class="fa fa-child" style="margin-right: 50px;"></i>';
                break;
        }

        return $style;
    }

    public function getEstado($estado) {
        switch ($estado) {
            case 1:
                $msg_cup = '<b>Solicitado</b>, esperando aprobaci&oacute;n';
                break;
            case 2:
                $msg_cup = '</b>Aprobado</b>';
                break;
            case 3:
                $msg_cup = '<b>Rechazado</b>';
                break;
            case 101:
                $msg_cup = '<b>Anulado</b>, volver a utilizar cup&oacute;n</a>';
                break;
            default :
                $msg_cup = '<b>Sin utilizar</b>';
                break;
        }
        return $msg_cup;
    }

    public function getComboEspecialCupon() {
        session_start();
        $data2 = CuponesNegocio::local();
        foreach ($data2 as $value) {
            $sucu = $value["sucu"];
            $ua = $value["ua"];
        }
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }

        $f = date('Y-m-d');
        $data = array();
        $array = Cupones::create()->functionComboEspe(intval($ua), $f, intval($org_id));
        $cont = 0;
        foreach ($array as $value) {
            $d = $value['cep_id'];
            $nombre = $value['cep_nombre'];
            $fecha = $value['cep_fec_fin'];
            $f = CuponesNegocio::diaconfecha($fecha);
            $data[$cont] = array('ceid' => $d, 'nombre' => $nombre, 'fecha' => $f);
            $cont++;
        }
        return $data;
    }

    public function getComboPuente() {
        session_start();
        $anio = $_SESSION['rec_anio'];
        $ua = $_SESSION['rec_usu_id'];
        $sucu = $_SESSION['rec_suc_id'];
        $tipo=$_SESSION['tipo'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
        $ver = Cupones::create()->functionCupVeri($tipo, $anio, $ua);
        $fe = date('Y-m-d', strtotime($ver[0]['cup_fec_perm']));
        $html = "";

        $datap = array();
        $m = date("m");
        $dpuente = Cupones::create()->functionComboPuente($org_id);
        $cont = 0;
        foreach ($dpuente as $fila) {
            $feriado = strtotime($anio . "-" . $fila['mes'] . "-" . $fila['dia']);
            $fap=-1;
            
            if(intval($dpuente[$i]['mes'])-intval($dpuente[$i+1]['mes'])==0){
            $fap= intval($dpuente[$i]['mes'] . $dpuente[$i+1]['dia'])-intval($dpuente[$i]['mes'] . ($dpuente[$i]['dia'])); //729
            }
            if($fap==1){
                $fmp=$dpuente[$i]['mes'] . $dpuente[$i+1]['dia'];
                $fmpa=  strval(intval($fmp)-1);
            }
            //$html.=diaconfecha(date("Y-m-d",$feriado));
            if (date("D", $feriado) == "Tue" && ($fila['mes'] . $fila['dia'] != $fmp)) {
                //$html.=" Dia puente ".date("D, Y-m-d",strtotime($anio."-".$fila['mes']."-".$fila['dia']." - 1 day"));
                if (($fila['mes'] . $fila['dia'] != "11") && ($fila['dia'] > $d) && ($fila['mes'] > $m)) {
                    $fec = date("Y-m-d", strtotime($anio . "-" . $fila['mes'] . "-" . $fila['dia'] . " - 1 day"));
                    if ($fec <> $fe) {
                        $id = $fec;
                        $fecha = CuponesNegocio::diaconfecha($fec);
                        $datap[$cont] = array('id' => $id, 'fecha' => $fecha);
                        $cont++;
                        //  $html.="\t\t\t<option value='$fec'>".diaconfecha($fec)."</option>\n";
                    }
                }
            }
            if ((date("D", $feriado) == "Thu" && ($fila['mes'] . $fila['dia'] != $fmpa)) && ($fila['dia'] > $d) && ($fila['mes'] > $m)) {
                //$html.=" Dia puente ".date("D, Y-m-d",strtotime($anio."-".$fila['mes']."-".$fila['dia']." + 1 day"));
                $fec = date("Y-m-d", strtotime($anio . "-" . $fila['mes'] . "-" . $fila['dia'] . " + 1 day"));
                if ($fec <> $fe) {
                    $id = $fec;
                    $fecha = CuponesNegocio::diaconfecha($fec);
                    $datap[$cont] = array('id' => $id, 'fecha' => $fecha);
                    $cont++;
                    // $html.="\t\t\t<option value='$fec'>".diaconfecha($fec)."</option>\n";
                }
            }
            //$html.="<br>";
        }
        if (date("D", strtotime(($anio + 1) . "-01-01")) == "Tue") {
            $fec = date("Y-m-d", strtotime(($anio) . "-12-31"));
            $id = $fec;
            $fecha = DateUtil::diaconfecha($fec);
            $fecha2 = $fecha . " (Cuponera " . ($anio + 1) . ")</option>";
            $datap[$cont] = array('id' => $id, 'fecha' => $fecha);
            $cont++;
            //$html.="\t\t\t<option value='$fec'>".diaconfecha($fec)." (Cuponera ".($anio+1).")</option>\n";
        }
        return $datap;
    }

    public function getEstadoC($estado, $f1, $f2, $tt) {
        if ($f1 != "") {
            $fi = CuponesNegocio::diaconfecha($f1);
        }
        if ($f2 != "") {

            $ff = CuponesNegocio::diaconfecha($f2);
        }$turno = '';
        $t = $_SESSION['tipo'];
        if ($t == 6 and $tt != 2) {
            $turno = (($tt == 1) ? ", turno: ma&ntilde;ana (8:00am a 12:30pm)" : "turno: tarde (12:30pm a 6:00pm)");
        }
        switch ($estado) {
            case 1:
                $msg_cup = '<b>Estado: Solicitado</b>, para los d&iacute;a ' . $fi . ' y ' . $ff . ', esperando aprobaci&oacute;n.';
                if ($t == 6 || $t == 1 || $t == 3 || $t == 4 || $t == 5) {
                    $msg_cup = '<b>Estado: Solicitado</b>, para el d&iacute;a ' . $fi . $turno . ' esperando aprobaci&oacute;n.';
                }
                break;
            case 2:
                $msg_cup = "Estado: <font color='green'><b>Aprobado</b></font> para los d&iacute;as " . $fi . ' y ' . $ff . ".";
                if ($t == 6 || $t == 1 || $t == 3 || $t == 4 || $t == 5) {
                    $msg_cup = "Estado: <font color='green'><b>Aprobado</b></font> para los d&iacute;as " . $fi . $turno . ".";
                }
                break;
            case 3:
                $msg_cup = "Estado: <font color='red'><b>Rechazado</b></font> para los d&iacute;as " . $fi . ' y ' . $ff . ". Puede volver a utilizar el cup&oacute;n.</a>";
                if ($t == 6 || $t == 1 || $t == 3 || $t == 4 || $t == 5) {
                    $msg_cup = "Estado: <font color='red'><b>Rechazado</b></font> para los d&iacute;as " . $fi . $turno . ". Puede volver a utilizar el cup&oacute;n.</a>";
                }
                break;
            case 101:
                $msg_cup = "Estado: <font color='red'><b>Anulado</b></font> para los d&iacute;as " . $fi . ' y ' . $ff . ". Puede volver a utilizar el cup&oacute;n.</a>";
                if ($t == 6 || $t == 1 || $t == 3 || $t == 4 || $t == 5) {
                    $msg_cup = "Estado: <font color='red'><b>Anulado</b></font> para los d&iacute;as " . $fi . $turno . ". Puede volver a utilizar el cup&oacute;n.</a>";
                }
                break;
            default :
                $msg_cup = '<b>Estado: Sin utilizar</b>';
                break;
        }

        return $msg_cup;
    }

    //func.php dìa habil
    public function diahabil($fecha, $anio) {
        $a = 1900;
        if ($anio != "") {
            $a = $anio;
        }
        $msg = "";
        $fec_time = strtotime($fecha);
        $dia = date("D", $fec_time);

        if ($dia == "Sat")
            $msg.="ERROR: D&iacute;a seleccionado es s&aacute;bado";
        if ($dia == "Sun")
            $msg.="ERROR: D&iacute;a seleccionado es domingo";
        $fila = Cupones::create()->functionFeriados(1, $a);
        if ($fila != 0) {
            $feriado = strtotime($anio . "-" . $fila[0]['mes'] . "-" . $fila[0]['dia']);
            $nota = $fila[0]['nota'];
            if ($fec_time == $feriado)
                $msg.="ERROR: D&iacute;a seleccionado es feriado por " . $nota . "<br>";
        }


        $fila1 = Cupones::create()->functionFeriados(2, $a);
        if ($fila1 != 0) {
            $feriado = strtotime($fila1[0]['fecha']);
            $nota = $fila1[0]['nota'];
            if ($fec_time == $feriado)
                $msg.="ERROR: D&iacute;a seleccionado es feriado por " . $nota . "<br>";
        }


        return $msg;
    }

    public function diaconfecha($fecha, $ext = NULL) {
        $fec_time = strtotime($fecha);

        $dia = date("D", $fec_time);

        if ($dia == "Mon")
            $dia = "Lun";
        if ($dia == "Tue")
            $dia = "Mar";
        if ($dia == "Wed")
            $dia = "Mie";
        if ($dia == "Thu")
            $dia = "Jue";
        if ($dia == "Fri")
            $dia = "Vie";
        if ($dia == "Sat")
            $dia = "Sab";
        if ($dia == "Sun")
            $dia = "Dom";

        $mes = date("M", $fec_time);

        if ($mes == "Jan")
            $mes = "Ene";
        if ($mes == "Feb")
            $mes = "Feb";
        if ($mes == "Mar")
            $mes = "Mar";
        if ($mes == "Apr")
            $mes = "Abr";
        if ($mes == "May")
            $mes = "May";
        if ($mes == "Jun")
            $mes = "Jun";
        if ($mes == "Jul")
            $mes = "Jul";
        if ($mes == "Aug")
            $mes = "Ago";
        if ($mes == "Sep")
            $mes = "Set";
        if ($mes == "Oct")
            $mes = "Oct";
        if ($mes == "Nov")
            $mes = "Nov";
        if ($mes == "Dec")
            $mes = "Dic";

        $anio = date("Y", $fec_time);
        $dia2 = date("j", $fec_time);

        if (is_null($ext))
            return "$dia, $dia2 $mes $anio";
        else
            $hora = date("h:i:s A", $fec_time);
        return "$dia, $dia2 $mes $anio $hora";
    }

    public function getDetalleDiasCupEsp($fec_ini, $dias) {
        $arr = array();

        $arr[] = $fec_ini;
        $j = 1;
        for ($i = 1; $i < $dias; $i++) {
            $alert = 1;
            while ($alert == 1) {
                $fecha = date("Y-m-d", strtotime($fec_ini . "+$j day"));
                $diahabil = CuponesNegocio::diahabil($fecha, substr($fecha, 0, 4));
                if (strlen($diahabil) == 0) {
                    $arr[] = $fecha;
                    $alert = 0;
                } else {
                    $alert = 1;
                }
                $j++;
            }
        }

        return $arr;
    }

    function getCupNombre($cup_tipo) {
        $datn = Cupones::create()->functionCuponNombre($cup_tipo);
        $cup_nombre = "NN";
        foreach ($datn as $fila) {
            $cup_nombre = $fila['cup_nombre'];
        }



        return $cup_nombre;
    }

    public function getDiasOcupados($cup_anio, $usu_id) {
        $arr = array();

        //Revisar en tabla cupones solo los registros que esten en estado 1, 2
        $data = Cupones::create()->functionDiasOcupados($usu_id, $cup_anio);

        foreach ($data as $fila) {
            switch ($fila['cup_estado']) {
                case 1:
                    $estado = "Solicitado";
                    break;
                case 2:
                    $estado = "Aprobado";
                    break;
                default:
                    $estado = "Inv&aacute;lido";
            }
            if (is_null($fila['cup_fec_perm2'])) {
                $arr[] = array("Cup&oacute;n", $fila['cup_nombre'], $fila['cup_fec_perm'], $estado);
            } else {
                $arr[] = array("Cup&oacute;n", $fila['cup_nombre'], $fila['cup_fec_perm'], $estado);
                $arr[] = array("Cup&oacute;n", $fila['cup_nombre'], $fila['cup_fec_perm2'], $estado);
            }
        }

        $data2 = Cupones::create()->functionEstadoSolicitudes($cup_anio, $cup_anio, $usu_id);

        foreach ($data2 as $fila) {
            switch ($fila['ces_estado']) {
                case 1:
                    $estado = "Solicitado";
                    break;
                case 2:
                    $estado = "Aprobado";
                    break;
                default:
                    $estado = "Inv&aacute;lido";
            }
            $arr2 = CuponesNegocio::getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
            if (count($arr2) > 0) {
                foreach ($arr2 as $v) {
                    $arr[] = array("Cup&oacute;n especial", $fila['cep_nombre'], $v, $estado);
                }
            }
        }
        //Revisar en tabla vacaciones solo los registros de goce que esten en estado 1, 2, 4 y 5
        $cup_anio_ant = $cup_anio - 1;
        $data3 = Cupones::create()->functionVacacionesEstado($cup_anio, $cup_anio_ant, $usu_id);


        foreach ($data3 as $fila) {
            switch ($fila['vac_estado']) {
                case 1:
                    $estado = "Solicitado";
                    break;
                case 2:
                    $estado = "Aprobado";
                    break;
                case 4:
                    $estado = "Actualizado";
                    break;
                case 5:
                    $estado = "Ejecutado";
                    break;
                default:
                    $estado = "Inv&aacute;lido";
            }
            for ($i = 0; $i < $fila[1]; $i++) {
                $arr[] = array("Vacaciones", "Goce", date("Y-m-d", strtotime($fila['vac_fec_ini'] . " + " . $i . " day")), $estado);
            }
        }

        return $arr;
    }

    public function cruceFechas($usu_id, $fecha_ini, $dias, $sdf_include) {
        //sdf = Sabado, Domingo, Feriados
        $cruce = false;
        $msg = null;

        // Arreglo de dias a consultar
        $arrCons = null;

        // Arreglo de dias ocupados
        $arrOcup = CuponesNegocio::getDiasOcupados(date("Y"), $usu_id);

        if ($sdf_include == false) {
            // Para cupones y cupones especiales
            // Obtiene los dias validos de un periodo de fechas sin incluir los dias no habiles (sabado, domingo, feriados)
            $arrCons = CuponesNegocio::getDetalleDiasCupEsp($fecha_ini, $dias);
        } else {
            // Para vacaciones
            // Agarra todos los dias sin importar si es sabado, domingo o feriado
            for ($i = 0; $i < $dias; $i++) {
                $arrCons[] = date("Y-m-d", strtotime($fecha_ini . " + " . $i . " day"));
            }
        }

        // Revisar arreglo contra arreglo
        foreach ($arrCons as $v) {
            foreach ($arrOcup as $w) {
                if ($v == $w[2]) {
                    $cruce = true;
                    $msg = $w[2] . " (" . $w[0] . " : " . $w[1] . ")";
                    break 2;
                }
            }
        }

        return array($cruce, $msg);
    }

    public function getProxDiaHabil($fecha) {
        //formato de $fecha debe ser anio mes dia por ejemplo: 2013-03-20
        $anio = substr($fecha, 0, 4);

        $dia = " ";

        while (strlen($dia) <> 0) {
            $fec_time = strtotime($fecha . " + 1 day");
            $fecha = date("Y-m-d", $fec_time);
            $dia = CuponesNegocio::diahabil($fecha, $anio);
        }

        return $fecha;
    }

    public function getCorreoUsuario($ldap_user) {


        $correo = "";

        $datac = Cupones::create()->functionObtenerCorreo($ldap_user);
        foreach ($datac as $fila) {


            if (strlen($fila[0]) > 0)
                $correo = $fila[1];
            else
                $correo = $ldap_user . "@netafim.com.pe";
        }

        return trim($correo);
    }

    public function getJefeDirecto($usu_ad) {
        $usu_jefe = "";

        $datac = Cupones::create()->functionJefes($usu_ad, 1);
        foreach ($datac as $fila) {
            $usu_jefe = $fila['usu_jefe'];
        }


        if (strlen($usu_jefe) == 0)
            $usu_jefe = "RRHH";



        return $usu_jefe;
    }

    public function getGerenteDirecto($usu_ad) {

        $datac = Cupones::create()->functionJefes($usu_ad, 2);
        foreach ($datac as $fila) {
            $usu_gerente = $fila['usu_gerente'];
        }
        $usu_gerente = $fila['usu_gerente'];
        if (strlen($usu_gerente) == 0)
            $usu_gerente = "RRHH";


        return $usu_gerente;
    }

//NA
    public function getAdmSucursal($usu_ad) {

        $datac = Cupones::create()->functionJefes($usu_ad, 3);
        foreach ($datac as $fila) {
            $usu = $fila['suc_adm'];
        }
        if (strlen($usu) == 0)
            $usu = "RRHH";


        return $usu;
    }

//NA
    public function getJefeRRHH() {
        $datac = Cupones::create()->functionAdministradores(1);
        foreach ($datac as $fila) {
            $usu = $fila['usu_ad'];
        }

        if (strlen($usu) == 0)
            $usu = "RRHH";

        return $usu;
    }

//NA
    public function getAsistSocial() {
        $datac = Cupones::create()->functionAdministradores(2);
        foreach ($datac as $fila) {
            $usu = $fila['usu_ad'];
        }
        if (strlen($usu) == 0)
            $usu = "RRHH";

        return $usu;
    }

//NA
    public function getAsistCompen() {
        $datac = Cupones::create()->functionAdministradores(3);
        foreach ($datac as $fila) {
            $usu = $fila['usu_ad'];
        }
        if (strlen($usu) == 0)
            $usu = "RRHH";

        return $usu;
    }

//NA
    public function getAdmi() {
        $datac = Cupones::create()->functionAdministradores(4);
        foreach ($datac as $fila) {
            $usu = $fila['usu_ad'];
        }
        if (strlen($usu) == 0)
            $usu = "RRHH";

        return $usu;
    }

//NA
    public function getGerenteGeneral() {
        $datac = Cupones::create()->functionAdministradores(5);
        foreach ($datac as $fila) {
            $usu = $fila['usu_ad'];
        }
        if (strlen($usu) == 0)
            $usu = "RRHH";

        return $usu;
    }

//NA
    public function getTesorero() {
        $datac = Cupones::create()->functionAdministradores(6);
        foreach ($datac as $fila) {
            $usu = $fila['usu_ad'];
        }
        if (strlen($usu) == 0)
            $usu = "RRHH";


        return $usu;
    }

    public function functionArchivar($file, $nombre, $ruta) {
        $decode = Util::base64ToImage($file);
//        throw new WarningException($file);
        if ($file == null || $file == '') {
            $imagen = null;
        } else {
            $imagen = $nombre;
            file_put_contents(__DIR__ . $ruta . $imagen, $decode);
            return 1;
            exit;
        }
        return 0;
    }

    function getDiasUsadosCupEsp($usu_id, $cep_id) {
        $data = Cupones::create()->functionDiasOcupadoCEspeciales($usu_id, $cep_id);
        $count = 0;
        foreach ($data as $fila) {
            $count = $fila['ces_dias'];
        }

        return $count;
    }

    public function getFechaVencCupEsp($cep_id) {
        //jalar datos de la consulta de cupones especiales
    }

    public function getAprobadorLevel($id) {
        $array = Especiales::create()->functionAprobadorLevel(9, $id);
        foreach ($array as $fila) {
            $level = $fila['cep_aprobador'];
        }
        return $level;
    }

    public function enviarCorreo($to, $cc, $subject, $body, $attachString = NULL, $attachFilename = NULL) {
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'mocha3017.mochahost.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@imaginatecperu.com';
        $mail->Password = 'no-reply';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->From = 'no-reply@imaginatecperu.com';
        $mail->FromName = 'Imagina Technologies';
        $mail->AddAddress($to);
        $mail->AddCC($cc);
        $mail->WordWrap = 90;
        $mail->IsHTML(false);
        $mail->Subject = "[SGA] " . $subject;
        $mail->Body = $body;
        if (!$mail->Send()) {
            $this->setMensajeEmergente($mail->ErrorInfo, null, Configuraciones::MENSAJE_WARNING);
        }
    }

    public function getUsuNom($usu_id) {
        $array = Cupones::create()->functionNombreUsu($usu_id);
        foreach ($array as $fila) {
            $usu_nombre = $fila['usu_nombre'];
        }
        return $usu_nombre;
    }

    public function getFechaPrimeraSolicitudCupEsp($id) {
        $fecha = date("Y") . "-01-01";

        if ($id != 255) {
            $arr = Cupones::create()->functionFechaPrimeraSolicitudCupEsp(1, $id);
        } else {
            $arr = Cupones::create()->functionFechaPrimeraSolicitudCupEsp(2, $id);
        }

        foreach ($arr as $fila) {
            $fecha = $fila['fecha'];
        }



        return $fecha;
    }

    public function listadiapuentehtml($anio) {
        $html =array();
        session_start();
        $ua = $_SESSION['rec_usu_id'];
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
                $cont=0;
        $dpuente = Cupones::create()->functionComboPuente($org_id);
        for ($i = 0; $i < count($dpuente); $i++) {
            $fap=-1;
            $faa=-1;
            $feriado = strtotime($anio . "-" . $dpuente[$i]['mes'] . "-" . $dpuente[$i]['dia']);
            if(intval($dpuente[$i]['mes'])-intval($dpuente[$i+1]['mes'])==0){
            $fap= intval($dpuente[$i]['mes'] . $dpuente[$i+1]['dia'])-intval($dpuente[$i]['mes'] . ($dpuente[$i]['dia'])); //729
            }
            if($fap==1){
                $fmp=$dpuente[$i]['mes'] . $dpuente[$i+1]['dia'];
                $fmpa=  strval(intval($fmp)-1);
            }
            if (date("D", $feriado) == "Tue" && ($dpuente[$i]['mes'] . $dpuente[$i]['dia'] !=$fmp)) {
                if ($dpuente[$i]['mes'] . $dpuente[$i]['dia'] != "11") {
                    $fec = date("Y-m-d", strtotime($anio . "-" . $dpuente[$i]['mes'] . "-" . $dpuente[$i]['dia'] . " - 1 day"));
                    $html[$cont]['fecha']=CuponesNegocio::diaconfecha($fec) ;
                    $cont++;
                }
                //728
            }

            if (date("D", $feriado) == "Thu" && ($dpuente[$i]['mes']. $dpuente[$i]['dia']!=$fmpa)) {
                $fec = date("Y-m-d", strtotime($anio . "-" . $dpuente[$i]['mes'] . "-" . $dpuente[$i]['dia'] . " + 1 day"));
                $html[$cont]['fecha']=CuponesNegocio::diaconfecha($fec) ;
                    $cont++;
            }
        }


        if (date("D", strtotime(($anio + 1) . "-01-01")) == "Tue") {
            $fec = date("Y-m-d", strtotime(($anio) . "-12-31"));
            $html[$cont]['fecha']= CuponesNegocio::diaconfecha($fec) . " (Cuponera " . ($anio + 1) . ")";
                    $cont++;
        }

        return $html;
    }
 public function listadiapuentehtmlS($anio) {
        $html =array();
        session_start();
        $ua = $_SESSION['rec_usu_id'];
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = $value['org_id'];
        }
                $cont=0;
        $dpuente = Cupones::create()->functionComboPuente($org_id);
        for ($i = 0; $i < count($dpuente); $i++) {
            $fap=-1;
            
            $feriado = strtotime($anio . "-" . $dpuente[$i]['mes'] . "-" . $dpuente[$i]['dia']);
            if(intval($dpuente[$i]['mes'])-intval($dpuente[$i+1]['mes'])==0){
            $fap= intval($dpuente[$i]['mes'] . $dpuente[$i+1]['dia'])-intval($dpuente[$i]['mes'] . ($dpuente[$i]['dia'])); //729
            }
            if($fap==1){
                $fmp=$dpuente[$i]['mes'] . $dpuente[$i+1]['dia'];
                $fmpa=  strval(intval($fmp)-1);
            }
            if (date("D", $feriado) == "Tue" && ($dpuente[$i]['mes'] . $dpuente[$i]['dia'] != $fmp)) {
                if ($dpuente[$i]['mes'] . $dpuente[$i]['dia'] != "11") {
                    $fec = date("Y-m-d", strtotime($anio . "-" . $dpuente[$i]['mes'] . "-" . $dpuente[$i]['dia'] . " - 1 day"));
                    $html[$cont]['fecha']=$fec ;
                    $cont++;
                }
            }
            if (date("D", $feriado) == "Thu" && ($dpuente[$i]['mes'] . $dpuente[$i]['dia'] != $fmpa)) {
                $fec = date("Y-m-d", strtotime($anio . "-" . $dpuente[$i]['mes'] . "-" . $dpuente[$i]['dia'] . " + 1 day"));
                $html[$cont]['fecha']=$fec ;
                    $cont++;
            }
        }


        if (date("D", strtotime(($anio + 1) . "-01-01")) == "Tue") {
            $fec = date("Y-m-d", strtotime(($anio) . "-12-31"));
            $html[$cont]['fecha']= $fec . " (Cuponera " . ($anio + 1) . ")";
                    $cont++;
        }

        return $html;
    }
}
