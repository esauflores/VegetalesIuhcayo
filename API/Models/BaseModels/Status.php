<?php

namespace App\Models\BaseModels;

use App\Controllers\Managers\ApiManager;
use App\Helpers\Validator;

/**
 * Clase modelo de estados http y mensaje opcional
 * 
 * @property int $status Estado
 * - Ver más: https://developer.mozilla.org/es/docs/Web/HTTP/Status 
 * @property string $message Mensaje opcional relacionado al estado
 */
class Status
{
    // * Propiedades 
    private $status;
    private $message;

    // * Constructor

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     * 
     * @param int $routeEnd 
     * @param string $message
     */
    function __construct($status = 500, $message = 'Error desconocido')
    {
        $this->setStatus($status);
        $this->setMessage($message);
    }

    // * Getters 

    /** 
     * Obtiene el valor de $status
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /** 
     * Obtiene el valor de $status
     * 
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    // * Setters

    /** 
     * Asigna y obtiene el valor de $status
     *
     * @param int $status
     */
    public function setStatus($status)
    {
        if (($error = Validator::validStatus($status)) !== true) {
            ApiManager::exitError(500, $error);
        }
        $this->status = $status;
    }

    /**
     * Asigna y obtiene el valor de $error
     * 
     * @param string $message
     */
    public function setMessage($message)
    {
        if ($error = Validator::validStatusMessage($message) !== true) {
            echo ($error);
        }

        $this->message = $message;
    }

    // * Métodos generales

    /**
     * Asigna el valor de $status y el valor de $message (opcional)
     *       
     * @param int $status
     * @param string $message
     */
    public function setStatusWithMessage($status, $message = '')
    {
        // Asignamos el estado
        $this->setStatus($status);

        // Asignamos el mensaje en caso exista
        if ($message) {
            $this->setMessage($message);
            return;
        }

        // Asignamos un mensaje por defecto dependiendo del estado
        switch ($status) {
            case 200:
                $this->setMessage('OK');
                break;
            case 201:
                $this->setMessage('Creación exitosa');
                break;
            case 400:
                $this->setMessage('No se pudo procesar la consulta');
                break;
            case 401:
                $this->setMessage('Sin autorización para acceder a este método');
                break;
            case 403:
                $this->setMessage('No tiene los permisos para acceder a este método');
            case 404:
                $this->setMessage('Recurso no encontrado');
                break;
            case 500:
                $this->setMessage('El servidor se encontró con un error');
                break;
            default:
                $this->setMessage($message);
                break;
        }
    }
}
