<?php


use App\Models\Routes\RouteNode;

/**
 * Nodo raíz de todas las raíces 
 */

return new RouteNode(
    [
        'login' => require(dirname(__DIR__) . '/Routes/Login.php'),
        'primer-usuario' => require(dirname(__DIR__) . '/Routes/PrimerUsuario.php'),
    ]
);
