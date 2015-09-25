<?php

require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/EspecialesNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ReporteEspecialNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/AprobacionCuponesEspecialesNegocio.php';


class CuponEspecialControlador extends ControladorBase {
    public function getDataGridEspeciales() {
        return EspecialesNegocio::create()->getDataEspeciales();
    }
    public function functionDeleteEspeciales() {
        $cep_id=  $this->getParametro("cep_id");
        return EspecialesNegocio::create()->functionDeleteEspeciales($cep_id);
    }
        public function functionInsertEspeciales(){
        $ce_fec_ini=$this->getParametro("cep_fec_ini");
        $ce_fec_fin= $this->getParametro("cep_fec_fin");
        $ce_nombre=$this->getParametro("cep_nombre");
        $ce_descri=$this->getParametro("cep_descripcion");
        $ce_saludo=$this->getParametro("cep_saludo");
        $ce_activo=$this->getParametro("cep_activo");
        $ce_aprobador=  $this->getParametro("cep_aprobador");
        $cup_doc=  $this->getParametro("cep_doc");
        $doc_s=  $this->getParametro("cep_doc_s");
        $doc_t=  $this->getParametro("cep_doc_t");
        $file=  $this->getParametro("cep_file");
        return EspecialesNegocio::create()->functionInsertEspeciales($ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_aprobador,$cup_doc,$doc_s,$doc_t,$file);
    }
     public function functionEditEspeciales(){
        $cep_id=$this->getParametro("cep_id");
        $ce_fec_ini=$this->getParametro("cep_fec_ini");
        $ce_fec_fin= $this->getParametro("cep_fec_fin");
        $ce_nombre=$this->getParametro("cep_nombre");
        $ce_descri=$this->getParametro("cep_descripcion");
        $ce_saludo=$this->getParametro("cep_saludo");
        $ce_activo=$this->getParametro("cep_activo");
        $ce_aprobador=  $this->getParametro("cep_aprobador");
        $cup_doc=  $this->getParametro("cep_doc");
        $doc_s=  $this->getParametro("cep_doc_s");
        $doc_t=  $this->getParametro("cep_doc_t");
        $file=  $this->getParametro("cep_file");
        $imgant=  $this->getParametro("cep_imgant");
        $cep_op_img=$this->getParametro("cep_op_img");
        return EspecialesNegocio::create()->functionEditEspeciales($cep_id,$ce_fec_ini,$ce_fec_fin,$ce_nombre,$ce_descri,$ce_saludo,$ce_activo,$ce_aprobador,$cup_doc,$doc_s,$doc_t,$file,$imgant,$cep_op_img);
    }
    public function getEditarData() {
        $cep_id=  $this->getParametro("cep_id");
        return EspecialesNegocio::create()->getDataEditar($cep_id);
    }
    public function DiasOcupados() {
        $ce_id=  $this->getParametro("ce_id");
        return EspecialesNegocio::create()->DiasDisponibles($ce_id);
    }
    public function DatosCuponEspecial() {
        $ce_id=  $this->getParametro("ce_id");
        return EspecialesNegocio::create()->DatosCuponEspecial($ce_id);
    }
    //revvisar envio cruce de fechas
    public function InsertSolicitud(){
        $cep_id=  $this->getParametro("cep_id");
        $fecha=  $this->getParametro("fecha");
        $dias=  $this->getParametro("dias");
        return EspecialesNegocio::create()->functionInsertSolicitud($cep_id,$dias,$fecha);
    }
    public function getComboEspecial() {
        return ReporteEspecialNegocio::create()->listarCuponEspecial();
    }
   public function getAprobacionCuponesEspeciales(){
        return AprobacionCuponesEspecialesNegocio::create()->ObtenerAprobacionesCuponesEspeciales();
    }
    public function functionAprobarAnularEspecial() {
        $id=  $this->getParametro("cep_id");
        $op=  $this->getParametro("opcion");
        $mot=  $this->getParametro("motivo");
        
        return AprobacionCuponesEspecialesNegocio::create()->functionAprobacionAnularEspeciales($id, $op, $mot) ;
    }
}
