<?php

namespace App\Models;

use App\Models\BaseModels\Model;

/** 
 * Contiene la estructura de los datos de un usuario/empleado de Vegetales Iuhcayo
 * 
 * @property string $codigoUsuario
 * @property int|null $idImagen
 * @property string $nombreCompleto
 * @property string $telefono
 * @property string $dui
 * @property string $correo
 * @property string $nombreUsuario
 * @property string contrasenia
 * @property int $tipoUsuario
 * @property bool $estadoEliminado
 */
class User extends Person
{
    // * Propiedades

    private $codigoUsuario;
    private $idImagen;
    private $nombreUsuario;
    private $contrasenia;
    private $idTipoUsuario;
    private $estadoEliminado;

    // * Constructor

    /**
     * Constructor:
     * asigna por defecto las propiedades de la clase
     * 
     * @param string $codigoUsuario
     * @param int|null $idImagen
     * @param string $nombreCompleto
     * @param string $telefono
     * @param string $dui
     * @param string $correo
     * @param string $nombreUsuario
     * @param string contrasenia
     * @param int $idTipoUsuario
     * @param bool $estadoEliminado
     */
    function __construct(
        $codigoUsuario = 'USER-0',
        $idImagen = null,
        $nombreCompleto = 'Example Example',
        $telefono = '0000-0000',
        $dui = '00000000-0',
        $correo = 'example@gmail.com',
        $nombreUsuario = 'USER12345',
        $contrasenia = '',
        $idTipoUsuario = '1',
        $estadoEliminado = false,
    ) {
        parent::__construct($nombreCompleto, $telefono, $dui, $correo);
        $this->setCodigoUsuario($codigoUsuario);
        $this->setIdImagen($idImagen);
        $this->setNombreUsuario($nombreUsuario);
        $this->setContrasenia($contrasenia);
        $this->setIdTipoUsuario($idTipoUsuario);
    }

    // * Getters

    /**
     * Obtiene el valor de $codigoUsuario
     * 
     * @return string
     */
    public function getCodigoUsuario()
    {
        return $this->codigoUsuario;
    }

    /**
     * Obtiene el valor de $codigoUsuario
     * 
     * @return int
     */
    public function getIdImagen()
    {
        return $this->idImagen;
    }

    /**
     * Obtiene el valor de $nombreUsuario
     * 
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Obtiene el valor de $contrasenia
     *
     * @return string
     */
    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    /**
     * Obtiene el valor de $idTipoUsuario
     *
     * @return int
     */
    public function getIdTipoUsuario()
    {
        return $this->idTipoUsuario;
    }

    /**
     * Obtiene el valor de $estadoEliminado
     * 
     * @return boolean
     */
    public function getEstadoEliminado()
    {
        return $this->estadoEliminado;
    }

    // * Setters

    /**
     * Asigna el valor de $codigoUsuario
     *
     * @param string $codigoUsuario
     */
    public function setCodigoUsuario($codigoUsuario)
    {
        $this->codigoUsuario = $codigoUsuario;
    }

    /**
     * Asigna el valor de $idImagen
     *
     * @param int $idImagen
     */
    public function setIdImagen($idImagen)
    {
        $this->idImagen = $idImagen;
    }

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
     * Asigna el valor de $contrasenia
     *
     * @param string $contrasenia
     */
    public function setContrasenia($contrasenia)
    {
        $this->contrasenia = $contrasenia;
    }


    /**
     * Asigna el valor de $idTipoUsuario
     *
     * @param int $idTipoUsuario
     */
    public function setIdTipoUsuario($idTipoUsuario)
    {
        $this->idTipoUsuario = $idTipoUsuario;
    }

    /**
     * Asigna el valor de $estadoEliminado
     *
     * @param boolean $estadoEliminado
     */
    public function setEstadoEliminado($estadoEliminado)
    {
        $this->estadoEliminado = $estadoEliminado;
    }
}
