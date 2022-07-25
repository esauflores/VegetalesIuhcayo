<?php

namespace App\Models;

use App\Models\BaseModels\Model;

/** 
 * Contiene la estructura de los datos de una persona
 * 
 * @property string $nombreUsuario Nombre de usuario de la persona
 * @property string $correo Correo de la persona
 * @property string $contrasenia Contraseña codificada
 */
class Credential extends Model
{
    // * Propiedades

    private $nombreUsuario;
    private $correo;
    private $contrasenia;

    // * Constructor

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     * 
     * @param string $nombreUsuario
     * @param string $correo
     * @param string $contrasenia
     */
    function __construct($nombreUsuario = '', $correo = '', $contrasenia = '')
    {
        parent::__construct();
        $this->setNombreUsuario($nombreUsuario);
        $this->setCorreo($correo);
        $this->setContrasenia($contrasenia);
    }

    // * Getters

    /**
     * Obtiene el valor de $nombreUsuario
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Obtiene el valor de $correo
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Obtiene el valor de $contrasenia
     */
    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    // * Setters

    /**
     * Asigna el valor de $nombreUsuario
     *
     * @param string $nombreUsuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
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
     * Asigna el valor de $contrasenia
     *
     * @param string $contrasenia
     */
    public function setContrasenia($contrasenia)
    {
        $this->contrasenia = $contrasenia;
    }
}
