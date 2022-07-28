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
        $filename = $filename . '.' . $extension;

        if (!@move_uploaded_file(self::$file['tmp_name'], $fileRoute . '/'  . $filename)) {
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
            self::deleteFile($route, $filename);
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
     * @param string $route Ruta donde se añadirá el archivo
     * @param string $filename nombre del archivo
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function deleteFile($fileRoute, $filename)
    {
        $prefix = 'Error al elminar el archivo:';

        // Si no existe la ruta del folder del archivo, error
        if (!file_exists($fileRoute)) {
            self::setStatusWithMessage(
                500,
                $prefix . ' No existe la ruta de archivos dentro del sistema'
            );
            return false;
        }

        // Si el archivo no existe cuenta como eliminado
        if (!file_exists($fileRoute . '/' . $filename)) return true;

        // Si no se pudo eliminar el archivo, error
        if (!@unlink($fileRoute . '/' . $filename)) {
            self::setStatusWithMessage(
                500,
                $prefix . ' No se pudo eliminar el archivo'
            );
            return false;
        }

        return true;
    }
}
