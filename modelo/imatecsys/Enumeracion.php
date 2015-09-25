<?php
require_once __DIR__."/../core/ModeloBase.php";
require_once __DIR__."/../enumeraciones/EstadoGenerico.php";

/**
 * Description of Enumeracion
 *
 * @author developer
 */
class Enumeracion extends ModeloBase {

    const DEFAULT_ALIAS_NOMBRE = 'nombre';
    const DEFAULT_ALIAS_DESCRIPCION = 'descripcion';
    
    function __construct() {
        parent::__construct();
        $this->schema_name = Schema::sys;
        $this->table_name = 'enumeracion';
        $this->fields = array('id','nombre_id','descripcion_id','codigo','valor',
                                'clasificacion','atributo','estado','fecha_creacion','fecha_eliminacion'); 
    }
    
    /**
     * Crea la instancia de Enumeracion
     * 
     * @return Enumeracion
     */
    static function create()
    {
        return parent::create();
    }
    
    /**
     * @return Enumeracion
     */
    public function filterByClasificacion($value, $comparison = ComparacionSQL::igual){
        if(is_array($value))
            $value = implode (',', $value);
        return $this->whereAdd(array(ElementoSQL::first_col => 'clasificacion', ElementoSQL::val => $value, ElementoSQL::comparacion => $comparison));
    }
    
    /**
     * Realiza el filtro por código en la enumeración
     * 
     * @param string $codigo codigo por el que filtrar
     * @param string $comparison comparación a realizar
     * @return Enumeracion
     * 
     * 
     */
    public function filterByCodigo ($codigo, $comparison = ComparacionSQL::igual)
    {
        return $this->whereAdd(array(ElementoSQL::first_col => 'codigo', ElementoSQL::val => $codigo, ElementoSQL::comparacion => $comparison));
    }
    
    /**
     * Agrega el Join a la tabla idiomacontenido representando el nombre de la enumeracion enlazada a la tabla enumeraciones
     * 
     * @param string $aliasThis es el alias que recibe la enumeraciones en la consulta
     * @param string $aliasForaneo es el alias que recibe la tabla idiomacontenido en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * @return Enumeracion
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useNombre($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = self::DEFAULT_ALIAS_NOMBRE, $joinType = Join::inner)
    {
        return $this->useTable('nombre_id', 'idiomacontenido', 'id', Schema::sys, $aliasForaneo, $aliasThis, $joinType);
    }
    
    /**
     * Agrega el Join a la tabla idiomacontenido representando la descripcion de la enumeracion enlazada a la tabla enumeraciones
     * 
     * @param string $aliasThis es el alias que recibe la enumeraciones en la consulta
     * @param string $aliasForaneo es el alias que recibe la tabla idiomacontenido en la consulta
     * @param Join $typeJoin es el tipo de join que tendría
     * @return Enumeracion
     * 
     * @author cheredia <cheredia@imaginatecperu.com>
     */
    public function useDescripcion($aliasThis = self::DEFAULT_ALIAS_TABLE, $aliasForaneo = self::DEFAULT_ALIAS_DESCRIPCION, $joinType = Join::inner)
    {
        return $this->useTable('descripcion_id', 'idiomacontenido', 'id', Schema::sys, $aliasForaneo, $aliasThis, $joinType);
    }
    
    /**
     * Obtiene los valores de enumeración de una clasificación. Extrae también su nombre y descripción en un idioma enviado
     * @param string $clasificacion La clasificación a obtener
     * @param string $idioma El idioma del nombre y la descripción. Por defecto es es_pe
     * @param string $codigo Si se desea obtener de un código específico de la enumeración
     * @param string|array $orderby columna o conjunto de columnas por las que ordenar. El orden del arreglo es el orden del ordenamiento.
     * @return array
     * 
     * 
     */
    public function getEnumsByClasificacion ($clasificacion, $idioma = 'es_pe', $codigo = null, $orderby = null, $fields)
    {
        if (ObjectUtil::isEmpty($clasificacion)) return null;
        if (ObjectUtil::isEmpty($idioma)) return null;
        
        $this->useNombre(self::DEFAULT_ALIAS_TABLE, self::DEFAULT_ALIAS_NOMBRE, Join::left)
             ->useDescripcion(self::DEFAULT_ALIAS_TABLE, self::DEFAULT_ALIAS_DESCRIPCION, Join::left)
             ->filterByClasificacion($clasificacion)
             ->whereEstado(EstadoGenerico::disponible);
        
        if (!ObjectUtil::isEmpty($codigo))
        {
            if(is_array($codigo))
                $this->filterByCodigo(implode (',', $codigo),  ComparacionSQL::in);
            else
                $this->filterByCodigo($codigo);
        }
        
        if (ObjectUtil::isEmpty($orderby))
        {
            $this->orderAdd(array(ElementoSQL::first_col => self::DEFAULT_ALIAS_NOMBRE, ElementoSQL::first_alias => self::DEFAULT_ALIAS_NOTHING));
        }
        else if (is_array($orderby))
        {   
            foreach ($orderby as $value)
            {
                if (is_array($value))
                {
                    $orderArray = array ();
                    
                    foreach ($value as $element => $val)
                    {
                        $orderArray[$element] = $val;
                    }
                    
                    if (!ObjectUtil::isEmpty($orderArray))
                    {
                        $this->orderAdd($orderArray);
                    }
                }
                else if (is_string($value))
                {
                     $this->orderAdd(array(ElementoSQL::first_col => $value));
                }
            }
        }
        else if (is_string($orderby))
        {
            $this->orderAdd(array(ElementoSQL::first_col => $orderby));
        }
        $this->fields = $fields;
        return $this->getSelectPersonalized("DISTINCT ".$this->getFieldsToSelect(self::DEFAULT_ALIAS_TABLE).", ".
                                            "(CASE ".self::DEFAULT_ALIAS_NOMBRE.".id IS NULL WHEN TRUE THEN '' ".
                                             "ELSE ".self::DEFAULT_ALIAS_NOMBRE.".".$idioma." END) as ".self::DEFAULT_ALIAS_NOMBRE.", ".
                                            "(CASE ".self::DEFAULT_ALIAS_DESCRIPCION.".id IS NULL WHEN TRUE THEN '' ".
                                             "ELSE ".self::DEFAULT_ALIAS_DESCRIPCION.".".$idioma." END) as ".self::DEFAULT_ALIAS_DESCRIPCION);
    }
    
    public function filterByValor ($valor, $comparison = ComparacionSQL::in)
    {
        return $this->whereAdd(array(ElementoSQL::first_col => 'valor', ElementoSQL::val => $valor, ElementoSQL::comparacion => $comparison));
    }
    
    public function disponible($alias = null)
    {
        return parent::disponible($alias);
    }
}

?>

