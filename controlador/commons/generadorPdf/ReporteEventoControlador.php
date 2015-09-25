<?php


require_once __DIR__ . '/../../core/ControladorBase.php';
require_once __DIR__ . '/../../../modelo/public/Ticket.php';
require_once __DIR__ . '/../../../modelo/sbsadm/espacioTrabajo/EspacioTrabajo.php';
require_once __DIR__ . '/../../../modeloNegocio/commons/EspacioTrabajoNegocio.php';

class ReporteEventoControlador extends ControladorBase{
    
    public function loadComponent()
    {
        $ticketsIds = $this->getParametro('tickets_ids');
        $ticketsIds = explode('|', $ticketsIds);
        $tickets = new Ticket();
        $confiEspTrab = $this->getConfiguracionesEspacioTrabajo();
        $configuraciones = array();
        foreach ($confiEspTrab as  $value) {
            $configuraciones[] = $value['codigo'];
        }
        $empresa = $this->getParametro(Configuraciones::PARAM_EMPRESA_ID);
        $espacioTrabajoId = $this->getParametro(Configuraciones::PARAM_ESPACIOTRABAJO_ID);
        $nombreEspacioTrabajo = EspacioTrabajo::create()->filterById($espacioTrabajoId)->getSelectPersonalized('tab.descripcion');
        $record = $tickets->getReporteTickets(implode(',', $ticketsIds),$this->culture);
        
        
        
        $formatoTicket = array('fecha_inicio'=>  FormatoTipo::FECHA_ESTANDAR,
                                'fecha_conocimiento'=>FormatoTipo::FECHA_ESTANDAR,
                                'descripcion'=>FormatoTipo::HTML_ESTANDAR,
                                'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                'acciones_inmediatas'=>FormatoTipo::HTML_ESTANDAR,
                                'causaprobable_comentario'=>FormatoTipo::HTML_ESTANDAR,
                                'solucionprobable_comentario'=>FormatoTipo::HTML_ESTANDAR,
                                'responsable'=>FormatoTipo::HTML_ESTANDAR,
                                'criticidad'=>FormatoTipo::HTML_ESTANDAR,
                                'catalogo'=>FormatoTipo::HTML_ESTANDAR,
                                'efecto_inicial'=>FormatoTipo::HTML_ESTANDAR,
                                'causaprobable'=>FormatoTipo::HTML_ESTANDAR,
                                'solucionprobable'=>FormatoTipo::HTML_ESTANDAR,
                                'analisispropuesto'=>FormatoTipo::HTML_ESTANDAR);
        $formatoTicketSuceso = array('fecha_creacion'=>FormatoTipo::FECHA_ESTANDAR,
                                    'suceso'=>FormatoTipo::HTML_ESTANDAR,
                                    'efecto'=>FormatoTipo::HTML_ESTANDAR,
                                    'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                    'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoTicketVerificacion = array('fecha_creacion'=>FormatoTipo::FECHA_ESTANDAR,
                                            'tipo'=>FormatoTipo::HTML_ESTANDAR,
                                            'puntaje'=>FormatoTipo::DECIMAL_ESTANDAR,
                                            'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoTicket5w2h = array('descripcion'=>FormatoTipo::HTML_ESTANDAR,
                                    'tipo'=>FormatoTipo::HTML_ESTANDAR,
                                    'clase'=>FormatoTipo::HTML_ESTANDAR);
        $formatoCausaProbable = array('fecha_creacion'=>FormatoTipo::FECHA_ESTANDAR,
                                            'naturaleza'=>FormatoTipo::HTML_ESTANDAR,
                                            'descripcion'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoCausaRaiz = array('fecha_creacion'=>FormatoTipo::FECHA_ESTANDAR,
                                            'naturaleza'=>FormatoTipo::HTML_ESTANDAR,
                                            'estado'=>FormatoTipo::HTML_ESTANDAR,
                                            'descripcion'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoValidacionCausa = array('fecha_creacion'=>FormatoTipo::FECHA_ESTANDAR,
                                            'estado'=>FormatoTipo::HTML_ESTANDAR,
                                            'descripcion'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoPorqueCausaRaiz= array('porque'=>FormatoTipo::HTML_ESTANDAR,
                                            'esraiz'=>FormatoTipo::HTML_ESTANDAR);
        
        $formatoTarea = array('criticidad'=>FormatoTipo::HTML_ESTANDAR,
                                'que'=>FormatoTipo::HTML_ESTANDAR,
                                'como'=>FormatoTipo::HTML_ESTANDAR,
                                'donde'=>FormatoTipo::HTML_ESTANDAR,
                                'porque'=>FormatoTipo::HTML_ESTANDAR,
                                'cuanto'=>FormatoTipo::HTML_ESTANDAR);
        $formatoTareaPlanificacion = array('fecha'=>FormatoTipo::FECHA_ESTANDAR,
                                            'inicio'=>FormatoTipo::FECHA_ESTANDAR,
                                            'duracion'=>FormatoTipo::HTML_ESTANDAR,
                                            'fin'=>FormatoTipo::FECHA_ESTANDAR,
                                            'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoTareaAvance = array('fecha'=>FormatoTipo::FECHA_ESTANDAR,
                                            'avance'=>FormatoTipo::DECIMAL_ESTANDAR,
                                            'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        
        $formatoTareaSucesos = array('fecha'=>FormatoTipo::FECHA_ESTANDAR,
                                            'suceso'=>FormatoTipo::HTML_ESTANDAR,
                                            'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoTareaVerificacion = array('fecha_creacion'=>FormatoTipo::FECHA_ESTANDAR,
                                            'tipo'=>FormatoTipo::HTML_ESTANDAR,
                                            'puntaje'=>FormatoTipo::DECIMAL_ESTANDAR,
                                            'comentario'=>FormatoTipo::HTML_ESTANDAR,
                                            'responsable'=>FormatoTipo::HTML_ESTANDAR);
        $formatoMediosComentario = array('imagen'=>FormatoTipo::HTML_ESTANDAR,
                                            'usuario'=>FormatoTipo::HTML_ESTANDAR,
                                            'descricpion'=>FormatoTipo::HTML_ESTANDAR,
                                            'fecha'=>FormatoTipo::FECHA_ESTANDAR);
        foreach ($record as $key => $value) {
            //formateamos la data propia del ticket
            $record[$key] = $this->getFormatRecord(array('row'=>$value,'colsFormat'=>$formatoTicket),true);
            //formateamos la data de la tabla 5w2h del ticket
            $record[$key]['preguntas5w2h'] = $this->getFormatData(array('rows'=>json_decode($value['preguntas5w2h'],true),'colsFormat'=>$formatoTicket5w2h));
            //formateamos la data de los sucesos del ticket
            $record[$key]['sucesos'] = $this->getFormatData(array('rows'=>json_decode($value['sucesos'],true),'colsFormat'=>$formatoTicketSuceso));
            //formateamos la data de los verificaciones del ticket
            $record[$key]['verificaciones'] = $this->getFormatData(array('rows'=>json_decode($value['verificaciones'],true),'colsFormat'=>$formatoTicketVerificacion));
            
            $record[$key]['causasprobables'] = json_decode($value['causasprobables'],true);
            
            foreach ($record[$key]['causasprobables'] as $keyCauPro => $valueCauPro) {
                $record[$key]['causasprobables'][$keyCauPro] = $this->getFormatRecord(array('row'=>$valueCauPro,'colsFormat'=>$formatoCausaProbable),true);
                $record[$key]['causasprobables'][$keyCauPro]['porques'] = $this->getFormatData(array('rows'=>$record[$key]['causasprobables'][$keyCauPro]['porques'],'colsFormat'=>array('porque'=>FormatoTipo::HTML_ESTANDAR)));
            }
            
            $record[$key]['causasraices'] = json_decode($value['causasraices'],true);
            foreach ($record[$key]['causasraices'] as $keyCauRaiz => $valueCauRaiz) {
                $record[$key]['causasraices'][$keyCauRaiz] = $this->getFormatRecord(array('row'=>$valueCauRaiz,'colsFormat'=>$formatoCausaRaiz),true);
                $record[$key]['causasraices'][$keyCauRaiz]['porques'] = $this->getFormatData(array('rows'=>$record[$key]['causasraices'][$keyCauPro]['porques'],'colsFormat'=>$formatoPorqueCausaRaiz));
            }
           
            $record[$key]['validacioncausas'] = $this->getFormatData(array('rows'=>json_decode($value['validacioncausas'],true),'colsFormat'=>$formatoValidacionCausa));

            $record[$key]['medios'] = json_decode(ObjectUtil::parseString($value['medios']),true);
            foreach ($record[$key]['medios'] as $keyMedios => $valueMedios) {
                $record[$key]['medios'][$keyMedios]['imagen'] = Configuraciones::url_base.'uploads/empresa-'.$empresa.'/'.basename($valueMedios['imagen']);
                $dim = $this->calcularDimensiones($record[$key]['medios'][$keyMedios]['imagen'], 47.19, 35);
                $record[$key]['medios'][$keyMedios]['ancho'] = $dim['ancho'];          
                $record[$key]['medios'][$keyMedios]['alto']= $dim['alto'];
                
                foreach ($record[$key]['medios'][$keyMedios]['comentarios'] as $keyComentarios => $valueComentarios) {
                    $record[$key]['medios'][$keyMedios]['comentarios'][$keyComentarios]['imagen'] = Configuraciones::url_base.'uploads/personas/'.basename($valueComentarios['imagen']);
                    $dimPer = $this->calcularDimensiones($record[$key]['medios'][$keyMedios]['comentarios'][$keyComentarios]['imagen'], 11.05, 15);
                    $record[$key]['medios'][$keyMedios]['comentarios'][$keyComentarios]['ancho'] = $dimPer['ancho'];          
                    $record[$key]['medios'][$keyMedios]['comentarios'][$keyComentarios]['alto']= $dimPer['alto'];
                    $record[$key]['medios'][$keyMedios]['comentarios'][$keyComentarios]['descripcion'] = $valueComentarios['descripcion'];
                }
            }
            $tareas = json_decode(ObjectUtil::parseString($value['tareas']),true);
            
            foreach ($tareas as $keyTarea => $valueTarea) {
                $tareas[$keyTarea] = $this->getFormatRecord(array('row'=>$valueTarea,'colsFormat'=>$formatoTarea),true);
                
                $tareas[$keyTarea]['planificaciones'] = $this->getFormatData(array('rows'=>$valueTarea['planificaciones'],'colsFormat'=>$formatoTareaPlanificacion));
                
                $tareas[$keyTarea]['avances'] = $this->getFormatData(array('rows'=>$valueTarea['avances'],'colsFormat'=>$formatoTareaAvance));
                
                $tareas[$keyTarea]['sucesos'] = $this->getFormatData(array('rows'=>$valueTarea['sucesos'],'colsFormat'=>$formatoTareaSucesos));
                
                $tareas[$keyTarea]['recursos'] = $this->getFormatData(array('rows'=>$valueTarea['recursos'],'colsFormat'=>array('recurso'=>FormatoTipo::HTML_ESTANDAR)));
                
                $tareas[$keyTarea]['verificacion'] = $this->getFormatData(array('rows'=>$valueTarea['verificacion'],'colsFormat'=>$formatoTareaVerificacion));
                
                foreach ($valueTarea['medios'] as $keyTarMedio => $valueTarMedio) {
                    $tareas[$keyTarea]['medios'][$keyTarMedio]['imagen'] = Configuraciones::url_base.'uploads/empresa-'.$empresa.'/'.basename($valueTarMedio['imagen']);
                    $dimTar = $this->calcularDimensiones($tareas[$keyTarea]['medios'][$keyTarMedio]['imagen'], 47.19, 35);
                    $tareas[$keyTarea]['medios'][$keyTarMedio]['ancho'] = $dimTar['ancho'];          
                    $tareas[$keyTarea]['medios'][$keyTarMedio]['alto']= $dimTar['alto'];
                    foreach ($valueTarMedio['comentarios'] as $keyComentario => $valueTarComentario) {
                        
                        $tareas[$keyTarea]['medios'][$keyTarMedio]['comentarios'][$keyComentario] = $this->getFormatRecord(array('row'=>$valueTarComentario,'colsFormat'=>$formatoMediosComentario),true);
                        $tareas[$keyTarea]['medios'][$keyTarMedio]['comentarios'][$keyComentario]['imagen'] = Configuraciones::url_base.'uploads/personas/'.basename($valueTarComentario['imagen']);
                        $dimPerTar = $this->calcularDimensiones($tareas[$keyTarea]['medios'][$keyTarMedio]['comentarios'][$keyComentario]['imagen'], 11.05, 15);
                        $tareas[$keyTarea]['medios'][$keyTarMedio]['comentarios'][$keyComentario]['ancho'] = $dimPerTar['ancho'];          
                        $tareas[$keyTarea]['medios'][$keyTarMedio]['comentarios'][$keyComentario]['alto']= $dimPerTar['alto'];
                        $tareas[$keyTarea]['medios'][$keyTarMedio]['comentarios'][$keyComentario]['descripcion'] = $valueTarComentario['descripcion'];
                    }
                }
            }
            
            $record[$key]['tareas'] = $tareas;
        }
        $data = array();
        $data['data'] = $record;
        $data['configuraciones'] = $configuraciones;
        $data['espacioTrabajo'] = $nombreEspacioTrabajo[0]['descripcion'];
        return $data;
    }
    
    private function calcularDimensiones($imagen,$maxWidth,$maxHeight)
    {
       
        $dimensiones = getimagesize($imagen);
        $ancho = $dimensiones[0];
        $alto = $dimensiones[1];
        
        $width = 0;
        $height = 0;
        if($ancho>$alto)
        {
            $width = $maxWidth;
            $height = $maxWidth*$alto/$ancho;
            if($height > $maxHeight)
            {
                $width = $maxHeight*$ancho/$alto;
                $height = $maxHeight;
            }
        }
        else
        {
           $width = $maxHeight*$ancho/$alto;
           $height = $maxHeight;
           if($width > $maxWidth)
           {
               $width = $maxWidth;
               $height = $maxWidth*$alto/$ancho;
           }
        }
        $dimensiones = array();
        $dimensiones['ancho'] = $width.'mm';
        $dimensiones['alto'] = $height.'mm';
        return $dimensiones;
    }

        /**
     * Nos encargamos de obtener las configuraciones que han sido definidas para 
     * el espacio de trabajo
     * 
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     */
    private function getConfiguracionesEspacioTrabajo(){
       return  EspacioTrabajoNegocio::create()->getComponenteEspacioConfigByEspacioTrabajo($this->getParametro(Configuraciones::PARAM_ESPACIOTRABAJO_ID));
    }
    
}
