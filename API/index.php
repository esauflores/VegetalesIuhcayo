<?php

use App\Controllers\Managers\ApiManager;
use App\Controllers\Managers\RoutesManager;

require_once(__DIR__ . '/Config/Headers.php');
require_once(__DIR__ . '/Config/Autoloader.php');
require_once(__DIR__ . '/Config/Initializer.php');

// Ejecuta una método de un controlador dado la url
if (!RoutesManager::executeMethodWithUrl(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1))) {
    // Caso de error - Retorna el error
    $status = RoutesManager::getStatus();
    ApiManager::exitError($status->getStatus(), $status->getMessage());
}

// Obtiene el resultado de la método
if (!RoutesManager::getResultFromController()) {
    // Caso de error - Retorna el error
    $status = RoutesManager::getStatus();
    ApiManager::exitError($status->getStatus(), $status->getMessage());
}

// Retorna la información obtenida con un estado http 200 (OK)
ApiManager::exitData(200, RoutesManager::getResult());
