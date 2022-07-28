<?php

namespace App\Models\BaseModels;

/**
 * Clase controller general, contiene métodos relacionados a la gestión de usuarios
 * 
 * @property Status $status Estado del controlador
 * @property array $result Resultado de los métodos del controlador
 */
class Controller
{
    // * Propiedades

    protected static $status;
    protected static $result;


    // * Inicializador

    /**
     * Inicializa las propiedades base del controlador
     * - $status Estado del controlador
     * - $result Arreglo resultado, contiene la información obtenida
     */
    public static function init()
    {
        self::setStatus(new Status());
        self::setResult([]);
    }


    // * Getters 

    /**
     * Obtiene el valor de $status
     * 
     * @return Status
     */
    public static function getStatus()
    {
        return self::$status;
    }

    /**
     * Obtiene el valor de $result
     * 
     * @return array
     */
    public static function getResult()
    {
        return self::$result;
    }

    // * Setters

    /**
     * Asigna el valor de $status
     * 
     * @param Status $status
     */
    public static function setStatus($status)
    {
        self::$status = $status;
    }

    /**
     * Asigna el valor de $result
     * 
     * @param array $result
     */
    public static function setResult($result)
    {
        self::$result = $result;
    }

    // * Métodos

    /**
     * Asigna el valor de $status
     * 
     * @param int $status
     * @param string $message
     */
    public static function setStatusWithMessage($status, $message)
    {
        if (!isset(self::$status)) self::setStatus(new Status());
        self::$status->setStatusWithMessage($status, $message);
    }
}
