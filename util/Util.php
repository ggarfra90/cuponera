<?php
/**
 * Description of Util
 *
 * @author cheredia
 * @version 1.0
 * @copyright (c) 2013, IMAGINA TECHNOLOGIES S.A.C.
 */
include_once __DIR__.'/../util/Configuraciones.php';

class Util 
{
    /**
     * Genera un codigo aleatorio de longitud especificada.
     * 
     * @author cheredia
     * @param int $lenght
     * @return string
     */
    static public function generateCode($lenght = 5)
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $code = "";
        for($i=0; $i<$lenght; $i++) {
            $code .= substr($str,rand(0,62),1);
        }
        return $code;
    }
    
    /**
     * Crea un objeto StdClass a partir de un array con valores
     * 
     * @param Array $object_as_array array con los keys y values que se transformarán en las propiedades del StdClass
     * @return null|\stdClass
     * 
     * 
     */
    static public function newStdClass($object_as_array)
    {
        if (ObjectUtil::isEmpty($object_as_array)) return null;
        
        $object = new stdClass();
        
        foreach ($object_as_array as $key => $value)
        {
            $property = $value;
                
            if (ObjectUtil::isNumber($value))
            {
                if (stripos($value,".") === FALSE)
                {
                    $property = intval($value);
                }
                else
                {
                    $property = floatval($value);
                }
            }

            $object->{$key} = $property;
        }
        
        return $object;
    }
    
    /**
     * Metodo para ordenar arreglos, que representan tablas de la base de datos.
     * 
     * @author cheredia <cheredia@imaginatecperu.com> 
     * @param type $arrayRecords
     * @param type $campo
     * @param type $desc
     * @return array
     */
    static public function sortArrayTabla($arrayRecords, $campo, $orden=Order::asc)    {
        $hash = array();

        foreach($arrayRecords as $keyR => $record) {
            $hash[$record[$campo] . '-' . $keyR] = $record;
        }

        ($orden==Order::desc)? krsort($hash) : ksort($hash);

        $arrayRecords = array();
        foreach($hash as $record) {
            $arrayRecords []= $record;
        }

        return $arrayRecords;
    }
    
    static public function crearCookie($usu_ad){
	setcookie(Configuraciones::COOKIE_NAME_SID, self::encripta($usu_ad), time() + Configuraciones::TIME_OUT, "/");
    }
    static public function borrarCookie(){
            setcookie(Configuraciones::COOKIE_NAME_SID, "", time() - 360000, "/");
        unset($_COOKIE[Configuraciones::COOKIE_NAME_SID]);
    }
    static public function encripta($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is iv';
        $key = "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3";
        // hash
        $key = hash('sha256', $key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    static public function desencripta($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is iv';
        $key = "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3";
        // hash
        $key = hash('sha256', $key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
     static public function base64ToImage($Base64Img) {
        list(, $Base64Img) = explode(';', $Base64Img);
        list(, $Base64Img) = explode(',', $Base64Img);
        $Base64Img = base64_decode($Base64Img);
        return $Base64Img;
    }
}

?>
