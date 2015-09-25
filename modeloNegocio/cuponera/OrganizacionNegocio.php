<?php

require_once __DIR__ . '/../../modelo/cuponera/Organizacion.php';
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';

require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';

class OrganizacionNegocio extends ModeloNegocioBase {

   
    public function getListarOrganizacion($org_id_b) {
        $data=  Organizacion::create()->functionListarOrganizacion();
        
         session_start();
         $mtr=$_SESSION['rec_usu_matr'];
         if(!isset($_SESSION['rec_usu_matr'])){
             $mtr=0;
         }
        $sucu = $_SESSION['rec_suc_id'];
            $data1 = Cupones::create()->functionOrg($sucu);
            foreach ($data1 as $value) {
                $org_id = $value['org_id'];
            }
            
            for ($i = 0; $i < count($data); $i++) {
                $org="";
                $orga="";
                 if($mtr==0 && $org_id_b=='' ){
            $org=$org_id;
            }
            if($org_id_b!=''){
            $orga=$org_id_b;
            
            }
            $data[$i]['org']=$org;
            $data[$i]['orga']=$orga;
            }
          
           
        return $data;
    }
    public function functionOrganizacionMatricial() {
        $data=  Organizacion::create()->functionListarOrganizacion();
         session_start();
        $sucu = $_SESSION['rec_suc_id'];
        $data1 = Cupones::create()->functionOrg($sucu);
        foreach ($data1 as $value) {
            $org_id = intval($value['org_id']);
        }
        
        for ($i = 0; $i < count($data); $i++) {
           
            $data[$i]['flag_org']=$org_id;
            }
            return $data;
    }
     
}
