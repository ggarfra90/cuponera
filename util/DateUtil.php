<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../modelo/enumeraciones/FormatoFecha.php';
require_once __DIR__.'/../modelo/enumeraciones/UnidadTiempo.php';

/**
 * Description of DateUtil
 *
 * @author JHOEL
 */
class DateUtil {
    /**
     * 
     * @param type $anio: indica el año a usar para generar la fecha
     * @param type $mes: indica el mes a usar para generar la fecha
     * @param type $semana: indica la semana a usar para generar la fecha
     * @param type $limite: indica si se tomara el primer dia o el ultimo dia del intervalo consultado
     * @return \DateTime
     */
    static public function getFechaByAnioMesSemana($anio,$mes=null,$semana=null,$limite='inicio') {
        $fecha=new DateTime('2013-01-01 00:00:00');
        if ($mes!=null){  
            $fecha->setDate($anio, $mes, 1);
            if ($limite!='inicio'){
                $fecha->add(new DateInterval('P1M'));
                $fecha->sub(new DateInterval('P1D'));                
            }                  
        }elseif ($semana!=null){
            $fecha->setISODate($anio, $semana);   
            if ($limite!='inicio'){
                $fecha->add(new DateInterval('P6D'));
            }
        }
        return $fecha;
    }
    
    static public function getStrFecha($fecha, $formato = FormatoFecha::REGISTRO_YMD_HIS) {
        //$fech=new DateTime($fecha);
        return "'" . $fecha->format($formato) . "'";
    }
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * @abstract Obtiene el numero de semana del año a travez de la fecha
     * @param datetime $fecha
     * @return int
     */
    static public function getSemanaNumeroByFecha($fecha) {
        $ddate = $fecha->format('Y-m-d');
        $duedt = explode("-", $ddate);
        $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
        return date('W', $date);
    }
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * @abstract Obtiene el año de una fecha
     * @param datetime $fecha
     * @return int
     */
    static public function getAnioByFecha($fecha) {
        return (int)$fecha->format("Y");
    }
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * @abstract Obtiene el número de mes de una fecha dada
     * @param type $fecha
     * @return type
     */
    static public function getMesNumeroByFecha($fecha) {
        return (int)$fecha->format("m");
    }
    
    static public function getDateTime($datetime, $formato = FormatoFecha::REGISTRO_YMD_HIS){
        return date_format(new DateTime($datetime), $formato);
    }
    
    /**
     * Funcion que convierte una cantidad de segundos a horas
     * 
     * @param type $segundos
     * @return type
     */
    static function getSegundosAHoras($segundos) {
        $horas = floor ( abs($segundos) / 3600 );
        $minutes = ( ( abs($segundos) / 60 ) % 60 );
        
        return (($seconds<0)?'-':'') . str_pad( $horas, 2, "0", STR_PAD_LEFT ) . ':' . str_pad( $minutes, 2, "0", STR_PAD_LEFT );
    }
    
    /**
     * Funcion que convierte una cantidad de horas a segundos
     * 
     * @param type $horas, es la cantidad de horas(formato hh:mm) que se desea convertir a segundos
     * @return type
     */
    static function getHorasASegundos($horas) {
        list($horas,$minutos) = explode(':', $horas);
        
        return (3600 * ((!ObjectUtil::isEmpty($horas) && $horas!= '')?$horas:0))+(60 * ((!ObjectUtil::isEmpty($minutos) && $minutos!= '')?$minutos:0));
    }
    
    static public function getSemanasPorNroSemanaAnio($anioIni, $semanaIni, $anioFin, $semanaFin)
    {
        $fechaInicio = (new DateTime('2000-01-01 00:00:00'));
        $fechaInicio->setISODate($anioIni, $semanaIni);
        $fechaFin = (new DateTime('2000-01-01 00:00:00'));        
        $fechaFin->setISODate($anioFin, $semanaFin,7);
        return self::getSemanasPorAnioIndex($fechaInicio, $fechaFin);
    }
    
