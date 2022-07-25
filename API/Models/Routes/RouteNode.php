<?php

namespace App\Models\Routes;

use App\Helpers\Validator;
use App\Models\BaseModels\Model;

/** 
 * Contiene la estructura un nodo de un camino/ruta de la API
 * 
 * @property null|RouteEnd $routeEnd Fin de la ruta
 * @property array $routePath Arreglo de caminos 
 */
class RouteNode extends Model
{
    // * Propiedades

    private $routeEnd;
    private $routePath;

    // * Constructor 

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     *
     * @param array $routePath
     * @param null|RouteEnd $routeEnd 
     */
    function __construct($routePath = [], $routeEnd = NULL)
    {
        parent::__construct();
        $this->setRouteEnd($routeEnd);
        $this->setRoutePath($routePath);
    }

    // * Getters

    /**
     * Obtiene el valor de $status
     * 
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Obtiene el valor de $routeEnd
     * 
     * @return null|RouteEnd
     */
    public function getRouteEnd()
    {
        return $this->routeEnd;
    }

    /**
     * Obtiene el valor de $routePath
     * 
     * @return array 
     */
    public function getRoutePath()
    {
        return $this->routePath;
    }

    /**
     * Obtiene el valor de un hijo de una ruta
     * 
     * @return null|RouteNode
     */
    public function getChildPath($pathName)
    {
        // $pathName inválido ó camino inexistente

        if (!Validator::validRoute($pathName) || !array_key_exists($pathName, $this->routePath)) {
            $this->status->setStatusWithMessage(404, 'Ruta no existente');
            return NULL;
        }

        // Camino válido
        return $this->routePath[$pathName];
    }

    // * Setters

    /**
     * Asigna el valor de $status
     * 
     * @param Status $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Asigna y obtiene el valor de $routeEnd
     * 
     * @param null|RouteEnd $routeEnd
     */
    public function setRouteEnd($routeEnd)
    {
        // Dato invalido, mensaje de error
        if ($routeEnd != NULL && @get_class($routeEnd) != RouteEnd::class) {
            $this->status->setStatusWithMessage(500, 'Fin de ruta inválido');
            return NULL;
        }

        // Dato válido, asignamos y retornamos
        return $this->routeEnd = $routeEnd;
    }

    /**
     * Asigna y obtiene el valor de $routePath
     * 
     * @param array $routePath
     */
    public function setRoutePath($routePath)
    {
        // Dato inválido, mensaje de error
        foreach ($routePath as $routeChild) {
            //Validamos que los caminos hijo sean de clase RouteNode
            if (@get_class($routeChild) != RouteNode::class) {
                $this->status->setStatusWithMessage(500, 'Camino de ruta inválido');
                return NULL;
            }
        }

        // Dato válido, asignamos y retornamos
        return $this->routePath = $routePath;
    }

    /**
     * Asigna y obtiene un valor hijo a $routePath
     * 
     * @param string $pathName
     * @param RouteNode $pathNode
     */
    public function setChildPath($pathName, &$pathNode)
    {
        // Dato inválido, mensaje de error
        if (!Validator::validRoute($pathName)) {
            $this->status->setStatusWithMessage(500, 'Nombre de ruta hijo inválido');
            return NULL;
        }

        // Dato válido, asignamos y retornamos
        return $this->routePath[$pathName] = $pathNode;
    }
}
