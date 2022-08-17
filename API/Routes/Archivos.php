<?php

use App\Controllers\Managers\FilesManager;
use App\Models\Routes\RouteEnd;
use App\Models\Routes\RouteNode;

return new RouteNode(
    [
        'obtener-archivo' => new RouteNode(
            [],
            new RouteEnd(
                array(FilesManager::class, 'obtenerArchivo'),
                array(FilesManager::class, 'getResult'),
                array(FilesManager::class, 'getStatus')
            )
        )
    ]
);
