<?php
/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';
require_once __DIR__ . '/../../util/ConstantesMail.php';


class CuponesPNegocio extends ModeloNegocioBase {
    public function insertCuponesP($cup_fec_perm) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        $flag=0;
        session_start();
        $cup_usu_id=$ua=$_SESSION['rec_usu_id'];
        $cup_anio=$_SESSION['rec_anio'];
        $cup_tipo=$_SESSION['tipo'];
        $cup_clase=$_SESSION['rec_cup_clase'];
        $usu_ad=$_SESSION['ldap_user'];
      
        $sucu=$_SESSION['rec_suc_id'];
        
        $data9 = Cupones::create()->functionOrg($sucu);
        foreach ($data9 as $value) {
            $org_id = $value['org_id'];
        }
        $diahabil=  CuponesNegocio::diaHabil($cup_fec_perm,$cup_anio);
      
        if (strlen($diahabil)>0){
		$flag=1;
                
               $response[2]["vout_exito"]=0;
		$response[2]["vout_mensaje"]=$diahabil;
	}
      	if ($cup_clase=="E" && strtotime($cup_fec_perm) <= strtotime(date('Y-m-d'))) {
		$flag=1;
               $response[3]["vout_exito"]=0;
		$response[3]["vout_mensaje"]="ERROR: S&oacute;lo se permite seleccionar la fecha de permiso que sea posterior a la fecha actual<br>";
	}

	if ($_SESSION['rec_cup_clase']=="P" && strtotime($cup_fec_perm) < strtotime(date('Y-m-d')."+7 days")) {
		$flag=1;
             $response[4]["vout_exito"]=0;
		$response[4]["vout_mensaje"]="ERROR: La fecha de permiso seleccionada debe pedirse con siete d&iacute;as de anticipaci&oacute;n como m&iacute;nimo<br>";
	}
        if (substr($fecha_p, 5, 5) != "12-31") {
		$anio_chequeo = substr($cup_fec_perm, 0, 4);
	} else {
		$anio_chequeo = substr($cup_fec_perm, 0, 4)+1;
	}
        $num=0;
        $dap=  Cupones::create()->functionDisP($anio_chequeo,$org_id);
        $dipu_dis=  count($dap);
        if($dipu_dis==0){
            $dipu_dis=0;
        }  else {
            foreach ($dap as $value) {
             $num=$value['disponibles'];
         }
         $dipu_dis=$num;
        }
        //usados
        $datU=  Cupones::create()->functionDisU($cup_usu_id,$anio_chequeo,$org_id);
        foreach ($datU as $value) {
             $dipu_usa=$value['usados'];
         }
         if (($dipu_dis-$dipu_usa)<1) {
		$flag=1;
                   $response[5]["vout_exito"]=0;
		$response[5]["vout_mensaje"]="ERROR: No quedan d&iacute;as puente disponibles para utilizar<br>";
	}
       $dat=  Cupones::create()->functionEstadoVerifica($cup_usu_id,$cup_anio,$cup_fec_perm,"",2,1);
         foreach ($dat as $value) {
             $num=$value['numero'];
         }
         if ($num>0) {
		
                  $flag=1;
                  $response[7]["vout_exito"]=0;
		$response[7]["vout_mensaje"]="ERROR: Ya existe un cup&oacute;n aprobado con la misma fecha seleccionada";
	}
        list($cruce, $msg_cruce) = CuponesNegocio::cruceFechas($cup_usu_id, $cup_fec_perm, 1, false);
	if ($cruce) {
		     $flag=1;
                  $response[8]["vout_exito"]=0;
		$response[8]["vout_mensaje"]="ERROR: Cruce de fecha el dia $msg_cruce";
	}
        if($flag==1){
    $response[0]["vout_exito"]=0;
    $response[0]["vout_mensaje"]="Error al enviar solicitud.";
            return $response;
            exit();
        }
            
         $data3=  Cupones::create()->functionCupVeri($cup_tipo,$anio_chequeo,$cup_usu_id);
            foreach ($data3 as $value2) {
                $cup_estado=$value2['cup_estado'];
            }
            if ($cup_estado==1 ) {
			$flag=1;
                  $response[11]["vout_exito"]=0;
		$response[11]["vout_mensaje"]="ya existe un cup&oacute; solicitado con esa fecha.";
		}
     if($flag==1){
    $response[0]["vout_exito"]=0;
    $response[0]["vout_mensaje"]="Error al enviar solicitud.";
            return $response;
            exit();
        }
     
  //se guarda mal!!!!!
        $response1 = Cupones::create()->insertCupones($cup_usu_id,$anio_chequeo,$cup_tipo,$cup_fec_perm,"","","","","");
        $dataI = Cupones::create()->functionLastIDCup();
        foreach ($dataI as $id) {
            $cup_id=$id['id_cup'];
        }
        $mov_descri="Registro solicitud cupon (".$cup_id.") asuntos personales de ".$_SESSION['rec_usu_nombre'];
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['SERVER_ADDR'];
    }
        
        $mov_ip =$ip;
        $mov_host=gethostbyaddr($ip);
        $response2 = Movimientos::create()->insertMovimientos($mov_descri,$cup_usu_id,$mov_ip,$mov_host);
        $to = CuponesNegocio::getCorreoUsuario($_SESSION['ldap_user']);
	 //descomentar para enviar correo 
	$cc = "ggarcia@imaginatecperu.com"; //array();
//	array_push ($cc, CuponesNegocio::getJefeDirecto($usu_ad).'@netafim.com.pe');
//	array_push ($cc, CuponesNegocio::getGerenteDirecto($usu_ad).'@netafim.com.pe');
//	array_push ($cc, CuponesNegocio::getAsistSocial().'@netafim.com.pe');
//	array_push ($cc, CuponesNegocio::getJefeRRHH().'@netafim.com.pe');
//	array_push ($cc, 'rrhh@netafim.com.pe');
        $cup_nombre=  CuponesNegocio::getCupNombre($cup_tipo);
       $subject = ConstantesMail::PARAM_APRO_PEN.$cup_nombre." de ".$_SESSION['rec_usu_nombre'];
	$body = ConstantesMail::PARAM_BODY_C_C.$cup_nombre." de ".$_SESSION['rec_usu_nombre']." para el dia ".$cup_fec_perm;
	$body .= ConstantesMail::PARAM_BODY_H_JD;
	CuponesNegocio::enviarCorreo($to, $cc, $subject, $body);
	//ConstructorMail::enviarCorreoInfo($to,$cc,$subject,$body,$var_modulo_ident);
         if ($response1[0]["vout_exito"] == 0 && $response2[0]["vout_exito"] == 0 ){
                 $response[0]["vout_exito"]=0;
                 $response[0]["vout_mensaje"]=$response1[0]["vout_mensaje"]." ".$response2[0]["vout_mensaje"];
        
            } else {
                  $response[0]["vout_exito"]='1';
                  $response[0]["vout_mensaje"]='Se registro su solicitud.';
          //  $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
          return $response;
    }
    
     

}
