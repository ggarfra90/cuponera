<?php
require_once __DIR__.'/InterfaceGrid.php';

/**
 * Description of InterfaceGridDescargar
 *
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */
class InterfaceGridDescargar extends InterfaceGrid{
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Definición del método para implementar la obtención de la data a exportar
     * @param array $params => Parametros opcionales que se le quiera pasar para la carga de la grilla
     */
    public function getDataDescargar($params = null);
}

?>
