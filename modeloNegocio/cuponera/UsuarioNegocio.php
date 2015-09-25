<?php

require_once __DIR__ . '/../../modelo/cuponera/Usuario.php';
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/Perfil.php';
require_once __DIR__ . '/../../modelo/cuponera/Movimientos.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
include_once __DIR__ . '/../../../Mailer/Entidades/ConstructorMail.php';
require_once __DIR__ . '/../../util/PasswordHash.php';


//require_once __DIR__ . '/../../../Classes/class.phpmailer.php';
//include_once __DIR__ . '/../../../Mailer/Entidades/ConstructorMail.php';

class UsuarioNegocio extends ModeloNegocioBase {

    public function validateLogin($username, $contrasena) {
        
        $data=Usuario::create()->validateLogin($username);
        if(count($data)>0){
        $cup_clase = $data[0]['cup_clase'];
	$usu_clave = $data[0]['usu_clave'];
        $usu_id = $data[0]['usu_id'];
        $usu_nombre=$data[0]['usu_nombre'];
        $usu_rol=$data[0]['usu_rol'];
        $cup_sucu=$data[0]['suc_id'];
        $usu_estado=$data[0]['usu_estado'];
        $usu_matri=$data[0]['usu_matricial'];
        $data1 = Cupones::create()->functionOrg($cup_sucu);
        foreach ($data1 as $value) {
            $org_id = intval($value['org_id']);
        }
         
        if($usu_estado==0){
            $response[0]['vout_exito_inac']='0';
            $response[0]['vout_mensaje']='Su cuenta está inactiva comuniquese con RRHH.';
            return $response;
        }
        if($usu_estado==2){
            $response[0]['vout_exito_elimi']='0';
            $response[0]['vout_mensaje']='Su cuenta fue eliminada.';
            return $response;
        }
        if(strlen($usu_clave)>0 && $usu_clave==$contrasena){
            if($usu_estado==0){
            $response[0]['vout_exito_inac']='0';
            $response[0]['vout_mensaje']='Su cuenta está inactiva comuniquese con RRHH.';
            return $response;
        }
        if($usu_estado==2){
            $response[0]['vout_exito_elimi']='0';
            $response[0]['vout_mensaje']='Su cuenta fue eliminada.';
            return $response;
        }
        $datasql=  Usuario::create()->obtenerCodigoGeneral($username);
        foreach ($datasql as $value) {
            $codigo=$value->idcodigogeneral;
        }
        
        $datasql2=  Usuario::create()->obtenerFechaCumpleaños($codigo);
        foreach ($datasql2 as $value) {
            $fec_nac=$value->fec_cump;
        }
        $y=substr($fec_nac,6,10);
        $m=  substr(substr($fec_nac,2,3),1);
        $d=substr($fec_nac,0,2);
        $fecha_nac=$y.'-'.$m.'-'.$d;
            session_start();
             $_SESSION['rec_org']=$org_id;
            $_SESSION['ldap_user']=$username;
            $_SESSION['rec_cup_clase']=$cup_clase;
            $_SESSION['rec_suc_id']=$cup_sucu;
            $_SESSION['rec_usu_nombre'] = $usu_nombre;
            $_SESSION['rec_usuario_rol'] =$usu_rol;
            $_SESSION['rec_usu_id']=$usu_id;
            $_SESSION['rec_fec_cump'] = substr_replace(substr($fecha_nac, 0, 10), date('Y'), 0, 4);
            $_SESSION['rec_usu_matricial']=$usu_matri;
            Util::crearCookie($username);
            $response[0]['vout_exito']='1';
            return $response;
        }else{
            $response[0]['vout_exito_clave']='0';
            $response[0]['vout_mensaje']='Clave erronea.';
            return $response;
        }
        
        }else{
            $response[0]['vout_exito_dato']='0';
            $response[0]['vout_mensaje']='Usuario no encontrado.';
        }
        return $response;
    }
    
