<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../../../../vistas/script/ScriptBase.php';
require_once __DIR__.'/../../../../util/Util.php';

class ReporteEvento extends ScriptBase{
 const COMPONENT_CODE = 'reporte.pdf.evento';
    
    var $module_code = null;
    
    /**
     * Aqui se realizar la implementación del script, se llamará la controlador, se asignarán las variables,
     * se agregarán los templates, etc, etc. Esta función es llamada desde el frontcontroller
     */
    public function execute()
    {
        
        $this->makeControllerGetLabels();
              
        // - Obtenemos la respuesta del controlador.
        $ticketsIds = $this->setRequestParamToController('tickets_ids');
        $response = $this->getResponse(true,'loadComponent', self::COMPONENT_CODE);

        if($response == null || !isset($response)) {
            throw new \Exception('ERROR: El controlador no devolvio la informacion minima necesaria.');
        }
        //cargammos la data en el tpl
        $this->assignSmartyVar("tickets",  $response['data']);
        $this->assignSmartyVar("configuraciones",  $response['configuraciones']);
        $this->assignSmartyVar("urlbase", Configuraciones::url_base());
        
        //configuramos el header
        $this->assignSmartyVar("logoEmpresa",  self::setImagen("sbslogo.jpg"));
        $this->assignSmartyVar("lblEvento","Evento");
        $this->assignSmartyVar("lblEspacioTrabajo",$response['espacioTrabajo']);
        $this->assignSmartyVar("fecha",  strftime("%d/%m/%Y").' '.date('H:m:i'));
        $this->assignSmartyVar("lblPagina","Página");
        $this->assignSmartyVar("maxDivision",  "50");
        $this->displaySmartyTemplate("ReporteEvento.tpl");
        
    }
    
    public static function setImagen($img)
    {
        return Configuraciones::PATH_IMG_PDF . $img;
    }
    
}
