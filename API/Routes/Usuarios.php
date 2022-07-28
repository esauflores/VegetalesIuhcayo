<?php

use App\Controllers\UsuariosController;
use App\Models\Routes\RouteEnd;
use App\Models\Routes\RouteNode;

return new RouteNode(
    [
        'primer-usuario' => new RouteNode(
            [
                'crear' => new RouteNode(
                    [],
                    new RouteEnd(
                        array(UsuariosController::class, 'getNumeroDeUsuarios'),
                        array(UsuariosController::class, 'getResult')
                    )
                )
            ]
        ),
        'usuario' => new RouteNode(
            [
                'crear' => new RouteNode(
                    [],
                    new RouteEnd(
                        array(UsuariosController::class, 'getNumeroDeUsuarios'),
                        array(UsuariosController::class, 'getResult')
                    )
                )
            ]
        )
    ]
);
