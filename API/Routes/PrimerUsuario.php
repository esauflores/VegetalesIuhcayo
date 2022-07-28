<?php

use App\Controllers\PrimerUsuarioController;
use App\Models\Routes\RouteEnd;
use App\Models\Routes\RouteNode;

return new RouteNode(
    [
        'validar' => new RouteNode(
            [],
            new RouteEnd(
                array(PrimerUsuarioController::class, 'validarPrimerUsuario'),
                array(PrimerUsuarioController::class, 'getResult'),
                array(PrimerUsuarioController::class, 'getStatus')
            )
        ),
        'registrar' => new RouteNode(
            [],
            new RouteEnd(
                array(PrimerUsuarioController::class, 'registrarPrimerUsuario'),
                array(PrimerUsuarioController::class, 'getResult'),
                array(PrimerUsuarioController::class, 'getStatus')
            )
        )
    ]
);
