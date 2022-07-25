<?php

namespace App\Models\BaseModels;

/**
 * Clase controller general, contiene métodos relacionados a la gestión de usuarios
 * 
 * @property Status $status Estado del modelo
 */
class Model
{
    // * Propiedades

    private $status;

    // * Inicializador

    /**
     * Inicializa las propiedades base del modelo
     * - $status Estado del modelo
     */
    public function __construct()
    {
        $this->setStatus(new Status());
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

    // * Métodos

    /**
     * Asigna el valor de $status con un código de status y un mensaje (opcional)
     * 
     * @param int $status
     * @param string $message
     */
    public function setStatusWithMessage($status, $message)
    {
        $this->status->setStatusWithMessage($status, $message);
    }
}
