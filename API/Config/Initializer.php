<?php

// Inicializa las clases con variables estáticas que necesitan ser inicializadas

use App\Controllers\Managers\DatabaseManager;
use App\Controllers\Managers\RouteManager;

DatabaseManager::init();
RouteManager::init();