     public function validateLoginWP($usuario, $contrasena) {
         
        $t_hasher = new PasswordHash(8, FALSE);
        
        $hash =Usuario::create()->validateLoginWP($usuario);
        if (count($hash)<=0) {
             $response[0]['vout_exito_wp']='0';
            $response[0]['vout_mensaje']='Usuario no encontrado.';
            return $response;
        }
        $check = $t_hasher->CheckPassword($contrasena, $hash[0]['user_pass']);
        if (!$check) {
             $response[0]['vout_exito_cup']='0';
            $response[0]['vout_mensaje']='Contraseña incorrecta.';
            return $response;
        }
         $data=Usuario::create()->validateLogin($usuario);
        if(count($data)>0){
        $cup_clase = $data[0]['cup_clase'];
        $usu_id = $data[0]['usu_id'];
        $usu_nombre=$data[0]['usu_nombre'];
        $cup_sucu=$data[0]['suc_id'];  
        $usu_estado=$data[0]['usu_estado'];
        $usu_rol=$data[0]['usu_rol'];
        $usu_matri=$data[0]['usu_matricial'];
        $fec_cump=substr_replace(substr($data[0]['usu_fec_cump'], 0, 10), date('Y'), 0, 4);
        if($usu_estado==0){
            $response[0]['vout_exito_inac']='0';
            $response[0]['vout_mensaje']='Su cuenta está inactiva comuniquese con RRHH.';
            return $response;
        }
        if($usu_estado==2){
            $response[0]['vout_exito_elimi']='0';
            $response[0]['vout_mensaje']='Su cuenta fue eliminada.';
            return $response;
        }
               session_start();

            $_SESSION['ldap_user']=$usuario;
            $_SESSION['rec_cup_clase']=$cup_clase;
            $_SESSION['rec_usu_nombre'] = $usu_nombre;
            $_SESSION['rec_suc_id']=$cup_sucu;
            $_SESSION['rec_usu_id']=$usu_id;
            $_SESSION['rec_anio']=  date("Y");
            $_SESSION['rec_fec_cump']=$fec_cump;
            $_SESSION['rec_usuario_rol'] = $usu_rol;
            $_SESSION['rec_usu_matricial']=$usu_matri;
            $response[0]['vout_exito']='1';
            return $response;
        }else{
            $response[0]['vout_exito_dato']='0';
            $response[0]['vout_mensaje']='Usuario no encontrado.';
            return $response;
        }
            return $response;  
    }
    public function getDataCombo($op,$org_id,$g_ad,$j_ad,$m_ad) {
        $data2="";
        $jefe="";
        $gere="";
        $matri="";
        $data2 = Usuario::create()-> getDataUsuarioCombo($op,$org_id);
        for ($i = 0; $i < count($data2); $i++) {
            $jefe=$j_ad;
            $gere=$g_ad;
            $matri=$m_ad;
            $data2[$i]['g_ad']=$gere;
            $data2[$i]['j_ad']=$jefe;
            $data2[$i]['m_ad']=$matri;
        }   
      
        return $data2;
    }
    public function getDataUsuario($org_id) {
        session_start();
        $sucu = $_SESSION['rec_suc_id'];
       if (!isset($_SESSION['rec_usu_mtr'])){
           $mtr=0;
       }
        if ($org_id == '0') {
            $data1 = Cupones::create()->functionOrg($sucu);
            foreach ($data1 as $value) {
                $org_id = $value['org_id'];
            }
        }
        $data = Usuario::create()->getDataUsuario($mtr,$org_id);
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            if ($data[$i]['usu_estado'] == 1) {
                $data[$i]['icono'] = "ion-checkmark-circled";
                $data[$i]['color'] = "#5cb85c"; 
                $data[$i]['estado'] = "Activo";

            } else {
                $data[$i]['icono'] = "ion-flash-off";
                $data[$i]['color'] = "#cb2a2a";
                $data[$i]['estado'] = "Inactivo";
            }
        }
        return $data;
    }
    
    public function insertarUsuario($usu_nombre,$usu_ad,$usu_nivel,$usu_estado,$usu_jefe,$usu_gerente,$usu_mtr,
                $usu_clase,$usu_rol,$usu_clave,$usu_correo,$suc_id,$usu_fec_cump,$usu_cargo,$usu_matricial) {
       
        $data=  Usuario::create()->functionValidarUsuarioAd($usu_ad);
        if($data[0]['vout_exito']=='1'){
            
        $flag = 1;
            $response[1]["vout_exito"] = 0;
            $response[1]["vout_mensaje"] = $data[0]['vout_mensaje'].", Ingrese otro usuario válido.";
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error de validación.";
            return $response;
            exit();
        }
        
        $response = Usuario::create()->insertarUsuario($usu_nombre,$usu_ad,$usu_nivel,$usu_estado,$usu_jefe,$usu_gerente,
                $usu_mtr,$usu_clase,$usu_rol,$usu_clave,$usu_correo,$suc_id,$usu_fec_cump,$usu_cargo,intval($usu_matricial));
        session_start();
            $usu_id=$_SESSION['rec_usu_id'];
            $usu_in_id=$response[0]['@vout_usu_id'];
        $desc =  "Registro nuevo usuario - identificador ($usu_in_id), nuevos valores: "
                . "nombre ($usu_nombre), uad ($usu_ad), jefe ($usu_jefe), ger ($usu_gerente), clase ($usu_clase), "
                . "rol ($usu_rol), clave ($usu_clave), correo ($usu_correo), sucursal ($suc_id), estado ($usu_estado)";
	
        $mov_descri =$desc;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response[0]["vout_exito"] =='1') {
            $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id, $mov_ip, $mov_host);
         }
         
         if ( $response2[0]["vout_exito"] == 0 ) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"];
          
            return $response;
        }
            return $response;
        }
    
 public function editarUsuario($usu_id,$usu_nombre,$usu_ad,$usu_ad_a,$usu_nivel,$usu_estado,$usu_jefe,$usu_gerente,$usu_mtr,
                $usu_clase,$usu_rol,$usu_clave,$usu_correo,$suc_id,$usu_fec_cump,$usu_cargo,$usu_matricial) {
       
        if($usu_ad!=$usu_ad_a){
        $data=  Usuario::create()->functionValidarUsuarioAd($usu_ad);
        if($data[0]['vout_exito']=='1'){
            
        $flag = 1;
            $response[1]["vout_exito"] = 0;
            $response[1]["vout_mensaje"] = $data[0]['vout_mensaje'].", Ingrese otro usuario válido.";
        }
        if ($flag == 1) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = "Error de validación.";
            return $response;
            exit();
        }
        }
        $response = Usuario::create()->editarUsuario($usu_id,$usu_nombre,$usu_ad,$usu_nivel,$usu_estado,$usu_jefe,$usu_gerente,
                $usu_mtr,$usu_clase,$usu_rol,$usu_clave,$usu_correo,$suc_id,$usu_fec_cump,$usu_cargo,intval($usu_matricial));
        session_start();
            $usu_id_e=$_SESSION['rec_usu_id'];
            
        $desc =  "Actualización de datos de usuario - identificador ($usu_id), nuevos valores: "
                . "nombre ($usu_nombre), uad ($usu_ad), jefe ($usu_jefe), ger ($usu_gerente), clase ($usu_clase), "
                . "rol ($usu_rol), clave ($usu_clave), correo ($usu_correo), sucursal ($suc_id), estado ($usu_estado)";
	
        $mov_descri =$desc;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response[0]["vout_exito"] =='1') {
            $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id_e, $mov_ip, $mov_host);
         }
         
         if ( $response2[0]["vout_exito"] == 0 ) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"];
          
            return $response;
        }
            return $response;
        }
    

    public function getObtenerUsuario($id) {
        $usuario=Usuario::create()->functionObtenerXId($id);
        for ($i = 0; $i < count($usuario); $i++) {
             if($usuario[$i]['usu_cargo']!="" && $usuario[$i]['usu_fec_cump']!="" ){
            $usuario[$i]['usu_especial']=1;
        }else{
            $usuario[$i]['usu_especial']=0;
        }
        }
       
        return $usuario;
        
    }


    public function deleteUsuario($usu_id,$usu_nombre,$usu_ad) {
       
      
        $response = Usuario::create()->deleteUsuario($usu_id);
        session_start();
            $usu_id_e=$_SESSION['rec_usu_id'];
            
        $desc = "Eliminacion de datos de usuario - identificador ($usu_id), nombre ($usu_nombre), usuario ($usu_ad)";
        $mov_descri =$desc;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $mov_ip = $ip;
        $mov_host = gethostbyaddr($ip);
         if ($response[0]["vout_exito"] =='1') {
            $response2 = Movimientos::create()->insertMovimientos($mov_descri, $usu_id_e, $mov_ip, $mov_host);
         }
         
         if ( $response2[0]["vout_exito"] == 0 ) {
            $response[0]["vout_exito"] = 0;
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"] . " " . $response2[0]["vout_mensaje"];
        } else {
            $response[0]["vout_exito"] = '1';
            $response[0]["vout_mensaje"] = $response[0]["vout_mensaje"];
          
            return $response;
        }
            return $response;
        }
    


}
