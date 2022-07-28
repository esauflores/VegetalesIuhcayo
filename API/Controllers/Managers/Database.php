<?php

namespace App\Controllers\Managers;

use Exception;
use PDO;
use PDOException;
use App\Models\BaseModels\Controller;

/**
 * Clase manager de consultas a la base de datos
 * 
 * @property Status $status Estado
 * @property array $credential Credenciales de la base de datos
 * @property null|PDO $connection Conexión con la base de datos
 * @property null|PDOStatement $statement Sentencia SQL de la base de datos
 * @property array $data Información obtenida de las consultas
 */
class DatabaseManager extends Controller
{
    // * Propiedades

    private static $credential;
    private static $connection;
    private static $statement;

    // * Inicializador

    /** 
     * Inicializa las variables necesarias para ejecutar consultas
     */
    public static function init()
    {
        parent::init();
        self::setCredential(json_decode(
            file_get_contents(dirname(__DIR__, 2) . '/Credentials/DB_credentials.json'),
            true
        ));
    }

    //* Getters

    /**
     * Obtiene el valor de $credential
     * 
     * @return array
     */
    private static function getCredential()
    {
        return self::$credential;
    }

    /**
     * Obtiene el valor de $connection
     * 
     * @return null|PDO
     */
    private static function getConnection()
    {
        return self::$connection;
    }

    /**
     * Obtiene el valor de $statement
     * 
     * @return null|PDOStatement
     */
    private static function getStatement()
    {
        return self::$statement;
    }

    // * Setters

    /**
     * Asigna el valor de $credential
     *
     * @param array $credential
     */
    private static function setCredential($credential)
    {
        self::$credential = $credential;
    }

    /**
     * Asigna el valor de $connection
     *
     * @param null|PDO $connection
     */
    private static function setConnection($connection)
    {
        self::$connection = $connection;
    }

    /**
     * Asigna el valor de $statement
     *
     * @param null|PDOStatement $statement
     */
    private static function setStatement($statement)
    {
        self::$statement = $statement;
    }

    // * Métodos

    /**
     * Crea una conexión con la base de datos
     *
     * @return bool True en caso de éxito, false en caso contrario
     */
    private static function createConnection()
    {
        // Bandera - True representa caso de éxito, false caso de error
        $returnFlag = true;

        // Obtenemos las credenciales de la db
        $credential = self::$credential['VegetalesIuhcayo'];

        // Crea la conexión con la base de datos
        try {
            self::setConnection(
                new PDO(
                    $credential['dsn'],
                    $credential['username'],
                    $credential['password'],
                )
            );
        } catch (Exception $error) {
            // Caso de error no se pudiera crea la conexión
            self::$status->setStatusWithMessage(
                500,
                'No se pudo conectar con la base de datos'
            );
            $returnFlag = false;
        } finally {
            // Borramos la información de las credenciales
            $credential = NULL;
        }

        return $returnFlag;
    }

    /** 
     * Destruye la conexión con la base de datos
     */
    private static function destroyConnection()
    {
        self::setConnection(NULL);
        self::setStatement(NULL);
    }

    /**
     * Crea un PDOStatement y ejecuta una consulta parametrizada en la base de datos
     * 
     * @param string $query Consulta
     * @param array $params Parametros de la consulta
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    private static function createStatement($query, $params = [])
    {
        // Si no puede crear la conexión retornamos false
        if (!self::createConnection()) return false;

        // Bandera - True representa caso de éxito, false caso de error
        $returnFlag = true;

        try {
            //Crea el statement por medio de la conexión
            self::setStatement(self::$connection->prepare($query));

            // Ejecuta la consulta con los parametros
            if (!self::$statement->execute($params)) {
                // Caso de error - destruimos la conexión y asignamos error
                self::destroyConnection();
                self::$status->setStatusWithMessage(
                    500,
                    'No se pudo ejecutar la consulta en la base de datos'
                );
                $returnFlag = false;
            }
        } catch (PDOException $error) {
            // Caso de error - destruimos la conexión y asignamos error
            self::destroyConnection();
            self::setErrorMessageWithCode($error->getCode(), $error->getMessage());
            $returnFlag = false;
        }

        return $returnFlag;
    }

    /**
     * Ejecuta una consulta parametrizada en la base de datos
     * 
     * @param string $query Consulta
     * @param array $params Parametros de la consulta
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function executeQuery($query, $params = [])
    {
        if (!self::createStatement($query, $params)) return false;
        self::destroyConnection();
        return true;
    }

    /**
     * Ejecuta una consulta parametrizada en la base de datos
     * y obtiene la información retornada por la consulta
     * 
     * @param string $query Consulta
     * @param array $params Parametros de la consulta
     * 
     * @return bool True en caso de éxito, false en caso contrario
     */
    public static function executeQueryGetData($query, $params = [])
    {
        if (!self::createStatement($query, $params)) return false;
        self::setResult(self::$statement->fetchAll(PDO::FETCH_ASSOC));
        self::destroyConnection();
        return true;
    }



    // Asigna el mensaje de error en base a un código de error
    private static function setErrorMessageWithCode(mixed $code, string $originalMessage): void
    {
        // Prefijo de mensaje a agregar 
        $prefix = 'Error en la base de datos: ';

        // Mensaje de error original en caso que sea necesario

        self::$status->setStatusWithMessage(
            500,
            $prefix . $originalMessage
        );

        switch ($code) {
            case '7':
                self::$status->setStatusWithMessage(
                    500,
                    $prefix . 'No se pudo conectar con la base de datos'
                );
                break;
            case '42703':
                self::$status->setStatusWithMessage(
                    500,
                    $prefix . 'Nombre de campo desconocido'
                );
                break;
            case '23505':
                self::$status->setStatusWithMessage(
                    500,
                    $prefix . 'Dato con campo único existente'
                );
                break;
            case '42P01':
                self::$status->setStatusWithMessage(
                    500,
                    $prefix . 'Nombre de tabla desconocido'
                );
                break;
            case '23503':
                self::$status->setStatusWithMessage(
                    500,
                    $prefix . 'Registro utilizado por otro, no se puede eliminar'
                );
                break;
            default:
                self::$status->setStatusWithMessage(
                    500,
                    $prefix . 'Ocurrió un error desconocido al conectar con la base de datos'
                );
        }

        self::$status->setStatusWithMessage(
            500,
            $prefix . $originalMessage
        );
    }
}
