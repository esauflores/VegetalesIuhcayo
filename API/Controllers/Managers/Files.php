<?php

namespace App\Controllers\Managers;

use App\Models\BaseModels\Controller;

/**
 * Clase manager de archivos:
 * permite subir y eliminar archivos
 *
 * @property string $route Ruta donde se almacena el archivo
 * @property mixed $file Archivo
 * @property string $filename Nombre del archivo
 */
class FilesManager extends Controller
{
    // * Propiedades
    private static $route;
    private static $file;
    private static $filename;

    // * Inicializador

    /** 
     * Inicializa las variables necesarias para ejecutar consultas
     */
    public static function init()
    {
        parent::init();
    }

    // * Getters

    /**
     * Obtiene el valor de $route
     * 
     * @return string
     */
    public static function getRoute()
    {
        return self::$route;
    }

    /**
     * Obtiene el valor de $file
     * 
     * @return mixed
     */
    public static function getFile()
    {
        return self::$file;
    }

    /**
     * Obtiene el valor de $filename
     *
     * @return string
     */
    public static function getFilename()
    {
        return self::$filename;
    }


    // * Setters

    /**
     * Asigna el valor de $route
     * 
     * @param string $route
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function setRoute($route)
    {
        self::$route = $route;
        return true;
    }

    /**
     * Asigna el valor de $file
     * 
     * @param string $file
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function setFile($file)
    {
        self::$file = $file;
        return true;
    }

    /**
     * Asigna el valor de $filename
     * 
     * @param string $filename
     * 
     * @return bool True en caso de éxito, false caso contrario
     */
    public static function setFilename($filename)
    {
        self::$filename = $filename;
        return true;
    }


    // * Métodos

    /**
     * Método que permite añadir archivos
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    private static function getRouteID()
    {
        $query = 'SELECT id_archivo FROM configuracion.menu_archivo 
        WHERE url_path = ?';

        $params = [self::$route];
        if (!DatabaseManager::executeQueryGetData($query, $params)) {
            self::setStatus(DatabaseManager::getStatus());
            return false;
        }

        $result = DatabaseManager::getResult();

        if (!sizeof($result)) {
            self::setStatusWithMessage(
                500,
                'No existe la ruta para agregar el archivo en la base de datos'
            );
            return false;
        }

        self::setResult(['id' => $result[0]['id_archivo']]);
        return true;
    }

    /**
     * Función que permite añadir archivos
     * - Almacena en id el id de la imagen añadida
     * 
     * @param string $route Ruta donde se añadirá el archivo
     * @param mixed $file archivo
     * @param string $filename nombre del archivo a utilizar
     *     
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function saveFile($route, $file, $filename)
    {
        if (!self::setRoute($route)) return false;
        if (!self::setFile($file)) return false;
        if (!self::setFilename($filename)) return false;

        // Obtiene el id de la ruta de los archivos de la base de datos
        if (!self::getRouteID($route)) return false;
        $idRoute = self::$result['id'];

        //Intenta mover el archivo a la ruta designada

        $prefix = 'Error al subir el archivo';

        $fileRoute = dirname(__DIR__, 3) . '/' . $route;

        // Verifica que la ruta exista en carpeta de archivos

        if (!file_exists($fileRoute)) {
            self::setStatusWithMessage(
                500,
                $prefix . 'No existe la ruta de archivos dentro del sistema'
            );
            return false;
        }

        // Intenta guardar el archivo en la carpeta de archivos
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Ruta final donde se colocará el archivo
        $fileFinal = $fileRoute . '/'  . $filename . '.' . $extension;

        // Si ya hay un archivo en esa ruta, buscamos sustituir el archivo
        if (file_exists($fileFinal)) {
            chmod($fileFinal, 0755); // Cambia los permisos del archivo, si se puede
            unlink($fileFinal); // Elimina el archivo
        }

        if (!@move_uploaded_file(self::$file['tmp_name'], $fileFinal)) {
            self::setStatusWithMessage(
                500,
                $prefix . 'No se pudo subir el archivo'
            );
            return false;
        }

        // Guarda la existencia del archivo en la base de datos

        $query =
            'INSERT INTO configuracion.archivo(url_path, id_archivo_padre)
            VALUES (?, ?) RETURNING id_archivo';

        $params = [$filename, $idRoute];

        if (!DatabaseManager::executeQueryGetData($query, $params)) {
            // Caso de error, asigna el mensaje de error y elimina el archivo creado
            self::setStatus(DatabaseManager::getStatus());
            self::deleteFile($fileFinal);
            return false;
        }

        //Guarda el resultado

        $result = DatabaseManager::getResult();

        self::setResult(['id' => $result[0]['id_archivo']]);
        return true;
    }

    /**
     * Función que permite añadir archivos
     * 
     * @param string $fileFinal Ruta final del archivo
     * @param int|null $fileID ID del archivo
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function deleteFile($fileFinal, $fileID = null)
    {
        $prefix = 'Error al elminar el archivo:';

        // Si no existe la ruta del folder del archivo, error

        // Si el archivo no existe cuenta como eliminado
        if (!file_exists($fileFinal)) return true;

        // Si no se pudo eliminar el archivo, error
        if (!@unlink($fileFinal)) {
            self::setStatusWithMessage(
                500,
                $prefix . ' No se pudo eliminar el archivo'
            );
            return false;
        }

        // Si no necesita eliminar el id en la base de datos, retorna
        if (!$fileID) return true;

        $query = 'DELETE FROM configuracion.archivo
        WHERE id_archivo = ?';
        $params = [$fileID];

        // No se pudo eliminar de la base de datos
        if (!DatabaseManager::executeQuery($query, $params)) {
            self::setStatus(DatabaseManager::getStatus());
            return false;
        }

        return true;
    }

    /**
     * Regresa una archivo en base a su id
     * 
     * @return bool|void En caso de éxito imprime el archivo, retorna false en caso contrario

     */
    public static function obtenerArchivo()
    {
        // Obtiene el id del archivo
        if (!isset($_GET['id'])) {
            self::setStatusWithMessage(500, 'ID de archivo no definido');
            return false;
        }

        $id = $_GET['id'];

        // Valida que sea un entero
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            self::setStatusWithMessage(500, 'ID de archivo no es un entero');
            return false;
        }

        // Busca la ruta del archivo en la base de datos

        $query =
            "SELECT menu.url_path AS directory, arch.url_path AS filename
            FROM configuracion.menu_archivo AS menu 
            INNER JOIN configuracion.archivo AS arch ON menu.id_archivo = arch.id_archivo_padre
            WHERE arch.id_archivo = ?";
        $params = [$id];

        // No se puede obtener la información de la base de datos o archivo no existente
        if (!DatabaseManager::executeQueryGetData($query, $params)) {
            self::setStatus(DatabaseManager::getStatus());
            return false;
        }

        if (sizeof($result = DatabaseManager::getResult()) == 0) {
            self::setStatusWithMessage(404, 'Archivo no existente en la base de datos');
            return false;
        }

        $directory = $result[0]['directory'];
        $filename = $result[0]['filename'];
        $fileFinal = dirname(__DIR__, 3) . '/' . $directory . '/' . $filename;
        if (!file_exists($fileFinal)) {
            self::setStatusWithMessage(404, 'Archivo no encontrado');
            return false;
        }

        $type = mime_content_type($fileFinal);
        header("Content-Type: image/png");
        echo file_get_contents($fileFinal);
        exit;
    }
}
