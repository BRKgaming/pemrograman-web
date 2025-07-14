<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Versi modifikasi untuk shared hosting
 */

// Path ke folder Laravel utama (satu level di atas public_html)
$laravel_path = __DIR__ . '/../laravel';

// Register the auto-loader
require $laravel_path.'/vendor/autoload.php';

// Load the application
$app = require_once $laravel_path.'/bootstrap/app.php';

// Modifikasi paths untuk shared hosting
$app->useStoragePath($laravel_path . '/storage');
$app->usePublicPath(__DIR__);

// Run the application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
