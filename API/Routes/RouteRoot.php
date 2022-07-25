<?php


use App\Models\Routes\RouteNode;

/**
 * Nodo raíz de todas las raíces 
 */

return new RouteNode(
    [
        // todo General
        'general' => require(dirname(__DIR__) . '/Routes/UsoGeneral.php'),

        //todo Programa de entrega de alimentos
        'programa-entrega-alimentos' => require(dirname(__DIR__) . '/Routes/ProgramaEntregaAlimentos.php'),

        // todo Programa Comedor Santa Rita
        'comedor-santa-rita' => require(dirname(__DIR__) . '/Routes/ComedorSantaRita.php'),

        // todo Asistencia económica
        'asistencia-economica' => require(dirname(__DIR__) . '/Routes/AsistenciaEconomica.php'),

        // todo Pastoral social de la salud
        'pastoral-social-salud' => require(dirname(__DIR__) . '/Routes/PastoralSocialSalud.php'),
    ]
);
