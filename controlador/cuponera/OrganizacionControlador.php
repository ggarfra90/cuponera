<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/OrganizacionNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class OrganizacionControlador extends ControladorBase {

    public function functionListarOrganizacion() {
        $org_id_b=  $this->getParametro("org_id_b");
        return OrganizacionNegocio::create()->getListarOrganizacion($org_id_b);
    }
    public function getOrganizacionMatricial() {
        //$org_matricila=  $this->getParametro("flag_org");
        return OrganizacionNegocio::create()->functionOrganizacionMatricial();
    }
    
}
