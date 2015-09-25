<?php
/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */
require_once __DIR__ . '/../../modelo/cuponera/Cupones.php';
require_once __DIR__ . '/../../modelo/cuponera/ReportesCupones.php';
require_once __DIR__ . '/../../modeloNegocio/core/ModeloNegocioBase.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/commons/ConstantesNegocio.php';

class ReporteEstadoTramiteNegocio extends ModeloNegocioBase {

    public function getReporteEstadoTramite() {
        session_start();
        $usu_id=$_SESSION['rec_usu_id'];
       
        $data = ReportesCupones::create()->listarEstadoTramite($usu_id);
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            
             $arr =  CuponesNegocio::getDetalleDiasCupEsp($data[$i]['ces_fec_ini'], $fila[$i]['ces_dias']);
	$nota = "";
	foreach ($arr as $v) {
		$nota .= CuponesNegocio::diaconfecha($v)."<br>";
	}
        $data[$i]['nota']=$nota;
        $fechaR=  CuponesNegocio::diaconfecha($data[$i]['ces_fec_resp']);
	switch($data[$i]['ces_estado']) {
		case 1:
                            $data[$i]['icono']= "fa fa-clock-o";
                            $data[$i]['color']= "#EFF70D";
                            $data[$i]['estado']= "Pendiente";
			break;
		case 2:
                            $data[$i]['icono']= "ion-checkmark-circled";
                            $data[$i]['color']= "#5cb85c";
                            
                        $not="<b>Colaborador:</b>&nbsp;".$data[$i]['usu_nombre']."<br><b>Fecha:</b>&nbsp;".$fechaR.")";
                       $data[$i]['estado'] =$not;
                        break;
		case 3:
                        
                        $not2="<b>Colaborador:</b>&nbsp;".$data[$i]['usu_nombre']."<br>";
                        if (strlen($data[$i]['ces_rechazo_usu'])>0) $not2 .= "<b>Motivo:</b> &nbsp;".$data[$i]['ces_rechazo_usu']."<br>";
                            $not2 .= "<b>Fecha:</b>&nbsp;".$fechaR;
                            $data[$i]['icono']= "fa  fa-times-circle";
                            $data[$i]['color'] = "#DC3611";
                            $data[$i]['estado'] =$not2;
			break;
		case 101:
                    $nom=  CuponesNegocio::getUsuNom($data[$i]['ces_usu_anul']);
                    $fechaA=  CuponesNegocio::diaconfecha($data[$i]['ces_fec_anul']);
                    $not3="<b>Colaborador:</b>".$nom."<br><b>Fecha:</b>".$fechaA."<br>";
                    $not3 .= " <b>Motivo:</b>".$data[$i]['ces_motivo_anul'];
			 $data[$i]['icono']='fa  fa-times-circle';
                         $data[$i]['color'] ='#DC3611;'; 
                         $data[$i]['estado'] =$not3;
			break;
		default:
			$data[$i]['estado'] = "Inv&aacute;lido";
	}
        }
        return $data;
    }

}
