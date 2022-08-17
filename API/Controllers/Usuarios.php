<?php

namespace App\Controllers;

use App\Controllers\Managers\DatabaseManager;
use App\Controllers\Managers\FilesManager;
use App\Models\BaseModels\Controller;
use App\Models\User;

/**
 * Clase controller general, contiene métodos relacionados a la gestión de usuarios
 */
class UsuariosController extends Controller
{
    // * Métodos base

    /**
     * Obtiene el número de usuarios activos dentro del sistema
     * - Almacena en 'numero-usuarios' el número de usuarios
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function getNumeroDeUsuarios()
    {
        $query = 'SELECT count(id_usuario) FROM usuarios.usuario 
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
     * crea un usuario en la base de datos
     * 
     * @param User $user
     */

    public static function createUsuarioDB($user)
    {
        $query =
            'INSERT INTO usuarios.usuario(
            codigo_usuario, id_imagen, nombre_completo, correo, dui, 
            telefono, nombre_usuario, contrasenia, id_tipo_usuario)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $params = [
            $user->getCodigoUsuario(),
            $user->getIdImagen(),
            $user->getNombreCompleto(),
            $user->getCorreo(),
            $user->getDui(),
            $user->getTelefono(),
            $user->getNombreUsuario(),
            $user->getContrasenia(),
            $user->getIdTipoUsuario()
        ];

        if (!DatabaseManager::executeQuery($query, $params)) {
            self::setStatus(DatabaseManager::getStatus());
            return false;
        }
        return true;
    }

    /**
     * Crea el modelo de un usuario según los datos en POST y en FILES
     * - Almacena en 'usuario' el modelo del usuario creado
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function createUsuarioModel()
    {
        // Datos necesarios para la creación de usuarios
        $requiredPostData =
            ['nombreCompleto', 'telefono', 'dui', 'correo', 'nombreUsuario', 'contrasenia', 'idTipoUsuario'];

        foreach ($requiredPostData as $requiredElement) {
            if (!isset($_POST[$requiredElement])) {
                self::setStatusWithMessage(
                    500,
                    "1 o más datos requeridos faltantes: {$requiredElement}"
                );
                return false;
            }
        }
        // Genera el del nuevo usuario
        $userCode = uniqid('USER-');

        // Asigna el id de la imagen en caso exista
        $idImage = null;
        if (isset($_FILES['imagen'])) {
            if (!FilesManager::saveFile('Files/Images/User', $_FILES['imagen'], $userCode)) {
                self::setStatus(FilesManager::getStatus());
                return false;
            }

            $result = FilesManager::getResult();
            $idImage = $result['id'];
        }

        $user = new User(
            $userCode,
            $idImage,
            $_POST['nombreCompleto'],
            $_POST['telefono'],
            $_POST['dui'],
            $_POST['correo'],
            $_POST['nombreUsuario'],
            $_POST['contrasenia'],
            $_POST['idTipoUsuario']
        );


        if ($user->getStatus()->getStatus() != 200) {
            self::setStatus($user->getStatus());
            return false;
        }

        self::setResult(['usuario' => $user]);
        return true;
    }
}
