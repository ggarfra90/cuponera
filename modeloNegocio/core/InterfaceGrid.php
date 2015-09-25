<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InterfaceGrid
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */
interface  InterfaceGrid {
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Definición de la funcion abstracta que sera implementada para llenar mi grid
     * @param int $pageNumber => Numero de pagina del grid
     * @param int $pageSize => Cantidad de registros mostrados por pagina del grid
     * @param array $params => Parametros adicionales que se le quiera pasar para la carga de la grilla
     */
    public function getDataGrid($pageNumber, $pageSize, $params = null);
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Retorna los codigos de las acciones de la Botonera dela grilla (Permisos).
     * @param array $params => Parametros opcionales que se le quiera pasar para la carga de la grilla
     */
    public function getAccionesGrid($espacioTrabajoId,$moduloId,$componenteId,$controlId,$usuarioId,$params = null);
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Definición del método para implementar la obtención de la data a exportar
     * @param array $params => Parametros opcionales que se le quiera pasar para la carga de la grilla
     */
    public function getDataDescargar($params = null);
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Definición de método para implementar la eliminación basado en un array de identificadores de la clase
     * @param array $ids => Array de identificadores a eliminar
     */
    public function delete($ids, $params = NULL);
    
}

?>