    static public function getSemanasPorAnio($fechaInicial,$fechaFinal){
        $findex = new DateTime($fechaInicial);
        $ffin = new DateTime($fechaFinal);
        $interval = $findex->diff($ffin);
        $semanasXAnio = array();
        while($findex < $ffin/*$interval->invert != 1*/)
        {
            $semanasXAnio[$findex->format("o")][] = $findex->format("W");
            $findex->add(new DateInterval("P7D"));
            $interval = $findex->diff($ffin);
        }
       return $semanasXAnio;
    }
    
    static public function getSemanasPorAnioIndex($fechaInicial,$fechaFinal){
        $findex = $fechaInicial;
        $ffin = $fechaFinal;
        $interval = $findex->diff($ffin);
        
        $aSemanas = array();
        while($findex < $ffin)
        {
            $object = new stdClass();
            $object->anio = $findex->format("o");
            $object->semana = $findex->format("W");
            $aSemanas[] = $object;
            $findex->add(new DateInterval("P7D"));
            $interval = $findex->diff($ffin);
       }
       return $aSemanas;
    }
    
    
    /**
     * Metodo que genera las fechas totales(inicio total y fin total) de un rango de tiempo especificado, ya sea dias, semanas o meses
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     * @param type $modoMostrar
     * @param type $inicio
     * @param type $fin
     * @return type
     */
    static public function getFechasIniFinTotalRangoTiempo($modoMostrar,$inicio,$fin) {
        $arrFechaInicioFin=array();
        
        //Generacion de los intervalos con sus fechas
        switch ($modoMostrar) {
            case UnidadTiempo::UND_TIEMPO_DIAS:
                $arrFechaInicioFin['inicio']=$inicio['fecha'];
                $arrFechaInicioFin['fin']=$fin['fecha'];
                break;
                
            case UnidadTiempo::UND_TIEMPO_MESES:
                $fechaInicio=new DateTime(date("Y-m-d 00:00:00",mktime(0,0,0,$inicio['mes'],1,$inicio['anio'])));
                $fechaFin=new DateTime(date("Y-m-d 23:59:59",mktime(0,0,0,$fin['mes']+1,0,$fin['anio'])));                
                $arrFechaInicioFin['inicio']=date("Y-m-d 00:00:00",$fechaInicio->getTimestamp());
                $arrFechaInicioFin['fin']=date("Y-m-d 23:59:59",$fechaFin->getTimestamp());
                break;   
                
            case UnidadTiempo::UND_TIEMPO_SEMANAS:
                $fechaInicio = (new DateTime('2000-01-01 00:00:00'));
                $fechaInicio->setISODate($inicio['anio'], $inicio['semana']);
                $fechaFin = (new DateTime('2000-01-01 00:00:00'));        
                $fechaFin->setISODate($fin['anio'], $fin['semana']);        
                $arrFechaInicioFin['inicio']=date("Y-m-d 00:00:00",$fechaInicio->getTimestamp());
                $arrFechaInicioFin['fin']=date("Y-m-d 23:59:59",$fechaFin->add(new DateInterval('P6D'))->getTimestamp());
                break;
        }
                
        return $arrFechaInicioFin;        
    }
    
