<?php

/*
 * @author Geancarlo Leiva <gleiva@imaginatecperu.com>
 * @version 1.0
 * @copyright (c) 2015, IMAGINA TECHNOLOGIES S.A.C.
 * @abstract Clase donde se implementará el Componente
 */

/**
 * Description of ConstantesNegocio
 *
 * @author GC
 */
class ConstantesNegocio {
    const PARAM_ACTIVO = '1';
    const PARAM_NO_ACTIVO = '0';
    const PARAM_VISIBLE = '1';
    const PARAM_NO_VISIBLE = '0';
    const PARAM_NULL = '-1';
    
    /*Tipo de parametro*/
    const PARAM_COD_TIPO_SOLICITUD = 'COD_TIPO_SOLICITUD';
    const PARAM_COD_TIPO_DESTINATARIO = 'COD_TIPO_DESTINATARIO';
    
    /*Tipo de semaforos*/
    const PARAM_SEM_VERDE = 'SEM_VERDE';
    const PARAM_SEM_AMARILLO = 'SEM_AMARILLO';
    const PARAM_SEM_ROJO = 'SEM_ROJO';
    
    /*Alertas*/
    const PARAM_OPE_IGUAL = '=';
    const PARAM_CERO = '0';
    const PARAM_EMAIL_PARA = 'DES_PARA';
    
    /*Bandejas*/
    const BANDE_REGISTRADOR = 'Registrador';
    const BANDE_REGISTRADOR_AF = 'Registrador AF';
    const BANDE_APROBADOR = 'Aprobador';
    const BANDE_CONTABILIDAD = 'Contabilidad';
    const BANDE_LOGISTICA = 'Logistica';
    
    /*Tablas del sistema*/
    const TAB_PERIODO = "periodo";
    
    /*ROLES DEL SISTEMA*/
    const ROL_RRHH='RRHH';
    const ROL_SOCI='SOCI';
    const ROL_COMP='COMP';
    const ROL_JI='JEFEINMENDIATO';
    const ROL_GI='GERENTEINMEDIATO';  
}
