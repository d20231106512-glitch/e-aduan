<?php

// Tambah ini di baris paling atas untuk elak timeout 30 saat
set_time_limit(0);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Tentukan jika aplikasi sedang diselenggara...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Daftar pengautomatik fail (Autoloader) - BAHAGIAN INI YANG COMPOSER TENGAH REPAIR
require __DIR__.'/../vendor/autoload.php';

// Jalankan Aplikasi Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

$request = Request::capture();

$response = $app->handle($request);

$response->send();

$app->terminate($request);