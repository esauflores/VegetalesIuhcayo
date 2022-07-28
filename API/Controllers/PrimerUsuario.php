<?php

namespace App\Controllers;

use App\Models\BaseModels\Controller;

/**
 * Clase controller general, contiene métodos relacionados a la gestión de usuarios
 */
class PrimerUsuarioController extends Controller
{
    // * Métodos

    /**
     * Valida que no existan usuarios en la base de datos
     * - Almacena en 'primer-usuario' el booleano resultado
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function validarPrimerUsuario()
    {
        if (!UsuariosController::getNumeroDeUsuarios()) {
            self::setStatus(UsuariosController::getStatus());
            return false;
        }
        $result = UsuariosController::getResult();
        self::setResult(['primer-usuario' => ($result['numero-usuarios'] == 0)]);
        return true;
    }

    /**
     * Registra en la base de datos el primer usuario
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function registrarPrimerUsuario()
    {
        if (!PrimerUsuarioController::validarPrimerUsuario()) return false;
        $result = PrimerUsuarioController::getResult();

        if (!$result['primer-usuario']) {
            self::setStatusWithMessage(500, 'Primer usuario ya existente');
            return false;
        }

        $_POST['idTipoUsuario'] = 1; // Admin

        if (!UsuariosController::createUsuarioModel()) {
            self::setStatus(UsuariosController::getStatus());
            return false;
        }
        $result = UsuariosController::getResult();


        $user = $result['usuario'];
        if (!UsuariosController::createUsuarioDB($user)) {
            self::setStatus(UsuariosController::getStatus());
            return false;
        }

        self::setResult([]);
        return true;
    }
}
