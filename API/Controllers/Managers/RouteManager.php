<?php

namespace App\Controllers\Managers;

use Error;
use App\Models\BaseModels\Controller;
use App\Models\Routes\RouteEnd;

/** 
 * Controldor manager de rutas, permite encontrar el controlador relacionado a una url
 * 
 * @property RouteEnd $routeEnd Contiene la información del controlador a usar
 */
class RouteManager extends Controller
{
    // * Propiedades 

    private static $routeEnd;

    // * Inicializador

    /** 
     * Inicializa las variables necesarias para ejecutar consultas
     */
    public static function init()
    {
        parent::init();
        self::setRouteEnd(NULL);
    }


    // * Getters 

    /**
     * Obtiene el valor de $routeEnd
     * 
     * @return null|RouteEnd 
     */
    private static function getRouteEnd()
    {
        return self::$routeEnd;
    }

    // * Setters

    /**
     * Asigna el valor de $routeEnd
     * 
     * @param null|RouteEnd $routeEnd
     */
    private static function setRouteEnd($routeEnd)
    {
        self::$routeEnd = $routeEnd;
    }

    // * Métodos

    /**
     * Asigna el final de la ruta dado un $url en base al RouteNode raíz RouteRoot
     * 
     * @param string $url Url a seguir en la ruta inicial
     * @param RouteNode $route Ruta inicial
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    private static function setRouteWithUrl($url)
    {
        // Obtiene el camino de rutas a a seguir
        $path = explode('/', $url);

        // Obtiene el nodo raíz de la consulta
        $route = require(dirname(__DIR__, 2) . '/Routes/RouteRoot.php');

        // Busca el controlador a través de los caminos
        foreach ($path as $partialPath) {
            // Si no puede seguir con la ruta, ya sea por error de validación ó ruta inexistente 
            if (!($route = $route->getChildPath($partialPath))) {
                self::$status->setStatusWithMessage(
                    404,
                    "Acción desconocida: No se pudo encontrar el controlador'"
                );
                return false;
            }
        }

        // Si no obtiene el final de la ruta
        if (!($routeEnd = $route->getRouteEnd())) {
            self::$status->setStatusWithMessage(
                404,
                "Acción desconocida: No se pudo encontrar el controlador'"
            );
            return false;
        }

        // Asigna y retorna
        self::setRouteEnd($routeEnd);
        return true;
    }

    /**
     * Ejecuta un método en un controlador dado por el final de la ruta obtenido
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function executeMethodWithUrl($url)
    {
        if (!self::setRouteWithUrl($url)) return false;
        try {
            call_user_func(self::$routeEnd->getControllerCallable());
        } catch (Error $error) {
            self::$status->setStatusWithMessage(
                500,
                "Error: No se pudo ejecutar el método en el controlador"
            );
            return false;
        }
        return true;
    }

    /**
     * Obtiene el resultado obtenido por el controlador dado por el final de la ruta obtenido
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function getResultFromController()
    {
        try {
            self::setResult(call_user_func(self::$routeEnd->getControllerResultCallable()));
        } catch (Error $error) {
            self::$status->setStatusWithMessage(
                500,
                "Error: No se pudo obtener el resultado del controlador"
            );
            return false;
        }
        return true;
    }
}
