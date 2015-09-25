<?php

require_once __DIR__ . '/AlmacenIndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/UsuarioNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/ColaboradorNegocio.php';
require_once __DIR__ . '/../../modeloNegocio/cuponera/PerfilNegocio.php';

class UsuarioControlador extends AlmacenIndexControlador {

    public function validateLogin($usuario,$contrasenia) {
        return UsuarioNegocio::create()->validateLogin($usuario,$contrasenia);
    }
    public function validateLoginWP($usuario_wp,$pass_wp) {
        return UsuarioNegocio::create()->validateLoginWP($usuario_wp,$pass_wp);
    }

    public function getDataGridUsuario() {
        $org_id=$this->getParametro("org_id");
        if($org_id=='' || $org_id=NaN || $org_id==NULL){
            $org_id='0';
        }
        return UsuarioNegocio::create()->getDataUsuario($org_id);
    }
    public function getDataUsuarioCombo() {
        $op=$this->getParametro("op");
        $org_id=$this->getParametro("id_org");
        $g_ad=$this->getParametro("g_ad");
        $j_ad=$this->getParametro("j_ad");
         $matri=$this->getParametro("matri_ad");         
        return UsuarioNegocio::create()->getDataCombo($op,$org_id,$g_ad,$j_ad);
    }
     public function getDataMatriCombo() {
        $op=$this->getParametro("op");
        $org_id=$this->getParametro("id_org");
        $matri=$this->getParametro("matri_ad");       
         $g_ad=$this->getParametro("g_ad");
        $j_ad=$this->getParametro("j_ad");
               
        return UsuarioNegocio::create()->getDataCombo($op,$org_id,$g_ad,$j_ad,$matri);
    }
    
    public function getComboColaborador()
    {
        $id_colaborador = $this->getParametro("id_usuario");
        return ColaboradorNegocio::create()->getDataColaborador($id_colaborador);
    }
    
   
    
    public function insertUsuario()
    {
        //matricial em base de datos y en codigo
        $usu_nombre=$this->getParametro("nombre");
        $usu_ad=$this->getParametro("usu_ad");
        $usu_nivel=$this->getParametro("nivel");
        $usu_estado=$this->getParametro("estado");
        $usu_jefe=$this->getParametro("jefe");
        $usu_gerente=$this->getParametro("gerente");
        $usu_jefe_matricial=  $this->getParametro("jefe_matricial");
        $usu_clase=$this->getParametro("clase");
        $usu_rol=$this->getParametro("rol");
        $usu_clave=$this->getParametro("clave");
        $usu_correo=$this->getParametro("correo");
        $suc_id=$this->getParametro("suc_id");
        $usu_fec_cump=$this->getParametro("fec_cump");
        $usu_cargo=$this->getParametro("cargo");
        $usu_matricial=$this->getParametro("matricial");
        return UsuarioNegocio::create()->insertarUsuario($usu_nombre,$usu_ad,$usu_nivel,$usu_estado,$usu_jefe,$usu_gerente,$usu_jefe_matricial,
                $usu_clase,$usu_rol,$usu_clave,$usu_correo,$suc_id,$usu_fec_cump,$usu_cargo,$usu_matricial);
    }
    
    public function getUsuario() {
        $id_usuario = $this->getParametro("usu_id");
        return UsuarioNegocio::create()->getObtenerUsuario($id_usuario);
    }
    
    public function editUsuario()
    {
        //matricial em base de datos y en codigo
        $usu_id=$this->getParametro("usu_id");
        $usu_nombre=$this->getParametro("nombre");
        $usu_ad_a=$this->getParametro("usu_ad_a");
        $usu_ad=$this->getParametro("usu_ad");
        $usu_nivel=$this->getParametro("nivel");
        $usu_estado=$this->getParametro("estado");
        $usu_jefe=$this->getParametro("jefe");
        $usu_gerente=$this->getParametro("gerente");
        $usu_jefe_matricial=  $this->getParametro("jefe_matricial");
        $usu_clase=$this->getParametro("clase");
        $usu_rol=$this->getParametro("rol");
        $usu_clave=$this->getParametro("clave");
        $usu_correo=$this->getParametro("correo");
        $suc_id=$this->getParametro("suc_id");
        $usu_fec_cump=$this->getParametro("fec_cump");
        $usu_cargo=$this->getParametro("cargo");
        $usu_matricial=$this->getParametro("matricial");
        return UsuarioNegocio::create()->editarUsuario($usu_id,$usu_nombre,$usu_ad,$usu_ad_a,$usu_nivel,$usu_estado,$usu_jefe,$usu_gerente,$usu_jefe_matricial,
                $usu_clase,$usu_rol,$usu_clave,$usu_correo,$suc_id,$usu_fec_cump,$usu_cargo,$usu_matricial);
    }
    
    public function deleteUsuario() {
        $id_usuario = $this->getParametro("id_usuario");
        $usu_nombre = $this->getParametro("usu_nombre");
        $usu_ad = $this->getParametro("usu_ad");
        return UsuarioNegocio::create()->deleteUsuario($id_usuario,$usu_nombre,$usu_ad);
    }
}
