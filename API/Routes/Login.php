<?php

use App\Controllers\LoginController;
use App\Models\Routes\RouteEnd;
use App\Models\Routes\RouteNode;

return new RouteNode(
    [
        'validar-acceso' => new RouteNode(
            [],
            new RouteEnd(
                array(LoginController::class, 'validateAccess'),
                array(LoginController::class, 'getResult'),
                array(LoginController::class, 'getStatus')
            )
        )
    ]
);
