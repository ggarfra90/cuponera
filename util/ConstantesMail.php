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
class ConstantesMail {

    const PARAM_SUBJECT = 'Solicitud de cupón de ';
    const PARAM_BODY_C_C = 'Se ha registrado la solicitud para utilizar el cupón de ';
    const PARAM_BODY_H_JD = 'Esperando la aprobación del Jefe Directo';
    const PARAM_BODY_H_RH = 'Esperando el visto bueno de Recursos Humanos';
    const PARAM_VISTO_B = 'utilizar un cupÓn. Se require el VISTO BUENO';
    const PARAM_VISTO_U = 'utilizar un cupÓn.';
    const PARAM_APRO_PEN = "Aprobación pendiente de cupon de ";
    const PARAM_E_SUBJECT='Solicitud de cupon especial de ';
    Const PARAM_E_BODY='Se ha registrado la solicitud para utilizar el cupón especial de ';
    const PARMA_E_BODY_2='dia(s) de acuerdo al siguiente detalle:';
    const PARAM_APRO_GD='Esperando aprobación del gerente directo.';
    const PARA_OPE='utilizan un cupon especial';
    // A:ANULAR //CUPON
    const PARAM_ANULACION="Anulaciòn de cupon de ";
    const  PARAM_SUBJECT_CA="Se ha anulado la solicitud del ";
    const PARAM_SUBJRCT_CA2='para utilizar el cupón de';
    const PARAM_TURNO_M='mañana (8:00am a 12:30pm)';
    const PARAM_TURNO_T='tarde (12:30pm a 6:00pm)';
    //A:ANULAR // CUPON ESPECIAL
    const PARAM_SUBJECT_A='Anulacion de solicitud de Cupon Especial de';
    const PARAM_BODY_A='Se ha ANULADO la solicitud fechada el ';
    const PARAM_BODY_A_2='Motivo de anulación: ';
    const PARAM_ANUL='Anulado por: ';
    //APROBACION DE CUPONES
    const PARAM_BODY_CUPON_H='Cupón de ';
    const PARAM_BODY_CUPON='Se ha';
    const PARAM_BODY_CUPON_B='la solicitud del';
    const PARAM_BODY_CUPON_C='para utilizar el cupón de ';
    const PARAM_BODY_CUPON_D='para el día ';
    const PARAM_BODY_CUPON_E='para los dias ';
    const PARAM_BODY_CUPON_FD='(Fecha de ';
    const PARAM_BODY_CUPON_FI=' (Fecha de inicio de curso ';
    const PARAM_BODY_CUPON_FF=', fecha de fin de curso ';
    const PARAM_BODY_CUPON_FC=')';
    const PARAM_MOTIVO_R='Motivo de rechazo: ';

    //visto bueno 
    const PARAM_SUBJECT_VB_S="con visto bueno de RRHH";
    const PARAM_SUBJECT_VB_N="rechazado por RRHH";
    const PARAM_BODY_1="dado visto bueno a";
    const PARAM_BODY_0="rechazado por RRHH";
    
        
    
}