    /**
     * * Metodo que genera las fechas para los intervalos, POR CADA UNIDAD DE TIEMPO (dias, semanas o meses)
     * 
     * @author cheredia <cheredia@imaginatecperu.com> 
     * @param type $modoMostrar
     * @param type $inicio
     * @param type $fin
     * @param type $pageNumberHor
     * @param type $pageSizeHor
     * @param type $totalHor
     * @return type
     */
    static public function getFechasIniFinUndTiempoRangoTiempo($modoMostrar,$inicio,$fin, $pageNumberHor, $pageSizeHor, &$totalHor) {
        $arrIntervalos=array();
        
        //Generacion de los intervalos con sus fechas
        switch ($modoMostrar) {
            case UnidadTiempo::UND_TIEMPO_DETALLADO:
            case UnidadTiempo::UND_TIEMPO_DIAS:
                $fechaIndex=new DateTime($inicio['fecha']);
                $fin=new DateTime($fin['fecha']);
                
                while ($fechaIndex->getTimestamp() <= $fin->getTimestamp()) {
                    $arrIntervalos[date('d/m/Y',$fechaIndex->getTimestamp())]=array('inicio'=>date("Y-m-d 00:00:00",$fechaIndex->getTimestamp()),'fin'=>date("Y-m-d 23:59:59",$fechaIndex->getTimestamp()));
                    $fechaIndex->add(new DateInterval('P1D'));
                }break;
                
            case UnidadTiempo::UND_TIEMPO_TOTAL:
                $fechaInicio = new DateTime($inicio['fecha']);
                $fechaFin = new DateTime($fin['fecha']);
                $arrIntervalos[date('d/m/Y',$fechaInicio->getTimestamp()) . ' - ' . date('d/m/Y',$fechaFin->getTimestamp())]=array('inicio'=>date("Y-m-d 00:00:00",$fechaInicio->getTimestamp()),'fin'=>date("Y-m-d 23:59:59",$fechaFin->getTimestamp()));
                break;
            
            case UnidadTiempo::UND_TIEMPO_MESES:
                $fechaIndex=new DateTime(date("Y-m-d 00:00:00",mktime(0,0,0,$inicio['mes'],1,$inicio['anio'])));
                $fin=new DateTime(date("Y-m-d 23:59:59",mktime(0,0,0,$fin['mes']+1,0,$fin['anio'])));
                
                while ($fechaIndex->getTimestamp() <= $fin->getTimestamp()) {
                    $arrIntervalos[date('Y-m',$fechaIndex->getTimestamp())]=array('inicio'=>date("Y-m-d 00:00:00",$fechaIndex->getTimestamp()),'fin'=>date("Y-m-d 23:59:59",mktime(0,0,0,date("m",$fechaIndex->getTimestamp())+1,0,date("Y",$fechaIndex->getTimestamp()))));
                    $fechaIndex->add(new DateInterval('P1M'));
                }break;   
                
            case UnidadTiempo::UND_TIEMPO_SEMANAS:
                $fechaIndex = (new DateTime('2000-01-01 00:00:00'));
                $fechaIndex->setISODate($inicio['anio'], $inicio['semana']);
                $fechaFin = (new DateTime('2000-01-01 00:00:00'));        
                $fechaFin->setISODate($fin['anio'], $fin['semana'],7);        
                
                while ($fechaIndex->getTimestamp() <= $fechaFin->getTimestamp()) {
                    $arrIntervalos[date('Y-W',$fechaIndex->getTimestamp())]=array('inicio'=>date("Y-m-d 00:00:00",$fechaIndex->getTimestamp()),'fin'=>date("Y-m-d 23:59:59",$fechaIndex->add(new DateInterval('P6D'))->getTimestamp()));
                    $fechaIndex->add(new DateInterval('P1D'));
                }break;
            case UnidadTiempo::UND_TIEMPO_PERSONALIZADO:
                foreach ($inicio as $value) {
                    $arrIntervalos[$value['und_tiempo']]=array('inicio'=>$value['fecha_inicio'],'fin'=>$value['fecha_fin'],'id'=>$value['und_tiempo_id']);
                }break;                
        }
        
        //Paginacion de los intervalos.
        if (!ObjectUtil::isEmpty($pageNumberHor) && !ObjectUtil::isEmpty($pageSizeHor)){
            $totalHor=  count($arrIntervalos);
            $index=1;
            $rangoPagHorIni=($pageNumberHor-1)*$pageSizeHor+1;
            $rangoPagHorFin=$pageNumberHor*$pageSizeHor;
            $fechasPaginadas = array();
            foreach ($arrIntervalos as $keyFech => $valueFech) {
                if ($index>=$rangoPagHorIni && $index<=$rangoPagHorFin){
                    $fechasPaginadas[$keyFech]=$valueFech;
                } $index++;            
            }
            return $fechasPaginadas;  
        }else{
            return $arrIntervalos;
        }     
    }
    
    
    
}

?>