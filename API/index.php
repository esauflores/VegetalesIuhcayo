<?php

use SistemaMargarita\Controllers\Managers\ApiManager;
use SistemaMargarita\Controllers\Managers\RouteManager;

require_once(__DIR__ . '/Config/Headers.php');
require_once(__DIR__ . '/Config/Autoloader.php');
require_once(__DIR__ . '/Config/Initializer.php');

// Ejecuta una función de un controlador dado la url
if (!RouteManager::executeMethodWithUrl(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1))) {
    // Caso de error - Retorna el error
    $status = RouteManager::getStatus();
    ApiManager::exitError($status->getStatus(), $status->getMessage());
}

// Obtiene el resultado de la función
if (!RouteManager::getResultFromController()) {
    // Caso de error - Retorna el error
    $status = RouteManager::getStatus();
    ApiManager::exitError($status->getStatus(), $status->getMessage());
}

// Retorna la información obtenida con un estado http 200 (OK)
ApiManager::exitData(200, RouteManager::getResult());
