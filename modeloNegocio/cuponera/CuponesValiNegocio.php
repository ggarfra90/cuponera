<?php

/* 
 * To change this license header, @GAGF.
 * To change this template file, choose Tools | Templates
 * negocio para el cupon matrimonio.
 */

require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class CuponesValiNegocio extends ModeloNegocioBase {
   public function getTipoCuponDatos(){ 
       session_start();
        $sucu=$_SESSION['rec_suc_id'];
           $usu_id=  $_SESSION['rec_usu_id'];
           $tt=2;
        $t=$_SESSION['tipo'];
        $a=date("Y");
        $data9 = Cupones::create()->functionOrg($sucu);
        foreach ($data9 as $value) {
            $org_id = $value['org_id'];
        }
       $data=array();
         $bloq= Cupones::create()->functionCupBloqueo(intval($a),intval($t),$usu_id); 
             foreach ($bloq as $value) {
            $bloqueo = $value['num'];  
        }
        $cup_color2=2;
        if($t==5)
        {$datap1=Cupones::create()->functionPuente(1,  intval($a),$usu_id,  intval($org_id));
        if ($datap1==0) {
            $cup_color2 = 0;
            $dipu = "No definido";
        }  else {
            $dipu = $datap1[0]['disponibles'];
        }
        $datap2=Cupones::create()->functionPuente(2,  intval($a),$usu_id,intval($org_id));
        $dipu_usad=$datap2[0]['usados'];
        $msj_dipu="";
            if(($dipu-$dipu_usad)<1) {
            $cup_color2 = 0;
            $msj_dipu = "No hay d&iacute;as puente disponibles para utilizar<br><br>";
            }
            $dataV=  Cupones::create()->functionverificaPuenteCombo($a,$org_id);
            $combo=  CuponesNegocio::listadiapuentehtmlS($a);
            $date=date('Y-m-d');
            $cont=0;
            for ($i = 0; $i < count($combo); $i++) {
                
                if($combo[$i]['fecha']>  $date){
                $arrayC[$cont]['fecha']=$combo[$i]['fecha'];
                $cont++;
                }
            }
            $tam=count($arrayC);
            $c=0;
                        for ($i = 0; $i < count($dataV); $i++) {
                
                        if($arrayC[$i]['fecha']== $dataV[$i]['cup_fec_perm']){
               
                           $cup_color2 = 0;
                }
                        
            }
                        }
                        
       $ver=  Cupones::create()->functionCupVeri($t,$a,$usu_id);
      
       if(count($ver)==0){
           $estado= CuponesNegocio::create()->getEstadoC(intval(0),"","",$tt);
           $cup_color=1;
           if($cup_color2!=2){
               $cup_color=$cup_color2;
               }
                  $data=array('cup_estado'=>$estado,'cup_color'=>$cup_color,'cup_bloqueo'=>$bloqueo,'dipu_disponible'=>$dipu,'dipu_msj'=>$msj_dipu,'dipu_usad'=>$dipu_usad);

       }else{
           $cup_color=1;
       foreach ($ver as $value) {
           if ($value["cup_estado"]==1 ) {
               $cup_color=0;
           }
           
           $estado=CuponesNegocio::create()->getEstadoC(intval($value["cup_estado"]),$value['cup_fec_perm'],$value['cup_fec_perm2'],$value['cup_part_time']);           
       }
       if($cup_color2!=2){
               $cup_color=$cup_color2;
               }
       $data=array('cup_estado'=>$estado,'cup_color'=>$cup_color,'cup_bloqueo'=>$bloqueo,'dipu_disponible'=>$dipu,'dipu_msj'=>$msj_dipu,'dipu_usad'=>$dipu_usad);
       }
       
       return $data; 
    }
     
   
}

