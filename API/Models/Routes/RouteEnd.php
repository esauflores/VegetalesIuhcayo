<?php

namespace App\Models\Routes;

use App\Models\BaseModels\Model;

/** 
 * Contiene la estructura de un camino final de un controlador,
 * manteniendo la información hacia el controlador y método a utilizar
 * 
 * @property callable $methodCallable Método a ejecutar del controlador
 * @property callable $resultCallable Método para obtener el resultado del controlador
 * @property callable $statusCallable Método para obtener el status del controlador

 */
class RouteEnd extends Model
{
    // * Propiedades

    private $methodCallable;
    private $resultCallable;
    private $statusCallable;

    // * Constructor

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     * 
     * @param callable $methodCallable
     * @param callable $resultCallable
     * @param callable $statusCallable
     */
    function __construct(
        $methodCallable = '',
        $resultCallable = '',
        $statusCallable = ''
    ) {
        parent::__construct();
        $this->setMethodCallable($methodCallable);
        $this->setResultCallable($resultCallable);
        $this->setStatusCallable($statusCallable);
    }

    // * Getters

    /** 
     * Obtiene el valor de $methodCallable
     * 
     * @return callable
     */
    public function getMethodCallable()
    {
        return $this->methodCallable;
    }

    /** 
     * Obtiene el valor de $methodCallable
     * 
     * @return callable
     */
    public function getResultCallable()
    {
        return $this->resultCallable;
    }

    /** 
     * Obtiene el valor de $statusCallable
     * 
     * @return callable
     */
    public function getStatusCallable()
    {
        return $this->statusCallable;
    }

    // * Setters

    /**
     * Asigna el valor de $methodCallable
     *
     * @param callable $methodCallable
     */
    private function setMethodCallable($methodCallable)
    {
        $this->methodCallable = $methodCallable;
    }

    /**
     * Asigna el valor de $resultCallable
     *
     * @param callable $resultCallable
     */
    private function setResultCallable($resultCallable)
    {
        $this->resultCallable = $resultCallable;
    }
    /**
     * Asigna el valor de $statusCallable
     *
     * @param callable $statusCallable
     */
    private function setStatusCallable($statusCallable)
    {
        $this->statusCallable = $statusCallable;
    }
}
