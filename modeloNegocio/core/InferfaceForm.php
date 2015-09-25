<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InferfaceForm
 * Define los metodos para el mantenimiento de un formulario 
 * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
 */
interface InferfaceForm {
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Función que se encarga de la validación de:
     *  - La estructura del $params
     *  - Redireccionar a un método específico (insert | update)
     *  - Formatear el array $params para que los valores Empty los transforme en NULL
     * @param array $params : Array con la data a insertar o actualizar
     * @param string $nameParamId : Nombre del identificador dentro 
     * del array $params que indica el id a actualizar
     * * Se implementará en el ModeloNegocioBase
     */
    public function save($params, $nameParamId = NULL);
    public function insert($params);
    public function update($id, $params);
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Definición del método para implementar la obtención del registro segun el id especificado
     * @param int $id Identificador
     * @param array $params Estándar para los parámetros opcionales
     */
    public function getRecordById($id, $params = NULL);
    
    /**
     * @author Christopher Heredia Lozada <cheredia@imaginatecperu.com>
     * Definición del método para implementar la obtención del último registro ingresado
     * @param array $params Estándar para los parámetros opcionales
     */
    public function getLastRecord($params = NULL);
    
}

?>
