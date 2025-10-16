<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Create the Laravel application
$app = require __DIR__ . '/../bootstrap/app.php';

// Bootstrap the application for console/testing
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Set the application in the facade
Illuminate\Support\Facades\Facade::setFacadeApplication($app);
