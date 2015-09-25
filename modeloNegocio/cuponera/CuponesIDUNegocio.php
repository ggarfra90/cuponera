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

class CuponesIDUNegocio extends ModeloNegocioBase {
    public function insertCupones($cup_fec_perm,$cup_fec_perm2,$cup_doc,$cup_fec_hito) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        $flag=0;
        session_start();
        $cup_usu_id=$ua=$_SESSION['rec_usu_id'];
        $cup_anio=$_SESSION['rec_anio'];
        $cup_tipo=$_SESSION['tipo'];
        $cup_clase=$_SESSION['rec_cup_clase'];
        $diahabil=  CuponesNegocio::diaHabil($cup_fec_perm,$cup_anio);
        if (strlen($diahabil)>0){
		$flag=1;
                
               $response[2]["vout_exito"]=0;
		$response[2]["vout_mensaje"]=$diahabil;
                //$this->setMensajeEmergente($response[0]["vout_mensaje"]);
	}
        if (strtotime($cup_fec_perm) < strtotime($cup_anio."-01-01")) {
	$flag=1;
                    $response[3]["vout_exito"]=0;
		$response[3]["vout_mensaje"]="ERROR: S&oacute;lo se permite seleccionar la fecha de permiso a partir del a&ntilde;o actual<br>";
               //$this->setMensajeEmergente($response[1]["vout_mensaje"]); 
        }
        //$cump=strtotime('2015-11-17'."-7 days");
        //$fc=strtotime($cup_fec_perm);
        if (strtotime($cup_fec_perm) < strtotime($cup_fec_hito."-7 days") || strtotime($cup_fec_perm) > strtotime($cup_fec_hito."+7 days")) {
		$flag=1;
                  $response[4]["vout_exito"]=0;
		$response[4]["vout_mensaje"]="ERROR: La fecha de permiso no puede ser menor ni mayor que 7 d&iacute;as despu&eacute;s de su cumplea&ntilde;os<br>";
	//$this->setMensajeEmergente($response[3]["vout_mensaje"]);
                
        }
        
        if ($cup_clase=="E" && strtotime($cup_fec_perm) <= strtotime(date('Y-m-d'))) {
		$flag=1;
                  $response[5]["vout_exito"]=0;
		$response[5]["vout_mensaje"]="ERROR: S&oacute;lo se permite seleccionar la fecha de permiso a partir de ma&ntilde;ana<br>";
	
               
        }
        if ($_SESSION['rec_cup_clase']=="P" && strtotime($cup_fec_perm) < strtotime(date('Y-m-d')."+7 days")) {
		$flag=1;
                  $response[6]["vout_exito"]=0;
		$response[6]["vout_mensaje"]="ERROR: S&oacute;lo se permite seleccionar la fecha de permiso con siete d&iacute;as de anticipaci&oacute;n como m&iacute;nimo<br>";
	}
         $dat=  Cupones::create()->functionEstadoVerifica($cup_usu_id,$cup_anio,$cup_fec_perm,$cup_fec_perm,2,  intval($cup_tipo));
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
            $data3=  Cupones::create()->functionCupVeri($cup_tipo,$cup_anio,$cup_usu_id);
            foreach ($data3 as $value2) {
                $cup_estado=$value2['cup_estado'];
            }
            if ($cup_estado==1 || $cup_estado==2) {
			$flag=1;
                  $response[9]["vout_exito"]=0;
		$response[9]["vout_mensaje"]="ya existe un cup&oacute; solicitado con esa fecha.";
		}    
     if($flag==1){
    $response[0]["vout_exito"]=0;
    $response[0]["vout_mensaje"]="Error al enviar solicitud.";
            return $response;
            exit();
        }
  
        $response1 = Cupones::create()->insertCupones($cup_usu_id,$cup_anio,$cup_tipo,$cup_fec_perm,$cup_fec_perm2,$cup_doc,$cup_fec_hito,"","");
        $dataI = Cupones::create()->functionLastIDCup();
        foreach ($dataI as $id) {
            $cup_id=$id['id_cup'];
        }
        $mov_descri="Registro solicitud cupon (".$cup_id.") cumpleanios de ".$_SESSION['rec_usu_nombre'];
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
//	array_push ($cc, CuponesNegocio::getJefeDirecto($_SESSION['ldap_user']).'@netafim.com.pe');
//	array_push ($cc, CuponesNegocio::getGerenteDirecto($_SESSION['ldap_user']).'@netafim.com.pe');
//	array_push ($cc, CuponesNegocio::getAsistSocial().'@netafim.com.pe');
//	array_push ($cc, CuponesNegocio::getJefeRRHH().'@netafim.com.pe');
//	array_push ($cc, 'rrhh@netafim.com.pe');
        $cup_nombre=  CuponesNegocio::getCupNombre($cup_tipo);
       $subject = ConstantesMail::PARAM_SUBJECT.$cup_nombre." de ".$_SESSION['rec_usu_nombre'];
	$body = ConstantesMail::PARAM_BODY_C_C.$cup_nombre." de ".$_SESSION['rec_usu_nombre']." para el dia ".$cup_fec_perm." (Fecha de cumplea&ntilde;os: ".$_SESSION['rec_fec_cump'].")";
	$body .= ConstantesMail::PARAM_BODY_H_JD;
        CuponesNegocio::enviarCorreo($to, $cc, $subject, $body);
	//ConstructorMail::enviarCorreoInfo($to,$cc,$subject,$body,$var_modulo_ident);
      //  $response3= CuponesIDUNegocio::enviarCorreoNotificacion($to,$cc,$subject,$body, $attachString=null, $attachFilename=null);
         if ($response1[0]["vout_exito"] == 0 && $response2[0]["vout_exito"] == 0 ){
                 $response[0]["vout_exito"]=0;
                 $response[0]["vout_mensaje"]=$response1[0]["vout_mensaje"]." ".$response2[0]["vout_mensaje"];
        
            } else {
                  $response[0]["vout_exito"]='1';
                  $response[0]["vout_mensaje"]='Se registro su solicitud.';
            $this->setMensajeEmergente($response[0]["vout_mensaje"]);
            return $response;
        }
          return $response;
    }
    
     

}
