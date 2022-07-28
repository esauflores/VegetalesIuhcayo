<?php

// Elimina los reportes de advertencias y notificaciones
//error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

// Permite el origen desde la api
$http_origin = @$_SERVER['HTTP_ORIGIN'];
if ($http_origin == "http://localhost:9000") {
    header("Access-Control-Allow-Origin: $http_origin");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept');

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    http_response_code(200); // OK
    exit;
}
