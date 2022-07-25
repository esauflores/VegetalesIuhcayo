<?php

namespace App\Controllers;

use App\Controllers\Managers\DatabaseManager;
use App\Models\BaseModels\Controller;

/**
 * Clase controller general, contiene métodos relacionados a la gestión de usuarios
 */
class UsuariosController extends Controller
{
    // * Métodos

    /**
     * Obtiene el número de usuarios activos dentro del sistema
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function getNumeroDeUsuarios()
    {
        $query = 'SELECT count(id_usuario) from usuarios.usuario 
                  WHERE estado_eliminado != TRUE';
        if (!DatabaseManager::executeQueryGetData($query)) {
            self::setStatus(DatabaseManager::getStatus());
            return false;
        }
        $dbResult = DatabaseManager::getResult();
        self::setResult(['numero-usuarios' => $dbResult[0]['count']]);
        return true;
    }

    /**
     * Añade el primer usuario 
     * - No requiere de autenticación (temporal)
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function addPrimerUsuario()
    {
        if (!self::getNumeroDeUsuarios()) return false;

        if (self::$result['numero-usuarios'] != 0) {
            self::setStatusWithMessage(403, 'Error - Ya existe el primer usuario');
            return false;
        }

        self::setResult(['ok' => 'ta bien']);
        return true;
    }
}
