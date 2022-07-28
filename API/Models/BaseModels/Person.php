<?php

namespace App\Models;

use App\Models\BaseModels\Model;

/** 
 * Contiene la estructura de los datos de una persona
 * 
 * @property string $nombre_completo Nombre completo de la persona
 * @property string $correo Correo de la persona
 * @property string $dui Dui de la persona
 * @property string $telefono Telefono de la persona
 */
class Person extends Model
{
    // * Propiedades

    private $nombreCompleto;
    private $correo;
    private $dui;
    private $telefono;

    // * Constructor

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     * 
     * @param string $nombreCompleto
     * @param string $correo
     * @param string $dui
     * @param string $telefono
     */
    function __construct(
        $nombreCompleto = 'Example Example',
        $telefono = '0000-0000',
        $dui = '00000000-0',
        $correo = 'example@gmail.com',
    ) {
        parent::__construct();
        $this->setNombreCompleto($nombreCompleto);
        $this->setCorreo($correo);
        $this->setDui($dui);
        $this->setTelefono($telefono);
    }

    // * Getters

    /**
     * Obtiene el valor de $nombreCompleto
     */
    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }

    /**
     * Obtiene el valor de $correo
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Obtiene el valor de $dui
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Obtiene el valor de $telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    // * Setters

    /**
     * Asigna el valor de $nombreCompleto
     *
     * @param string $nombreCompleto
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * Asigna el valor de $correo
     *
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * Asigna el valor de $dui
     *
     * @param string $dui
     */
    public function setDui($dui)
    {
        $this->dui = $dui;
    }

    /**
     * Asigna el valor de $telefono
     *
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
}
