<?php
/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/PerfilPermiso.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class PermisosPerfilNegocio extends ModeloNegocioBase {
    
    public function getPermisosAdministrativos($rol) {
        session_start();
        $usu_ad=$_SESSION['ldap_user'];
        
	$data="";
	if ($rol=='JEFEINMEDIATO') {
            $data=  PerfilPermiso::create()->getPermisos(1,$usu_ad,"");
            } elseif ($rol=='GERENTEINMEDIATO') {
            $data=  PerfilPermiso::create()->getPermisos(2,$usu_ad,"");
	} else {
            $data=  PerfilPermiso::create()->getPermisos(3,$usu_ad,$rol);
	}
	
        foreach ($data as $fila) {
           $count = $fila['cont'];
            $urol = $fila['usu_rol']; 
        }
	
	if($urol =='ADMI') $count=1;
	return $count;
}


}
