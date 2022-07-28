<?php

namespace App\Controllers;

use App\Models\BaseModels\Controller;

/**
 * Clase controller general, contiene métodos relacionados al login y registro de usuarios
 * 
 * ? Usar Auth0 ? 
 */
class LoginController extends Controller
{
    // * Métodos

    /**
     * Verifica el acceso al sistema de un usuario
     * - Retorna en 'acceso' si el usuario tiene un acceso válido 
     * 
     * @return bool True en caso de acceso exitoso, false caso contrario
     */
    public static function validateAccess()
    {

        // Caso de no tener acceso
        self::setStatusWithMessage(401, 'No tiene acceso');
        // self::setResult(['acceso' => true]);
        return true;
    }

    /**
     * Agrega una nueva llave de acceso a un usuario
     * - Requiere de una validación de acceso
     * 
     * @return bool True en caso de acceso exitoso, false caso contrario
     */
    public static function logIn()
    {
        self::setResult(['acceso' => true]);
        return true;
    }

    /**
     * Elimina el acceso al sistema a un usuario
     * 
     * @return bool True en caso de acceso exitoso, false caso contrario
     */
    public static function logOut()
    {
        return true;
    }
}
