<?php

require_once __DIR__ . '/../../modelo/cuponera/Especiales.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Asignaciones.php';
require_once __DIR__ . '/../../modelo/cuponera/EspecialesSolicitudes.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../util/ConstantesMail.php';

class EspecialesNegocio extends ModeloNegocioBase {
    

    public function DiasDisponibles($ce_id) {
        session_start();
        $usu_id=$_SESSION['rec_usu_id'];
        $dataD=  Asignaciones::create()->DiasCuponAsignado(8,$ce_id,$usu_id,"");
        $diasU=  CuponesNegocio::create()->getDiasUsadosCupEsp($usu_id,$ce_id);
        foreach ($dataD as $value) {
            $dias_d=$value['cea_dias'];
            $cep_id=$value['cep_id'];
        }
        $dias_dipo=$dias_d-$diasU;
        $dataR=array();
        $dataR=array('cea_dias'=>$dias_dipo,'dias'=>$dias_d,'cep_id'=>$cep_id);
        return $dataR;
    }
    public function DatosCuponEspecial($ce_id) {
        $response=  Especiales::create()->dataCuponEspecial(8,$ce_id);
        return $response;
    }
    public function SearchEspecial($cep_id) {
        $cep = intval($cep_id);
        $datC = Especiales::create()->functionSearchEspecial(5, $cep);
        return $datC;
    }

    //insertar cupon especial
    public function functionInsertEspeciales($ce_fec_ini, $ce_fec_fin, $ce_nombre, $ce_descri, $ce_saludo, $ce_activo, $ce_aprobador, $cup_doc, $doc_s, $doc_t, $file) {
        session_start();
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = intval($value['org_id']);
        }
        $mimeTypes = array("image/jpeg", "image/pjpeg", "image/png");
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $ext = explode(".", $cup_doc);
        $extension = end($ext);

