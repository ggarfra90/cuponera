<?php

/**
 * Clase utilizada para unificar el procesamiento de los graficos, 
 * tanto en las obtenciones de parámetros como en el formateo y 
 * si necesitase alguna cosa que es comun en las graficas
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */
class ControladorBaseGraficos extends ControladorBase {
    // <editor-fold defaultstate="collapsed" desc="Metodos Principales">
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * @abstract Obtiene el intervalo de fechas en un array con dos elementos fini y ffin
     * @param array('mostrar'=>$mostrar,'fini'=>$fini, 'ffin'=>$ffin, 'valor'=>$valor, 'zoom'=>$zoom) $intervalo
     * @return array('fini'=>$fini, 'ffin'=>$ffin)
     * @throws WarningException
     */
    protected function getIntervaloByLineaTiempo($intervalo)
    {
        if (ObjectUtil::isEmpty($intervalo))
        {
            throw new WarningException(118);
        }
        
        $mostrar = null; $fini = null; $ffin = null; $valor = null; $zoom = null;
        
        if (array_key_exists('mostrar', $intervalo)) $mostrar = $intervalo['mostrar'];
        if (array_key_exists('fini', $intervalo)) $fini = $intervalo['fini'];
        if (array_key_exists('ffin', $intervalo)) $ffin = $intervalo['ffin'];
        if (array_key_exists('valor', $intervalo)) $valor = $intervalo['valor'];
        if (array_key_exists('zoom', $intervalo)) $zoom = $intervalo['zoom'];
        
        if (ObjectUtil::isEmpty($mostrar))
        {
            throw new WarningException(102); //"El tipo de periodicidad del reporte en la solicitud esta vacía o es nula."
        }
        if (ObjectUtil::isEmpty($fini))
        {
            throw new WarningException(103); //"El inicio del periodo del reporte en la solicitud esta vacía o es nula."
        }
        if (ObjectUtil::isEmpty($ffin))
        {
            throw new WarningException(104); //"El fin del periodo del reporte en la solicitud esta vacía o es nula."
        }
        if (ObjectUtil::isEmpty($valor))
        {
            throw new WarningException(119);
        }
        if (ObjectUtil::isEmpty($zoom))
        {
            throw new WarningException(120);
        }
        
        $rango = null; $tamanio_rango = null;
        
        if (is_numeric($zoom)) $tamanio_rango = floatval ($zoom);
        
        if (ObjectUtil::isEmpty($tamanio_rango))
        {
            throw new WarningException(129);
        }
        
        if ($tamanio_rango > 1) $tamanio_rango = $tamanio_rango - 1; //Le quitamos el mismo día
        
        $rango_menos = floor ($tamanio_rango / 2);
        $rango_mas = $tamanio_rango - $rango_menos;
        
        switch (strtolower(trim($mostrar)))
        {
            case "dias":
                $fini_fecha = null; $ffin_fecha = null; $valor_fecha = null; 
                
                if (array_key_exists('fecha', $fini)) $fini_fecha = $fini['fecha'];
                if (array_key_exists('fecha', $ffin)) $ffin_fecha = $ffin['fecha'];
                if (array_key_exists('fecha', $valor)) $valor_fecha = $valor['fecha'];
                
                if (ObjectUtil::isEmpty($fini_fecha) || ObjectUtil::isEmpty($ffin_fecha) || ObjectUtil::isEmpty($valor_fecha))
                {
                    throw new WarningException(123);
                }
                
                $fecha_inicio = new DateTime($fini_fecha);
                $fecha_fin = new DateTime($ffin_fecha);
                
                $valor_fecha = str_replace('00:00:00', "", $valor_fecha);
                $rango_finicio = new DateTime(trim($valor_fecha).' 00:00:00');                
                $rango_ffin = new DateTime(trim($valor_fecha).' 23:59:59');
                
                if ($rango_finicio < $fecha_inicio || $rango_finicio > $fecha_fin)
                {
                    throw new WarningException(130);
                }                
                
                $rango_finicio->modify('-'.$rango_menos.' day');
                $rango_ffin->modify('+'.$rango_mas.' day');
                
                if ($rango_finicio < $fecha_inicio)
                {
                    $diff = $rango_finicio->diff($fecha_inicio, true);
                    $days = intval($diff->format('%a'));
                    
                    if ($days > $rango_menos) $days = $rango_menos;
                    
                    $rango_finicio = $fecha_inicio;
                    $rango_ffin->add(new DateInterval('P'.$days.'D'));
                    
                    if ($rango_ffin > $fecha_fin) $rango_ffin = $fecha_fin;
                }
                
                if ($rango_ffin > $fecha_fin)
                {
                    $diff = $rango_ffin->diff($fecha_fin, true);
                    $days = intval($diff->format('%a'));
                    
                    if ($days > $rango_mas) $days = $rango_mas;
                    
                    $rango_ffin = $fecha_fin;
                    $rango_finicio->sub(new DateInterval('P'.$days.'D'));
                    
                    if ($rango_finicio < $fecha_inicio) $rango_finicio = $fecha_inicio;
                }
                
                $rango = array ("fini" => array ("fecha" => DateUtil::getStrFecha($rango_finicio)),
                                "ffin" => array ("fecha" => DateUtil::getStrFecha($rango_ffin))
                               );
                
                break;
            case "semanas":
                $fini_anio = null; $fini_semana = null; $ffin_anio = null; $ffin_semana = null; $valor_anio = null; $valor_semana = null;
                
                if (array_key_exists('anio', $fini)) $fini_anio = $fini['anio'];
                if (array_key_exists('semana', $fini)) $fini_semana = $fini['semana'];
                if (array_key_exists('anio', $ffin)) $ffin_anio = $ffin['anio'];
                if (array_key_exists('semana', $ffin)) $ffin_semana = $ffin['semana'];
                if (array_key_exists('anio', $valor)) $valor_anio = $valor['anio'];
                if (array_key_exists('semana', $valor)) $valor_semana = $valor['semana'];
                
                if (ObjectUtil::isEmpty($fini_anio) || ObjectUtil::isEmpty($fini_semana) || 
                    ObjectUtil::isEmpty($ffin_anio) || ObjectUtil::isEmpty($ffin_semana) ||
                    ObjectUtil::isEmpty($valor_anio) || ObjectUtil::isEmpty($valor_semana))
                {
                    throw new WarningException(123);
                }
                
                $fecha_inicio =  $this->getFechaBySemana($fini_anio, $fini_semana); //new DateTime($fini_anio."W".$fini_semana." 00:00:00");
                $fecha_fin = $this->getFechaBySemana($ffin_anio, $ffin_semana); //new DateTime($ffin_anio."W".$ffin_semana." 23:59:59");
                
                $rango_finicio = $this->getFechaBySemana($valor_anio, $valor_semana); //new DateTime($valor_anio."W".$valor_semana.' 00:00:00');                
                $rango_ffin = $this->getFechaBySemana($valor_anio, $valor_semana); // new DateTime($valor_anio."W".$valor_semana.' 23:59:59');
                
                if ($rango_finicio < $fecha_inicio || $rango_finicio > $fecha_fin)
                {
                    throw new WarningException(130);
                }
                
                $rango_finicio->modify('-'.$rango_menos.' week');
                $rango_ffin->modify('+'.$rango_mas.' week');
                
                if ($rango_finicio < $fecha_inicio)
                {
                    $diff = $rango_finicio->diff($fecha_inicio, true);
                    $days = intval($diff->format('%a'));
                    $semanas = $days/7;
                    if ($semanas > $rango_menos) $semanas = $rango_menos;
                    
                    $rango_finicio = $fecha_inicio;
                    $rango_ffin->modify('+'.$semanas.' week');
                    //$rango_ffin->add(new DateInterval('P'.$days.'D'));
                    
                    if ($rango_ffin > $fecha_fin) $rango_ffin = $fecha_fin;
                }
                
                if ($rango_ffin > $fecha_fin)
                {
                    $diff = $rango_ffin->diff($fecha_fin, true);
                    $days = intval($diff->format('%a'));
                    $semanas = $days/7;
                    if ($semanas > $rango_mas) $semanas = $rango_mas;
                    
                    $rango_ffin = $fecha_fin;
                    $rango_finicio->modify('-'.$semanas.' week');
                    //$rango_finicio->sub(new DateInterval('P'.$days.'D'));
                    
                    if ($rango_finicio < $fecha_inicio) $rango_finicio = $fecha_inicio;
                }
                
                $rango = array ("fini" => array 
                                        ("anio" => DateUtil::getAnioByFecha($rango_finicio),
                                        "semana" => DateUtil::getSemanaNumeroByFecha($rango_finicio)),
                                "ffin" => array 
                                        ("anio" => DateUtil::getAnioByFecha($rango_ffin),
                                        "semana" => DateUtil::getSemanaNumeroByFecha($rango_ffin))
                               );
                break;
            case "meses":
                $fini_anio = null; $fini_mes = null; $ffin_anio = null; $ffin_mes = null; $valor_anio = null; $valor_mes = null;
                
                if (array_key_exists('anio', $fini)) $fini_anio = $fini['anio'];
                if (array_key_exists('mes', $fini)) $fini_mes = $fini['mes'];
                if (array_key_exists('anio', $ffin)) $ffin_anio = $ffin['anio'];
                if (array_key_exists('mes', $ffin)) $ffin_mes = $ffin['mes'];
                if (array_key_exists('anio', $valor)) $valor_anio = $valor['anio'];
                if (array_key_exists('mes', $valor)) $valor_mes = $valor['mes'];
                
                if (ObjectUtil::isEmpty($fini_anio) || ObjectUtil::isEmpty($fini_mes) || 
                    ObjectUtil::isEmpty($ffin_anio) || ObjectUtil::isEmpty($ffin_mes) ||
                    ObjectUtil::isEmpty($valor_anio) || ObjectUtil::isEmpty($valor_mes))
                {
                    throw new WarningException(123);
                }
                
                $fecha_inicio =  $this->getFechaByMes($fini_anio, $fini_mes); //new DateTime($fini_anio."W".$fini_semana." 00:00:00");
                $fecha_fin = $this->getFechaByMes($ffin_anio, $ffin_mes); //new DateTime($ffin_anio."W".$ffin_semana." 23:59:59");
                
                $rango_finicio = $this->getFechaByMes($valor_anio, $valor_mes); //new DateTime($valor_anio."W".$valor_semana.' 00:00:00');                
                $rango_ffin = $this->getFechaByMes($valor_anio, $valor_mes); // new DateTime($valor_anio."W".$valor_semana.' 23:59:59');
                
                if ($rango_finicio < $fecha_inicio || $rango_finicio > $fecha_fin)
                {
                    throw new WarningException(130);
                }
                
                $rango_finicio->modify('-'.$rango_menos.' month');
                $rango_ffin->modify('+'.$rango_mas.' month');
                
                if ($rango_finicio < $fecha_inicio)
                {
                    $diff = $rango_finicio->diff($fecha_inicio, true);
                    $meses = intval($diff->format('%m'));
                    
                    if ($meses > $rango_menos) $meses = $rango_menos;
                    
                    $rango_finicio = $fecha_inicio;
                    $rango_ffin->modify('+'.$meses.' month');
                    
                    if ($rango_ffin > $fecha_fin) $rango_ffin = $fecha_fin;
                }
                
                if ($rango_ffin > $fecha_fin)
                {
                    $diff = $rango_ffin->diff($fecha_fin, true);
                    $meses = intval($diff->format('%m'));
                    
                    if ($meses > $rango_mas) $meses = $rango_mas;
                    
                    $rango_ffin = $fecha_fin;
                    $rango_finicio->modify('-'.$meses.' month');
                    
                    if ($rango_finicio < $fecha_inicio) $rango_finicio = $fecha_inicio;
                }
                
                $rango = array ("fini" => array 
                                        ("anio" => DateUtil::getAnioByFecha($rango_finicio),
                                        "mes" => DateUtil::getMesNumeroByFecha($rango_finicio)),
                                "ffin" => array 
                                        ("anio" => DateUtil::getAnioByFecha($rango_ffin),
                                        "mes" => DateUtil::getMesNumeroByFecha($rango_ffin))
                               );
                break;
            default:
                throw new WarningException(121);         
        }
        
        return $rango;
    }
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Metodos de apoyo">
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * @abstract Obtiene una fecha en función a la semana que se le pase
     * @param string $anio
     * @param string $semanaNumero
     * @return \DateTime
     */
    private function getFechaBySemana($anio, $semanaNumero){
        if ((int)$semanaNumero < 10){
            $semanaNumero = '0'.(int)$semanaNumero;
        }
        $fecha = new DateTime($anio."W".$semanaNumero." 00:00:00");
        return $fecha;
    }
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * @abstract Obtiene una fecha en función al mes que se le pase
     * @param string $anio
     * @param string $mesNumero
     * @return \DateTime
     */
    private function getFechaByMes($anio, $mesNumero){
        $fecha = new DateTime();
        $fecha->setDate($anio, $mesNumero, 1);
        return $fecha;
    }
    // </editor-fold>  
}
