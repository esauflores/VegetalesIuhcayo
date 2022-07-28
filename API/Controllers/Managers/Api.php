<?php

namespace App\Controllers\Managers;

/** 
 * Clase manager, contiene funciones estáticas para manejar la api
 */
class ApiManager
{
    // * Métodos

    /** 
     * Retorna un objeto JSON con un estado y mensaje de error
     *
     * @param int $status
     * @param string $error
     */
    public static function exitError($status, $error)
    {
        http_response_code($status);
        header('Content-Type: application/json');

        //$resultJSON = ['status' => $status, 'error' => $error];
        $resultJSON = ['error' => $error];
        exit(json_encode(
            $resultJSON,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
        ));
    }

    /** 
     * Retorna un objeto JSON con un estado y un arreglo data con información a retornar
     *
     * @param int $status
     * @param array $data
     */
    public static function exitData($status, $data)
    {
        http_response_code($status);
        header('Content-Type: application/json');

        //$resultJSON = ['status' => $status, 'data' => $data];
        $resultJSON = ['data' => $data];

        exit(json_encode(
            $resultJSON,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
        ));
    }
}
