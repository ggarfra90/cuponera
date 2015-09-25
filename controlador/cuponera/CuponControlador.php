<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

//require_once __DIR__ . '/AlmacenIndexControlador.php';

require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesValiNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesIDUNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesMNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesGNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesANegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesPNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/CuponesPTNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ReporteCuponNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ReporteEspecialNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ReporteDiasOcupadosNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ReporteEstadoTramiteNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/AprobacionCuponesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/AprobacionVistoBuenoNegocio.php';
require_once __DIR__ . '/../../util/Configuraciones.php';
require_once __DIR__ . '/../core/ControladorBase.php';

class CuponControlador extends ControladorBase {

    public function getCupon(){
       
        return CuponesNegocio::create()->getIniciaCupon();
        
    }
    public function getComboEspecial() {
        return CuponesNegocio::create()->getComboEspecialCupon();
    }
    public function getComboPuente() {
        return CuponesNegocio::create()->getComboPuente();
    }
    public function getCuponTipo(){
        return CuponesValiNegocio::create()->getTipoCuponDatos();
    }
      public function insertCupones() {
        $cup_fec_perm = $this->getParametro("fecha2");
        $cup_fec_perm2= "";
        $cup_doc ="";
        $cup_fec_hito = $this->getParametro("fecha_cump");
        return CuponesIDUNegocio::create()->insertCupones($cup_fec_perm,$cup_fec_perm2,$cup_doc,$cup_fec_hito);
    }
     public function insertCuponesM() {
        $cup_fec_b = $this->getParametro("fecha_b");
        $cup_fec_perm = $this->getParametro("fecha4");
        $cup_fec_perm2= $this->getParametro("fecha6");
        $cup_doc = $this->getParametro("fname");
        $doc_s = $this->getParametro("fsize");
        $doc_t = $this->getParametro("ftype");
        $file = $this->getParametro("file");
        return CuponesMNegocio::create()->insertCuponesM($cup_fec_perm,$cup_fec_perm2,$cup_doc,$doc_s,$doc_t,$cup_fec_b,$file);
    }
    public function insertCuponesG() {
        $cup_fec_perm= $this->getParametro("fecha6");
        $cup_doc = $this->getParametro("fname");
        $doc_s = $this->getParametro("fsize");
        $doc_t = $this->getParametro("ftype");
        $cup_fec_hito = $this->getParametro("fecha2");
        $cup_fec_hito2 = $this->getParametro("fecha4");
        $file = $this->getParametro("file");
        return CuponesGNegocio::create()->insertCuponesG($cup_fec_perm,$cup_doc,$doc_s,$doc_t,$cup_fec_hito,$cup_fec_hito2,$file);
    }
    public function insertCuponesA() {
        $cup_fec_perm= $this->getParametro("fecha2");
        return CuponesANegocio::create()->insertCuponesA($cup_fec_perm);
    }
     public function insertCuponesP() {
        $cup_fec_perm= $this->getParametro("fecha2");
        return CuponesPNegocio::create()->insertCuponesP($cup_fec_perm);
    }
     public function insertCuponesPT() {
        $cup_fec_perm= $this->getParametro("fecha2");
        $cup_part_time= $this->getParametro("turno");
        return CuponesPTNegocio::create()->insertCuponesPT($cup_fec_perm,$cup_part_time);
    }
    public function getReporteCupon(){
        $fecha1=  $this->getParametro("fecha_ini");
        $fecha2=  $this->getParametro("fecha_fin");
        $est=  $this->getParametro("est");
        $org=  $this->getParametro("org_id");
        return ReporteCuponNegocio::create()->getReporteCupones($fecha1,$fecha2,$est,$org);
    }
    public function anularCupon(){
        $id=  $this->getParametro("id_cupon");
        $mot=  $this->getParametro("motivo");
        $op=  $this->getParametro("opcion");
        return ReporteCuponNegocio::create()->functionAnular($id,$op,$mot);
    }
    
    
    public function getReporteCuponEspecial(){
        $ce_id=  $this->getParametro("ce_id");
        $fecha1=  $this->getParametro("fecha_ini");
        $fecha2=  $this->getParametro("fecha_fin");
        $est=  $this->getParametro("est");
        $usu=  $this->getParametro("usu_id");
        return ReporteEspecialNegocio::create()->getReporteCuponesEspeciales($ce_id,$fecha1,$fecha2,$est,$usu);
    }
    public function anularCuponEspecial(){
        $id=  $this->getParametro("ce_id");
        $mot=  $this->getParametro("motivo");
        $op=  $this->getParametro("opcion");
        return ReporteEspecialNegocio::create()->functionAnularEspecial($id,$op,$mot);
    }
    public function ObtenerFechaPrimeraSolicitudCupEsp($id) {
        return CuponesNegocio::create()->getFechaPrimeraSolicitudCupEsp($id);
    }
     public function getReporteDiasOcupados(){
     
        return ReporteDiasOcupadosNegocio::create()->getReporteDiasOcupados();
    }
    
    public function getReporteEstadoTramiteListar(){
     
        return ReporteEstadoTramiteNegocio::create()->getReporteEstadoTramite();
    }
    public function getReporteCuponEspecialUso(){
             $id=  $this->getParametro("ce_id");
        return ReporteEspecialNegocio::create()->functionCuponesEspecialesUSo($id);
    }
    public function getAprobacionCupones(){
        return AprobacionCuponesNegocio::create()->ObtenerAprobacionesCupones();
    }
    public function functionAprobarAnular() {
        $id=  $this->getParametro("cup_id");
        $op=  $this->getParametro("opcion");
        $mot=  $this->getParametro("motivo");
        
        return AprobacionCuponesNegocio::create()->functionAprobacionAnular($id, $op, $mot) ;
    }
    public function getAprobacionVistoBueno(){
        return AprobacionVistoBuenoNegocio::create()->ObtenerAprobacionesVistoBueno();
    }
    public function functionAprobacionAnularVistoBueno(){
        
        $id=  $this->getParametro("cup_id");
        $op=  $this->getParametro("opcion");
        $mot=  $this->getParametro("motivo");
        
        return AprobacionVistoBuenoNegocio::create()->functionAprobacionAnularVistoBueno($id,$op,$mot);
    }
}
