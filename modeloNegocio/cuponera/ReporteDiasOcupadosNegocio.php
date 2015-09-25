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

class ReporteDiasOcupadosNegocio extends ModeloNegocioBase {

    public function getReporteDiasOcupados() {
        session_start();
        $usu_id=$_SESSION['rec_usu_id'];
                $year=date('Y');
        $data = CuponesNegocio::create()->getDiasOcupados($year,$usu_id);
        $array=array();
        $tamanio = count($data);
        for ($i = 0; $i < $tamanio; $i++) {
            
             switch($data[$i][3]) {
			case "Solicitado":
                            $icono= "fa fa-clock-o";
                            $color = "#EFF70D";
                            $estado = "Pendiente";

				break;
			case "Aprobado":
                             $icono= "ion-checkmark-circled";
                            $color = "#5cb85c";
                            $estado = "Aprobado";
				break;
                        case "Inv&aacute;lido":
                            $icono= "fa  fa-times-circle";
                            $color = "#DC3611";
                            $estado = "Inv&aacute;lido";
                       case "Ejecutado":
                           $icono= "fa  fa-play-circle";
                            $color = "#337AB7";
                            $estado = "Eejcutado";
		
		}
                $array[$i]=array('fecha'=>$data[$i][2],'categoria'=>$data[$i][0],'tipo'=>$data[$i][1],'icono'=>$icono,'color'=>$color,'estado'=>$estado);
        }
        return $array;
    }

}
