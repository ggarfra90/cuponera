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

class CuponesGNegocio extends ModeloNegocioBase {
    public function insertCuponesG($cup_fec_perm,$cup_doc,$doc_s,$doc_t,$cup_fec_hito,$cup_fec_hito2,$file) {
        $visible = ConstantesNegocio::PARAM_VISIBLE;
        $flag=0;
        session_start();
        $cup_usu_id=$ua=$_SESSION['rec_usu_id'];
        $cup_anio=$_SESSION['rec_anio'];
        $cup_tipo=$_SESSION['tipo'];
        $cup_clase=$_SESSION['rec_cup_clase'];
        $usu_ad=$_SESSION['ldap_user'];
        $diahabil=  CuponesNegocio::diaHabil($cup_fec_perm,$cup_anio);
      
        if (strlen($diahabil)>0){
		$flag=1;
                
               $response[2]["vout_exito"]=0;
		$response[2]["vout_mensaje"]=substr($diahabil, 0, 6)." (Primer permiso)".substr( $diahabil, 6);
	}
        
        if (strtotime($cup_fec_hito)==strtotime($cup_fec_hito2)) {
	$flag=1;
                $response[4]["vout_exito"]=0;
		$response[4]["vout_mensaje"]="ERROR: Los d&iacute;as de inicio y fin de curso deben ser diferentes<br>";
        }
        if (strtotime($cup_fec_hito) > strtotime($cup_fec_hito2)) {
		$flag=1;
                  $response[5]["vout_exito"]=0;
		$response[5]["vout_mensaje"]="ERROR: La fecha de fin del curso debe pertenecer al a&ntilde;o actual<br>";

        }
        if (strtotime($cup_fec_hito2) > strtotime($_SESSION['rec_anio']."-12-31")) {
		$flag=1;
             $response[14]["vout_exito"]=0;
		$response[14]["vout_mensaje"]="ERROR: La fecha de fin del curso debe pertenecer al a&ntilde;o actual<br>";
	}
	if (strtotime($cup_fec_perm) < strtotime($cup_fec_hito2) || strtotime($cup_fec_perm) > strtotime($cup_fec_hito2."+ 3 months")) {
		$flag=1;
                  $response[6]["vout_exito"]=0;
		$response[6]["vout_mensaje"]="ERROR: La fecha del d&iacute;a de permiso no puede ser mayor que 3 meses ni anterior a su fecha de fin de curso<br>";
 
        } 
       
	if (strtotime($cup_fec_perm) <= strtotime(date('Y-m-d'))) {
		 $flag=1;
                  $response[7]["vout_exito"]=0;
		$response[7]["vout_mensaje"]="ERROR: S&oacute;lo se permite seleccionar la fecha de permiso a partir de ma&ntilde;ana<br>";

	}
       $dat=  Cupones::create()->functionEstadoVerifica($cup_usu_id,$cup_anio,$cup_fec_hito,$cup_fec_perm,2,2);
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
             //archivo
        $mimeTypes = array("image/jpeg", "image/pjpeg", "image/png", "application/pdf", "application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/zip",
		"application/x-rar-compressed", "application/octet-stream");
	$allowedExts = array("jpg", "jpeg", "pdf", "doc", "docx", "zip", "rar");
	$ext = explode(".", $cup_doc);
	$extension = end($ext);
        
	$cup_doc_attach=uniqid() . " " . $cup_doc;
        //verificamos el tipo de documento
        if(!in_array($doc_t, $mimeTypes) && $doc_t!=""){
                    $flag=1;
                  $response[9]["vout_exito"]=0;
		$response[9]["vout_mensaje"]="Archivo inv&aacute;lido. Los formatos permitidos son pdf, jpg, microsoft word, zip o rar y no podr&aacute; exceder los 6 megabytes de tama&ntilde;o";
        }
        if($doc_t=="" && $cup_doc!=""){
            if (!in_array($extension, $allowedExts)){
                 $flag=1;
                  $response[10]["vout_exito"]=0;
		$response[10]["vout_mensaje"]="Archivo inv&aacute;lido. Los formatos permitidos son pdf, jpg, microsoft word, zip o rar y no podr&aacute; exceder los 6 megabytes de tama&ntilde;o";
            }
        }
        if($flag==1){
    $response[0]["vout_exito"]=0;
    $response[0]["vout_mensaje"]="Error al enviar solicitud.";
            return $response;
            exit();
        }
        //validamos tamanio del archivo
        if(intval($doc_s) > 600000){
 	 $flag=1;
                  $response[11]["vout_exito"]=0;
		$response[11]["vout_mensaje"]="el archivo no debe exceder los 6 megabytes de tama&ntilde;o";
           
        }
        if($flag==1){
    $response[0]["vout_exito"]=0;
    $response[0]["vout_mensaje"]="Error al enviar solicitud.";
            return $response;
            exit();
        }
        if($cup_doc!=""){
        $ruta='/../../vistas/com/cupones/archivos/';
                $rs=CuponesNegocio::functionArchivar($file,$cup_doc_attach,$ruta);
                if($rs!=1){
                    $flag=1;
                  $response[12]["vout_exito"]=0;
		$response[12]["vout_mensaje"]="Error al guardar archivo.";
           
                }
//      move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__.'/../../util/uploads/'. $cup_doc_attach);
        }
	if($flag==1){
    $response[0]["vout_exito"]=0;
    $response[0]["vout_mensaje"]="Error al enviar solicitud.";
            return $response;
            exit();
        }
        //end archivo
        
        
         $data3=  Cupones::create()->functionCupVeri($cup_tipo,$cup_anio,$cup_usu_id);
            foreach ($data3 as $value2) {
                $cup_estado=$value2['cup_estado'];
            }
            if ($cup_estado==1 || $cup_estado==2) {
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
        $cup_b="";
  //se guarda mal!!!!!
        $response1 = Cupones::create()->insertCupones($cup_usu_id,$cup_anio,$cup_tipo,$cup_fec_perm,$cup_b,$cup_doc_attach,$cup_fec_hito,$cup_fec_hito2,"");
        $dataI = Cupones::create()->functionLastIDCup();
        foreach ($dataI as $id) {
            $cup_id=$id['id_cup'];
        }
        $mov_descri="Registro solicitud cupon (".$cup_id.") graduaci&oacute; de ".$_SESSION['rec_usu_nombre'];
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
        $cup_nombre=  CuponesNegocio::create()->getCupNombre($cup_tipo);
       $subject = ConstantesMail::PARAM_SUBJECT.$cup_nombre." de ".$_SESSION['rec_usu_nombre'];
	$body = ConstantesMail::PARAM_BODY_C_C.$cup_nombre." de ".$_SESSION['rec_usu_nombre']." para el dia ".$cup_fec_perm." (Fecha de inicio de curso ".$cup_fec_hito.", fecha de fin de curso ".$cup_fec_hito2.")";
	$body .= ConstantesMail::PARAM_BODY_H_RH;
        
           CuponesNegocio::create()->enviarCorreo($to, $cc, $subject, $body);
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