        $cup_doc_attach = "cep " . uniqid() . " " . substr($cup_doc, 0, 80);
        //verificamos el tipo de documento
        if (!in_array($doc_t, $mimeTypes) && $doc_t != "") {
            $flag = 1;
            $response[2]["vout_exito"] = 0;
            $response[2]["vout_mensaje"] = "Archivo inv&aacute;lido. Los formatos permitidos son pdf, jpg, microsoft word, zip o rar y no podr&aacute; exceder los 6 megabytes de tama&ntilde;o";
        }
        if ($doc_t == "" && $cup_doc != "") {
            if (!in_array($extension, $allowedExts)) {
                $flag = 1;
                $response[3]["vout_exito"] = 0;
                $response[3]["vout_mensaje"] = "Archivo inv&aacute;lido. Los formatos permitidos son pdf, jpg, microsoft word, zip o rar y no podr&aacute; exceder los 6 megabytes de tama&ntilde;o";
            }
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        //validamos tamanio del archivo
        if (intval($doc_s) > 600000) {
            $flag = 1;
            $response[4]["vout_exito"] = 0;
            $response[4]["vout_mensaje"] = "el archivo no debe exceder los 6 megabytes de tama&ntilde;o";
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        if ($cup_doc != "") {
            $ruta = '/../../vistas/com/especiales/archivos/';
            $rs = CuponesNegocio::functionArchivar($file, $cup_doc_attach, $ruta);
            if ($rs != 1) {
                $flag = 1;
                $response[5]["vout_exito"] = 0;
                $response[5]["vout_mensaje"] = "Error al guardar archivo.";
            }
//      move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__.'/../../util/uploads/'. $cup_doc_attach);
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        //end archivo

        $response = Especiales::create()->insertEspeciales(2, "", $ce_fec_ini, $ce_fec_fin, $ce_nombre, $ce_descri, $ce_saludo, intval($ce_activo), $cup_doc_attach, intval($ce_aprobador), $org_id);
        $dataI = Especiales::create()->functionLastID(6);
        foreach ($dataI as $id) {
            $cep_id = $id['cep_id'];
        }
        $descri = "Registro de cupon especial - identificador ($cep_id), nuevos valores: nombre ($ce_nombre), desc ($ce_descri), saludo ($ce_saludo), fec_ini ($ce_fec_ini), fec_fin ($ce_fec_fin), aprobador ($ce_aprobador), estado ($ce_activo), imagen ($cup_doc)";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($descri,$_SESSION['rec_usu_id'],$mov_ip, $mov_host);
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

    //edit cupon especial
    public function functionEditEspeciales($cep_id, $ce_fec_ini, $ce_fec_fin, $ce_nombre, $ce_descri, $ce_saludo, $ce_activo, $ce_aprobador, $cup_doc, $doc_s, $doc_t, $file, $img_ant, $op_img) {
                session_start();

        if ($op_img == '1') {
            $cup_doc_attach = $img_ant;
        }
        if ($op_img == '2') {
             unlink(__DIR__ . '/../../vistas/com/especiales/archivos/' .$img_ant);
            $mimeTypes = array("image/jpeg", "image/pjpeg", "image/png");
            $allowedExts = array("jpg", "jpeg", "gif", "png");
            $ext = explode(".", $cup_doc);
            $extension = end($ext);

            $cup_doc_attach = "cep_". uniqid() ."_".substr($cup_doc, 0, 80);
            //verificamos el tipo de documento
            if (!in_array($doc_t, $mimeTypes) && $doc_t != "") {
                $flag = 1;
                $response[2]["vout_exito"] = 0;
                $response[2]["vout_mensaje"] = "Archivo inv&aacute;lido. Los formatos permitidos son pdf, jpg, microsoft word, zip o rar y no podr&aacute; exceder los 6 megabytes de tama&ntilde;o";
            }
            if ($doc_t == "" && $cup_doc != "") {
                if (!in_array($extension, $allowedExts)) {
                    $flag = 1;
                    $response[3]["vout_exito"] = 0;
                    $response[3]["vout_mensaje"] = "Archivo inv&aacute;lido. Los formatos permitidos son pdf, jpg, microsoft word, zip o rar y no podr&aacute; exceder los 6 megabytes de tama&ntilde;o";
                }
            }
            if ($flag == 1) {
                $response[0]["vout_exito"] = 0;
                $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
                return $response;
                exit();
            }
            //validamos tamanio del archivo
            if (intval($doc_s) > 600000) {
                $flag = 1;
                $response[4]["vout_exito"] = 0;
                $response[4]["vout_mensaje"] = "el archivo no debe exceder los 6 megabytes de tama&ntilde;o";
            }
            if ($flag == 1) {
                $response[0]["vout_exito"] = 0;
                $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
                return $response;
                exit();
            }
            if ($cup_doc != "") {
                $ruta = '/../../vistas/com/especiales/archivos/';
                $rs = CuponesNegocio::functionArchivar($file, $cup_doc_attach, $ruta);
                if ($rs != 1) {
                    $flag = 1;
                    $response[5]["vout_exito"] = 0;
                    $response[5]["vout_mensaje"] = "Error al guardar archivo.";
                }
                //end archivo  
            }
            if ($flag == 1) {
                $response[0]["vout_exito"] = 0;
                $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
                return $response;
                exit();
            }
        }

         if ($op_img == '3'){
             unlink(__DIR__ . '/../../vistas/com/especiales/archivos/' .$img_ant);
             $cup_doc_attach="";
         }

        $response = Especiales::create()->insertEspeciales(3,$cep_id, $ce_fec_ini, $ce_fec_fin, $ce_nombre, $ce_descri, $ce_saludo, intval($ce_activo), $cup_doc_attach, intval($ce_aprobador),"");
       
$descri = "Actualizacion de datos de cupon especial - identificador ($cep_id), nuevos valores: nombre ($ce_nombre), desc ($ce_descri), saludo ($ce_saludo), fec_ini ($ce_fec_ini), fec_fin ($ce_fec_fin), aprobador ($ce_aprobador), estado ($ce_activo), imagen ($cup_doc_attach)";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($descri,$_SESSION['rec_usu_id'], $mov_ip, $mov_host);
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

    public function functionDeleteEspeciales($cep_id) {
               session_start();

        $datC = Especiales::create()->functionSearchEspecial(5, $cep_id);
        foreach ($datC as $fila) {
            $cep_nombre = $fila['cep_nombre'];
            $cep_descripcion = $fila['cep_descripcion'];
            $img_ant = $fila['cep_imagen'];
        }
        $response = Especiales::create()->functionDeleteEspecial(4, $cep_id);
        $mov_descri = "Eliminacion de cupon especial - identificador ($cep_id), nombre ($cep_nombre), descripcion ($cep_descripcion)";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($mov_descri,$_SESSION['rec_usu_id'], $mov_ip, $mov_host);
        if (strlen($img_ant) > 0)
            unlink(__DIR__ . '/../../vistas/com/especiales/archivos/' . $img_ant);
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

    public function getDataEspeciales() {
        session_start();
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = intval($value['org_id']);
        }
        $data = Especiales::create()->functionGetAll(1, "", "", "", "", "", "", "", "", "", $org_id);
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            if ($data[$i]['cep_activo'] == 1) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c";
                $data[$i]['estado'] = "Activo";
            } else {
                $data[$i]['icono'] = "ion-flash-off";
                $data[$i]['color'] = "#cb2a2a";
                $data[$i]['estado'] = "Inactivo";
            }
            if ($data[$i]['cep_aprobador'] == 1) {
                $data[$i]['aprobador'] = "Jefe";
            } else {
                $data[$i]['aprobador'] = "Gerente";
            }
        }
        return $data;
    }

    public function getDataEditar($cep_id) {
        $data = Especiales::create()->dataEditEspeciales(7, $cep_id);
        return $data;
    }
    //cupone especial solicitud
    public function functionInsertSolicitud($cep_id,$dias,$fecha) {
        session_start();
        $usu_id=$_SESSION['rec_usu_id'];
        $diahabil=  CuponesNegocio::create()->diahabil($fecha, substr($fecha, 0, 4));
	if (strlen($diahabil)>0) {
		  $flag=1;
               $response[2]["vout_exito"] = 0;
                $response[2]["vout_mensaje"] =$diahabil;
	}
        if (strtotime($fecha) <= strtotime(date('Y-m-d'))) {
		$flag=1;
                  $response[3]["vout_exito"] = 0;
                $response[3]["vout_mensaje"] ="Solo se permite seleccionar la fecha de permiso desde ma&ntilde;ana hasta el fin del año actual<br>";
		}
                //datoscuponespecial
                $arr =  CuponesNegocio::create()->getDetalleDiasCupEsp($fecha, $dias);
	$fecha_f = end($arr);
	$array = EspecialesNegocio::DatosCuponEspecial($cep_id);
        foreach ($array as $fila) {
            $cep_fec_fin = $fila['cep_fec_fin'];
            $ces_nombre=$fila['cep_nombre'];
        }
	if (strtotime($cep_fec_fin) < strtotime($fecha_f)) {
            $flag=1;
            $fecha_fin=CuponesNegocio::create()->diaconfecha($cep_fec_fin);
                  $response[4]["vout_exito"] = 0;
                $response[4]["vout_mensaje"] ="La fecha final del permiso no puede exceder de lo que permite el periodo (".$fecha_fin.")<br>";
	}
        list($cruce, $msg_cruce) = CuponesNegocio::create()->cruceFechas($usu_id, $fecha, $dias, false);
	if ($cruce) {
		$flag=1;
                  $response[4]["vout_exito"] = 0;
                $response[4]["vout_mensaje"] ="ERROR: Cruce de fecha el dia ".utf8_encode($msg_cruce)."<br>";
	}
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error al enviar solicitud.";
            return $response;
            exit();
        }
        $response= EspecialesSolicitudes::create()->insertEspecialesSolicitudes(2,$usu_id,$cep_id,1,$fecha,$fecha_f,$dias);
         $dataI = EspecialesSolicitudes::create()->functionLastID(5);
        foreach ($dataI as $id) {
            $ces_id = $id['ces_id'];
        }
	$descri = "Registro solicitud cupon especial (id : ".$ces_id.") - ".$ces_nombre." - de ".$_SESSION['rec_usu_nombre'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($descri,$_SESSION['rec_usu_id'],$mov_ip, $mov_host);
        //start ec
	$to =  CuponesNegocio::create()->getCorreoUsuario($_SESSION['ldap_user']);
	$cc =$cc = "ggarcia@imaginatecperu.com";// array();
        $apro_level=  CuponesNegocio::create()->getAprobadorLevel($cep_id);
	if ($apro_level==2) {
		array_push ($cc, CuponesNegocio::getGerenteDirecto($_SESSION['ldap_user']).'@netafim.com.pe');
	}
	else {
		array_push ($cc, CuponesNegocio::getJefeDirecto($_SESSION['ldap_user']).'@netafim.com.pe');
	}

	array_push ($cc, CuponesNegocio::getAsistSocial().'@netafim.com.pe');
	array_push ($cc, CuponesNegocio::getJefeRRHH().'@netafim.com.pe');
	array_push ($cc, 'rrhh@netafim.com.pe');
	$subject = ConstantesMail::PARAM_E_SUBJECT.$ces_nombre." de ".$_SESSION['rec_usu_nombre'];
	$body = ConstantesMail::PARAM_E_BODY.$ces_nombre." de ".$_SESSION['rec_usu_nombre']." para usar ".$dias.ConstantesMail::PARMA_E_BODY_2;
	foreach ($arr as $k=>$v) {
		$body .= "Dia ".($k+1).": ".  CuponesNegocio::diaconfecha($v)."\n";
	}
	$espc  = $body;
	$body .= ConstantesMail::PARAM_APRO_GD;
	CuponesNegocio::create()->enviarCorreo($to, $cc, $subject, $body);
//start enviar correo mayler carpeta
	
	$subject = ConstantesMail::PARAM_E_SUBJECT.$ces_nombre." de ".$_SESSION['rec_usu_nombre'];
	$id                = $id;
	$aprobador         = CuponesNegocio::getGerenteDirecto($_SESSION['ldap_user']);
	$location          = "recursos/ce_aprob";//falta corregir ruta
	$detalle_operacion = $espc;
	$operacion         = ConstantesMail::PARA_OPE;
	//ConstructorMail::enviarCorreoAprobacion($id, $aprobador, $location, $detalle_operacion, $operacion, "template_1", "", array("subject" => $subject));
        //end nc
        
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
    
    public function getCuponesEspecialesUso($id, $aprob) {
	$arrCup = array();

	if ($aprob>0) $q_aprob = "AND ( u.usu_jefe='".$_SESSION['ldap_user']."'
	OR u.usu_gerente='".$_SESSION['ldap_user']."'
	OR u2.usu_ad='".$_SESSION['ldap_user']."')";
	else $q_aprob = "";
        $data=  Especiales::create()->obtenerCuponesEspecialesUso($id,$aprob,$q_aprob);
        //se recoge la primera fila del resultado que arroja la consulta
        $fila=$data[0];
	// Procesa primera fila de consulta SQL
	if (count($fila)>0) {
		$usu_nombre = $fila['usu_nombre'];
		$usu_id = $fila['usu_id'];
		$cea_dias = $fila['cea_dias'];
		$dias_sol = 0;
		$dias_aprob = 0;
		$msg_det_sol = "";
		$msg_det_aprob = "";
		if ($fila['ces_estado']==1) {
			$dias_sol+=$fila['ces_dias'];
			$msg_det_sol .= "<b>".$fila['ces_dias']." dia(s)</b> [";
			$arr = getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
			foreach ($arr as $v) {
				$detalle[] = CuponesNegocio::diaconfecha($v);
				
			}
			$msg_det_sol .= implode(" ; ", $detalle);
			$msg_det_sol .= "]<br>";
		}
		if ($fila['ces_estado']==2) {
			$dias_aprob+=$fila['ces_dias'];
			$msg_det_aprob .= "<b>".$fila['ces_dias']." dia(s)</b> [";
			$arr =  CuponesNegocio::getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
			foreach ($arr as $v) {
				$detalle[] = CuponesNegocio::diaconfecha($v);
				
			}
			$msg_det_aprob .= implode(" ; ", $detalle);
			$msg_det_aprob .= "]<br>";
		}
		unset($detalle);

		// Procesa resto de filas de consulta SQL
		foreach ($data as $fila) {
			if ($usu_nombre == $fila['usu_nombre']) {
				if ($fila['ces_estado']==1) {
					$dias_sol+=$fila['ces_dias'];
					$msg_det_sol .= "<b>".$fila['ces_dias']." dia(s)</b> [";
					$arr =  CuponesNegocio::getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
					foreach ($arr as $v) {
						$detalle[] = CuponesNegocio::diaconfecha($v);
						
					}
					$msg_det_sol .= implode(" ; ", $detalle);
					$msg_det_sol .= "]<br>";
				}
				if ($fila['ces_estado']==2) {
					$dias_aprob+=$fila['ces_dias'];
					$msg_det_aprob .= "<b>".$fila['ces_dias']." dia(s)</b> [";
					$arr =  CuponesNegocio::getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
					foreach ($arr as $v) {
						$detalle[] = CuponesNegocio::diaconfecha($v);
						
					}
					$msg_det_aprob .= implode(" ; ", $detalle);
					$msg_det_aprob .= "]<br>";
				}
				unset($detalle);
			}
			else {
				$dias_sin_usar = $cea_dias-$dias_sol-$dias_aprob;

				$arrCup[] = array($usu_nombre, $cea_dias, $dias_sol, $msg_det_sol, $dias_aprob, $msg_det_aprob, $dias_sin_usar, $usu_id);
				
				$usu_nombre = $fila['usu_nombre'];
				$usu_id = $fila['usu_id'];
				$cea_dias = $fila['cea_dias'];
				$dias_sol = 0;
				$dias_aprob = 0;
				$msg_det_sol = "";
				$msg_det_aprob = "";
				if ($fila['ces_estado']==1) {
					$dias_sol+=$fila['ces_dias'];
					$msg_det_sol .= "<b>".$fila['ces_dias']." dia(s)</b> [";
					$arr =  CuponesNegocio:: getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
					
                                        foreach ($arr as $v) {
						$detalle[] =  CuponesNegocio::diaconfecha($v);
						
					}
					$msg_det_sol .= implode(" ; ", $detalle);
					$msg_det_sol .= "]<br>";
				}
				if ($fila['ces_estado']==2) {
					$dias_aprob+=$fila['ces_dias'];
					$msg_det_aprob .= "<b>".$fila['ces_dias']." dia(s)</b> [";
					$arr =  CuponesNegocio::getDetalleDiasCupEsp($fila['ces_fec_ini'], $fila['ces_dias']);
					foreach ($arr as $v) {
						$detalle[] = CuponesNegocio::diaconfecha($v);
						
					}
					$msg_det_aprob .= implode(" ; ", $detalle);
					$msg_det_aprob .= "]<br>";
				}
				unset($detalle);
			}
		}
		
		//Procesa ultima fila del reporte
		$dias_sin_usar = $cea_dias-$dias_sol-$dias_aprob;
		
		$arrCup[] = array($usu_nombre, $cea_dias, $dias_sol, $msg_det_sol, $dias_aprob, $msg_det_aprob, $dias_sin_usar, $usu_id);

	}
		
	return $arrCup;
    
        }
    
                                       
}
