<?php

namespace App\Models\Routes;

use App\Models\BaseModels\Model;

/** 
 * Contiene la estructura de un camino final de un controlador,
 * manteniendo la información hacia el controlador y método a utilizar
 * 
 * @property callable $controllerCallable Función a ejecutar del controlador
 * @property callable $controllerResultCallable Función para obtener el resultado del controlador
 */
class RouteEnd extends Model
{
    // * Propiedades

    private $controllerCallable;
    private $controllerResultCallable;

    // * Constructor

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     * 
     * @param callable $controllerCallable
     * @param callable $controllerResultCallable
     */
    function __construct($controllerCallable = '', $controllerResultCallable = '')
    {
        parent::__construct();
        $this->setControllerCallable($controllerCallable);
        $this->setControllerResultCallable($controllerResultCallable);
    }

    // * Getters

    /** 
     * Obtiene el valor de $controllerCallable
     * 
     * @return callable
     */
    public function getControllerCallable()
    {
        return $this->controllerCallable;
    }

    /** 
     * Obtiene el valor de $controllerCallable
     * 
     * @return callable
     */
    public function getControllerResultCallable()
    {
        return $this->controllerResultCallable;
    }

    // * Setters

    /**
     * Asigna el valor de $controllerCallable
     *
     * @param callable $controllerCallable
     */
    private function setControllerCallable($controllerCallable)
    {
        $this->controllerCallable = $controllerCallable;
    }

    /**
     * Asigna el valor de $controllerResultCallable
     *
     * @param callable $controllerResultCallable
     */
    private function setControllerResultCallable($controllerResultCallable)
    {
        $this->controllerResultCallable = $controllerResultCallable;
    }
}
