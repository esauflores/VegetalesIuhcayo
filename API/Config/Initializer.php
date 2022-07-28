<?php

// Inicializa las clases con variables estáticas que necesitan ser inicializadas

use App\Controllers\Managers\DatabaseManager;
use App\Controllers\Managers\FilesManager;
use App\Controllers\Managers\RoutesManager;

DatabaseManager::init();
RoutesManager::init();
FilesManager::init();
